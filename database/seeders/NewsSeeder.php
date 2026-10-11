<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\User;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        if (!$admin) return;

        $items = [
            [
                'author_id' => $admin->id,
                'title' => 'Juara 1 LKS Cloud Computing Tingkat Provinsi Jawa Barat 2026',
                'slug' => 'juara-1-lks-cloud-computing-jabar-2026',
                'category' => 'prestasi',
                'excerpt' => 'Siswa SMK TI Syariah kembali memborong medali emas di bidang infrastruktur awan dan DevOps.',
                'content' => 'Alhamdulillah, ananda Rayhan kelas XII RPL sukses mempersembahkan trofi juara 1 LKS Cloud Computing tingkat provinsi...',
                'status' => 'published',
                'published_at' => now(),
            ],
            [
                'author_id' => $admin->id,
                'title' => 'Kemitraan Strategis DUDI dengan 15 Perusahaan Teknologi Terkemuka',
                'slug' => 'kemitraan-strategis-dudi-2026',
                'category' => 'berita',
                'excerpt' => 'Penandatanganan kerja sama magang industri dan rekrutmen kerja lulusan langsung tanpa tes ulang.',
                'content' => 'Dalam rangka memperkuat link and match vokasi industri, SMK TI Syariah menjalin kerja sama strategis...',
                'status' => 'published',
                'published_at' => now(),
            ],
        ];

        foreach ($items as $item) {
            News::updateOrCreate(['slug' => $item['slug']], $item);
        }
    }
}
