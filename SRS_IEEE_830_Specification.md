# SOFTWARE REQUIREMENTS SPECIFICATION (SRS)
## Proyek: Sistem Informasi Profil Sekolah & Digital Admission Engine (WEB_SMK)

---

**Standar Rujukan:** IEEE Std 830-1998 (*IEEE Recommended Practice for Software Requirements Specifications*)  
**Dokumen Pengenal:** `SRS-WEB-SMK-2026-V1.0`  
**Versi:** 1.0.0  
**Status:** Approved for Engineering Implementation  
**Klasifikasi:** Internal / Restricted Engineering  
**Penyusun:** Lead Systems Analyst & Technical Architect  
**Berdasarkan Dokumen:** PRD `web_smk` v1.0.0 (Release v1.0.0-PROD)  
**Tanggal Penerbitan:** Q3-2026  

---

## DAFTAR ISI

1. **PENDAHULUAN (INTRODUCTION)**  
   1.1 Tujuan (Purpose)  
   1.2 Konvensi Dokumen (Document Conventions)  
   1.3 Audiens Target & Panduan Pembacaan (Intended Audience)  
   1.4 Lingkup Sistem & Batasan Produk (Scope & System Boundary)  
   1.5 Definisi, Akronim, dan Singkatan (Definitions & Abbreviations)  
   1.6 Dokumen Referensi (References)  

2. **DESKRIPSI KESELURUHAN (OVERALL DESCRIPTION)**  
   2.1 Perspektif Produk (Product Perspective & System Architecture)  
   2.2 Karakteristik Pengguna (User Classes and Characteristics)  
   2.3 Lingkungan Operasi (Operating Environment)  
   2.4 Batasan Desain dan Implementasi (Design & Implementation Constraints)  
   2.5 Asumsi dan Ketergantungan (Assumptions & Dependencies)  

3. **SPESIFIKASI KEBUTUHAN ANTARMUKA EKSTERNAL (EXTERNAL INTERFACE REQUIREMENTS)**  
   3.1 Antarmuka Pengguna (User Interfaces)  
   3.2 Antarmuka Perangkat Keras (Hardware Interfaces)  
   3.3 Antarmuka Perangkat Lunak (Software Interfaces)  
   3.4 Antarmuka Komunikasi (Communications Interfaces)  

4. **KEBUTUHAN FUNGSIONAL SISTEM (SYSTEM FUNCTIONAL REQUIREMENTS)**  
   4.1 Modul Portal Profil Publik (FR-PUB)  
   4.2 Modul Engine Pendaftaran PPDB (FR-REG)  
   4.3 Modul Pelacak Status Mandiri (FR-TRK)  
   4.4 Modul Autentikasi & Kontrol Akses (FR-AUTH)  
   4.5 Modul Back-Office Management & Verifikasi (FR-ADM)  

5. **KONTRAK API ENDPOINTS & SPESIFIKASI PERTUKARAN DATA (API SPECIFICATIONS)**  
   5.1 Konvensi Protokol & Autentikasi  
   5.2 Endpoint Publik: PPDB & Lacak Status  
   5.3 Endpoint Administratif: Verifikasi & Master Data  

6. **ATURAN VALIDASI DATA & INTEGRITAS SISTEM (DATA VALIDATION RULES)**  
   6.1 Validasi Input Entitas Pendaftaran PPDB  
   6.2 Validasi Master Data & Konten  
   6.3 Integritas Basis Data & Relational Constraints  

7. **PENANGANAN ERROR & MANAJEMEN EKSEPSI (ERROR HANDLING & FAULT TOLERANCE)**  
   7.1 Format Respons Standar Galat (RFC 7807 / JSON Standard Envelope)  
   7.2 Pemetaan Kode Galat HTTP & Domain Exception  
   7.3 Mekanisme Transaksional & Pemulihan Kegagalan Generator Kode  

8. **KEBUTUHAN NON-FUNGSIONAL (NON-FUNCTIONAL REQUIREMENTS)**  
   8.1 Kebutuhan Kinerja (Performance Requirements)  
   8.2 Kebutuhan Keamanan (Security Requirements)  
   8.3 Ketersediaan & Keandalan (Availability & Reliability)  
   8.4 Kemudahan Pemeliharaan & Skalabilitas (Maintainability & Scalability)  

9. **MATRIKS KETERTELUSURAN KEBUTUHAN (REQUIREMENTS TRACEABILITY MATRIX - RTM)**  

---

## 1. PENDAHULUAN (INTRODUCTION)

### 1.1 Tujuan (Purpose)
Dokumen *Software Requirements Specification* (SRS) ini merinci seluruh spesifikasi kebutuhan fungsional, non-fungsional, batasan teknis, dan antarmuka integrasi untuk platform **WEB_SMK**. Dokumen ini diformulasikan untuk menjadi sumber acuan teknis mutlak (*single source of engineering truth*) bagi tim rekayasa perangkat lunak: System Architect, Software Engineer (Backend/Frontend), UI/UX Designer, dan Quality Assurance Tester dalam mengimplementasikan platform rilis v1.0.0.

### 1.2 Konvensi Dokumen (Document Conventions)
Penulisan spesifikasi teknis dalam dokumen ini mematuhi standar terminologi RFC 2119:
* **MUST** / **REQUIRED** / **SHALL**: Mengindikasikan kewajiban mutlak arsitektural.
* **SHOULD** / **RECOMMENDED**: Mengindikasikan praktik terbaik yang sangat disarankan kecuali terdapat batasan teknis yang beralasan.
* **MAY** / **OPTIONAL**: Mengindikasikan parameter opsional yang tidak memblokir rilis inti.

Setiap kebutuhan fungsional diklasifikasikan menggunakan notasi penomoran hierarkis:
* `FR-[MODUL]-[NOMOR]`: Kebutuhan Fungsional (*Functional Requirement*).
* `NFR-[DOMAIN]-[NOMOR]`: Kebutuhan Non-Fungsional (*Non-Functional Requirement*).

### 1.3 Audiens Target & Panduan Pembacaan (Intended Audience)
Dokumen ini disusun untuk:
1. **Software Engineers (Agent Dev):** Pedoman implementasi logika backend (Laravel), frontend rendering (Blade/Bootstrap 5), validasi data, dan transaksi basis data.
2. **Technical Architect:** Memvalidasi isolasi transaksional, skema indeks relasional, dan arsitektur konkurensi.
3. **UI/UX Designers (Agent Pixel):** Memandu integrasi antarmuka agar mematuhi batasan *user interface* dan hierarki data.
4. **Quality Assurance Engineers:** Dasar pembuatan skenario uji otomatis (*Test Cases*), pengujian regresi, dan pengujian beban (*Load Testing*).

### 1.4 Lingkup Sistem & Batasan Produk (Scope & System Boundary)

