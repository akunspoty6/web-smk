# BLUEPRINT ARSITEKTUR: WEB_SMK

## 1. Usecase Diagram & Skenario Interaksi Sistem

Sistem Informasi Web SMK mengidentifikasi tiga aktor utama dengan batasan hak akses yang tegas: Pengunjung (Publik), Calon Siswa (Pendaftar PPDB), dan Admin (Staf Administrasi & Verifikator).

A. DAFTAR AKTOR & DESKRIPSI PERAN:
1. Pengunjung (Guest): Aktor tanpa autentikasi yang dapat mengakses informasi profil sekolah, daftar konsentrasi keahlian/jurusan, fasilitas akademik/kejuruan, serta agenda dan artikel berita.
2. Calon Siswa (Applicant): Aktor yang mengakses layanan pendaftaran PPDB, mengisi formulir online, mengunggah berkas persyaratan, memperoleh kode unik registrasi, dan melakukan penelusuran status penerimaan seleksi secara berkala.
3. Administrator (Staf TU / Panitia PPDB): Aktor terotentikasi penuh dengan hak akses terhadap pengelolaan data master jurusan, publikasi warta/berita, data sarana-prasarana, verifikasi berkas PPDB, penentuan status hasil seleksi (Diterima / Ditolak / Cadangan), dan ekspor rekapitulasi data pendaftar.

B. DAFTAR USECASE & RELASI (INCLUDE / EXTEND):
1. UC-01: Menjelajahi Profil & Informasi Publik (Pengunjung)
2. UC-02: Melihat Rincian Konsentrasi Keahlian / Jurusan (Pengunjung, Calon Siswa)
3. UC-03: Melihat Fasilitas Sekolah (Pengunjung)
4. UC-04: Membaca Berita dan Pengumuman (Pengunjung, Calon Siswa)
5. UC-05: Mengajukan Pendaftaran PPDB Online (Calon Siswa)
   - <<include>>: Validasi Input & Format Berkas (UC-05a)
   - <<include>>: Generate Kode Registrasi Otomatis (UC-05b)
   - <<extend>>: Cetak Bukti Registrasi PDF (UC-05c)
6. UC-06: Memeriksa Status Seleksi PPDB (Calon Siswa)
   - <<include>>: Verifikasi Kode Registrasi & NISN (UC-06a)
7. UC-07: Login Dashboard Administratif (Admin)
   - <<include>>: Autentikasi Kredensial & Proteksi Sesi (UC-07a)
8. UC-08: Mengelola Master Data Jurusan (Admin) [CRUD]
9. UC-09: Mengelola Berita dan Pengumuman (Admin) [CRUD]
10. UC-10: Mengelola Inventaris Fasilitas (Admin) [CRUD]
11. UC-11: Verifikasi dan Seleksi Berkas PPDB (Admin)
   - <<include>>: Mutasi Status Seleksi Calon Siswa (UC-11a)
   - <<extend>>: Berikan Catatan Perbaikan Berkas (UC-11b)
12. UC-12: Ekspor Rekapitulasi Data Pendaftar (Admin)

C. SPESIFIKASI USECASE KRUSIAL:
- Kasus: UC-05 (Pendaftaran PPDB Online)
  * Primary Actor: Calon Siswa
  * Pre-condition: Jalur PPDB berstatus aktif dan kuota pendaftaran belum ditutup.
  * Main Success Scenario:
    1. Calon siswa mengakses menu PPDB dan memilih jurusan prioritas.
    2. Sistem menampilkan formulir data diri, data orang tua, data akademik asal sekolah, dan upload berkas.
    3. Calon siswa mengisi seluruh field dan mengunggah dokumen digital (kartu keluarga, rapor, ijazah/SKL).
    4. Sistem melakukan validasi tipe file (PDF/JPG/PNG maksimal 2MB) dan keunikan NISN.
    5. Sistem membangkitkan Registration Code terenkripsi/unik berbasis format timestamp dan hash urutan.
    6. Sistem menyimpan data ke basis data dengan status default 'PENDING'.
    7. Sistem menampilkan ringkasan data pendaftaran beserta tombol 'Unduh Kartu Registrasi'.
  * Post-condition: Record tersimpan di tabel `ppdb_registrations`, kode pendaftaran diterbitkan ke calon siswa.

## 2. ERD (Entity Relationship Diagram) & Skema Database Relasional

Basis data dirancang menggunakan arsitektur relasional normalisasi bentuk ketiga (3NF) guna menjamin konsistensi data, integritas referensial antar-tabel, dan efisiensi query beban tinggi saat periode PPDB.

