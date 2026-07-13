<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Buat akun admin default untuk login ke EMS Portal.
     * Role     : admin
     * Username : admin (bebas diganti saat login, asal password benar)
     * Password : admin123
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@admin.local'],
            [
                'name' => 'Administrator',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
            ]
        );
    }
}