#### 1.4.1 In-Scope (Batasan Lingkup Operasi v1.0.0)
* **Portal Profil Institusi Publik:** Penayangan profil kelembagaan, visi-misi, akreditasi, katalog program kompetensi keahlian (jurusan), inventaris sarana praktikum/fasilitas, dan warta kegiatan sekolah.
* **Digital Admission Engine (PPDB Online):** Alur pendaftaran multi-input mandiri calon siswa dengan validasi ketat identitas kependudukan (NISN/NIK) dan riwayat nilai rapor.
* **Atomic Unique Registration Code Generator:** Algoritma pengalokasian kode pendaftaran deterministik berformat `REG-YYYYMMDD-XXXX` bebas tabrakan data (*collision-proof*).
* **Self-Service Verification Tracker:** Pelacakan status seleksi publik berbasis otentikasi ganda tanpa akun (`registration_code` + `nisn`).
* **Back-Office RBAC System:** Manajemen hak akses staf sekolah berbasis sesi terproteksi untuk verifikasi berkas pendaftar dan CRUD data master portal.
* **Export Reporting Engine:** Ekstraksi data tabular pendaftar ke format file terstruktur (CSV/XLSX).

#### 1.4.2 Out-of-Scope (Batas Tegas di Luar Sistem v1.0.0)
* **SIAKAD (Sistem Informasi Akademik):** Manajemen mata pelajaran berjalan, presensi kelas harian, dan pencetakan buku rapor kurikulum.
* **Payment Gateway Integration:** Sistem tidak memproses mutasi escrow/kartu kredit/VA secara daring; verifikasi keuangan menggunakan kanal rekening perbankan manual.
* **Learning Management System (LMS):** Distribusi materi pembelajaran daring, forum diskusi siswa, dan pengumpulan penugasan guru.
* **Computer-Based Test (CBT) Real-time Engine:** Penyelenggaraan ujian seleksi selektif online secara masif di dalam antarmuka web.

### 1.5 Definisi, Akronim, dan Singkatan (Definitions & Abbreviations)

| Istilah / Akronim | Definisi Lengkap / Penjelasan Konseptual |
|---|---|
| **PPDB** | Penerimaan Peserta Didik Baru; proses seleksi formal calon siswa sekolah kejuruan. |
| **NISN** | Nomor Induk Siswa Nasional; kode pengenal identitas siswa unik berskala nasional (10 digit numerik). |
| **NIK** | Nomor Induk Kependudukan; nomor identitas warga negara Indonesia tercatat di Disdukcapil (16 digit numerik). |
| **RBAC** | *Role-Based Access Control*; mekanisme pembatasan wewenang sistem berdasarkan hierarki peran pengguna. |
| **CSRF** | *Cross-Site Request Forgery*; eksploitasi pengiriman perintah tidak sah dari pengguna terpercaya. |
| **XSS** | *Cross-Site Scripting*; kerentanan injeksi skrip berbahaya ke dalam antarmuka web terpercaya. |
| **ACID** | *Atomicity, Consistency, Isolation, Durability*; prinsip jaminan integritas transaksi basis data. |
| **TTFB** | *Time to First Byte*; metrik latensi durasi respon penerimaan byte pertama klien dari server. |
| **LCP** | *Largest Contentful Paint*; metrik kecepatan render visual komponen terbesar pada viewport peramban. |

### 1.6 Dokumen Referensi (References)
* IEEE Std 830-1998: *Recommended Practice for Software Requirements Specifications*.
* ISO/IEC/IEEE 29148:2018: *Systems and software engineering — Life cycle processes — Requirements engineering*.
* RFC 7807: *Problem Details for HTTP APIs*.
* *Product Requirements Document (PRD) WEB_SMK* v1.0.0, Project PM-Studio Workspace.

---

## 2. DESKRIPSI KESELURUHAN (OVERALL DESCRIPTION)

### 2.1 Perspektif Produk (Product Perspective & System Architecture)
Platform **WEB_SMK** adalah aplikasi monolitik berbasis *Web MVC (Model-View-Controller)* berperforma tinggi yang dioptimalkan untuk memisahkan domain publik tanpa autentikasi dan domain administratif dengan proteksi akses ketat.

```
+-----------------------------------------------------------------------------------+
|                                  WEB_SMK SYSTEM                                   |
+-----------------------------------------------------------------------------------+
|  PUBLIC INTERFACE LAYER (Bootstrap 5.3 + Blade SSR + Vanilla JS Core)             |
|  [ Landing Portal ]    [ Katalog Jurusan ]    [ PPDB Form ]    [ Tracking Status ]|
+------------------------------------------+----------------------------------------+
                                           | HTTPS / TLS 1.3
+------------------------------------------v----------------------------------------+
|  HTTP ROUTING, SECURITY GUARDS & MIDDLEWARE LAYER                                 |
|  [ RateLimiter ]   [ VerifyCsrfToken ]   [ SessionGuard ]   [ RBAC: RoleMiddleware ]
+------------------------------------------+----------------------------------------+
                                           | Execution Bus
+------------------------------------------v----------------------------------------+
|  APPLICATION LOGIC / CONTROLLERS / DOMAIN SERVICES                               |
|  [ PublicViewController ]  [ PpdbRegistrationEngine ]  [ BackofficeAdminEngine ]   |
|  - Content Query Cache     - Atomic Code Generator     - Status State Machine     |
|                            - Storage Upload Handler    - Excel Export Streamer    |
+------------------------------------------+----------------------------------------+
                                           | Eloquent ORM / PDO
+------------------------------------------v----------------------------------------+
|  PERSISTENCE STORAGE LAYER (RDBMS - MySQL 8.0 / MariaDB 10.6+ InnoDB)             |
|  [ users ]       [ majors ]       [ facilities ]       [ news ]       [ ppdb_reg ]|
|  Indexes: B-Tree Unique Constraints | Foreign Keys with ON DELETE RESTRICT        |
+-----------------------------------------------------------------------------------+
```

### 2.2 Karakteristik Pengguna (User Classes and Characteristics)

| Kelas Pengguna | Tingkat Hak Istimewa | Tingkat Pendidikan / Teknis | Pola Interaksi Sistem |
|---|---|---|---|
| **Pengunjung (Guest)** | Akses Publik (Tanpa Autentikasi) | Masyarakat Umum / Menengah ke Bawah | Mengakses informasi institusi, membaca berita, melihat katalog jurusan secara sporadis. |
| **Calon Siswa (Applicant)** | Akses Publik Transaksional Khusus | Siswa SMP Sederajat / Digital Native Mobile | Mengisi formulir PPDB via perangkat seluler, mengunggah berkas, memeriksa status berkas secara periodik. |
| **Verifikator (Admin PPDB)** | Terotentikasi: Peran `verifikator` | Staf Administrasi / Menguasai Desktop | Meninjau berkas pendaftar harian, memvalidasi NISN fisik, mengubah status berkas, memberikan catatan penolakan. |
| **Super Admin (IT/Kepala)** | Hak Penuh: Peran `super_admin` | Administrator Sistem / Ahli | Mengelola master jurusan, kuota, akun staf, menghapus data anomali, melakukan ekspor rekapitulasi data pendaftar. |

### 2.3 Lingkungan Operasi (Operating Environment)
* **Web Server:** Nginx 1.24+ / Apache 2.4+ dengan ekstensi `mod_rewrite` aktif.
* **Server Runtime:** PHP 8.2 atau 8.3 dengan ekstensi wajib: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, `gd`.
* **Database Engine:** MySQL 8.0+ atau MariaDB 10.6+ dengan storage engine InnoDB dan karakter default `utf8mb4_unicode_ci`.
* **Client Peramban:** Minimum Google Chrome v100+, Mozilla Firefox v100+, Safari v15+, Microsoft Edge v100+ (resolusi adaptif 360px hingga 1920px).

