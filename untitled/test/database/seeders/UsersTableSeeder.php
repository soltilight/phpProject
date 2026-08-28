<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'alex',
                'email' => 'alex@mail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'is_super_user' => false,
            ],
            [
                'name' => 'maria',
                'email' => 'maria@mail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'is_super_user' => false,
            ],
            [
                'name' => 'ivan',
                'email' => 'ivan@mail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'is_super_user' => false,
            ],
            [
                'name' => 'olga',
                'email' => 'olga@mail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'is_super_user' => false,
            ],
            [
                'name' => 'pavel',
                'email' => 'pavel@mail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'is_super_user' => false,
            ],
            [
                'name' => 'anna',
                'email' => 'anna@mail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'is_super_user' => false,
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                $user
            );
        }

        $this->command->info('✅ Пользователи добавлены (пропущены существующие)');
    }
}
