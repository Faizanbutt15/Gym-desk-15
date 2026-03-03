<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Gym;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GymController extends Controller
{
    public function index()
    {
        $gyms = Gym::latest()->paginate(10);
        return view('superadmin.gyms.index', compact('gyms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
            'subscription_start' => 'nullable|date',
            'subscription_end' => 'nullable|date',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Gym::create($validated);
        return redirect()->route('superadmin.gyms.index')->with('success', 'Gym created successfully.');
    }

    public function update(Request $request, Gym $gym)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
            'subscription_start' => 'nullable|date',
            'subscription_end' => 'nullable|date',
        ]);

        if ($request->hasFile('logo')) {
            if ($gym->logo) Storage::disk('public')->delete($gym->logo);
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $gym->update($validated);
        return redirect()->route('superadmin.gyms.index')->with('success', 'Gym updated successfully.');
    }

    public function destroy(Gym $gym)
    {
        $gym->delete();
        return redirect()->route('superadmin.gyms.index')->with('success', 'Gym deleted successfully.');
    }

    public function toggleStatus(Request $request, Gym $gym)
    {
        $validated = $request->validate(['status' => 'required|in:active,inactive']);
        $gym->update(['status' => $validated['status']]);
        return redirect()->back()->with('success', "Gym status updated.");
    }
}