A. DEFINISI ENTITAS DAN STRUKTUR KOLOM:

1. Tabel: `users` (Manajemen Akun Panitia & Administrator)
- `id` (BIGINT, Unsigned, Auto Increment, Primary Key)
- `name` (VARCHAR(100), Not Null) - Nama lengkap staf/admin
- `email` (VARCHAR(150), Not Null, Unique) - Identitas otentikasi
- `password` (VARCHAR(255), Not Null) - Hash bcrypt
- `role` (ENUM('superadmin', 'admin_ppdb', 'editor'), Not Null, Default: 'admin_ppdb')
- `phone_number` (VARCHAR(20), Nullable)
- `remember_token` (VARCHAR(100), Nullable)
- `created_at` (TIMESTAMP, Nullable)
- `updated_at` (TIMESTAMP, Nullable)

2. Tabel: `majors` (Data Master Program/Konsentrasi Keahlian)
- `id` (BIGINT, Unsigned, Auto Increment, Primary Key)
- `code` (VARCHAR(10), Not Null, Unique) - Contoh: 'RPL', 'TKJ', 'DKV'
- `name` (VARCHAR(150), Not Null) - Nama Program Keahlian
- `slug` (VARCHAR(150), Not Null, Unique) - Slug URL ramah SEO
- `description` (TEXT, Not Null) - Gambaran umum jurusan
- `competencies` (TEXT, Not Null) - Capaian kompetensi keahlian
- `career_prospects` (TEXT, Nullable) - Peluang kerja lulusan
- `quota` (INT, Unsigned, Not Null, Default: 0) - Daya tampung siswa baru
- `thumbnail` (VARCHAR(255), Nullable) - Jalur penyimpanan gambar
- `is_active` (BOOLEAN, Not Null, Default: TRUE)
- `created_at` (TIMESTAMP, Nullable)
- `updated_at` (TIMESTAMP, Nullable)

3. Tabel: `news` (Kanal Warta dan Agenda Sekolah)
- `id` (BIGINT, Unsigned, Auto Increment, Primary Key)
- `author_id` (BIGINT, Unsigned, Not Null) - Foreign Key ke `users.id`
- `title` (VARCHAR(255), Not Null)
- `slug` (VARCHAR(255), Not Null, Unique)
- `category` (ENUM('berita', 'agenda', 'prestasi', 'pengumuman'), Not Null, Default: 'berita')
- `excerpt` (VARCHAR(500), Not Null) - Ringkasan artikel
- `content` (LONGTEXT, Not Null)
- `featured_image` (VARCHAR(255), Nullable)
- `status` (ENUM('draft', 'published'), Not Null, Default: 'draft')
- `published_at` (DATETIME, Nullable)
- `created_at` (TIMESTAMP, Nullable)
- `updated_at` (TIMESTAMP, Nullable)

4. Tabel: `facilities` (Inventaris Sarana & Prasarana Sekolah)
- `id` (BIGINT, Unsigned, Auto Increment, Primary Key)
- `name` (VARCHAR(150), Not Null) - Nama laboratorium / ruang praktik / sarana
- `category` (ENUM('laboratorium', 'bengkel', 'ruang_kelas', 'sarana_olahraga', 'fasilitas_umum'), Not Null)
- `description` (TEXT, Nullable)
- `image_path` (VARCHAR(255), Nullable)
- `capacity` (INT, Unsigned, Nullable) - Kapasitas tampung orang
- `condition` (ENUM('sangat_baik', 'baik', 'pemeliharaan'), Not Null, Default: 'baik')
- `is_public` (BOOLEAN, Not Null, Default: TRUE)
- `created_at` (TIMESTAMP, Nullable)
- `updated_at` (TIMESTAMP, Nullable)

