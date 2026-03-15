<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Gym;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gymos.test',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
        ]);

        // Create Demo Gym
        $gym = Gym::create([
            'name' => 'Gymdesk-15',
            'address' => '123 Fitness St',
            'status' => 'active',
            'subscription_start' => now(),
            'subscription_end' => now()->addYear(),
        ]);

        // Create Gym Admin
        User::create([
            'name' => 'Gym Admin',
            'email' => 'admin@gymos.test',
            'password' => Hash::make('password'),
            'role' => 'gym_admin',
            'gym_id' => $gym->id,
        ]);

        // Seed dummy members only in non-production app environments.
        if (app()->environment(['local', 'staging'])) {
            $this->call(MemberSeeder::class);
        }
    }
}
