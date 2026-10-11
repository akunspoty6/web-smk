-- ========================================================================
-- SKEMA BASIS DATA RELASIONAL SMK TI SYARIAH ENGINEERING (web_smk)
-- Target Engine : SQLite & MySQL / MariaDB (Agnostik Kompatibel)
-- Versi Skema   : 1.0 (3NF Relasional Bersih)
-- ========================================================================

-- Pastikan integritas foreign key aktif di SQLite
PRAGMA foreign_keys = ON;

-- 1. TABEL PENGGUNA & PANITIA (users)
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'admin_ppdb' CHECK (role IN ('superadmin', 'admin_ppdb', 'editor')),
    phone_number VARCHAR(20),
    remember_token VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. TABEL KONSENTRASI KEAHLIAN / JURUSAN (majors)
DROP TABLE IF EXISTS majors;
CREATE TABLE majors (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    code VARCHAR(10) NOT NULL UNIQUE,
    name VARCHAR(150) NOT NULL,
    slug VARCHAR(150) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    competencies TEXT NOT NULL,
    career_prospects TEXT,
    quota INTEGER NOT NULL DEFAULT 0,
    thumbnail VARCHAR(255),
    is_active INTEGER NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. TABEL WARTA, AGENDA & PRESTASI (news)
DROP TABLE IF EXISTS news;
CREATE TABLE news (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    author_id INTEGER NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    category VARCHAR(20) NOT NULL DEFAULT 'berita' CHECK (category IN ('berita', 'agenda', 'prestasi', 'pengumuman')),
    excerpt VARCHAR(500) NOT NULL,
    content TEXT NOT NULL,
    featured_image VARCHAR(255),
    status VARCHAR(20) NOT NULL DEFAULT 'published' CHECK (status IN ('draft', 'published')),
    published_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- 4. TABEL INVENTARIS SARANA & PRASARANA (facilities)
DROP TABLE IF EXISTS facilities;
CREATE TABLE facilities (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(150) NOT NULL,
    category VARCHAR(30) NOT NULL CHECK (category IN ('laboratorium', 'bengkel', 'ruang_kelas', 'sarana_olahraga', 'fasilitas_umum')),
    description TEXT,
    image_path VARCHAR(255),
    capacity INTEGER DEFAULT 30,
    condition VARCHAR(20) NOT NULL DEFAULT 'baik' CHECK (condition IN ('sangat_baik', 'baik', 'pemeliharaan')),
    is_public INTEGER NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5. TABEL PENDAFTARAN PPDB ONLINE (ppdb_registrations)
DROP TABLE IF EXISTS ppdb_registrations;
CREATE TABLE ppdb_registrations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    registration_code VARCHAR(25) NOT NULL UNIQUE,
    major_id INTEGER NOT NULL,
    alternative_major_id INTEGER,
    nisn VARCHAR(10) NOT NULL UNIQUE,
    nik VARCHAR(16) NOT NULL,
    full_name VARCHAR(150) NOT NULL,
    gender VARCHAR(1) NOT NULL CHECK (gender IN ('L', 'P')),
    birth_place VARCHAR(100) NOT NULL,
    birth_date DATE NOT NULL,
    religion VARCHAR(30) NOT NULL DEFAULT 'Islam',
    previous_school VARCHAR(150) NOT NULL,
    student_phone VARCHAR(20) NOT NULL,
    parent_phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    report_card_score DECIMAL(5,2) NOT NULL,
    document_kk_path VARCHAR(255) DEFAULT 'default_kk.pdf',
    document_raport_path VARCHAR(255) DEFAULT 'default_rapor.pdf',
    document_photo_path VARCHAR(255) DEFAULT 'default_foto.jpg',
    status VARCHAR(20) NOT NULL DEFAULT 'pending' CHECK (status IN ('pending', 'verified', 'accepted', 'rejected')),
    verification_notes TEXT,
    verified_by INTEGER,
    verified_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (major_id) REFERENCES majors(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (alternative_major_id) REFERENCES majors(id) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (verified_by) REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE
);

-- PEMBUATAN INDEKS PERFORMA QUERY CEPAT
CREATE INDEX idx_ppdb_nisn ON ppdb_registrations(nisn);
CREATE INDEX idx_ppdb_code ON ppdb_registrations(registration_code);
CREATE INDEX idx_ppdb_status ON ppdb_registrations(status);
CREATE INDEX idx_news_slug ON news(slug);
CREATE INDEX idx_majors_slug ON majors(slug);

-- ========================================================================
-- DATA SEED AWAL (SAMPLE DATA STANDAR INDUSTRI)
-- ========================================================================

-- Akun Administrator Panitia (Password default: admin123 via bcrypt)
INSERT INTO users (id, name, email, password, role, phone_number) VALUES
(1, 'Ust. Ahmad Fauzi, S.Kom', 'admin@smk.sch.id', '$2y$12$e6m7xT8.mR9FkX1Kk3vR8e8KqgqjW5uVbX2R5CqQ5Y6gV7aZ9X1Km', 'superadmin', '081298765432'),
(2, 'Siti Nurhaliza, S.Pd', 'verifikator@smk.sch.id', '$2y$12$e6m7xT8.mR9FkX1Kk3vR8e8KqgqjW5uVbX2R5CqQ5Y6gV7aZ9X1Km', 'admin_ppdb', '081311223344');

-- Master Konsentrasi Keahlian
INSERT INTO majors (id, code, name, slug, description, competencies, career_prospects, quota, is_active) VALUES
(1, 'RPL', 'Rekayasa Perangkat Lunak', 'rekayasa-perangkat-lunak', 'Fokus pada pengembangan aplikasi modern, microservices, cloud native, dan rekayasa web terstandarisasi.', 'Fullstack Web, Database PostgreSQL, Rest API, Git CI/CD', 'Software Engineer, Frontend Dev, Backend Engineer, QA Specialist', 72, 1),
(2, 'TKJ', 'Teknik Komputer & Jaringan', 'teknik-komputer-dan-jaringan', 'Spesialisasi infrastruktur jaringan komputer, sistem server cloud, MikroTik MTCNA, dan keamanan siber.', 'Routing Cisco, Mikrotik MTCNA, Server Linux, Fiber Optik FTTH', 'Network Engineer, Cloud Administrator, Cyber Security Analyst', 72, 1),
(3, 'DKV', 'Desain Komunikasi Visual', 'desain-komunikasi-visual', 'Eksplorasi visual grafis digital, animasi Islami berkarakter, branding produk, serta desain UI/UX mobile apps.', 'UI/UX Design Figma, Blender 3D, Premiere Pro, Adobe Illustrator', 'UI/UX Designer, Motion Graphic Artist, Creative Director', 36, 1),
(4, 'TKRO', 'Teknik Kendaraan Ringan Otomotif', 'teknik-kendaraan-ringan-otomotif', 'Teknologi injeksi kendaraan modern (EFI), diagnosa berbasis komputer scanner OBD-II, dan sistem EV car.', 'Engine Tune-up EFI, Sistem Kelistrikan Body, Konversi Motor Listrik', 'Teknisi Dealer Resmi, Mekanik Industri Alat Berat, Wirausaha Bengkel', 36, 1);

-- Sarana & Prasarana
INSERT INTO facilities (name, category, description, capacity, condition, is_public) VALUES
('Lab Cloud & DevOps Enterprise', 'laboratorium', 'Ruang praktikum ber-AC dengan 36 unit PC workstation Core i7, dual monitor, dan server lokal.', 36, 'sangat_baik', 1),
('Bengkel Otomotif Konversi EV & EFI', 'bengkel', 'Lengkap dengan 2 hydraulic lift, computerized engine scanner, dan bengkel uji emisi gas.', 40, 'sangat_baik', 1),
('Studio Multimedia & Podcast DKV', 'laboratorium', 'Acoustic soundproof chamber, lighting studio, kamera 4K cinema dan pen tablet.', 24, 'baik', 1),
('Masjid Jami & Islamic Center Siswa', 'fasilitas_umum', 'Pusat ibadah harian, halaqah Quran, kajian adab, dan pembinaan ruhiyah berdaya tampung 800 orang.', 800, 'sangat_baik', 1);

-- Warta & Pengumuman
INSERT INTO news (author_id, title, slug, category, excerpt, content, status) VALUES
(1, 'Juara 1 LKS Cloud Computing Tingkat Provinsi Jawa Barat 2026', 'juara-1-lks-cloud-computing-jabar-2026', 'prestasi', 'Siswa SMK TI Syariah kembali memborong medali emas di bidang infrastruktur awan.', 'Alhamdulillah, ananda Rayhan kelas XII RPL sukses mempersembahkan trofi juara 1 LKS...', 'published'),
(1, 'Kemitraan Strategis DUDI dengan 15 Perusahaan Teknologi Terkemuka', 'kemitraan-strategis-dudi-2026', 'berita', 'Penandatanganan kerja sama magang industri dan rekrutmen kerja lulusan langsung tanpa tes ulang.', 'Dalam rangka memperkuat link and match vokasi...', 'published');

-- Data Pendaftaran PPDB Awal
INSERT INTO ppdb_registrations (registration_code, major_id, alternative_major_id, nisn, nik, full_name, gender, birth_place, birth_date, religion, previous_school, student_phone, parent_phone, address, report_card_score, status, verification_notes, verified_by, verified_at) VALUES
('PPDB-20260330-1092', 1, 2, '0081234567', '3201012304080001', 'Muhammad Fadhil Pratama', 'L', 'Bogor', '2008-04-12', 'Islam', 'SMP Negeri 1 Cibinong', '081298765432', '081311223344', 'Jl. Raya Bogor KM 42, Cibinong', 88.50, 'verified', 'Nilai dan NISN lolos validasi online.', 1, CURRENT_TIMESTAMP),
('PPDB-20260330-8841', 2, 1, '0087654321', '3201011802080002', 'Aisyah Nur Rahmah', 'P', 'Jakarta', '2008-02-18', 'Islam', 'MTs Negeri 2 Bogor', '085712345678', '085811223344', 'Komplek Pesona Karadenan No. 5', 91.20, 'accepted', 'Lulus seleksi berkas gelombang 1 kuota utama.', 1, CURRENT_TIMESTAMP);