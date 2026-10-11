<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@smk.sch.id'],
            [
                'name' => 'Ust. Ahmad Fauzi, S.Kom',
                'password' => Hash::make('password123'),
                'role' => 'superadmin',
                'phone_number' => '081298765432',
            ]
        );

        User::updateOrCreate(
            ['email' => 'verifikator@smk.sch.id'],
            [
                'name' => 'Siti Nurhaliza, S.Pd',
                'password' => Hash::make('password123'),
                'role' => 'admin_ppdb',
                'phone_number' => '081311223344',
            ]
        );
    }
}
