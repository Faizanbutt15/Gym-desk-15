<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $gymId = $request->user()->gym_id;

        // Auto-move members expired > 60 days to inactive
        Member::where('gym_id', $gymId)
            ->where('status', 'active')
            ->whereNotNull('fee_due_date')
            ->where('fee_due_date', '<', now()->subDays(60))
            ->update(['status' => 'inactive']);

        $query = Member::where('gym_id', $gymId);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact', 'like', "%{$search}%");
            });
        }

        if ($request->filled('filter') && $request->filter !== 'all') {
            switch ($request->filter) {
                case 'active':
                    $query->where('status', 'active');
                    break;
                case 'inactive':
                    $query->where('status', 'inactive');
                    break;
                case 'with_trainer':
                    $query->where('trainer_fee', '>', 0);
                    break;
                case 'no_trainer':
                    $query->where('trainer_fee', '<=', 0);
                    break;
                case 'with_locker':
                    $query->where('locker_fee', '>', 0);
                    break;
                case 'no_locker':
                    $query->where('locker_fee', '<=', 0);
                    break;
            }
        }

        $members = $query->latest()->paginate(10)->withQueryString();
        return view('gym.members.index', compact('members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'email' => 'nullable|email|max:255',
            'contact' => 'nullable|string|max:20',
            'fee_due_date' => 'nullable|date',
            'fee_amount' => 'required|numeric|min:0',
            'admission_fee' => 'nullable|numeric|min:0',
            'trainer_fee' => 'nullable|numeric|min:0',
            'locker_fee' => 'nullable|numeric|min:0',
            'joined_date' => 'nullable|date',
        ]);

        // Default empty fees to 0
        $validated['admission_fee'] = $validated['admission_fee'] ?? 0;
        $validated['trainer_fee'] = $validated['trainer_fee'] ?? 0;
        $validated['locker_fee'] = $validated['locker_fee'] ?? 0;

        $gymId = $request->user()->gym_id;
        $validated['gym_id'] = $gymId;
        $validated['status'] = 'active';

        if ($request->filled('photo_base64') && strpos($request->photo_base64, 'data:image') === 0) {
            $image_parts = explode(";base64,", $request->photo_base64);
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = 'photos/' . uniqid() . '.png';
            Storage::disk('public')->put($fileName, $image_base64);
            $validated['photo'] = $fileName;
        } elseif ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        Member::create($validated);

        return redirect()->back()->with('success', 'Member added successfully.');
    }

    public function update(Request $request, Member $member)
    {
        if ($member->gym_id !== $request->user()->gym_id) abort(403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'email' => 'nullable|email|max:255',
            'contact' => 'nullable|string|max:20',
            'fee_due_date' => 'nullable|date',
            'fee_amount' => 'required|numeric|min:0',
            'admission_fee' => 'nullable|numeric|min:0',
            'trainer_fee' => 'nullable|numeric|min:0',
            'locker_fee' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        // Default empty fees to 0
        $validated['admission_fee'] = $validated['admission_fee'] ?? 0;
        $validated['trainer_fee'] = $validated['trainer_fee'] ?? 0;
        $validated['locker_fee'] = $validated['locker_fee'] ?? 0;

        if ($request->filled('photo_base64') && strpos($request->photo_base64, 'data:image') === 0) {
            if ($member->photo) Storage::disk('public')->delete($member->photo);
            $image_parts = explode(";base64,", $request->photo_base64);
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = 'photos/' . uniqid() . '.png';
            Storage::disk('public')->put($fileName, $image_base64);
            $validated['photo'] = $fileName;
        } elseif ($request->hasFile('photo')) {
            if ($member->photo) Storage::disk('public')->delete($member->photo);
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $member->update($validated);
        return redirect()->back()->with('success', 'Member updated successfully.');
    }

    public function destroy(Request $request, Member $member)
    {
        if ($member->gym_id !== $request->user()->gym_id) abort(403);
        $member->delete();
        return redirect()->back()->with('success', 'Member deleted successfully.');
    }

    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([
            'member_ids' => 'required|array',
            'member_ids.*' => 'integer|exists:members,id'
        ]);

        $gymId = $request->user()->gym_id;

        // Delete all provided member IDs that actually belong to this gym
        $deletedCount = Member::where('gym_id', $gymId)
            ->whereIn('id', $validated['member_ids'])
            ->delete();

        return redirect()->back()->with('success', "{$deletedCount} members deleted successfully.");
    }

    public function markAsPaid(Request $request, Member $member)
    {
        if ($member->gym_id !== $request->user()->gym_id) abort(403);

        $months = (int) $request->input('months', 1);
        if ($months < 1) $months = 1;
        
        $daysToAdd = 30 * $months;
        // The recurring amount paid is only the active recurring fees
        $totalRecurringMonthly = $member->fee_amount + $member->trainer_fee + $member->locker_fee;
        $amountPaid = $totalRecurringMonthly * $months;

        // If inactive or fee is wildly overdue (e.g. over 30 days), start billing cycle from today
        if ($member->status === 'inactive' || ($member->fee_due_date && $member->fee_due_date->diffInDays(now(), false) > 30)) {
            $newDueDate = now()->addDays($daysToAdd);
        } else {
            $newDueDate = $member->fee_due_date ? $member->fee_due_date->addDays($daysToAdd) : now()->addDays($daysToAdd);
        }

        $member->update([
            'fee_due_date' => $newDueDate,
            'status' => 'active'
        ]);

        Payment::create([
            'gym_id' => $member->gym_id,
            'member_id' => $member->id,
            'member_name' => $member->name,
            'amount' => $amountPaid,
            'paid_date' => now()
        ]);

        $message = $months > 1 
            ? "Payment of {$months} months recorded successfully. Member activated." 
            : 'Payment recorded successfully. Member activated.';

        return redirect()->back()->with('success', $message);
    }

    public function reactivate(Request $request, Member $member)
    {
        if ($member->gym_id !== $request->user()->gym_id) abort(403);
        
        $member->update([
            'status' => 'active',
            'fee_due_date' => now() // Reset due date to today so they aren't months overdue
        ]);
        
        return redirect()->back()->with('success', 'Member reactivated successfully. Please collect and record their fee to update their due date.');
    }
}
