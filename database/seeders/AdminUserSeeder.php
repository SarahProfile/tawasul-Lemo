<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate([
            'email' => 'admin@tawasullimo.com'
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);
    }
}
