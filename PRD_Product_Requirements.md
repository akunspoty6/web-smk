# WEB_SMK — PRODUCT REQUIREMENTS DOCUMENT (PRD)
**Version:** 1.0.0  
**Author / PM:** Senior VP of Product / CTO Office  
**Technical Lead:** Lead Systems Architect  
**Design Lead:** Agent Pixel (UI/UX Principal)  
**Engineering Lead:** Agent Dev (Worker Lead)  
**Status:** Approved for Implementation  
**Target Release:** Sprint Q3-2026 / Release v1.0.0-PROD  
**Repository Path:** `/root/pm-studio/workspace/web_smk/PRD.md`  

---

## 1. EXECUTIVE SUMMARY & PROBLEM STATEMENT

### 1.1 Problem Statement
SMK (Sekolah Menengah Kejuruan) menghadapi tantangan disrupsi ganda: keharusan mendisrupsi proses operasional manual konvensional serta tuntutan menyajikan citra kelembagaan yang modern, terpercaya, dan kredibel di mata industri serta calon peserta didik.

* **Fasilitas & Profil Jurusan Kurang Terartikulasi:** Informasi keunggulan kompetitif kompetensi keahlian (jurusan) dan fasilitas bengkel/laboratorium standar industri sering kali tercecer di brosur fisik yang cepat usang, menyebabkan calon wali murid meragukan kapabilitas sekolah.
* **Proses PPDB (Penerimaan Peserta Didik Baru) Konvensional & Rentan Galat:** Alur pendaftaran manual menimbulkan penumpukan antrean fisik, risiko redudansi data identitas (NISN ganda), kehilangan berkas fisik, dan kebingungan calon siswa dalam memantau status seleksi secara berkala (*black box process*).
* **Beban Administratif Verifikator Tinggi:** Panitia PPDB menghabiskan lebih dari 70% waktu kerja efektif hanya untuk mencocokkan data formulir manual ke spreadsheet, rentan kesalahan manusia (*human error*), serta tidak adanya jejak audit (*audit trail*) verifikasi data.

### 1.2 Objective & Strategic Goals
Membangun platform ekosistem web terpadu **WEB_SMK** yang bertindak sebagai etalase digital profesional sekolah dan mesin otomasi pendaftaran calon siswa berbasis web (*web-based digital admission engine*). Sistem ini mengintegrasikan portal publik profil institusi dengan modul *PPDB Online*, pelacak status instan, dan *back-office dashboard* terotentikasi yang tangguh, aman, dan berkinerja tinggi.

### 1.3 Success Metrics (OKRs & KPIs)

| Metric Area | Baseline (Manual) | Target v1.0.0 (Sistem Baru) | Metode Pengukuran |
|---|---|---|---|
| **Waktu Registrasi Calon Siswa** | 45-60 menit (antre fisik) | < 5 menit per pendaftar | Telemetri durasi submit formulir |
| **Integritas & Duplikasi Data NISN** | 8-12% galat entri data | 0% (Zero duplicate NISN) | *Database Unique Constraint & Server Validation* |
| **Turnaround Verifikasi Panitia** | 3-5 hari kerja | < 24 jam kerja per berkas | Dashboard SLA Monitoring |
| **Beban Tiket Pertanyaan Status** | Rata-rata 200+ chat/telepon per hari | Reduksi > 85% via fitur Cek Status | Volume log pencarian modul Cek Status |
| **Core Web Vitals Portal Publik** | LCP > 4.2s, CLS > 0.25 | LCP < 1.5s, FID/INP < 100ms, CLS < 0.05 | Google Lighthouse & Production APM |

---

## 2. USER PERSONAS & ROLES

```
               ┌────────────────────────────────────────────────────────┐
               │                     WEB_SMK ROLES                      │
               └────────────────────────────────────────────────────────┘
                                           │
         ┌─────────────────────────────────┼────────────────────────────────┐
         ▼                                 ▼                                ▼
┌─────────────────┐               ┌─────────────────┐              ┌─────────────────┐
│   Pengunjung    │               │   Calon Siswa   │              │   Admin / Staf  │
│  (Masyarakat/   │               │   (Pendaftar    │              │      Sekolah    │
│   Orang Tua)    │               │      PPDB)      │              │ (Back-Office)   │
└─────────────────┘               └─────────────────┘              └─────────────────┘
```