5. Tabel: `ppdb_registrations` (Entitas Utama Pendaftaran Peserta Didik Baru)
- `id` (BIGINT, Unsigned, Auto Increment, Primary Key)
- `registration_code` (VARCHAR(25), Not Null, Unique) - Format: 'PPDB-YYYYMMDD-XXXX'
- `major_id` (BIGINT, Unsigned, Not Null) - Foreign Key ke `majors.id` (Pilihan Utama)
- `alternative_major_id` (BIGINT, Unsigned, Nullable) - Foreign Key ke `majors.id` (Pilihan Kedua)
- `nisn` (CHAR(10), Not Null, Unique) - Nomor Induk Siswa Nasional
- `nik` (CHAR(16), Not Null) - Nomor Induk Kependudukan
- `full_name` (VARCHAR(150), Not Null)
- `gender` (ENUM('L', 'P'), Not Null)
- `birth_place` (VARCHAR(100), Not Null)
- `birth_date` (DATE, Not Null)
- `religion` (VARCHAR(30), Not Null)
- `previous_school` (VARCHAR(150), Not Null) - Asal SMP / MTs
- `student_phone` (VARCHAR(20), Not Null)
- `parent_phone` (VARCHAR(20), Not Null)
- `address` (TEXT, Not Null)
- `report_card_score` (DECIMAL(5,2), Not Null) - Rata-rata nilai rapor
- `document_kk_path` (VARCHAR(255), Not Null) - Scan Kartu Keluarga
- `document_raport_path` (VARCHAR(255), Not Null) - Scan Rapor / SKL
- `document_photo_path` (VARCHAR(255), Not Null) - Pas foto formal
- `status` (ENUM('pending', 'verified', 'accepted', 'rejected'), Not Null, Default: 'pending')
- `verification_notes` (TEXT, Nullable) - Catatan admin/alasan penolakan
- `verified_by` (BIGINT, Unsigned, Nullable) - Foreign Key ke `users.id`
- `verified_at` (DATETIME, Nullable)
- `created_at` (TIMESTAMP, Nullable)
- `updated_at` (TIMESTAMP, Nullable)

B. RELASI DAN KARDINALITAS DATABASE:
1. `users` (1) ke `news` (N): One-to-Many. Satu user (author) dapat mempublikasikan banyak berita. ON DELETE RESTRICT, ON UPDATE CASCADE.
2. `users` (1) ke `ppdb_registrations` (N): One-to-Many. Satu admin dapat memverifikasi banyak pendaftar (`verified_by`). ON DELETE SET NULL, ON UPDATE CASCADE.
3. `majors` (1) ke `ppdb_registrations` (N): One-to-Many. Satu konsentrasi keahlian dapat dipilih oleh banyak pendaftar sebagai jurusan primer (`major_id`) maupun alternatif (`alternative_major_id`). ON DELETE RESTRICT, ON UPDATE CASCADE.
4. Foreign Key Constraints:
   - `news.author_id` REFERENCES `users.id`
   - `ppdb_registrations.major_id` REFERENCES `majors.id`
   - `ppdb_registrations.alternative_major_id` REFERENCES `majors.id`
   - `ppdb_registrations.verified_by` REFERENCES `users.id`

## 3. Activity Diagram: Alur Pendaftaran PPDB Online

Berikut adalah urutan sistematis interaksi swimlane antara Calon Siswa, Antarmuka Web (Frontend Blade + JS Modular), Application Logic (Laravel Controller & Services), dan Database Relasional.

SWIMLANE 1: CALON SISWA
SWIMLANE 2: WEB CLIENT FRONTEND
SWIMLANE 3: LARAVEL BACKEND CONTROLLER & SERVICE
SWIMLANE 4: DATABASE RELASIONAL (MYSQL / POSTGRES)

URUTAN ALUR AKTIVITAS:
1. [Calon Siswa] Membuka URL portal resmi PPDB (/ppdb/daftar).
2. [Web Client] Mengirim request HTTP GET untuk memuat formulir pendaftaran.
3. [Laravel Backend] Query daftar jurusan yang aktif (`is_active = true`) dari database.
4. [Database] Mengembalikan kumpulan data jurusan.
5. [Laravel Backend] Render view form PPDB beserta inject CSRF Token.
6. [Web Client] Menampilkan antarmuka formulir bertahap (Data Pribadi, Data Sekolah, Pilihan Jurusan, Unggah Berkas).
7. [Calon Siswa] Mengisi seluruh field, memilih preferensi jurusan, dan mengunggah dokumen digital (KK, Rapor, Foto).
8. [Web Client] Menjalankan validasi sisi klien (tipe file, batas ukuran maksimal 2MB, format NISN 10 digit numerik).
   - Kondisi [Validasi Klien Gagal]: Tampilkan alert validasi inline; Siswa memperbaiki input.
   - Kondisi [Validasi Klien Berhasil]: Lanjutkan kirim HTTP POST payload multipart/form-data.
9. [Laravel Backend] Menerima request HTTP POST, mengeksekusi sanitasi string dan Server-Side Validation via `StorePpdbRequest`.
   - Kondisi [Validasi Server Gagal]: Kembalikan HTTP 422 dengan pesan error; Web Client menampilkan pesan error.
   - Kondisi [Validasi Server Berhasil]: Mulai blok Database Transaction (`DB::beginTransaction()`).