### 2.4 Batasan Desain dan Implementasi (Design & Implementation Constraints)
1. **Pustaka CSS Utama:** Wajib mengadaptasi Bootstrap 5.3+ via SCSS token tanpa menggunakan template dashboard siap pakai pihak ketiga yang menggelembungkan ukuran berkas (*anti AI-slop bloatware*).
2. **Kepatuhan ACID Penuh:** Seluruh proses pendaftaran calon siswa wajib dieksekusi dalam satu *Database Transaction block* terisolasi. Jika alokasi kode registrasi gagal, seluruh perubahan biodata harus di-*rollback*.
3. **Penyimpanan Berkas Terisolasi:** Berkas dokumen pendaftaran (PDF/JPG/PNG) wajib disimpan di direktori internal terproteksi (`storage/app/private/documents/ppdb`) dan hanya dapat diakses melalui rute terotentikasi (*signed download stream*).
4. **Dependensi RDBMS:** Larangan penggunaan penghapusan luncuran (*CASCADE DELETE*) pada relasi data induk jurusan (`majors`) terhadap data registrasi PPDB guna mencegah kerusakan integritas riwayat pendaftaran.

### 2.5 Asumsi dan Ketergantungan (Assumptions & Dependencies)
* Sinkronisasi jam sistem server wajib dikonfigurasi melalui protokol NTP (*Network Time Protocol*) guna menjamin kepastian tanggal pada generator kode registrasi (`YYYYMMDD`).
* Koneksi internet pengguna stabil dengan kecepatan minimum 256 kbps untuk pengunggahan berkas pendaftaran.
* Pengaturan variabel PHP server: `upload_max_filesize >= 5M`, `post_max_size >= 8M`, dan `memory_limit >= 256M`.

---

## 3. SPESIFIKASI KEBUTUHAN ANTARMUKA EKSTERNAL (EXTERNAL INTERFACE REQUIREMENTS)

### 3.1 Antarmuka Pengguna (User Interfaces)

#### 3.1.1 Desain Layout & Gaya Visual
* **Palet Warna Arsitektural:**
  * *Primary Anchor:* Deep Navy (`#0A192F` - Background Hero/Footer, `#1E3A8A` - Navbar, Brand Buttons).
  * *Slate Neutrals:* Slate Dark (`#334155`), Slate Light (`#64748B`), Background Canvas (`#F8FAFC`).
  * *Warm Accent:* Dark Amber (`#D97706`), Vivid Amber (`#F59E0B`).
* **Sistem Tipografi:**
  * Font Antarmuka: **Plus Jakarta Sans** (Google Fonts). Bobot font terdistribusi pada Reguler (400) untuk badan teks, Medium (500) untuk label formulir, dan Semi-Bold (600) / Bold (700) untuk judul serta *card headers*.
* **Adaptabilitas Layar (Breakpoints):**
  * Mobile Small: `360px - 575px` (Tata letak satu kolom vertikal penuh).
  * Tablet: `768px - 991px` (Dua kolom modular).
  * Desktop / High-DPI: `992px - 1920px` (Tiga/Empat kolom katalog dan tabel densitas tinggi).

#### 3.1.2 Karakteristik Tampilan Inti
* **UI-PUB-01 (Beranda & Profil):** Menampilkan banner profil sekolah dengan visual tajam, *quick stats counter* dinamis (Jumlah Siswa, Kuota Tersedia, Jumlah Guru, Jurusan), ringkasan program keahlian, dan cuplikan 3 berita terbaru.
* **UI-PUB-02 (Formulir Pendaftaran PPDB):** Formulir segmented linear 3 tahap:
  1. *Identitas Pribadi:* NISN, NIK, Nama Lengkap, Tempat & Tanggal Lahir, Jenis Kelamin, Agama, Nomor Kontak.
  2. *Pilihan Akademik:* Dropdown Pilihan Jurusan 1, Dropdown Pilihan Jurusan 2, Rata-rata Nilai Rapor, Asal Sekolah.
  3. *Unggah Dokumen:* Input berkas gabungan (Scan KK/Ijazah/SKL).
* **UI-PUB-03 (Pelacak Status PPDB):** Kotak pencarian minimalis terpusat dengan input Nomor Registrasi dan NISN, menghasilkan kartu rincian status seleksi beserta *badge status* (Kuning: `Pending`, Biru: `Verified`, Hijau: `Accepted`, Merah: `Rejected`).
* **UI-ADM-01 (Admin Data Table):** Tabel data pendaftar bervolume tinggi dengan penyeragaman tinggi baris (`compact layout`), indikator *badge*, aksi verifikasi cepat (*quick action modal*), dan filter multi-kriteria tanpa memuat ulang seluruh halaman.

### 3.2 Antarmuka Perangkat Keras (Hardware Interfaces)
* Sistem beroperasi pada peladen fisik atau *Virtual Private Server* (VPS) arsitektur x86_64 atau ARM64.
* Server wajib menyediakan memori operasional (RAM) minimum 1024 MB (2048 MB direkomendasikan) dan ruang penyimpanan persisten berbasis NVMe/SSD dengan IOPS minimum 1500 guna mencegah kemacetan (*I/O bottleneck*) saat penulisan data registrasi bersamaan.

### 3.3 Antarmuka Perangkat Lunak (Software Interfaces)

```
+-------------------------------------------------------------------------------+
|                       SOFTWARE INTERFACES INTEGRATION                         |
+-------------------------------------------------------------------------------+
| Web Application      ──► Laravel Framework 11.x Core                          |
| DBMS Interface       ──► PDO MySQL / Eloquent Driver (Port 3306)              |
| Cache & Session      ──► Redis Engine 7.0+ atau Database Table Session Driver |
| Asset Pipeline       ──► Node.js 20 LTS / Vite 5 Engine (CSS/JS Bundler)      |
| File System          ──► Local Disk Virtual Directory / POSIX Compliant FS    |
+-------------------------------------------------------------------------------+
```

* **Relasi dengan DBMS:** Sistem berkomunikasi melalui pustaka PHP Data Objects (PDO) terisolasi dengan koneksi persisten terbatas, mematuhi standar ANSI-SQL.
* **Relasi dengan Penyimpanan Berkas:** Menggunakan *File Storage Abstraction* internal untuk menyimpan dan memverifikasi integritas berkas unduhan via fungsi `Storage::disk('local')`.

### 3.4 Antarmuka Komunikasi (Communications Interfaces)
* **Protokol Jaringan:** Wajib menggunakan HTTPS (Hypertext Transfer Protocol Secure) dengan TLS versi 1.2 atau TLS versi 1.3 dienkripsi Cipher Suites aman (ECDHE-RSA-AES128-GCM-SHA256 atau lebih tinggi). Port 80 diarahkan permanen (*HTTP 301 Permanent Redirect*) ke Port 443.
* **Struktur Header Keamanan HTTP:**
  * `Strict-Transport-Security: max-age=31536000; includeSubDomains`
  * `X-Content-Type-Options: nosniff`
  * `X-Frame-Options: SAMEORIGIN`
  * `X-XSS-Protection: 1; mode=block`
  * `Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline' fonts.googleapis.com; font-src 'self' fonts.gstatic.com;`
* **Format Pengiriman Data API:** Payload pertukaran data wajib diserialisasi menggunakan tipe MIME `application/json; charset=UTF-8` atau `multipart/form-data` untuk formulir unggah berkas.

---

