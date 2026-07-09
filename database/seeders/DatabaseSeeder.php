<?php

namespace Database\Seeders;

use App\Models\Login;
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
        $admin = Login::firstOrCreate([
            'username' => 'admin',
        ], [
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        if (! Hash::check('password', $admin->password)) {
            $admin->password = Hash::make('password');
            $admin->save();
        }
    }
}