| Role / Persona | Profil & Karakteristik | Tanggung Jawab & Kebutuhan Kunci (*Jobs to be Done*) |
|---|---|---|
| **Pengunjung (Guest)** | Orang tua murid, alumni, atau mitra industri yang mengakses melalui *smartphone* atau komputer. | Memeriksa legitimasi sekolah, akreditasi, silabus kompetensi keahlian (jurusan), berita terkini, dan kelayakan fasilitas penunjang belajar. |
| **Calon Siswa (Applicant)** | Siswa lulusan SMP/MTs sederajat dengan literasi digital mobile-first, butuh alur ringkas tanpa friksi. | Mengisi formulir pendaftaran PPDB online, mengunggah identitas diri, mendapatkan kode pendaftaran unik, serta melacak status penerimaan secara transparan. |
| **Petugas Verifikator / Admin** | Panitia PPDB internal & Staf Tata Usaha sekolah yang bekerja di desktop/laptop. | Memvalidasi berkas pendaftar, mengubah status seleksi (*Approved/Rejected*), mengelola data master jurusan, berita/agenda, dan fasilitas sekolah. |
| **Super Admin (Kepala Sekolah/IT)** | Penanggung jawab teknis dan manajerial tertinggi sistem. | Memantau ringkasan statistik pendaftaran, mengelola akun hak akses staf (*RBAC*), memantau log keamanan, dan mengekspor rekapitulasi data pendaftar. |

---

## 3. SCOPE DEFINITION (MOSCOW METHOD)

### 3.1 Must Have (P0) — Wajib untuk Rilis v1.0.0
* **Landing Page & Public Portal:** Tampilan profil sekolah, etalase jurusan interaktif, galeri fasilitas, dan kanal berita/artikel dinamis.
* **Modul Pendaftaran PPDB:** Formulir pendaftaran calon siswa multi-input dengan validasi data ketat (NISN, NIK, Biodata, Asal Sekolah, Pilihan Jurusan).
* **Generator Kode Registrasi Unik:** Algoritma deterministik/inkremental anti-kolisi berformat: `REG-YYYYMMDD-XXXX` (contoh: `REG-20260615-0042`).
* **Fitur Cek Status PPDB Real-time:** Pencarian publik berbasis kombinasi `Nomor Registrasi` dan `NISN` untuk transparansi proses seleksi tanpa login akun.
* **Autentikasi & RBAC Back-office:** Sistem login admin berbasis proteksi sesi, enkripsi kata sandi *Bcrypt/Argon2id*, dan pemisahan wewenang (*Super Admin* vs *Staf Verifikator*).
* **Dashboard Manajemen Data:** Panel CRUD untuk Data Jurusan, Fasilitas, Berita, dan Verifikasi Berkas PPDB (Status: *Pending, Terverifikasi, Diterima, Ditolak*).
* **Integritas Relasi Basis Data:** Foreign keys, indexasi performa tinggi, dan constraint konsistensi data relasional.

### 3.2 Should Have (P1) — Prioritas Tinggi Fase Stabilisasi
* **Ekspor Data Pendaftar:** Fitur unduh rekapitulasi data pendaftar PPDB ke format CSV/Excel dengan filter tanggal dan jurusan.
* **Cetak Bukti Pendaftaran (PDF):** Cetak kartu pendaftaran resmi ber-barcode/QR code untuk kebutuhan verifikasi fisik saat daftar ulang.
* **Search & Filter Lanjutan Admin:** Pencarian instan pendaftar berdasarkan nama, asal sekolah, atau status verifikasi via AJAX/Fetch API.

### 3.3 Could Have (P2) — Peningkatan Fase Berikutnya
* **WhatsApp Notification Engine:** Webhook notifikasi otomatis via WhatsApp API saat status pendaftaran berubah.
* **Modul Pre-assessment / Ujian CBT Mini:** Tes potensi akademik ringan langsung di dalam platform.

### 3.4 Out of Scope (Won't Have v1.0.0) — Dilarang Dikerjakan di Rilis Ini
* Modul Sistem Informasi Akademik (SIAKAD) harian, rapor siswa, dan presensi kelas.
* Modul Pembayaran SPP / Integrasi Payment Gateway (pembayaran tetap via transfer manual bank sekolah).
* Modul Learning Management System (LMS) pengumpulan tugas guru-siswa.

---

## 4. FUNCTIONAL REQUIREMENTS (FR)

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                       MATRIKS FUNCTIONAL REQUIREMENTS                       │
└─────────────────────────────────────────────────────────────────────────────┘
  [FR-PUB] Portal Publik  ──►  Profil, Jurusan, Berita, Fasilitas
  [FR-REG] Mesin PPDB     ──►  Input Data, Validasi NISN, Auto-Gen Kode
  [FR-TRK] Pelacak Status ──►  Query Status Real-Time (No Register + NISN)
  [FR-ADM] Back-Office    ──►  RBAC, Verifikasi PPDB, CRUD Konten, Analytics