## 4. KEBUTUHAN FUNGSIONAL SISTEM (SYSTEM FUNCTIONAL REQUIREMENTS)

### 4.1 Modul Portal Profil Publik (FR-PUB)

#### 4.1.1 FR-PUB-01: Penyajian Identitas Institusi
* **Deskripsi:** Sistem SHALL merender informasi profil sekolah mencakup sejarah singkat, nilai kelembagaan, visi, misi, dan susunan pimpinan institusi.
* **Input:** Permintaan HTTP GET pada URI `/profil`.
* **Proses:** Sistem mengambil entitas profil dari berkas konfigurasi dinamis atau tabel basis data dan merender melalui view template engine.
* **Output:** Halaman web responsif berstatus HTTP 200 dengan markup terstruktur (*schema.org EducationalOrganization*).

#### 4.1.2 FR-PUB-02: Katalog Kompetensi Keahlian (Jurusan)
* **Deskripsi:** Sistem SHALL menampilkan daftar program keahlian aktif dari tabel `majors` beserta kuota daya tampung, silabus keahlian, dan dokumentasi visual.
* **Input:** Permintaan HTTP GET pada URI `/jurusan` atau rincian per jurusan `/jurusan/{slug}`.
* **Proses:** Sistem mengeksekusi kueri `SELECT * FROM majors WHERE is_active = TRUE ORDER BY name ASC`.
* **Output:** Grid katalog program keahlian interaktif berisi informasi deskriptif lengkap.

#### 4.1.3 FR-PUB-03: Katalog Fasilitas Sekolah
* **Deskripsi:** Sistem SHALL menampilkan inventaris sarana dan prasarana fisik institusi yang terhimpun dalam tabel `facilities`.
* **Input:** Permintaan HTTP GET pada URI `/fasilitas`.
* **Proses:** Sistem mengelompokkan fasilitas berdasarkan kategori (`laboratorium`, `bengkel`, `sarana_umum`, `olahraga`).
* **Output:** Galeri visual fasilitas dilengkapi kartu ringkasan spesifikasi alat dan kapasitas.

#### 4.1.4 FR-PUB-04: Publikasi Berita & Agenda Terkini
* **Deskripsi:** Sistem SHALL menampilkan warta sekolah yang memiliki atribut `status = 'published'` dan `published_at <= NOW()`.
* **Input:** Permintaan HTTP GET pada URI `/berita` dengan parameter opsional `?page={n}&search={keyword}`.
* **Proses:** Sistem melakukan kueri paginasi (*10 record per halaman*) dengan pencarian pada kolom `title` dan `excerpt`.
* **Output:** Daftar artikel berita dengan penomoran halaman dinamis dan penanganan riwayat pencarian.

---

### 4.2 Modul Engine Pendaftaran PPDB (FR-REG)

#### 4.2.1 FR-REG-01: Penerimaan Data Formulir Pendaftaran
* **Deskripsi:** Sistem SHALL menyediakan dan memproses formulir registrasi calon siswa baru secara aman.
* **Input:** Payload HTTP POST pada URI `/ppdb/daftar` dengan parameter data sesuai skema tabel `ppdb_registrations`.
* **Proses:**
  1. Melakukan validasi format seluruh input di sisi server (*Server-Side Validation*).
  2. Mengamankan integritas dengan membuka transaksi basis data (`DB::beginTransaction()`).
  3. Memastikan ketiadaan duplikasi `nisn` melalui kueri bersyarat eksklusif.
  4. Menyimpan unggahan berkas dokumen ke direktori terisolasi dengan nama acak hash UUID.
  5. Memanggil modul generator kode registrasi otomatis (FR-REG-02).
  6. Menginsersi rekaman data ke tabel `ppdb_registrations`.
  7. Menutup transaksi basis data (`DB::commit()`).
* **Output:** Pengalihan klien ke halaman `/ppdb/sukses` dengan menyertakan variabel sesi flash berupa nomor registrasi resmi yang diterbitkan.

#### 4.2.2 FR-REG-02: Generator Kode Registrasi Atomik
* **Deskripsi:** Sistem SHALL menerbitkan kode pendaftaran pendaftar unik yang deterministik, berurutan, dan kebal terhadap tabrakan konkurensi (*zero collision*).
* **Format Kode:** `REG-YYYYMMDD-XXXX` (Di mana `YYYYMMDD` adalah tanggal server saat transaksi, dan `XXXX` adalah 4 digit nomor urut harian dimulai dari `0001`).
* **Algoritma Pemrosesan (Pseudospek):**
  ```
  BEGIN TRANSACTION (Isolation Level: READ COMMITTED)
    date_prefix = FORMAT_DATE(CURRENT_DATE, 'YYYYMMDD')
    base_prefix = 'REG-' + date_prefix + '-'
    
    // Melakukan locking baris tertinggi di hari yang sama untuk mencegah Race Condition
    last_record = SELECT registration_code FROM ppdb_registrations 
                  WHERE registration_code LIKE (base_prefix + '%')
                  ORDER BY registration_code DESC 
                  FOR UPDATE;

    IF last_record EXISTS THEN
      current_sequence = EXTRACT_NUMBER(last_record.registration_code, OFFSET 13, LENGTH 4)
      next_sequence = current_sequence + 1
    ELSE
      next_sequence = 1
    END IF

    formatted_sequence = PAD_LEFT(next_sequence, 4, '0')
    allocated_code = base_prefix + formatted_sequence
    
    INSERT INTO ppdb_registrations (registration_code, ...) VALUES (allocated_code, ...)
  COMMIT TRANSACTION
  ```
* **Kriteria Kegagalan:** Jika sequence mencapai `9999` dalam 1 hari kalender, sistem SHALL melempar `SequenceOverflowException` dan memicu alert audit log.

---

### 4.3 Modul Pelacak Status Mandiri (FR-TRK)

#### 4.3.1 FR-TRK-01: Verifikasi Identitas Pendaftar Publik
* **Deskripsi:** Sistem SHALL memvalidasi parameter pencarian status tanpa mewajibkan pendaftar membuat akun login terpisah.
* **Input:** Payload HTTP POST pada URI `/ppdb/cek-status` membawa parameter:
  * `registration_code` (String, Format `REG-YYYYMMDD-XXXX`)
  * `nisn` (String numerik, Tepat 10 digit)
* **Proses:** Sistem mengeksekusi kueri terindeks:
  `SELECT id, registration_code, full_name, status, major_id_1, major_id_2, rejection_reason, created_at, updated_at FROM ppdb_registrations WHERE registration_code = ? AND nisn = ? LIMIT 1;`
* **Output:** Jika rekaman cocok, sistem menampilkan linimasa status berkas dan keputusan seleksi. Jika tidak cocok, sistem mengembalikan kode HTTP 404 dengan pesan peringatan yang netral tanpa membocorkan eksistensi salah satu parameter.

#### 4.3.2 FR-TRK-02: Representasi State Mesin Status
* **Deskripsi:** Sistem SHALL menampilkan label status seleksi yang merefleksikan nilai kolom `status` pada basis data:

```
+-------------+------------------+----------------------------------------------------+
| Status Enum | Label Visual UI  | Deskripsi Informasi Terbuka                        |
+-------------+------------------+----------------------------------------------------+
| pending     | Menunggu Berkas  | Berkas berhasil masuk antrean panitia PPDB.        |
| verified    | Lolos Verifikasi | Berkas administratif absah; menunggu sidang kuota. |
| accepted    | Diterima         | Dinyatakan lolos seleksi final pada Jurusan Utama. |
| rejected    | Belum Lolos      | Berkas tidak memenuhi syarat beserta rincian nota. |
+-------------+------------------+----------------------------------------------------+
```

