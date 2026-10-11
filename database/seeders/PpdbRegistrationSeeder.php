<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PpdbRegistration;
use App\Models\Major;
use App\Models\User;

class PpdbRegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $rpl = Major::where('code', 'RPL')->first();
        $tkj = Major::where('code', 'TKJ')->first();
        $admin = User::first();

        if (!$rpl || !$tkj) return;

        $regs = [
            [
                'registration_code' => 'PPDB-20260330-1092',
                'major_id' => $rpl->id,
                'alternative_major_id' => $tkj->id,
                'nisn' => '0081234567',
                'nik' => '3201012304080001',
                'full_name' => 'Muhammad Fadhil Pratama',
                'gender' => 'L',
                'birth_place' => 'Bogor',
                'birth_date' => '2008-04-12',
                'religion' => 'Islam',
                'previous_school' => 'SMP Negeri 1 Cibinong',
                'student_phone' => '081298765432',
                'parent_phone' => '081311223344',
                'address' => 'Jl. Raya Bogor KM 42, Cibinong',
                'report_card_score' => 88.50,
                'status' => 'verified',
                'verification_notes' => 'Nilai dan NISN lolos validasi online.',
                'verified_by' => $admin ? $admin->id : null,
                'verified_at' => now(),
            ],
            [
                'registration_code' => 'PPDB-20260330-8841',
                'major_id' => $tkj->id,
                'alternative_major_id' => $rpl->id,
                'nisn' => '0087654321',
                'nik' => '3201011802080002',
                'full_name' => 'Aisyah Nur Rahmah',
                'gender' => 'P',
                'birth_place' => 'Jakarta',
                'birth_date' => '2008-02-18',
                'religion' => 'Islam',
                'previous_school' => 'MTs Negeri 2 Bogor',
                'student_phone' => '085712345678',
                'parent_phone' => '085811223344',
                'address' => 'Komplek Pesona Karadenan No. 5',
                'report_card_score' => 91.20,
                'status' => 'accepted',
                'verification_notes' => 'Lulus seleksi berkas gelombang 1 kuota utama.',
                'verified_by' => $admin ? $admin->id : null,
                'verified_at' => now(),
            ],
        ];

        foreach ($regs as $reg) {
            PpdbRegistration::updateOrCreate(['registration_code' => $reg['registration_code']], $reg);
        }
    }
}