10. [Laravel Backend] Memeriksa keunikan NISN terhadap pendaftaran yang sedang berlangsung.
11. [Laravel Backend] Simpan berkas dokumen ke storage privat/terproteksi (`storage/app/ppdb_documents`) dan catat file path.
12. [Laravel Backend] Eksekusi Registration Code Generator Service:
    - Pola: 'REG-' + Date('Ymd') + '-' + Str::upper(Str::random(4))
    - Pemeriksaan anti-collision: Pastikan kode registrasi belum terdaftar dalam tabel.
13. [Laravel Backend] Memasukkan record lengkap ke dalam tabel `ppdb_registrations` dengan status default 'pending'.
14. [Database] Eksekusi query INSERT dan komit transaksi (`DB::commit()`).
15. [Laravel Backend] Mengirimkan respon sukses HTTP 201 dengan data flash payload kode pendaftaran ke session.
16. [Web Client] Redirect ke halaman terminasi sukses (/ppdb/bukti-pendaftaran/{code}).
17. [Calon Siswa] Melihat status registrasi 'PENDING' dan mengunduh Kartu Bukti Registrasi dalam format PDF/Cetak Mandiri.

ALUR PARALEL VERIFIKASI (ADMIN SISTEM):
18. [Admin] Melakukan otentikasi ke panel /admin/ppdb.
19. [Admin] Membuka antarmuka verifikasi berkas pendaftar.
20. [Laravel Backend] Mengambil data detail calon siswa dan URL dokumen fisik terenkripsi.
21. [Admin] Memeriksa kecocokan nilai rapor, keabsahan kartu keluarga, dan status NISN.
22. [Admin] Menentukan keputusan: Ubah status menjadi 'verified', 'accepted', atau 'rejected' beserta input catatan koreksi.
23. [Database] Mengupdate status pada baris `ppdb_registrations` beserta ID verifikator dan timestamp.
24. [Calon Siswa] Saat mengakses halaman /ppdb/cek-status menggunakan NISN & Kode Registrasi, sistem menampilkan status penerimaan teranyar secara real-time.

## 4. Spesifikasi Arsitektur, Route/API & Struktur File Pendukung

A. PANDUAN DESAIN ANTARMUKA (DESIGN.md GUIDELINES):
- Karakter Visual: Bersih, profesional, editorial akademis tanpa elemen visual berlebihan (no AI slop).
- Tipografi: 'Plus Jakarta Sans', sans-serif (Google Fonts), hierarki font-weight: 400 (Body), 500 (Subheading), 700 (Header & Badge).
- Skema Palet Warna:
  * Primary (Navy): `#0F172A` (Slate 900) - Header, navbar primer, tipografi utama.
  * Secondary (Slate/Cool Grey): `#475569` (Slate 600) - Body text, border outline, subtle state.
  * Accent (Amber): `#D97706` (Amber 600) / Hover `#B45309` - Tombol CTA, highlight status, badge prestasi.
  * Surface & Background: `#F8FAFC` (Slate 50) - Latar belakang web; `#FFFFFF` - Card container.
  * Semantic Status: Sukses (`#16A34A`), Tertunda (`#EA580C`), Gagal (`#DC2626`).
- Layouting: Bootstrap 5 Mobile-First Grid System, Fluid Container, Sticky Navigation, Zero generic full-screen overlays.

B. SPESIFIKASI ROUTING LARAVEL (WEB & ENDPOINTS):

1. Publik & Pengunjung:
- GET  `/`                              -> `HomeController@index` (Landing page profil, highlight jurusan, berita terbaru)
- GET  `/jurusan`                       -> `MajorController@index` (Katalog konsentrasi keahlian)
- GET  `/jurusan/{slug}`                -> `MajorController@show` (Detail kurikulum, prospek & sarana jurusan)
- GET  `/fasilitas`                     -> `FacilityController@index` (Galeri sarana & prasarana terfilter)
- GET  `/berita`                        -> `NewsController@index` (Arsip warta sekolah dengan paginasi)
- GET  `/berita/{slug}`                 -> `NewsController@show` (Detail artikel warta & berita terkait)

2. Modul Layanan PPDB Online:
- GET  `/ppdb`                          -> `PpdbController@index` (Informasi jalur seleksi, jadwal & alur)
- GET  `/ppdb/daftar`                   -> `PpdbController@create` (Tampilan form formulir PPDB online)
- POST `/ppdb/daftar`                   -> `PpdbController@store` (Handler submit data pendaftaran + generator kode)
- GET  `/ppdb/sukses/{code}`            -> `PpdbController@success` (Halaman konfirmasi & cetak bukti)
- GET  `/ppdb/cek-status`               -> `PpdbController@checkStatusForm` (Tampilan form lacak seleksi)
- POST `/ppdb/cek-status`               -> `PpdbController@processCheckStatus` (Handler pencarian status via NISN & Kode)
- GET  `/ppdb/unduh-kartu/{code}`       -> `PpdbController@downloadCard` (Stream dokumen bukti registrasi)