---

### 4.4 Modul Autentikasi & Kontrol Akses (FR-AUTH)

#### 4.4.1 FR-AUTH-01: Otentikasi Staf Back-Office
* **Deskripsi:** Sistem SHALL memverifikasi identitas pengguna back-office melalui pasangan kredensial email dan kata sandi terenkripsi.
* **Input:** Payload HTTP POST pada URI `/admin/login` membawa `email`, `password`, dan token `_token` (CSRF).
* **Proses:**
  1. Evaluasi batas percobaan login (maksimum 5 kali kegagalan per IP dalam durasi 60 detik).
  2. Pencarian data pada tabel `users` berdasarkan nilai email dengan status `is_active = TRUE`.
  3. Verifikasi kesesuaian nilai password menggunakan algoritma `Hash::check()` (Bcrypt Work Factor 12).
  4. Regenerasi ID sesi aktif (`request()->session()->regenerate()`) untuk mencegah serangan *Session Fixation*.
* **Output:** Pengalihan pengguna ke dashboard utama admin (`/admin/dashboard`) jika valid; atau pengembalian pesan kesalahan umum jika tidak valid.

#### 4.4.2 FR-AUTH-02: Kontrol Akses Berbasis Peran (RBAC Enforcement)
* **Deskripsi:** Sistem SHALL membatasi akses rute administratif berdasarkan kolom `role` pada akun pengguna yang terotentikasi.
* **Matriks Otorisasi:**
  * `super_admin`: Mengakses seluruh menu manajemen, mutasi pengguna lain, konfigurasi jurusan, fasilitas, berita, verifikasi PPDB, dan ekspor data.
  * `verifikator`: Mengakses dashboard analitik terbatas, daftar pendaftar PPDB, rincian berkas, dan fungsi pembaruan status pendaftar (`verify/reject`).
  * `editor`: Mengakses modul manajemen artikel berita dan konten galeri fasilitas semata.

---

### 4.5 Modul Back-Office Management & Verifikasi (FR-ADM)

#### 4.5.1 FR-ADM-01: Dashboard Analitik Ringkas
* **Deskripsi:** Sistem SHALL menampilkan metrik agregat performa PPDB secara langsung pada saat administrator mengakses panel utama.
* **Komponen Metrik:**
  * Total akumulasi pendaftar.
  * Rasio pendaftar berdasarkan status (`pending`, `verified`, `accepted`, `rejected`).
  * Distribusi pilihan peminatan per kompetensi keahlian (`majors`).
  * Sisa kuota daya tampung masing-masing jurusan.

#### 4.5.2 FR-ADM-02: Peninjauan & Verifikasi Berkas PPDB
* **Deskripsi:** Pengguna dengan peran `super_admin` atau `verifikator` SHALL dapat meninjau rincian pendaftar dan mengeksekusi transisi status berkas.
* **Input:** Permintaan HTTP PATCH/POST pada URI `/admin/ppdb/{id}/status`.
* **Payload:**
  * `status`: Nilai enum valid (`verified`, `accepted`, `rejected`).
  * `rejection_reason`: Teks opsional (Wajib diisi jika status = `rejected`).
* **Efek Samping (Side Effects):**
  * Kolom `verified_by` diisi dengan ID pengguna yang sedang login.
  * Kolom `verified_at` dimutasi menjadi stempel waktu lokal server saat ini (`CURRENT_TIMESTAMP`).
  * Menuliskan catatan audit log pembaruan status.

#### 4.5.3 FR-ADM-03: Ekspor Rekapitulasi Data Pendaftar
* **Deskripsi:** Sistem SHALL menyediakan utilitas pembuatan berkas laporan tabular data pendaftar dalam format `.xlsx` atau `.csv`.
* **Input:** Permintaan HTTP GET pada URI `/admin/ppdb/export` disertai query string filter opsional `?major_id={id}&status={status}`.
* **Proses:** Sistem mengalirkan data (*stream download*) langsung dari tabel basis data menggunakan chunking memory-efficient guna mencegah pelampauan limit `memory_limit` PHP server.
* **Output:** File unduhan biner dengan header `Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet`.

---

## 5. KONTRAK API ENDPOINTS & SPESIFIKASI PERTUKARAN DATA (API SPECIFICATIONS)

### 5.1 Konvensi Protokol & Autentikasi
* Seluruh permintaan API atau form submit berbasis AJAX wajib menyertakan header permintaan:
  * `Accept: application/json`
  * `X-Requested-With: XMLHttpRequest`
  * `X-CSRF-TOKEN: [Token Sesi Klien]`
* Respons sukses sistem disajikan dalam amplop JSON terstruktur:
  ```json
  {
    "success": true,
    "message": "Deskripsi status pemrosesan.",
    "data": {}
  }
  ```

### 5.2 Endpoint Publik: PPDB & Lacak Status

#### 5.2.1 Endpoint Registrasi PPDB
* **URI Path:** `/api/v1/ppdb/register` (atau `POST /ppdb/daftar`)
* **Metode HTTP:** `POST`
* **Format Body:** `multipart/form-data`
* **Struktur Parameter Payload:**

| Nama Parameter | Tipe Data | Wajib/Opsional | Deskripsi & Batasan |
|---|---|---|---|
| `nisn` | String | Wajib | 10 digit numerik, unik di tabel `ppdb_registrations`. |
| `nik` | String | Wajib | 16 digit numerik identitas kependudukan. |
| `full_name` | String | Wajib | Panjang 3 - 150 karakter, alfabet dan spasi. |
| `birth_place` | String | Wajib | Panjang 2 - 100 karakter. |
| `birth_date` | Date | Wajib | Format ISO `YYYY-MM-DD`, usia maksimal 21 tahun. |
| `gender` | Enum | Wajib | Pilihan: `'L'` (Laki-laki), `'P'` (Perempuan). |
| `religion` | String | Wajib | Pilihan: Islam, Kristen, Katolik, Hindu, Buddha, Konghucu. |
| `phone_number` | String | Wajib | Panjang 10 - 15 digit numerik, format seluler Indonesia. |
| `parent_phone_number`| String | Wajib | Panjang 10 - 15 digit numerik kontak orang tua/wali. |
| `previous_school`| String | Wajib | Asal sekolah SMP/MTs, panjang 3 - 150 karakter. |
| `address` | String | Wajib | Teks alamat domisili, minimal 10 karakter. |
| `major_id_1` | Integer | Wajib | ID referensi valid ke tabel `majors` (aktif). |
| `major_id_2` | Integer | Wajib | ID referensi valid ke tabel `majors` (berbeda dari major_1). |
| `average_report_score`| Float | Wajib | Nilai desimal `0.00` hingga `100.00`. |
| `document_file`| Binary | Opsional | Berkas ekstensi `.pdf`, `.jpg`, `.png`, maksimal 2048 KB. |

* **Skema Respons Sukses (HTTP 201 Created):**
```json
{
  "success": true,
  "message": "Pendaftaran pendaftar baru berhasil diamankan ke dalam sistem.",
  "data": {
    "registration_code": "REG-20260615-0042",
    "nisn": "0081234567",
    "full_name": "MUHAMMAD RIZKY FIRDAUS",
    "status": "pending",
    "registered_at": "2026-06-15T14:32:01+07:00"
  }
}
```

