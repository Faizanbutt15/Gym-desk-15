<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Gym;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class GymController extends Controller
{
    public function index(Request $request)
    {
        $query = Gym::with(['admins' => function($q) {
            $q->where('role', 'gym_admin');
        }]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhereHas('admins', function($adminQuery) use ($search) {
                      $adminQuery->where('name', 'like', "%{$search}%")
                                 ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('filter') && $request->filter !== 'all') {
            if ($request->filter === 'active') {
                $query->where('status', 'active');
            } elseif ($request->filter === 'inactive') {
                $query->where('status', 'inactive');
            } elseif ($request->filter === 'expired') {
                $query->where('subscription_end', '<', now());
            } elseif ($request->filter === 'expiring_soon') {
                $query->whereBetween('subscription_end', [now(), now()->addDays(7)]);
            }
        }

        $gyms = $query->latest()->paginate(10)->withQueryString();
        
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
            // Admin fields
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|string|email|max:255|unique:users,email',
            'admin_password' => 'required|string|min:8',
            // Payment fields
            'payment_amount' => 'nullable|numeric|min:0',
        ]);

        $gymData = collect($validated)->except(['admin_name', 'admin_email', 'admin_password', 'payment_amount'])->toArray();

        if ($request->hasFile('logo')) {
            $gymData['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $gym = Gym::create($gymData);

        // Create the primary admin
        User::create([
            'name' => $validated['admin_name'],
            'email' => $validated['admin_email'],
            'password' => Hash::make($validated['admin_password']),
            'role' => 'gym_admin',
            'gym_id' => $gym->id,
        ]);

        // Create initial payment if provided
        if (!empty($validated['payment_amount']) && $validated['payment_amount'] > 0) {
            $gym->gymPayments()->create([
                'amount' => $validated['payment_amount'],
                'payment_date' => now()->toDateString(),
                'notes' => 'Initial signup payment',
            ]);
        }

        return redirect()->route('superadmin.gyms.index')->with('success', 'Gym and Admin created successfully.');
    }

    public function update(Request $request, Gym $gym)
    {
        // Find the primary admin
        $admin = $gym->admins()->where('role', 'gym_admin')->first();
        $adminId = $admin ? $admin->id : 'NULL';

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
            'subscription_start' => 'nullable|date',
            'subscription_end' => 'nullable|date',
            // Admin fields
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|string|email|max:255|unique:users,email,' . $adminId,
            'admin_password' => 'nullable|string|min:8',
        ]);

        $gymData = collect($validated)->except(['admin_name', 'admin_email', 'admin_password'])->toArray();

        if ($request->hasFile('logo')) {
            if ($gym->logo) Storage::disk('public')->delete($gym->logo);
            $gymData['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $gym->update($gymData);

        // Update the primary admin, or create one if it doesn't exist logically
        if ($admin) {
            $adminData = [
                'name' => $validated['admin_name'],
                'email' => $validated['admin_email'],
            ];
            
            if (!empty($validated['admin_password'])) {
                $adminData['password'] = Hash::make($validated['admin_password']);
            }
            
            $admin->update($adminData);
        } else {
             User::create([
                'name' => $validated['admin_name'],
                'email' => $validated['admin_email'],
                'password' => Hash::make($validated['admin_password'] ?? 'password123'),
                'role' => 'gym_admin',
                'gym_id' => $gym->id,
            ]);
        }

        return redirect()->route('superadmin.gyms.index')->with('success', 'Gym updated successfully.');
    }

    public function destroy(Gym $gym)
    {
        // Delete associated logo if exists
        if ($gym->logo) Storage::disk('public')->delete($gym->logo);
        
        // Delete the admins (might be handled by foreign key cascade, but let's be explicit)
        $gym->admins()->delete();
        
        $gym->delete();
        
        return redirect()->route('superadmin.gyms.index')->with('success', 'Gym and associated admins deleted successfully.');
    }

    public function toggleStatus(Request $request, Gym $gym)
    {
        $validated = $request->validate(['status' => 'required|in:active,inactive']);
        $gym->update(['status' => $validated['status']]);
        return redirect()->back()->with('success', "Gym status updated.");
    }

    public function addPayment(Request $request, Gym $gym)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $gym->gymPayments()->create($validated);

        return redirect()->back()->with('success', "Payment of Rs " . number_format($validated['amount'], 2) . " recorded successfully for " . $gym->name . ".");
    }
}