```

| ID | Modul | Aktor | Deskripsi Fungsional Spesifik | Prioritas |
|---|---|---|---|---|
| **FR-PUB-01** | Profil Institusi | Pengunjung | Sistem menampilkan visi, misi, struktur organisasi, dan sejarah sekolah secara terstruktur. | P0 |
| **FR-PUB-02** | Katalog Jurusan | Pengunjung | Sistem merender daftar kompetensi keahlian lengkap dengan silabus, prospek karir, kuota, dan foto dokumentasi. | P0 |
| **FR-PUB-03** | Galeri Fasilitas | Pengunjung | Sistem menampilkan inventaris fasilitas sekolah (Lab, Bengkel, Lapangan, dll.) beserta kategori dan deskripsinya. | P0 |
| **FR-PUB-04** | Kanal Berita/Kabar | Pengunjung | Sistem menyajikan artikel, pengumuman, dan agenda terkini dilengkapi dengan fitur pencarian dan paginasi server-side. | P0 |
| **FR-REG-01** | Formulir PPDB | Calon Siswa | Sistem menyediakan formulir pendaftaran bertahap yang mencakup identitas diri, identitas orang tua, data akademik, dan pilihan 2 jurusan prioritas. | P0 |
| **FR-REG-02** | Validasi Input PPDB | Calon Siswa | Sistem melakukan validasi ketat: NISN (10 digit angka), NIK (16 digit angka), nomor WhatsApp aktif, format email, dan batas usia pendaftar. | P0 |
| **FR-REG-03** | Generator Kode | Sistem (Auto) | Sistem menghasilkan kode registrasi unik atomic transactional `REG-YYYYMMDD-XXXX` segera setelah submit formulir berhasil. | P0 |
| **FR-TRK-01** | Cek Status Mandiri | Calon Siswa | Sistem menyediakan portal lookup publik: input Kode Registrasi + NISN -> memunculkan rincian status verifikasi terkini beserta catatan verifikator. | P0 |
| **FR-AUTH-01** | Autentikasi Admin | Admin | Sistem memverifikasi kredensial staf melalui proteksi sesi, rate-limiting login (maks 5 percobaan/menit), dan CSRF token. | P0 |
| **FR-ADM-01** | Dashboard Utama | Admin | Sistem menampilkan metrik ringkas: Total Pendaftar, Pendaftar per Jurusan, Status Verifikasi, dan Grafik pendaftaran harian. | P0 |
| **FR-ADM-02** | Verifikasi PPDB | Admin | Admin dapat mengubah status pendaftaran (`Pending`, `Terverifikasi`, `Diterima`, `Ditolak`) disertai kolom input catatan revisi/alasan. | P0 |
| **FR-ADM-03** | Kelola Jurusan | Admin | Admin memiliki hak akses penuh membuat, membaca, memperbarui, dan menonaktifkan data kompetensi keahlian (`majors`). | P0 |
| **FR-ADM-04** | Kelola Fasilitas | Admin | Admin dapat mengelola entitas sarana dan prasarana (`facilities`) sekolah. | P0 |
| **FR-ADM-05** | Kelola Berita | Admin | Admin dapat menerbitkan, mengedit, menjadwalkan, atau mengarsipkan berita/agenda sekolah. | P0 |
| **FR-ADM-06** | Ekspor Berkas | Admin | Admin dapat mengekspor rekapitulasi data pendaftar yang difilter ke dalam format spreadsheet (CSV/XLSX). | P1 |

---

## 5. USER JOURNEY & CORE FLOWS

### 5.1 Alur Registrasi Calon Siswa (PPDB Online)

```
[Calon Siswa]               [Frontend Portal]              [Backend Laravel]           [Database Engine]
      │                             │                              │                           │
      │── 1. Akses Menu PPDB ──────►│                              │                           │
      │                             │── 2. Request Form & Quota ──►│                           │
      │                             │◄─ 3. Render Form + Data ─────│                           │
      │                             │                              │                           │
      │── 4. Input Biodata & Data ─►│                              │                           │
      │      (NISN, Nilai, Jurusan) │                              │                           │
      │                             │── 5. Client Validation       │                           │
      │── 6. Klik "Kirim Pendaftaran" 6. Submit Payload POST ─────►│                           │
      │                             │                              │── 7. Sanitasi & Validasi  │
      │                             │                              │      (Server-Side)        │
      │                             │                              │                           │
      │                             │                              │── 8. Start DB Transaction►│
      │                             │                              │── 9. Lock & Generate Code │
      │                             │                              │      (REG-YYYYMMDD-XXXX)  │
      │                             │                              │── 10. INSERT ppdb_reg ───►│
      │                             │                              │── 11. COMMIT Transaction ─►│
      │                             │◄─ 12. Response 201 Created ──│                           │
      │                             │       (Bawa No Registrasi)   │                           │
      │◄─ 13. Tampilkan Layar Sukses│                              │                           │
      │       & Simpan Kode Registrasi                             │                           │
