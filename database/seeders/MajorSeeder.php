<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Major;

class MajorSeeder extends Seeder
{
    public function run(): void
    {
        $majors = [
            [
                'code' => 'RPL',
                'name' => 'Rekayasa Perangkat Lunak',
                'slug' => 'rekayasa-perangkat-lunak',
                'description' => 'Fokus pada pengembangan aplikasi modern, microservices, cloud native, dan rekayasa web terstandarisasi.',
                'competencies' => 'Fullstack Web, Database PostgreSQL, Rest API, Git CI/CD',
                'career_prospects' => 'Software Engineer, Frontend Dev, Backend Engineer, QA Specialist',
                'quota' => 72,
                'thumbnail' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=600&q=80',
                'is_active' => true,
            ],
            [
                'code' => 'TKJ',
                'name' => 'Teknik Komputer & Jaringan',
                'slug' => 'teknik-komputer-dan-jaringan',
                'description' => 'Spesialisasi infrastruktur jaringan komputer, sistem server cloud, MikroTik MTCNA, dan keamanan siber.',
                'competencies' => 'Routing Cisco, Mikrotik MTCNA, Server Linux, Fiber Optik FTTH',
                'career_prospects' => 'Network Engineer, Cloud Administrator, Cyber Security Analyst',
                'quota' => 72,
                'thumbnail' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&w=600&q=80',
                'is_active' => true,
            ],
            [
                'code' => 'DKV',
                'name' => 'Desain Komunikasi Visual',
                'slug' => 'desain-komunikasi-visual',
                'description' => 'Eksplorasi visual grafis digital, animasi Islami berkarakter, branding produk, serta desain UI/UX mobile apps.',
                'competencies' => 'UI/UX Design Figma, Blender 3D, Premiere Pro, Adobe Illustrator',
                'career_prospects' => 'UI/UX Designer, Motion Graphic Artist, Creative Director',
                'quota' => 36,
                'thumbnail' => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?auto=format&fit=crop&w=600&q=80',
                'is_active' => true,
            ],
            [
                'code' => 'TKRO',
                'name' => 'Teknik Kendaraan Ringan Otomotif',
                'slug' => 'teknik-kendaraan-ringan-otomotif',
                'description' => 'Teknologi injeksi kendaraan modern (EFI), diagnosa berbasis komputer scanner OBD-II, dan sistem EV car.',
                'competencies' => 'Engine Tune-up EFI, Sistem Kelistrikan Body, Konversi Motor Listrik',
                'career_prospects' => 'Teknisi Dealer Resmi, Mekanik Industri Alat Berat, Wirausaha Bengkel',
                'quota' => 36,
                'thumbnail' => 'https://images.unsplash.com/photo-1486006920555-c77dce18193b?auto=format&fit=crop&w=600&q=80',
                'is_active' => true,
            ],
        ];

        foreach ($majors as $m) {
            Major::updateOrCreate(['code' => $m['code']], $m);
        }
    }
}
