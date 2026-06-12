<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('admin.email');
        $password = config('admin.password');

        if (blank($email) || blank($password)) {
            throw new RuntimeException('Set ADMIN_EMAIL and ADMIN_PASSWORD before running AdminUserSeeder.');
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => config('admin.name', 'Admin'),
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ],
        );
    }
}
