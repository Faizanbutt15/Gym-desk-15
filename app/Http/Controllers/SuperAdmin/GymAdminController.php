<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Gym;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GymAdminController extends Controller
{
    public function index()
    {
        $gymAdmins = User::where('role', 'gym_admin')->with('gym')->latest()->paginate(10);
        $gyms = Gym::orderBy('name')->get();
        return view('superadmin.gym-admins.index', compact('gymAdmins', 'gyms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'gym_id' => 'required|exists:gyms,id',
        ]);

        $validated['role'] = 'gym_admin';
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);
        return redirect()->route('superadmin.gym-admins.index')->with('success', 'Gym Admin created successfully.');
    }

    public function update(Request $request, User $gymAdmin)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $gymAdmin->id,
            'gym_id' => 'required|exists:gyms,id',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8']);
            $validated['password'] = Hash::make($request->password);
        }

        $gymAdmin->update($validated);
        return redirect()->route('superadmin.gym-admins.index')->with('success', 'Gym Admin updated successfully.');
    }

    public function destroy(User $gymAdmin)
    {
        $gymAdmin->delete();
        return redirect()->route('superadmin.gym-admins.index')->with('success', 'Gym Admin deleted successfully.');
    }
}
