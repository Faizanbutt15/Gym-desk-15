<?php

namespace Database\Seeders;

use App\Models\Gym;
use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Seed 50 dummy members for the first gym.
     */
    public function run(): void
    {
        $gym = Gym::first();

        if (!$gym) {
            return;
        }

        for ($i = 0; $i < 50; $i++) {
            $status = fake()->boolean(80) ? 'active' : 'inactive';

            $feeDueDate = match (true) {
                $status === 'inactive' => now()->subDays(fake()->numberBetween(61, 180)),
                fake()->numberBetween(1, 100) <= 25 => now()->subDays(fake()->numberBetween(1, 30)), // expired
                fake()->numberBetween(1, 100) <= 45 => now()->addDays(fake()->numberBetween(0, 3)),  // expiring soon
                default => now()->addDays(fake()->numberBetween(4, 45)),                              // active/future
            };

            Member::create([
                'gym_id' => $gym->id,
                'member_id' => $this->generateMemberCode($gym->id),
                'name' => fake()->name(),
                'email' => fake()->boolean(85) ? fake()->unique()->safeEmail() : null,
                'contact' => fake()->numerify('03#########'),
                'fee_due_date' => $feeDueDate,
                'fee_amount' => fake()->randomElement([2000, 2500, 3000, 3500, 4000, 4500, 5000]),
                'admission_fee' => fake()->randomElement([0, 0, 500, 1000, 1500]),
                'trainer_fee' => fake()->boolean(35) ? fake()->randomElement([1000, 1500, 2000, 2500, 3000]) : 0,
                'locker_fee' => fake()->boolean(30) ? fake()->randomElement([300, 500, 700, 1000]) : 0,
                'status' => $status,
                'joined_date' => now()->subDays(fake()->numberBetween(1, 365)),
            ]);
        }
    }

    private function generateMemberCode(int $gymId): string
    {
        do {
            $code = sprintf('GYM%02d-%s', $gymId, fake()->unique()->numerify('#####'));
        } while (Member::where('member_id', $code)->exists());

        return $code;
    }
}