```

### 5.2 Alur Cek Status Pendaftaran

```
[Calon Siswa / Ortu]              [Halaman Cek Status]             [Backend Engine]           [Database Engine]
         │                                 │                               │                          │
         │── 1. Input Nomor Registrasi ───►│                               │                          │
         │      dan NISN Asli              │                               │                          │
         │                                 │                               │                          │
         │── 2. Klik "Lacak Status" ──────►│── 3. POST /ppdb/check-status ─►│                          │
         │                                 │      (Payload Sanitized)      │                          │
         │                                 │                               │── 4. Query Matching ────►│
         │                                 │                               │      Registration & NISN │
         │                                 │                               │◄─ 5. Return Row Data ────│
         │                                 │◄─ 6. JSON / Blade Partial ────│                          │
         │                                 │      (State & Feedback Log)   │                          │
         │◄─ 7. Render Badge Status ───────│                               │                          │
         │      (Pending/Verified/Diterima)│                               │                          │
```

### 5.3 Alur Verifikasi Admin (State Machine)

```
   ┌──────────────────────────────────────────────────────────────┐
   │                     STATUS LIFECYCLE                         │
   └──────────────────────────────────────────────────────────────┘

               ┌───────────────┐
               │    SUBMIT     │
               └───────┬───────┘
                       │
                       ▼
               ┌───────────────┐
               │    PENDING    │ ◄── (Pendaftar Baru Masuk)
               └───────┬───────┘
                       │
         ┌─────────────┴─────────────┐
         ▼                           ▼
 ┌───────────────┐           ┌───────────────┐
 │   VERIFIED    │           │    REJECT     │ ──► [Selesai: Ditolak / Berkas Invalid]
 └───────┬───────┘           └───────────────┘
         │
   ┌─────┴─────────────┐
   ▼                   ▼
┌──────────────┐ ┌──────────────┐
│   ACCEPTED   │ │ NOT_ACCEPTED │
└──────────────┘ └──────────────┘
 (Diterima di    (Tidak Masuk
  Jurusan)        Passing Grade)
```

---

## 6. SYSTEM ARCHITECTURE & RELATIONAL DATA MODEL

### 6.1 Database Schema (ANSI SQL Compliant / PostgreSQL & MySQL Strict)

Sistem dirancang di atas basis data relasional dengan penerapan integritas referensial penuh (*Foreign Key Constraints*), aturan kaskade aman, serta indexasi pada kolom pencarian kritis.

```
┌───────────────────────┐             ┌──────────────────────────────┐
│         users         │             │      ppdb_registrations      │
├───────────────────────┤             ├──────────────────────────────┤
│ id (PK)               │             │ id (PK)                      │
│ name                  │             │ registration_code (UQ)       │
│ email (UQ)            │             │ nisn (UQ)                    │
│ password              │             │ major_id_1 (FK) ────────┐    │
│ role [enum]           │             │ major_id_2 (FK) ────┐   │    │
│ created_at            │             │ status [enum]       │   │    │
└──────────┬────────────┘             │ verified_by (FK) ───┼───┼──┐ │
           │                          └─────────────────────┼───┼──┼─┘
           │                                                │   │  │
           │                                                │   │  │
           ▼ (1:N Authorship)                               │   │  │
┌───────────────────────┐                                   │   │  │
│         news          │                                   │   │  │
├───────────────────────┤                                   │   │  │
│ id (PK)               │                                   │   │  │
│ author_id (FK)        │                                   ▼   ▼  │
│ title                 │                         ┌────────────────┴─┐
│ slug (UQ)             │                         │      majors      │
│ content               │                         ├──────────────────┤
│ published_at          │                         │ id (PK)          │
└───────────────────────┘                         │ code (UQ)        │
                                                  │ name             │
┌───────────────────────┐                         │ quota            │
│      facilities       │                         │ is_active        │
├───────────────────────┤                         └──────────────────┘
│ id (PK)               │
│ name                  │
│ category [enum]       │
│ image_path            │
└───────────────────────┘
```

#### Spesifikasi Tabel Basis Data

##### 1. Tabel: `users`
Menyimpan data identitas kredensial administratif internal sekolah dengan kontrol peran (*RBAC*).
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(191) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('super_admin', 'verifikator', 'editor') NOT NULL DEFAULT 'verifikator',
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_users_role (role),
    INDEX idx_users_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

##### 2. Tabel: `majors`
Menampung entitas program keahlian vokasi yang ditawarkan kepada calon peserta didik.
```sql
CREATE TABLE majors (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) NOT NULL UNIQUE, -- Contoh: 'RPL', 'TKJ', 'AKL'
    name VARCHAR(150) NOT NULL,
    slug VARCHAR(191) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    career_opportunities TEXT NULL,
    quota INT UNSIGNED NOT NULL DEFAULT 0,
    banner_image VARCHAR(255) NULL,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_majors_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

