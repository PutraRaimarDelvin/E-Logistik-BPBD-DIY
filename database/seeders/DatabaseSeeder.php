<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
   public function run(): void
{
    User::updateOrCreate(
    ['email' => 'admin@bpbd.com'],
    [
        'name' => 'Admin BPBD',
        'password' => Hash::make('password123'),
        'role' => 'admin',
        'is_admin' => 1,
        'email_verified_at' => now(),
    ]
);

User::updateOrCreate(
    ['email' => 'user@gmail.com'],
    [
        'name' => 'User Biasa',
        'password' => Hash::make('password123'),
        'role' => 'user',
        'is_admin' => 0,
        'email_verified_at' => now(),
    ]
);

}

}