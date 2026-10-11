<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            [
                'name' => 'Lab Cloud & DevOps Enterprise',
                'category' => 'laboratorium',
                'description' => 'Ruang praktikum ber-AC dengan 36 unit PC workstation Core i7, dual monitor, dan server lokal.',
                'capacity' => 36,
                'condition' => 'sangat_baik',
                'is_public' => true,
            ],
            [
                'name' => 'Bengkel Otomotif Konversi EV & EFI',
                'category' => 'bengkel',
                'description' => 'Lengkap dengan 2 hydraulic lift, computerized engine scanner, dan bengkel uji emisi gas.',
                'capacity' => 40,
                'condition' => 'sangat_baik',
                'is_public' => true,
            ],
            [
                'name' => 'Studio Multimedia & Podcast DKV',
                'category' => 'laboratorium',
                'description' => 'Acoustic soundproof chamber, lighting studio, kamera 4K cinema dan pen tablet.',
                'capacity' => 24,
                'condition' => 'baik',
                'is_public' => true,
            ],
            [
                'name' => 'Masjid Jami & Islamic Center Siswa',
                'category' => 'fasilitas_umum',
                'description' => 'Pusat ibadah harian, halaqah Quran, kajian adab, dan pembinaan ruhiyah berdaya tampung 800 orang.',
                'capacity' => 800,
                'condition' => 'sangat_baik',
                'is_public' => true,
            ],
        ];

        foreach ($facilities as $f) {
            Facility::updateOrCreate(['name' => $f['name']], $f);
        }
    }
}