#### 5.2.2 Endpoint Pelacakan Status Seleksi Mandiri
* **URI Path:** `/api/v1/ppdb/tracking` (atau `POST /ppdb/cek-status`)
* **Metode HTTP:** `POST`
* **Format Body:** `application/json`
* **Struktur Parameter Payload:**
```json
{
  "registration_code": "REG-20260615-0042",
  "nisn": "0081234567"
}
```
* **Skema Respons Sukses (HTTP 200 OK):**
```json
{
  "success": true,
  "message": "Data pendaftar valid ditemukan.",
  "data": {
    "registration_code": "REG-20260615-0042",
    "nisn": "0081234567",
    "full_name": "MUHAMMAD RIZKY FIRDAUS",
    "previous_school": "SMP NEGERI 1 SURABAYA",
    "first_choice_major": "Rekayasa Perangkat Lunak",
    "second_choice_major": "Teknik Jaringan Komputer & Telekomunikasi",
    "status": "verified",
    "status_description": "Berkas telah dinyatakan lengkap dan absah oleh verifikator.",
    "rejection_reason": null,
    "last_updated": "2026-06-16T09:15:22+07:00"
  }
}
```

### 5.3 Endpoint Administratif: Verifikasi & Master Data

#### 5.3.1 Endpoint Pembaruan Status Verifikasi PPDB
* **URI Path:** `/api/v1/admin/ppdb/{id}/status`
* **Metode HTTP:** `PATCH`
* **Proteksi:** Terotentikasi Sesi, Role `super_admin` atau `verifikator`.
* **Struktur Parameter Payload:**
```json
{
  "status": "rejected",
  "rejection_reason": "Scan Kartu Keluarga buram dan nilai rapor semester 1 tidak tertera jelas."
}
```
* **Skema Respons Sukses (HTTP 200 OK):**
```json
{
  "success": true,
  "message": "Status verifikasi berhasil diperbarui.",
  "data": {
    "id": 42,
    "registration_code": "REG-20260615-0042",
    "status": "rejected",
    "verified_by_name": "Budi Santoso, S.Kom",
    "verified_at": "2026-06-16T11:00:15+07:00"
  }
}
```

---

## 6. ATURAN VALIDASI DATA & INTEGRITAS SISTEM (DATA VALIDATION RULES)

### 6.1 Validasi Input Entitas Pendaftaran PPDB
Setiap data pendaftaran wajib lolos dari *Validation Layer* server-side berikut sebelum dieksekusi ke basis data:

```
+------------------------+---------------------------------------------------------------------------------------------+
| Nama Field Entitas     | Aturan Validasi Teknis (Laravel Validator Syntax Compliant)                                 |
+------------------------+---------------------------------------------------------------------------------------------+
| nisn                   | 'required', 'string', 'size:10', 'regex:/^[0-9]{10}$/', 'unique:ppdb_registrations,nisn'     |
| nik                    | 'required', 'string', 'size:16', 'regex:/^[0-9]{16}$/'                                      |
| full_name              | 'required', 'string', 'min:3', 'max:150', 'regex:/^[\pL\s\.\'\-]+$/u'                       |
| birth_place            | 'required', 'string', 'min:2', 'max:100'                                                    |
| birth_date             | 'required', 'date_format:Y-m-d', 'before:today', 'after:2004-12-31'                         |
| gender                 | 'required', 'in:L,P'                                                                        |
| religion               | 'required', 'string', 'in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu'                      |
| phone_number           | 'required', 'string', 'min:10', 'max:15', 'regex:/^(08|\+628|628)[0-9]{8,13}$/'             |
| parent_phone_number    | 'required', 'string', 'min:10', 'max:15', 'regex:/^(08|\+628|628)[0-9]{8,13}$/'             |
| previous_school        | 'required', 'string', 'min:3', 'max:150'                                                    |
| address                | 'required', 'string', 'min:10', 'max:1000'                                                  |
| major_id_1             | 'required', 'integer', 'exists:majors,id,is_active,1'                                       |
| major_id_2             | 'required', 'integer', 'different:major_id_1', 'exists:majors,id,is_active,1'               |
| average_report_score   | 'required', 'numeric', 'between:0,100', 'regex:/^\d+(\.\d{1,2})?$/'                         |
| document_file          | 'nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'                                   |
+------------------------+---------------------------------------------------------------------------------------------+
```

### 6.2 Validasi Master Data & Konten

#### 6.2.1 Entitas Kompetensi Keahlian (`majors`)
* `code`: Wajib unik, alfanumerik huruf kapital tanpa spasi, panjang 2 - 10 karakter (`regex:/^[A-Z0-9]+$/`).
* `name`: Wajib terisi, panjang 3 - 150 karakter.
* `quota`: Wajib integer positif minimal 0 (`integer`, `min:0`).
* `slug`: Wajib unik, format url-friendly (`regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/`).

#### 6.2.2 Entitas Berita (`news`)
* `title`: Wajib terisi, panjang 5 - 255 karakter.
* `content`: Wajib terisi, tipe text minimal 50 karakter.
* `status`: Wajib berada dalam pilihan set: `draft`, `published`, `archived`.
* `thumbnail_image`: Berkas gambar ekstensi `.jpg`, `.jpeg`, `.webp`, atau `.png` dengan resolusi minimal 800x450 piksel, maksimal 1024 KB.

### 6.3 Integritas Basis Data & Relational Constraints

```
       [ majors ]
       (PK: id) 
       ▲      ▲
       │      │  ON DELETE RESTRICT (Mencegah penghapusan jurusan berelasi)
       │      └──────────────────────────────────────┐
       │                                             │
(FK: major_id_1)                              (FK: major_id_2)
+------------------------------------------------------------+
|                    ppdb_registrations                      |
+------------------------------------------------------------+
| PK: id                                                     |
| UQ: registration_code                                      |
| UQ: nisn                                                   |
| FK: verified_by ────────────────────────┐                  |
+-----------------------------------------┼------------------+
                                          │ ON DELETE SET NULL
                                          ▼
                                      [ users ]
                                      (PK: id)
                                          ▲
                                          │ ON DELETE RESTRICT
                                   (FK: author_id)
                                      [ news ]
                                      (PK: id)
```

1. **Aturan Kaskade Terbatas (No Cascade On Critical Data):**
   * Foreign key `ppdb_registrations.major_id_1` dan `ppdb_registrations.major_id_2` mengikat tabel `majors(id)` dengan klausul `ON DELETE RESTRICT`. Operator tidak diizinkan menghapus baris data jurusan yang telah memiliki catatan pendaftar aktif.
   * Foreign key `ppdb_registrations.verified_by` mengikat tabel `users(id)` dengan klausul `ON DELETE SET NULL`. Jika akun staf administrator dihapus, riwayat verifikasi berkas pendaftar tetap bertahan tanpa kehilangan entitas transaksi.
2. **Kekangan Ketunggalan Fisik (Physical Unique Indexes):**
   * Indeks unik diterapkan pada level DDL basis data pada kolom `registration_code` dan `nisn` di tabel `ppdb_registrations` untuk menolak potensi duplikasi saat kondisi *concurrent race conditions*.