3. Administrator Dashboard (Middleware: `auth`, `role:admin`):
- GET  `/admin/dashboard`               -> `Admin\DashboardController@index` (Statistik pendaftar, kuota, metrik berita)
- RESOURCE `/admin/jurusan`            -> `Admin\MajorController` (CRUD Master data keahlian)
- RESOURCE `/admin/fasilitas`          -> `Admin\FacilityController` (CRUD Master fasilitas)
- RESOURCE `/admin/berita`             -> `Admin\NewsController` (CRUD Publikasi artikel warta)
- GET  `/admin/ppdb`                    -> `Admin\PpdbController@index` (Tabel pendaftar terfilter status & jurusan)
- GET  `/admin/ppdb/{id}`               -> `Admin\PpdbController@show` (Review berkas & detail calon siswa)
- PATCH `/admin/ppdb/{id}/status`       -> `Admin\PpdbController@updateStatus` (Aksi verifikasi, terima, atau tolak)
- GET  `/admin/ppdb/export/excel`       -> `Admin\PpdbController@exportExcel` (Rekapitulasi berkas pendaftaran)

C. STRUKTUR POHON DIREKTORI PROYEK (LARAVEL CLEAN MVC ARCHITECTURE):

web_smk/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── FacilityController.php
│   │   │   │   ├── MajorController.php
│   │   │   │   ├── NewsController.php
│   │   │   │   └── PpdbController.php
│   │   │   ├── Auth/
│   │   │   │   └── LoginController.php
│   │   │   ├── FacilityController.php
│   │   │   ├── HomeController.php
│   │   │   ├── MajorController.php
│   │   │   ├── NewsController.php
│   │   │   └── PpdbController.php
│   │   ├── Middleware/
│   │   │   ├── Authenticate.php
│   │   │   └── RoleMiddleware.php
│   │   └── Requests/
│   │       ├── StoreMajorRequest.php
│   │       ├── StoreNewsRequest.php
│   │       ├── StorePpdbRequest.php
│   │       └── UpdatePpdbStatusRequest.php
│   ├── Models/
│   │   ├── Facility.php
│   │   ├── Major.php
│   │   ├── News.php
│   │   ├── PpdbRegistration.php
│   │   └── User.php
│   └── Services/
│       ├── FileUploadService.php
│       └── RegistrationCodeGenerator.php
├── database/
│   ├── factories/
│   ├── migrations/
│   │   ├── 2026_03_30_000001_create_users_table.php
│   │   ├── 2026_03_30_000002_create_majors_table.php
│   │   ├── 2026_03_30_000003_create_news_table.php
│   │   ├── 2026_03_30_000004_create_facilities_table.php
│   │   └── 2026_03_30_000005_create_ppdb_registrations_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── MajorSeeder.php
│       ├── FacilitySeeder.php
│       └── UserAdminSeeder.php
├── docs/
│   ├── DESIGN.md
│   └── SPESIFIKASI_ARSITEKTUR_SMK.docx
├── resources/
│   ├── js/
│   │   ├── app.js
│   │   └── modules/
│   │       ├── ppdb-form-wizard.js
│   │       ├── ppdb-status-checker.js
│   │       └── admin-status-updater.js
│   ├── scss/
│   │   ├── app.scss
│   │   ├── _variables.scss
│   │   ├── _typography.scss
│   │   └── _components.scss
│   └── views/
│       ├── layouts/
│       │   ├── admin.blade.php
│       │   └── public.blade.php
│       ├── public/
│       │   ├── home.blade.php
│       │   ├── majors/
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   ├── facilities/
│       │   │   └── index.blade.php
│       │   ├── news/
│       │   │   ├── index.blade.php
│       │   │   └── show.blade.php
│       │   └── ppdb/
│       │       ├── index.blade.php
│       │       ├── register.blade.php
│       │       ├── check-status.blade.php
│       │       └── success-card.blade.php
│       └── admin/
│           ├── dashboard.blade.php
│           ├── majors/
│           ├── news/
│           ├── facilities/
│           └── ppdb/
│               ├── index.blade.php
│               └── show.blade.php
├── routes/
│   ├── api.php
│   └── web.php
├── storage/
│   └── app/
│       ├── private/ppdb_documents/
│       └── public/
│           ├── news/
│           └── facilities/
├── package.json
├── vite.config.js
└── composer.json