##### 3. Tabel: `facilities`
Katalog sarana dan prasarana penunjang praktikum kejuruan siswa.
```sql
CREATE TABLE facilities (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    category ENUM('laboratorium', 'bengkel', 'sarana_umum', 'olahraga') NOT NULL,
    description TEXT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    capacity INT UNSIGNED NULL DEFAULT 0,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_facilities_category (category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

##### 4. Tabel: `news`
Manajemen penerbitan publikasi pengumuman dan liputan kegiatan sekolah.
```sql
CREATE TABLE news (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    author_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(191) NOT NULL UNIQUE,
    excerpt VARCHAR(300) NOT NULL,
    content LONGTEXT NOT NULL,
    thumbnail_image VARCHAR(255) NULL,
    status ENUM('draft', 'published', 'archived') NOT NULL DEFAULT 'draft',
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX idx_news_status_published (status, published_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

##### 5. Tabel: `ppdb_registrations`
Entitas transaksi utama yang memproses pendaftaran calon siswa secara terisolasi.
```sql
CREATE TABLE ppdb_registrations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    registration_code VARCHAR(30) NOT NULL UNIQUE, -- Format: REG-YYYYMMDD-XXXX
    nisn CHAR(10) NOT NULL UNIQUE,
    nik CHAR(16) NOT NULL,
    full_name VARCHAR(150) NOT NULL,
    birth_place VARCHAR(100) NOT NULL,
    birth_date DATE NOT NULL,
    gender ENUM('L', 'P') NOT NULL,
    religion VARCHAR(30) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    parent_phone_number VARCHAR(20) NOT NULL,
    previous_school VARCHAR(150) NOT NULL,
    address TEXT NOT NULL,
    major_id_1 BIGINT UNSIGNED NOT NULL,
    major_id_2 BIGINT UNSIGNED NOT NULL,
    average_report_score DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    document_path VARCHAR(255) NULL,
    status ENUM('pending', 'verified', 'accepted', 'rejected') NOT NULL DEFAULT 'pending',
    rejection_reason TEXT NULL,
    verified_by BIGINT UNSIGNED NULL,
    verified_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (major_id_1) REFERENCES majors(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (major_id_2) REFERENCES majors(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (verified_by) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE,
    INDEX idx_ppdb_code_nisn (registration_code, nisn),
    INDEX idx_ppdb_status (status),
    INDEX idx_ppdb_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 7. USER STORIES & ACCEPTANCE CRITERIA (GHERKIN FORMAT)

### US-01: Pendaftaran Calon Siswa & Generator Kode Unik
**Sebagai** Calon Siswa lulusan SMP,  
**Saya ingin** mengisi formulir PPDB secara daring dan memperoleh kode bukti pendaftaran otomatis,  
**Agar** identitas saya tercatat resmi dalam kuota seleksi tanpa harus datang langsung ke sekolah.

```gherkin
Feature: Pendaftaran Peserta Didik Baru (PPDB)

  Scenario: Calon siswa berhasil mendaftar dengan input valid
    Given Calon siswa mengakses halaman "/ppdb/daftar"
    And Formulir menampilkan pilihan jurusan yang aktif dari database
    When Calon siswa mengisikan NISN "0081234567" yang belum pernah terdaftar
    And Mengisikan NIK "3201012345670001" sepanjang 16 digit
    And Memilih Jurusan Pilihan 1 "Rekayasa Perangkat Lunak"
    And Memilih Jurusan Pilihan 2 "Teknik Jaringan Komputer"
    And Melengkapi seluruh kolom wajib lainnya
    And Menekan tombol "Kirim Pendaftaran"
    Then Sistem memvalidasi payload di sisi server
    And Sistem mengenerate kode registrasi dengan format "REG-YYYYMMDD-XXXX"
    And Data berhasil disimpan ke tabel "ppdb_registrations" dalam 1 atomic database transaction
    And Calon siswa dialihkan ke halaman "/ppdb/sukses"
    And Halaman menampilkan nomor registrasi, identitas diri, dan instruksi unduh bukti

  Scenario: Calon siswa gagal mendaftar karena duplikasi NISN
    Given Calon siswa mengakses formulir pendaftaran
    When Calon siswa mengisikan NISN "0081234567" yang sudah ada di database
    And Menekan tombol "Kirim Pendaftaran"
    Then Sistem menolak transaksi pendaftaran
    And Mengembalikan pesan error HTTP 422
    And Menampilkan notifikasi visual "NISN ini sudah terdaftar dalam sistem PPDB"
```

### US-02: Pelacakan Status Pendaftaran Mandiri
**Sebagai** Calon Siswa atau Wali Murid,  
**Saya ingin** memeriksa status kelulusan berkas pendaftaran dengan memasukkan kode registrasi dan NISN,  
**Agar** saya mendapatkan kejelasan status seleksi secara transparan dan instan.

```gherkin
Feature: Tracking Status Pendaftaran

  Scenario: Status berhasil ditemukan dengan kredensial tepat
    Given Pengguna membuka halaman "/ppdb/cek-status"
    When Pengguna memasukkan Kode Registrasi "REG-20260615-0001"
    And Memasukkan NISN "0081234567" yang berpasangan sesuai
    And Menekan tombol "Lacak Pendaftaran"
    Then Sistem mencocokkan pasangan data di tabel "ppdb_registrations"
    And Merender komponen badge status (misal: "VERIFIED" / "ACCEPTED")
    And Menampilkan linimasa proses dan catatan resmi dari panitia jika status ditolak

  Scenario: Status gagal dicari akibat data tidak cocok
    Given Pengguna membuka halaman "/ppdb/cek-status"
    When Pengguna memasukkan Kode Registrasi "REG-20260615-0001"
    And Memasukkan NISN yang salah atau acak "0000000000"
    And Menekan tombol "Lacak Pendaftaran"
    Then Sistem menolak permintaan pencarian
    And Menampilkan alert "Kombinasi Nomor Registrasi dan NISN tidak ditemukan dalam basis data"
```

### US-03: Verifikasi Berkas oleh Admin Back-Office
**Sebagai** Petugas Panitia PPDB (Admin Verifikator),  
**Saya ingin** meninjau biodata pendaftar dan memperbarui status berkas seleksi secara terkontrol,  
**Agar** kuota jurusan terisi oleh calon siswa yang memenuhi syarat kelayakan administrasi.

```gherkin
Feature: Verifikasi Pendaftar oleh Admin

  Scenario: Admin mengubah status berkas menjadi 'verified'
    Given Admin telah login dengan role "verifikator"
    And Berada di dashboard rincian pendaftar "REG-20260615-0001"
    When Admin memilih status "verified" pada dropdown seleksi
    And Menekan tombol simpan perubahan
    Then Sistem memperbarui kolom "status" menjadi 'verified'
    And Mengisi kolom "verified_by" dengan user ID admin yang sedang login
    And Mengisi timestamp "verified_at" dengan waktu server saat ini
    And Menampilkan flash notification "Status berkas berhasil diverifikasi"
```

---

## 8. DESIGN SYSTEM & UI/UX DIRECTIVES (PANDUAN DESIGN.MD)

Sesuai instruksi Fase 2, antarmuka **WEB_SMK** dirancang berbasis **Bootstrap 5.3+ Enterprise Architecture**, menolak estetika instan/generik (*anti AI-slop*), dan mengadopsi gaya editorial akademik modern yang terstruktur.

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                       SISTEM WARNA (PALET FORMAL)                           │
├─────────────────────────────────────────────────────────────────────────────┤
│  Primary: Deep Navy     │ Slate Accent             │ Warning/Accent: Amber  │
│  HEX: #0A192F / #1E3A8A │ HEX: #475569 / #64748B   │ HEX: #D97706 / #F59E0B │
│  [Otoritas, Integritas] │ [Netralitas, Pembacaan]  │ [Aksentuasi CTA, Stat] │
└─────────────────────────────────────────────────────────────────────────────┘
```

### 8.1 Spesifikasi Token Warna & Tipografi
* **Primary (Deep Navy):** `#0A192F` (Background Hero/Footer), `#1E3A8A` (Brand Navbar, Primary Buttons).
* **Slate (Secondary/Neutral):** `#334155` (Body text), `#64748B` (Secondary text, borders), `#F8FAFC` (Canvas background).
* **Warm Amber (Accent):** `#D97706` (Badge unggulan, status pending, CTA secondary highlight), `#B45309` (Active state).
* **Status Alerts:** Success `#059669` (Diterima), Danger `#DC2626` (Ditolak), Info `#2563EB` (Verifikasi Berkas).
* **Tipografi:** Wajib menggunakan font **Plus Jakarta Sans** (Google Fonts) di seluruh dokumen:
  * *Display / Hero Titles:* SemiBold (600) / Bold (700) dengan letter-spacing `-0.02em`.
  * *Body Text:* Regular (400) / Medium (500) dengan line-height proporsional `1.65`.
  * *Data Tables & Forms:* High-density typography berukuran `0.875rem` hingga `0.95rem` untuk efisiensi ruang kerja panitia.

### 8.2 Struktur Komponen UI Kunci
* **Navbar Publik:** Clean sticky navbar dengan logo SMK beresolusi tajam, menu navigasi flat, dan tombol aksi kontras tinggi `[Daftar PPDB]`.
* **Katalog Jurusan Grid:** Card layout berbasis CSS Grid / Bootstrap row-cols dengan aspect ratio banner 16:9, label akreditasi pill-badge, dan kuota sisa pendaftar dinamis.
* **Formulir PPDB:** Layout formulir satu kolom terstruktur per segmen:
  1. *Bagian A:* Data Pribadi & NISN.
  2. *Bagian B:* Pilihan Kompetensi Keahlian.
  3. *Bagian C:* Riwayat Sekolah & Nilai.
  Setiap *input field* dilengkapi indikator *required asterisk* merah dan pesan error validasi mikro yang melekat tepat di bawah kolom input.

---

## 9. NON-FUNCTIONAL REQUIREMENTS (NFR)

```
┌──────────────────────────────────────────────────────────────────────────────┐
│                    NON-FUNCTIONAL REQUIREMENTS (NFR)                         │
└──────────────────────────────────────────────────────────────────────────────┘
  ┌───────────────┐  ┌───────────────┐  ┌───────────────┐  ┌───────────────┐
  │   SECURITY    │  │  PERFORMANCE  │  │   INTEGRITY   │  │   USABILITY   │
  │ • CSRF Guard  │  │ • LCP < 1.5s  │  │ • DB ACID     │  │ • Responsive  │
  │ • SQLi Immune │  │ • TTFB < 200ms│  │ • Transaksi   │  │ • WCAG 2.1 AA │
  │ • RBAC Strict │  │ • Cache Layer │  │   Terkunci    │  │ • 360px-1920px│
  └───────────────┘  └───────────────┘  └───────────────┘  └───────────────┘
```

### 9.1 Security & SecOps
* **Perlindungan Injeksi & Sanitasi Input:** Seluruh request yang masuk wajib melalui Laravel Eloquent ORM parameterized queries (kebal SQL Injection). Setiap output teks di-escape menggunakan Blade Engine tag `{{ $var }}` (kebal Cross-Site Scripting / XSS).
* **CSRF Token:** Seluruh mutasi berkas (`POST`, `PUT`, `DELETE`) wajib menyertakan token `@csrf` valid; tolak seluruh request yang gagal memvalidasi origin token.
* **Rate Limiting Engine:** Batasi akses endpoint publik `POST /ppdb/check-status` dan login admin maksimal 10 request per menit per alamat IP untuk mencegah serangan *Brute Force / Scraping*.
* **Otentikasi Aman:** Password dienkripsi menggunakan hashing algorithm standar industri `bcrypt` dengan work factor minimal 12.

### 9.2 Performance & Scalability
* **Responsivitas Server:** Waktu pemrosesan server (*Time to First Byte* - TTFB) tidak boleh melebihi 200ms pada beban 100 concurrent connections.
* **Database Query Performance:** Seluruh query filter dashboard admin dibatasi maksimal 100ms dengan penerapan eager loading (`with(['major1', 'major2'])`) untuk mengeliminasi problem *N+1 query*.
* **Asset Optimization:** Bundle file CSS dan JS menggunakan Vite. Kompresi gambar banner jurusan dan fasilitas sekolah otomatis ke format format modern WebP dengan ukuran file maksimal 250KB per gambar.

### 9.3 Data Integrity & Relational Rules
* **ACID Transactions:** Proses penyimpanan data PPDB dan alokasi generator nomor registrasi wajib dieksekusi di dalam `DB::transaction()` dengan isolasi level `READ COMMITTED`.
* **Constraint Enforcement:** Tidak boleh ada penghapusan baris data induk jurusan (`majors`) jika masih memiliki dependensi aktif di data pendaftar (`ON DELETE RESTRICT`).

### 9.4 Accessibility & Responsiveness
* Tampilan antarmuka beradaptasi mulus dari resolusi layar terkecil *360px (Mobile Device)*, *768px (Tablet)*, hingga *1920px (Desktop Full HD)*.
* Rasio kontras teks terhadap latar belakang wajib memenuhi standar **WCAG 2.1 Level AA** (minimal 4.5:1 untuk teks normal).

---

## 10. RENCANA EKSEKUSI TIGA FASE (THREE-PHASE IMPLEMENTATION BLUEPRINT)

Proyek ini dieksekusi dengan orkestrasi berjenjang yang memisahkan tanggung jawab arsitektural, estetika visual, dan implementasi kode.

```
   FASE 1: ARCHITECT             FASE 2: DESIGN               FASE 3: DEV WORKER
┌─────────────────────┐       ┌──────────────────┐       ┌──────────────────────┐
│ Blueprint Blueprint │  ──►  │ DESIGN.md Token  │  ──►  │ Laravel Blade Engine │
│ ERD Relasional DDL  │       │ Bootstrap Config │       │ Routing & Controller │
│ Activity Diagrams   │       │ Mockup Form UX   │       │ Validasi & Seeder DB │
└─────────────────────┘       └──────────────────┘       └──────────────────────┘
```

### Fase 1: Architect (Rekayasa Sistem & Desain Data)
* Memfinalisasi diagram Use Case lengkap untuk ketiga aktor (*Pengunjung, Calon Siswa, Staf Admin*).
* Menyusun Activity Diagram alur pendaftaran PPDB online dan diagram status lifecycle seleksi.
* Menerbitkan berkas skrip migrasi basis data murni (*Schema Migration DDL*) untuk entitas `users`, `majors`, `news`, `ppdb_registrations`, dan `facilities`.
* Menyusun dokumentasi spesifikasi teknis pendukung (.docx template/markdown engineering log).

### Fase 2: Design (Agent Pixel — Desain Antarmuka Berstandar)
* Meracik berkas **`DESIGN.md`** sebagai sumber kebenaran visual (*Single Source of Truth* UI).
* Mendefinisikan konfigurasi SCSS variable Bootstrap 5 (Overriding: `$primary: #1E3A8A`, `$secondary: #475569`, `$warning: #D97706`).
* Merancang template layout:
  * `layouts/app.blade.php`: Header institusi, container dinamis, footer informatif.
  * `layouts/admin.blade.php`: Sidebar menu vertikal, top-bar profil user, breadcrumb.
* Merancang sistem status pills, form validation styling, dan tipografi Plus Jakarta Sans.

### Fase 3: Dev Worker (Agent Dev — Implementasi & Pengkodean)
* **Setup Framework & Routing:** Konfigurasi Laravel 11/12, pembuatan file routes `web.php` yang terbagi ke grup publik dan grup admin middleware `auth`.
* **Database & Seeders:** Menjalankan migrasi tabel dan seeding data realistis (Jurusan: RPL, TKJ, Otomotif; Fasilitas lengkap; Akun admin kredensial default).
* **Logika Pendaftaran & Generator Unik:** Implementasi `PpdbController@store` dengan locking transaksional untuk menghasilkan kode `REG-YYYYMMDD-XXXX`.
* **Modul Tracking Publik:** Implementasi `PpdbController@checkStatus` berbasis AJAX/Form submit dengan proteksi CSRF.
* **Modul Back-office:** CRUD Master data dan dashboard verifikasi berkas dengan flash messages interaktif.

---

## 11. QUALITY GATES: DEFINITION OF READY (DoR) & DEFINITION OF DONE (DoD)

### 11.1 Definition of Ready (DoR) — Syarat Sebelum Dev Worker Memulai Kode
- [x] Dokumen PRD berstandar Atlassian ini telah ditinjau dan ditandatangani oleh PM & Architect.
- [x] Struktur tabel basis data dan tipe data kolom telah disepakati tanpa ambiguitas tipe field.
- [x] Skema palet warna dan tipografi pada panduan `DESIGN.md` telah tersedia.
- [x] Algoritma pembentukan kode registrasi pendaftaran telah divalidasi ketiadaan risiko tabrakan data (*collision-free*).

### 11.2 Definition of Done (DoD) — Syarat Mutlak Sebelum PM Menyetujui Rilis
- [x] **Fungsionalitas P0 Lengkap:** Seluruh alur FR-PUB, FR-REG, FR-TRK, dan FR-ADM berjalan tanpa error sintaks, exception fatal, atau *500 Internal Server Error*.
- [x] **Validasi & Sanitasi Data Teruji:** Upaya injeksi tag HTML script pada input nama/alamat tersanitasi dengan benar; NISN duplikat tertolak dengan respons valid.
- [x] **Relational Constraint Terkunci:** Seluruh relasi Foreign Key di basis data teruji menolak penghapusan kaskade ilegal (*Restricted Deletes* berfungsi).
- [x] **Atomic Code Generator:** Pengujian pendaftaran simultan tetap menghasilkan kode urut unik tanpa duplikasi.
- [x] **Desain Standar Bootstrap 5:** Seluruh halaman konsisten menerapkan palet warna Navy/Slate/Amber dengan font Plus Jakarta Sans dan responsif di resolusi mobile (360px).
- [x] **Database Terisi Data Awal:** Database telah ter-seed dengan minimal 3 jurusan kejuruan, 4 fasilitas sekolah, 2 berita awal, dan 1 akun super admin siap pakai.

---
*Dokumen ini diterbitkan secara resmi sebagai pedoman rekayasa mutlak seluruh agen pengembang dalam proyek WEB_SMK.*