---

## 7. PENANGANAN ERROR & MANAJEMEN EKSEPSI (ERROR HANDLING & FAULT TOLERANCE)

### 7.1 Format Respons Standar Galat (RFC 7807 Standard)
Seluruh respons kesalahan sistem yang diakibatkan oleh validasi data, otorisasi, maupun gangguan basis data, SHALL diformat mengikuti representasi seragam:

```json
{
  "type": "https://smk.sch.id/errors/validation-error",
  "title": "Unprocessable Entity",
  "status": 422,
  "detail": "Data yang dikirimkan tidak memenuhi spesifikasi verifikasi sistem.",
  "instance": "/api/v1/ppdb/register",
  "invalid_params": [
    {
      "name": "nisn",
      "reason": "NISN ini sudah terdaftar dalam sistem penerimaan tahun berjalan."
    },
    {
      "name": "average_report_score",
      "reason": "Nilai rata-rata rapor tidak boleh melampaui angka 100.00."
    }
  ],
  "timestamp": "2026-06-15T14:32:01Z"
}
```

### 7.2 Pemetaan Kode Galat HTTP & Domain Exception

| Kode Status HTTP | Kondisi Terjadinya Galat | Deskripsi Pesan Antarmuka Pengguna | Tindakan Sistem |
|---|---|---|---|
| **400 Bad Request** | Format payload JSON tidak dapat diuraikan (*malformed JSON*). | "Format data yang dikirimkan salah atau tidak lengkap." | Menolak request tanpa memproses basis data. |
| **401 Unauthorized** | Sesi otentikasi login admin kadaluarsa atau tidak ada token sesi. | "Sesi kerja Anda telah berakhir. Silakan login kembali." | Mengalihkan pengguna ke form `/admin/login`. |
| **403 Forbidden** | Akun staf mencoba mengakses modul di luar hak peran (RBAC). | "Anda tidak memiliki wewenang untuk mengeksekusi aksi ini." | Mencatat upaya pelanggaran hak akses ke audit log. |
| **404 Not Found** | Pencarian data PPDB (Kode Registrasi + NISN) tidak ditemukan. | "Kombinasi Nomor Registrasi dan NISN tidak terdaftar." | Mengembalikan respon tanpa mengekspos rincian basis data. |
| **419 Page Expired** | Token validasi CSRF hilang atau tidak valid. | "Sesi pengiriman formulir kedaluwarsa. Silakan muat ulang halaman." | Meminta browser memuat ulang token token baru. |
| **422 Unprocessable** | Pelanggaran aturan validasi formulir input di sisi server. | "Terdapat data yang belum valid. Mohon periksa isian Anda." | Mengembalikan daftar error spesifik per kolom form. |
| **429 Too Many Req** | Melampaui ambang batas rate limiting (10 req/menit pada status check).| "Aktivitas terlalu padat. Harap tunggu 1 menit lagi." | Menutup koneksi sementara untuk IP pemohon. |
| **500 Internal Error**| Eksepsi internal tak terduga (Basis data putus, filesystem error). | "Terjadi kendala pada sistem internal kami. Tim teknis sedang menangani." | Log stack-trace terenkripsi ke file log internal. |

### 7.3 Mekanisme Transaksional & Pemulihan Kegagalan Generator Kode

```
               [ Request Pendaftaran ]
                          │
                          ▼
             ┌─────────────────────────┐
             │   Mulai DB Transaction  │
             └────────────┬────────────┘
                          │
                          ▼
             ┌─────────────────────────┐
             │ Lock Sequences Table/Row│
             └────────────┬────────────┘
                          │
               ┌──────────┴──────────┐
          Sukses?                 Gagal? (Deadlock / Timeout)
               │                             │
               ▼                             ▼
   ┌───────────────────────┐     ┌───────────────────────┐
   │ Generate Code:        │     │ Tangkap PDOException  │
   │  REG-YYYYMMDD-XXXX    │     └───────────┬───────────┘
   └───────────┬───────────┘                 │
               │                             ▼
               ▼                 ┌───────────────────────┐
   ┌───────────────────────┐     │ Auto-Retry Maks 3x    │
   │ Insert Data Pendaftar │     │ (Exponential Backoff) │
   └───────────┬───────────┘     └───────────┬───────────┘
               │                             │
      ┌────────┴────────┐           ┌────────┴────────┐
   Sukses?           Gagal?      Sukses?           Gagal? (Tetap Gagal)
      │                 │           │                 │
      ▼                 │           ▼                 ▼
┌───────────┐           │     ┌───────────┐     ┌───────────┐
│ Commit DB │           └────►│ Rollback  │◄────┤ Rollback  │
│ 201 Resp  │                 │ Database  │     │ Fatal 500 │
└───────────┘                 └───────────┘     └───────────┘
```

1. **Mekanisme Percobaan Ulang Transaksi (Automatic Retry Policy):**
   * Apabila eksekusi transaksi alokasi kode pendaftaran mengalami kegagalan akibat kebuntuan basis data (*deadlock*) pada saat lonjakan pendaftaran, sistem SHALL secara otomatis mengulang transaksi maksimum 3 (tiga) kali dengan jeda eksponensial acak (*exponential backoff with jitter* antara 100ms - 300ms).
2. **Pembersihan Berkas Mengambang (Orphan File Cleanup):**
   * Jika basis data mengalami *rollback* setelah berkas dokumen fisik pendaftar berhasil dituliskan ke media penyimpanan disk, sistem operasi aplikasi SHALL secara otomatis menghapus berkas dokumen terkait dari disk untuk mencegah penumpukan sampah data (*orphan storage leak*).

---

## 8. KEBUTUHAN NON-FUNGSIONAL (NON-FUNCTIONAL REQUIREMENTS)

### 8.1 Kebutuhan Kinerja (Performance Requirements)
* **NFR-PRF-01:** Waktu tanggap server (*Time to First Byte* - TTFB) untuk seluruh rute portal profil publik tidak boleh melampaui **200 milidetik** pada beban 100 koneksi konkuren.
* **NFR-PRF-02:** *Largest Contentful Paint* (LCP) pada peramban mobile (koneksi 4G standar) wajib tercapai di bawah **1.5 detik**.
* **NFR-PRF-03:** Pemrosesan transaksi formulir pendaftaran PPDB (sejak tombol diklik hingga respons nomor registrasi muncul) tidak boleh melebihi **1.000 milidetik**.
* **NFR-PRF-04:** Beban kueri pemfilteran dan paginasi dashboard admin pendaftar PPDB tidak boleh melebihi **100 milidetik** untuk dataset hingga 10.000 baris, dicapai melalui optimasi index relasional majemuk `idx_ppdb_code_nisn (registration_code, nisn)` dan `idx_ppdb_status (status)`.

