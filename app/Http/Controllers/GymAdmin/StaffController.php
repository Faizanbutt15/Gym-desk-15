<?php

namespace App\Http\Controllers\GymAdmin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StaffPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $gymId = $request->user()->gym_id;
        $staff = Staff::where('gym_id', $gymId)->latest()->paginate(10);
        return view('gym.staff.index', compact('staff'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'contact' => 'nullable|string|max:20',
            'joined_date' => 'required|date',
        ]);

        $validated['gym_id'] = $request->user()->gym_id;

        if ($request->filled('photo_base64') && strpos($request->photo_base64, 'data:image') === 0) {
            $image_parts = explode(";base64,", $request->photo_base64);
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = 'photos/' . uniqid() . '.png';
            Storage::disk('public')->put($fileName, $image_base64);
            $validated['photo'] = $fileName;
        } elseif ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        Staff::create($validated);
        return redirect()->back()->with('success', 'Staff member added successfully.');
    }

    public function update(Request $request, Staff $staff)
    {
        if ($staff->gym_id !== $request->user()->gym_id) abort(403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'contact' => 'nullable|string|max:20',
            'joined_date' => 'required|date',
        ]);

        if ($request->filled('photo_base64') && strpos($request->photo_base64, 'data:image') === 0) {
            if ($staff->photo) Storage::disk('public')->delete($staff->photo);
            $image_parts = explode(";base64,", $request->photo_base64);
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = 'photos/' . uniqid() . '.png';
            Storage::disk('public')->put($fileName, $image_base64);
            $validated['photo'] = $fileName;
        } elseif ($request->hasFile('photo')) {
            if ($staff->photo) Storage::disk('public')->delete($staff->photo);
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $staff->update($validated);
        return redirect()->back()->with('success', 'Staff member updated successfully.');
    }

    public function destroy(Request $request, Staff $staff)
    {
        if ($staff->gym_id !== $request->user()->gym_id) abort(403);
        if ($staff->photo) Storage::disk('public')->delete($staff->photo);
        $staff->delete();
        return redirect()->back()->with('success', 'Staff member deleted successfully.');
    }

    public function paySalary(Request $request, Staff $staff)
    {
        if ($staff->gym_id !== $request->user()->gym_id) abort(403);

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        StaffPayment::create([
            'gym_id' => $staff->gym_id,
            'staff_id' => $staff->id,
            'amount' => $request->amount,
            'paid_date' => now()
        ]);

        return redirect()->back()->with('success', 'Salary recorded successfully.');
    }
}
