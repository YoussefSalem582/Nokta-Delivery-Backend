<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\RiderProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@nokta.app',
            'phone' => '+201000000001',
            'password' => Hash::make('AdminPass123!'),
            'role' => 'ADMIN',
        ]);

        $rider = User::create([
            'name' => 'Demo Rider',
            'email' => 'rider@nokta.app',
            'phone' => '+201000000002',
            'password' => Hash::make('RiderPass123!'),
            'role' => 'RIDER',
            'wallet_balance' => 500,
        ]);

        RiderProfile::create([
            'user_id' => $rider->id,
        ]);
    }
}