### 8.2 Kebutuhan Keamanan (Security Requirements)
* **NFR-SEC-01 (Kekebalan Injeksi SQL):** 100% interaksi pembacaan dan penulisan basis data wajib menggunakan teknik *Parameterized Queries* atau *Eloquent Object-Relational Mapping (ORM)*. Larangan mutlak penyambungan string manual (*raw string concatenation*) pada klausul SQL.
* **NFR-SEC-02 (Kekebalan Cross-Site Scripting):** Seluruh output variabel dinamis yang dirender ke antarmuka Blade wajib melalui mekanisme sanitasi bawaan `{{ $variable }}` yang mengeksekusi fungsi `htmlspecialchars()`. Data HTML kaya konten (*Rich Text Editor*) dari modul berita wajib dibersihkan menggunakan *HTMLPurifier* sebelum disimpan.
* **NFR-SEC-03 (Proteksi Token CSRF):** Seluruh rute formulir web mutatif bertipe `POST`, `PUT`, `PATCH`, dan `DELETE` wajib memvalidasi token CSRF yang terenkripsi per sesi.
* **NFR-SEC-04 (Hashing Kredensial):** Kata sandi seluruh akun pengguna back-office wajib di-hash menggunakan algoritma **Bcrypt** dengan work factor minimum bernilai 12 (atau Argon2id dengan batas memori 64MB).
* **NFR-SEC-05 (Mitigasi Serangan DoS / Brute-Force):**
  * Endpoint publik `/ppdb/cek-status` dibatasi maksimum **10 permintaan per menit** per IP address.
  * Endpoint login back-office `/admin/login` dibatasi maksimum **5 percobaan gagal per menit** per IP address sebelum dikunci selama 300 detik.

### 8.3 Ketersediaan & Keandalan (Availability & Reliability)
* **NFR-REL-01 (Service Availability):** Sistem ditargetkan memiliki tingkat ketersediaan layanan (*uptime*) **99.5%** selama masa aktif periode pendaftaran PPDB daring.
* **NFR-REL-02 (Data Loss Prevention):** Kehilangan data transaksi akibat kegagalan perangkat lunak atau *server crash* dibatasi dengan target *Recovery Point Objective* (RPO) maksimal **1 jam**, dan *Recovery Time Objective* (RTO) penyalaan sistem kembali maksimal **2 jam** melalui pencadangan basis data berkala otomatis (*Automated Daily Database Dump*).

### 8.4 Kemudahan Pemeliharaan & Skalabilitas (Maintainability & Scalability)
* **NFR-MNT-01 (Struktur Kode Modular):** Arsitektur perangkat lunak wajib menerapkan pola *Clean MVC Architecture* di mana seluruh logika transaksional terisolasi di dalam *Action Classes* atau *Service Classes*, membebaskan lapisan Controller dari manipulasi kueri basis data berulang.
* **NFR-MNT-02 (Aksesibilitas Antarmuka):** Rasio kontras warna teks dan antarmuka interaktif wajib mematuhi panduan **WCAG 2.1 Level AA** dengan nilai kontras minimum **4.5:1** terhadap latar belakang untuk menjamin kemudahan navigasi bagi calon pendaftar dengan disabilitas visual parsial.

---

## 9. MATRIKS KETERTELUSURAN KEBUTUHAN (REQUIREMENTS TRACEABILITY MATRIX - RTM)

Matriks berikut mengaitkan kebutuhan bisnis pada PRD, kebutuhan fungsional teknis pada dokumen SRS ini, skema data basis data terkait, serta rute antarmuka sistem:

| ID PRD | ID Spesifikasi SRS | Deskripsi Kebutuhan Teknis | Tabel RDBMS Terkait | Endpoint Rute / Antarmuka | Metode Verifikasi Uji |
|---|---|---|---|---|---|
| **FR-PUB-01** | `FR-PUB-01` | Profil Institusi & Visi-Misi | File Config / Content | `GET /profil` | Pengujian Inspeksi Visual & DOM |
| **FR-PUB-02** | `FR-PUB-02` | Katalog Jurusan & Daya Tampung | `majors` | `GET /jurusan`, `GET /jurusan/{slug}` | Pengujian Integrasi Unit Database |
| **FR-PUB-03** | `FR-PUB-03` | Katalog Sarana & Fasilitas | `facilities` | `GET /fasilitas` | Pengujian Tampilan Antarmuka |
| **FR-PUB-04** | `FR-PUB-04` | Berita & Pengumuman Sekolah | `news`, `users` | `GET /berita`, `GET /berita/{slug}` | Pengujian Fungsional Paginasi & Search |
| **FR-REG-01** | `FR-REG-01` | Formulir Pendaftaran PPDB Multi-Input | `ppdb_registrations` | `POST /ppdb/daftar` | Pengujian Validasi E2E & Boundary Testing |
| **FR-REG-02** | `FR-REG-01` | Validasi Format NISN, NIK, Nilai | `ppdb_registrations` | `POST /ppdb/daftar` | Automated Negative Test Case (Regex) |
| **FR-REG-03** | `FR-REG-02` | Generator Kode Transaksional Atomik | `ppdb_registrations` | Internal Engine Service | Pengujian Konkurensi Paralel (Race Cond) |
| **FR-TRK-01** | `FR-TRK-01` | Lacak Status Mandiri (No Reg + NISN) | `ppdb_registrations` | `POST /ppdb/cek-status` | Pengujian Integrasi Query Status |
| **FR-AUTH-01**| `FR-AUTH-01`| Login Admin, Session, Throttle | `users` | `POST /admin/login` | Pengujian Penetrasi Keamanan (Brute Force) |
| **FR-ADM-01** | `FR-ADM-01` | Dashboard Analitik & Kuota | `ppdb_registrations`, `majors` | `GET /admin/dashboard` | Pengujian Akurasi Kalkulasi Agregat |
| **FR-ADM-02** | `FR-ADM-02` | State Machine Verifikasi Berkas | `ppdb_registrations`, `users` | `PATCH /admin/ppdb/{id}/status` | Pengujian State Lifecycle Transition |
| **FR-ADM-03** | `FR-ADM-03` | Kelola Master Data Jurusan (CRUD) | `majors` | Resource `/admin/jurusan` | Pengujian CRUD Operasional |
| **FR-ADM-04** | `FR-ADM-04` | Kelola Fasilitas Sekolah (CRUD) | `facilities` | Resource `/admin/fasilitas` | Pengujian CRUD & Handler Unggah Berkas |
| **FR-ADM-05** | `FR-ADM-05` | Publikasi Berita Sekolah (CRUD) | `news` | Resource `/admin/berita` | Pengujian Publikasi Konten & Sanitasi XSS |
| **FR-ADM-06** | `FR-ADM-03` | Ekspor Tabular Spreadsheet Data | `ppdb_registrations`, `majors` | `GET /admin/ppdb/export` | Pengujian Integritas Berkas Unduhan |

---

## 10. PENGESAHAN DOKUMEN ARSITEKTUR (ARCHITECTURAL SIGN-OFF)

Spesifikasi Kebutuhan Perangkat Lunak (**SRS**) ini telah ditinjau dan dinyatakan memenuhi standar arsitektur industri sistem informasi modern. Seluruh instruksi dalam dokumen ini mengikat dan menjadi syarat penentu penerimaan rilis (*Definition of Done*) perangkat lunak.

| Peran Peninjau | Nama Agen / Personil | Tanggal Tinjau | Status Persetujuan |
|---|---|---|---|
| **Lead Systems Analyst** | Technical Architect Office | Q3-2026 | **APPROVED** |
| **Principal UI/UX Designer** | Agent Pixel (UI Lead) | Q3-2026 | **APPROVED** |
| **Lead Engineering Worker** | Agent Dev (Core Backend Lead) | Q3-2026 | **ACCEPTED FOR IMPLEMENTATION** |

---
*AKHIR DARI DOKUMEN SRS — IEEE 830-1998 STANDARD COMPLIANT.*