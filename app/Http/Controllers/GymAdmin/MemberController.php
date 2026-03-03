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
        $query = Member::where('gym_id', $gymId);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
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
            'joined_date' => 'nullable|date',
        ]);

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
            'status' => 'required|in:active,inactive',
        ]);

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

    public function markAsPaid(Request $request, Member $member)
    {
        if ($member->gym_id !== $request->user()->gym_id) abort(403);

        $months = (int) $request->input('months', 1);
        if ($months < 1) $months = 1;
        
        $daysToAdd = 30 * $months;
        $amountPaid = $member->fee_amount * $months;

        $newDueDate = $member->fee_due_date ? $member->fee_due_date->addDays($daysToAdd) : now()->addDays($daysToAdd);

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
        
        $member->update(['status' => 'active']);
        return redirect()->back()->with('success', 'Member reactivated successfully.');
    }
}
