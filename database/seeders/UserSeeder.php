<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_pass = env('ADMIN_PASS');
        $test_pass = env('TEST_PASS');
        User::create([
            'name' => 'Dana Tal',
            'email' => 'dana@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt($admin_pass), /* static::$password ??= Hash::make('password'), */
            'is_admin' => true,
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Test Test',
            'email' => 'test@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt($test_pass),
            'remember_token' => Str::random(10),
        ]);
        User::factory(8)->create();
    }
}
