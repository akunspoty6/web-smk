<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SMK TI Syariah Engineering - Portal Resmi & PPDB Online</title>
  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
            mono: ['"JetBrains Mono"', 'monospace'],
          },
          colors: {
            brand: {
              50: '#ecfdf5',
              100: '#d1fae5',
              500: '#10b981',
              600: '#059669',
              700: '#047857',
              800: '#065f46',
              900: '#064e3b',
            },
            slateCustom: {
              850: '#151f32',
              900: '#0f172a',
            }
          }
        }
      }
    }
  </script>
  <style>
    @media print {
      body * { visibility: hidden; }
      #printable-card, #printable-card * { visibility: visible; }
      #printable-card { position: absolute; left: 0; top: 0; width: 100%; }
      .no-print { display: none !important; }
    }
  </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased selection:bg-brand-500 selection:text-white">

  <!-- TOPBAR NOTIFIKASI -->
  <div class="bg-slateCustom-900 text-slate-200 text-xs py-2 px-4 border-b border-slate-800">
    <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
      <div class="flex items-center space-x-2">
        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-amber-500 text-slate-900">GELOMBANG 1</span>
        <span>PPDB Tahun Ajaran 2026/2027 Resmi Dibuka hingga 30 Juni 2026</span>
      </div>
      <div class="flex items-center space-x-4 text-slate-400">
        <span class="flex items-center gap-1"><i data-lucide="phone" class="w-3.5 h-3.5 text-brand-500"></i> (021) 8892-1204</span>
        <span class="flex items-center gap-1"><i data-lucide="mail" class="w-3.5 h-3.5 text-brand-500"></i> info@smkti-syariah.sch.id</span>
      </div>
    </div>
  </div>

  <!-- NAVIGATION HEADER -->
  <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
      <a href="#beranda" class="flex items-center gap-3 group">
        <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-brand-800 to-brand-600 flex items-center justify-center text-white shadow-md shadow-brand-700/20 group-hover:scale-105 transition-transform">
          <i data-lucide="graduation-cap" class="w-6 h-6"></i>
        </div>
        <div>
          <span class="block text-lg font-extrabold tracking-tight text-slateCustom-900 leading-none">SMK TI SYARIAH</span>
          <span class="text-[11px] font-semibold text-brand-700 tracking-wider uppercase">Vocational & Islamic Tech</span>
        </div>
      </a>

      <!-- Desktop Nav -->
      <nav class="hidden md:flex items-center gap-7 text-sm font-semibold text-slate-600">
        <a href="#beranda" class="hover:text-brand-700 transition-colors">Beranda</a>
        <a href="#jurusan" class="hover:text-brand-700 transition-colors">Konsentrasi Keahlian</a>
        <a href="#fasilitas" class="hover:text-brand-700 transition-colors">Fasilitas</a>
        <a href="#berita" class="hover:text-brand-700 transition-colors">Warta & Prestasi</a>
        <a href="#cek-status" class="hover:text-brand-700 transition-colors text-amber-600">Lacak Seleksi</a>
      </nav>

      <!-- Action Buttons -->
      <div class="hidden sm:flex items-center gap-3">
        @auth
          <div class="flex items-center gap-2 bg-emerald-50 text-emerald-800 px-3 py-1.5 rounded-lg border border-emerald-200 text-xs font-bold">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>{{ Auth::user()->name }} ({{ Auth::user()->role }})</span>
          </div>
          <form action="{{ url('/logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
              <i data-lucide="log-out" class="w-3.5 h-3.5"></i> Keluar
            </button>
          </form>
        @else
          <a href="{{ url('/login') }}" class="inline-flex items-center gap-2 px-3.5 py-2 text-xs font-semibold text-slate-700 hover:text-slate-900 bg-slate-100 hover:bg-slate-200 rounded-lg transition-colors">
            <i data-lucide="shield" class="w-3.5 h-3.5 text-slate-500"></i> Panel Admin
          </a>
        @endauth
        <a href="#pendaftaran" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-bold text-white bg-brand-700 hover:bg-brand-800 rounded-lg shadow-sm shadow-brand-800/20 transition-all hover:shadow-md">
          <i data-lucide="user-plus" class="w-3.5 h-3.5"></i> Daftar PPDB
        </a>
      </div>

      <!-- Mobile Hamburger -->
      <button onclick="toggleMobileMenu()" class="md:hidden p-2 text-slate-600 hover:text-slate-900" aria-label="Toggle Navigation">
        <i data-lucide="menu" class="w-6 h-6"></i>
      </button>
    </div>

    <!-- Mobile Drawer Nav -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-slate-200 bg-white px-4 pt-3 pb-5 space-y-2">
      <a href="#beranda" onclick="toggleMobileMenu()" class="block py-2 text-sm font-semibold text-slate-700">Beranda</a>
      <a href="#jurusan" onclick="toggleMobileMenu()" class="block py-2 text-sm font-semibold text-slate-700">Konsentrasi Keahlian</a>
      <a href="#fasilitas" onclick="toggleMobileMenu()" class="block py-2 text-sm font-semibold text-slate-700">Fasilitas</a>
      <a href="#berita" onclick="toggleMobileMenu()" class="block py-2 text-sm font-semibold text-slate-700">Warta & Prestasi</a>
      <a href="#cek-status" onclick="toggleMobileMenu()" class="block py-2 text-sm font-semibold text-amber-600">Lacak Seleksi Siswa</a>
      <div class="pt-3 border-t border-slate-100 flex flex-col gap-2">
        <a href="#pendaftaran" onclick="toggleMobileMenu()" class="w-full text-center py-2.5 text-xs font-bold text-white bg-brand-700 rounded-lg">Daftar PPDB Online</a>
        <button onclick="toggleMobileMenu(); openModal('admin-login-modal')" class="w-full text-center py-2 text-xs font-semibold text-slate-700 bg-slate-100 rounded-lg">Masuk Panel Admin</button>
      </div>
    </div>
  </header>

  <!-- HERO SECTION -->
  <section id="beranda" class="relative pt-12 pb-20 md:py-24 overflow-hidden bg-gradient-to-b from-white via-slate-50 to-emerald-50/20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        
        <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
          <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold bg-brand-50 text-brand-800 border border-brand-200">
            <span class="w-2 h-2 rounded-full bg-brand-600 animate-pulse"></span>
            Terakreditasi "A" Unggul & Standar Industri 4.0
          </div>
          
          <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slateCustom-900 tracking-tight leading-[1.15]">
            Mencetak Teknisi Digital Andal dengan Integritas <span class="text-brand-700">Syariah Engineering</span>
          </h1>
          
          <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
            Kurikulum berbasis industri multinasional, sertifikasi keahlian berstandar BNSP, dan pembinaan karakter berbasis nilai kepesantrenan modern. Siap kerja, berwirausaha, dan siap kuliah.
          </p>

          <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3.5 pt-2">
            <a href="#pendaftaran" class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-6 py-3.5 text-sm font-bold text-white bg-brand-700 hover:bg-brand-800 rounded-xl shadow-lg shadow-brand-700/25 transition-all">
              <i data-lucide="file-check-2" class="w-4 h-4"></i> Daftar PPDB 2026/2027
            </a>
            <a href="#cek-status" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 text-sm font-semibold text-slate-700 bg-white hover:bg-slate-100 border border-slate-300 rounded-xl transition-all">
              <i data-lucide="search" class="w-4 h-4 text-slate-500"></i> Cek Status Pendaftaran
            </a>
          </div>

          <!-- Quick Metric -->
          <div class="pt-8 border-t border-slate-200 grid grid-cols-3 gap-4 text-center lg:text-left">
            <div>
              <p class="text-2xl font-extrabold text-slateCustom-900">96.8%</p>
              <p class="text-xs text-slate-500 font-medium">Terserap DUDI</p>
            </div>
            <div>
              <p class="text-2xl font-extrabold text-slateCustom-900">4 Kejuruan</p>
              <p class="text-xs text-slate-500 font-medium">Standar Global</p>
            </div>
            <div>
              <p class="text-2xl font-extrabold text-slateCustom-900">45+ Mitra</p>
              <p class="text-xs text-slate-500 font-medium">Industri Tech</p>
            </div>
          </div>
        </div>

        <div class="lg:col-span-5 relative">
          <div class="relative mx-auto max-w-md lg:max-w-none">
            <div class="absolute -top-4 -left-4 w-72 h-72 bg-brand-200/40 rounded-full blur-3xl -z-10"></div>
            <div class="absolute -bottom-4 -right-4 w-72 h-72 bg-amber-200/40 rounded-full blur-3xl -z-10"></div>
            
            <div class="bg-white p-6 sm:p-7 rounded-2xl border border-slate-200 shadow-xl shadow-slate-200/60 space-y-6">
              <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Gelombang PPDB</span>
                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-700 bg-brand-50 px-2.5 py-1 rounded-full">
                  <span class="w-1.5 h-1.5 rounded-full bg-brand-600"></span> Aktif
                </span>
              </div>
              
              <div class="space-y-4 text-sm">
                <div class="flex items-start gap-3">
                  <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-700 flex items-center justify-center shrink-0 font-bold">1</div>
                  <div>
                    <h4 class="font-bold text-slate-900">Pengisian Formulir Mandiri</h4>
                    <p class="text-xs text-slate-500">Input biodata siswa, NISN, nilai rapor, dan jurusan impian.</p>
                  </div>
                </div>
                <div class="flex items-start gap-3">
                  <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center shrink-0 font-bold">2</div>
                  <div>
                    <h4 class="font-bold text-slate-900">Dapatkan Kode Registrasi Unik</h4>
                    <p class="text-xs text-slate-500">Sistem menggenerate kode pendaftaran resmi untuk cetak kartu.</p>
                  </div>
                </div>
                <div class="flex items-start gap-3">
                  <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-700 flex items-center justify-center shrink-0 font-bold">3</div>
                  <div>
                    <h4 class="font-bold text-slate-900">Verifikasi Dokumen & Wawancara</h4>
                    <p class="text-xs text-slate-500">Panitia memverifikasi berkas secara teliti dan transparan.</p>
                  </div>
                </div>
              </div>

              <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 text-xs text-slate-600 flex items-center gap-3">
                <i data-lucide="info" class="w-5 h-5 text-brand-700 shrink-0"></i>
                <span>Biaya pendaftaran online <strong>Gratis</strong> (Subsidi Yayasan Syariah Tekno).</span>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- KONSENTRASI KEAHLIAN / MAJORS -->
  <section id="jurusan" class="py-20 bg-white border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center max-w-2xl mx-auto mb-14">
        <span class="text-xs font-bold text-brand-700 uppercase tracking-widest">Katalog Kompetensi</span>
        <h2 class="text-3xl font-extrabold text-slateCustom-900 mt-2">Program Keahlian Unggulan</h2>
        <p class="text-slate-600 text-sm mt-3">Kurikulum berbasis proyek riil dengan laboratorium perangkat modern dan standar industri global.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="majors-container">
        <!-- Rendered by JavaScript -->
      </div>
    </div>
  </section>

  <!-- FASILITAS SEKOLAH -->
  <section id="fasilitas" class="py-20 bg-slate-50 border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
        <div>
          <span class="text-xs font-bold text-brand-700 uppercase tracking-widest">Sarana & Prasarana</span>
          <h2 class="text-3xl font-extrabold text-slateCustom-900 mt-2">Fasilitas Standar Modern</h2>
          <p class="text-slate-600 text-sm mt-2">Mendukung eksplorasi teknis dan pembinaan ruhiyah siswa setiap hari.</p>
        </div>
        <div class="flex gap-2">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
            <i data-lucide="check-circle" class="w-3.5 h-3.5"></i> 100% Siap Praktikum
          </span>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="facilities-container">
        <!-- Rendered by JavaScript -->
      </div>
    </div>
  </section>

  <!-- FORMULIR PENDAFTARAN PPDB ONLINE -->
  <section id="pendaftaran" class="py-20 bg-white border-t border-slate-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="text-center mb-10">
        <span class="text-xs font-bold text-brand-700 uppercase tracking-widest">PPDB Online 2026</span>
        <h2 class="text-3xl font-extrabold text-slateCustom-900 mt-1">Formulir Pendaftaran Calon Siswa Baru</h2>
        <p class="text-slate-600 text-sm mt-2">Isi seluruh isian dengan data asli dan valid sesuai dokumen Kartu Keluarga & Rapor SMP/MTs.</p>
      </div>

      <!-- Step Indicator -->
      <div class="flex items-center justify-between mb-8 px-4 sm:px-12 relative">
        <div class="absolute left-10 right-10 top-1/2 -translate-y-1/2 h-0.5 bg-slate-200 -z-0"></div>
        <div class="flex flex-col items-center gap-1 z-10" id="step-node-1">
          <div class="w-9 h-9 rounded-full bg-brand-700 text-white font-bold flex items-center justify-center text-xs shadow">1</div>
          <span class="text-[11px] font-semibold text-slate-800">Pilihan Jurusan</span>
        </div>
        <div class="flex flex-col items-center gap-1 z-10" id="step-node-2">
          <div class="w-9 h-9 rounded-full bg-slate-200 text-slate-600 font-bold flex items-center justify-center text-xs">2</div>
          <span class="text-[11px] font-semibold text-slate-500">Data Pribadi</span>
        </div>
        <div class="flex flex-col items-center gap-1 z-10" id="step-node-3">
          <div class="w-9 h-9 rounded-full bg-slate-200 text-slate-600 font-bold flex items-center justify-center text-xs">3</div>
          <span class="text-[11px] font-semibold text-slate-500">Nilai & Kontak</span>
        </div>
      </div>

      <div class="bg-white border border-slate-200 rounded-2xl shadow-xl shadow-slate-200/50 p-6 sm:p-8">
        
        <form id="ppdb-form" onsubmit="handleRegistrationSubmit(event)">
          <!-- STEP 1: PILIHAN JURUSAN -->
          <div id="step-1" class="space-y-6">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2 flex items-center gap-2">
              <i data-lucide="layers" class="w-4 h-4 text-brand-700"></i> Prioritas Program Keahlian
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
              <div>
                <label for="major_id" class="block text-xs font-bold text-slate-700 uppercase mb-2">Jurusan Pilihan Utama *</label>
                <select id="major_id" required class="w-full h-11 px-3.5 rounded-lg border border-slate-300 text-sm focus:border-brand-700 focus:ring-2 focus:ring-brand-700/20 outline-none">
                  <option value="">-- Pilih Jurusan Utama --</option>
                  <option value="1">RPL - Rekayasa Perangkat Lunak</option>
                  <option value="2">TKJ - Teknik Komputer & Jaringan</option>
                  <option value="3">DKV - Desain Komunikasi Visual</option>
                  <option value="4">TKRO - Teknik Kendaraan Ringan Otomotif</option>
                </select>
              </div>

              <div>
                <label for="alt_major_id" class="block text-xs font-bold text-slate-700 uppercase mb-2">Jurusan Pilihan Cadangan (Opsional)</label>
                <select id="alt_major_id" class="w-full h-11 px-3.5 rounded-lg border border-slate-300 text-sm focus:border-brand-700 focus:ring-2 focus:ring-brand-700/20 outline-none">
                  <option value="">-- Tidak Ada / Sama --</option>
                  <option value="1">RPL - Rekayasa Perangkat Lunak</option>
                  <option value="2">TKJ - Teknik Komputer & Jaringan</option>
                  <option value="3">DKV - Desain Komunikasi Visual</option>
                  <option value="4">TKRO - Teknik Kendaraan Ringan Otomotif</option>
                </select>
              </div>
            </div>

            <div class="pt-4 flex justify-end">
              <button type="button" onclick="goToStep(2)" class="px-5 py-2.5 bg-brand-700 hover:bg-brand-800 text-white text-xs font-bold rounded-lg flex items-center gap-2">
                Selanjutnya <i data-lucide="arrow-right" class="w-4 h-4"></i>
              </button>
            </div>
          </div>

          <!-- STEP 2: DATA PRIBADI -->
          <div id="step-2" class="hidden space-y-6">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2 flex items-center gap-2">
              <i data-lucide="user" class="w-4 h-4 text-brand-700"></i> Identitas Calon Siswa
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
              <div>
                <label for="nisn" class="block text-xs font-bold text-slate-700 uppercase mb-1">NISN (10 Digit Angka) *</label>
                <input type="text" id="nisn" maxlength="10" placeholder="0081234567" required class="w-full h-11 px-3.5 font-mono text-sm rounded-lg border border-slate-300 focus:border-brand-700 focus:ring-2 focus:ring-brand-700/20 outline-none">
                <span class="text-[11px] text-slate-500">Wajib sesuai data verval PD Kemdikbud</span>
              </div>

              <div>
                <label for="nik" class="block text-xs font-bold text-slate-700 uppercase mb-1">NIK (16 Digit Angka) *</label>
                <input type="text" id="nik" maxlength="16" placeholder="3201012304080001" required class="w-full h-11 px-3.5 font-mono text-sm rounded-lg border border-slate-300 focus:border-brand-700 focus:ring-2 focus:ring-brand-700/20 outline-none">
              </div>

              <div class="sm:col-span-2">
                <label for="full_name" class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Lengkap Siswa *</label>
                <input type="text" id="full_name" placeholder="Muhammad Fadhil Pratama" required class="w-full h-11 px-3.5 text-sm rounded-lg border border-slate-300 focus:border-brand-700 focus:ring-2 focus:ring-brand-700/20 outline-none">
              </div>

              <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jenis Kelamin *</label>
                <div class="flex gap-4 pt-2">
                  <label class="inline-flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                    <input type="radio" name="gender" value="L" checked class="text-brand-700 focus:ring-brand-700"> Laki-Laki
                  </label>
                  <label class="inline-flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                    <input type="radio" name="gender" value="P" class="text-brand-700 focus:ring-brand-700"> Perempuan
                  </label>
                </div>
              </div>

              <div>
                <label for="birth_date" class="block text-xs font-bold text-slate-700 uppercase mb-1">Tanggal Lahir *</label>
                <input type="date" id="birth_date" required class="w-full h-11 px-3.5 text-sm rounded-lg border border-slate-300 focus:border-brand-700 focus:ring-2 focus:ring-brand-700/20 outline-none">
              </div>
            </div>

            <div class="pt-4 flex justify-between">
              <button type="button" onclick="goToStep(1)" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg flex items-center gap-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
              </button>
              <button type="button" onclick="goToStep(3)" class="px-5 py-2.5 bg-brand-700 hover:bg-brand-800 text-white text-xs font-bold rounded-lg flex items-center gap-2">
                Selanjutnya <i data-lucide="arrow-right" class="w-4 h-4"></i>
              </button>
            </div>
          </div>

          <!-- STEP 3: ASAL SEKOLAH, NILAI, KONTAK & BERKAS -->
          <div id="step-3" class="hidden space-y-6">
            <h3 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-2 flex items-center gap-2">
              <i data-lucide="award" class="w-4 h-4 text-brand-700"></i> Akademik & Narahubung
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
              <div>
                <label for="previous_school" class="block text-xs font-bold text-slate-700 uppercase mb-1">Asal SMP / MTs *</label>
                <input type="text" id="previous_school" placeholder="SMP Negeri 1 Cibinong" required class="w-full h-11 px-3.5 text-sm rounded-lg border border-slate-300 focus:border-brand-700 focus:ring-2 focus:ring-brand-700/20 outline-none">
              </div>

              <div>
                <label for="report_score" class="block text-xs font-bold text-slate-700 uppercase mb-1">Rata-rata Nilai Rapor (Skala 100) *</label>
                <input type="number" id="report_score" step="0.01" min="50" max="100" placeholder="87.50" required class="w-full h-11 px-3.5 text-sm rounded-lg border border-slate-300 focus:border-brand-700 focus:ring-2 focus:ring-brand-700/20 outline-none">
              </div>

              <div>
                <label for="student_phone" class="block text-xs font-bold text-slate-700 uppercase mb-1">WhatsApp Calon Siswa *</label>
                <input type="tel" id="student_phone" placeholder="081298765432" required class="w-full h-11 px-3.5 text-sm rounded-lg border border-slate-300 focus:border-brand-700 focus:ring-2 focus:ring-brand-700/20 outline-none">
              </div>

              <div>
                <label for="parent_phone" class="block text-xs font-bold text-slate-700 uppercase mb-1">WhatsApp Orang Tua / Wali *</label>
                <input type="tel" id="parent_phone" placeholder="081311223344" required class="w-full h-11 px-3.5 text-sm rounded-lg border border-slate-300 focus:border-brand-700 focus:ring-2 focus:ring-brand-700/20 outline-none">
              </div>

              <div class="sm:col-span-2">
                <label for="address" class="block text-xs font-bold text-slate-700 uppercase mb-1">Alamat Domisili Lengkap *</label>
                <textarea id="address" rows="2" placeholder="Jl. Raya Sukamaju No. 14, RT 02/05, Desa Cijeruk, Bogor" required class="w-full p-3 text-sm rounded-lg border border-slate-300 focus:border-brand-700 focus:ring-2 focus:ring-brand-700/20 outline-none"></textarea>
              </div>

              <div class="sm:col-span-2 p-3 bg-amber-50 border border-amber-200 rounded-lg text-xs text-amber-900 flex items-start gap-2">
                <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-600 shrink-0 mt-0.5"></i>
                <span>Pastikan data valid. Kode registrasi akan langsung digenerate secara resmi dan wajib disimpan sebagai bukti kartu peserta tes.</span>
              </div>
            </div>

            <div class="pt-4 flex justify-between">
              <button type="button" onclick="goToStep(2)" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg flex items-center gap-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
              </button>
              <button type="submit" id="btn-submit-ppdb" class="px-6 py-2.5 bg-brand-700 hover:bg-brand-800 text-white text-xs font-bold rounded-lg shadow-md flex items-center gap-2">
                <i data-lucide="check" class="w-4 h-4"></i> Kirim Formulir Pendaftaran
              </button>
            </div>
          </div>
        </form>

      </div>
    </div>
  </section>

  <!-- CEK STATUS PPDB -->
  <section id="cek-status" class="py-20 bg-slate-50 border-t border-slate-200">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-8">
        <span class="text-xs font-bold text-amber-600 uppercase tracking-widest">Portal Mandiri Siswa</span>
        <h2 class="text-3xl font-extrabold text-slateCustom-900 mt-1">Lacak Status Seleksi PPDB</h2>
        <p class="text-slate-600 text-sm mt-2">Masukkan NISN dan Kode Registrasi yang Anda peroleh saat submit formulir.</p>
      </div>

      <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm">
        <form onsubmit="handleCheckStatus(event)" class="space-y-4">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label for="check-nisn" class="block text-xs font-bold text-slate-700 uppercase mb-1">NISN Calon Siswa</label>
              <input type="text" id="check-nisn" placeholder="Contoh: 0081234567" required class="w-full h-11 px-3.5 font-mono text-sm rounded-lg border border-slate-300 focus:border-brand-700 outline-none">
            </div>
            <div>
              <label for="check-code" class="block text-xs font-bold text-slate-700 uppercase mb-1">Kode Registrasi</label>
              <input type="text" id="check-code" placeholder="PPDB-20260330-XXXX" required class="w-full h-11 px-3.5 font-mono text-sm rounded-lg border border-slate-300 focus:border-brand-700 outline-none uppercase">
            </div>
          </div>
          <button type="submit" class="w-full h-11 bg-slateCustom-900 hover:bg-slate-800 text-white font-bold text-xs uppercase tracking-wider rounded-lg flex items-center justify-center gap-2 transition-colors">
            <i data-lucide="search" class="w-4 h-4"></i> Lacak Status Sekarang
          </button>
        </form>

        <!-- Status Result Container -->
        <div id="check-result" class="hidden mt-6 pt-6 border-t border-slate-200">
          <!-- Injected via JS -->
        </div>
      </div>
    </div>
  </section>

  <!-- WARTA & ARTIKEL BERITA -->
  <section id="berita" class="py-20 bg-white border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-4">
        <div>
          <span class="text-xs font-bold text-brand-700 uppercase tracking-widest">Informasi Terkini</span>
          <h2 class="text-3xl font-extrabold text-slateCustom-900 mt-1">Warta Sekolah & Prestasi</h2>
        </div>
        <a href="#berita" class="text-xs font-bold text-brand-700 hover:text-brand-800 flex items-center gap-1">
          Lihat Semua Arsip <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
        </a>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="news-container">
        <!-- Rendered by JS -->
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="bg-slateCustom-900 text-slate-300 pt-16 pb-12 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-10">
      <div class="space-y-4 md:col-span-2">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-lg bg-brand-600 flex items-center justify-center text-white">
            <i data-lucide="graduation-cap" class="w-5 h-5"></i>
          </div>
          <span class="text-lg font-bold text-white">SMK TI SYARIAH ENGINEERING</span>
        </div>
        <p class="text-xs text-slate-400 max-w-md leading-relaxed">
          Lembaga pendidikan kejuruan teknologi yang mengintegrasikan penguasaan kode, infrastruktur modern, dan nilai adab Islami untuk kemaslahatan umat dan bangsa.
        </p>
        <p class="text-xs text-slate-500 font-mono">Kampus Utama: Jl. Mandiri Syariah No. 88, Cibinong, Kab. Bogor, Jawa Barat</p>
      </div>

      <div class="space-y-3">
        <h4 class="text-xs font-bold text-white uppercase tracking-wider">Tautan Penting</h4>
        <ul class="space-y-2 text-xs text-slate-400">
          <li><a href="#jurusan" class="hover:text-brand-500">Katalog Jurusan</a></li>
          <li><a href="#fasilitas" class="hover:text-brand-500">Sarana Praktikum</a></li>
          <li><a href="#pendaftaran" class="hover:text-brand-500">Formulir PPDB Online</a></li>
          <li><a href="#cek-status" class="hover:text-brand-500">Cek Hasil Kelulusan</a></li>
        </ul>
      </div>

      <div class="space-y-3">
        <h4 class="text-xs font-bold text-white uppercase tracking-wider">Hubungi Kami</h4>
        <div class="text-xs text-slate-400 space-y-2">
          <p class="flex items-center gap-2"><i data-lucide="phone-call" class="w-3.5 h-3.5 text-brand-500"></i> (021) 8892-1204</p>
          <p class="flex items-center gap-2"><i data-lucide="message-square" class="w-3.5 h-3.5 text-brand-500"></i> +62 812-9876-5432 (Admin PPDB)</p>
          <p class="flex items-center gap-2"><i data-lucide="mail" class="w-3.5 h-3.5 text-brand-500"></i> panitia.ppdb@smkti-syariah.sch.id</p>
        </div>
      </div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-6 border-t border-slate-800 text-center text-xs text-slate-500">
      &copy; 2026 SMK TI Syariah Engineering. Arsitektur Bersih Sesuai Standar Industri.
    </div>
  </footer>

  <!-- MODAL: KARTU BUKTI REGISTRASI (BISA DI-PRINT) -->
  <div id="registration-card-modal" class="fixed inset-0 z-50 hidden bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-xl w-full p-6 sm:p-8 shadow-2xl relative max-h-[90vh] overflow-y-auto" id="printable-card">
      <div class="no-print flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
        <span class="text-xs font-bold text-brand-700 uppercase tracking-wider">Kartu Pendaftaran Berhasil Terbit</span>
        <button onclick="closeModal('registration-card-modal')" class="text-slate-400 hover:text-slate-600 p-1">
          <i data-lucide="x" class="w-5 h-5"></i>
        </button>
      </div>

      <div class="border-2 border-dashed border-slate-300 rounded-xl p-5 bg-slate-50/50 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-200 pb-3">
          <div class="flex items-center gap-2.5">
            <div class="w-9 h-9 bg-brand-700 text-white rounded-lg flex items-center justify-center font-bold">
              <i data-lucide="graduation-cap" class="w-5 h-5"></i>
            </div>
            <div>
              <h4 class="font-extrabold text-slate-900 text-sm">SMK TI SYARIAH ENGINEERING</h4>
              <p class="text-[10px] text-slate-500 uppercase tracking-wider">Bukti Pendaftaran Peserta Didik Baru 2026/2027</p>
            </div>
          </div>
          <div class="text-right">
            <span class="text-[10px] font-bold text-brand-700 bg-brand-50 px-2 py-0.5 rounded border border-brand-200">GELOMBANG 1</span>
          </div>
        </div>

        <div class="bg-white p-3.5 rounded-lg border border-slate-200 text-center">
          <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest block">KODE REGISTRASI RESMI</span>
          <span id="modal-reg-code" class="text-2xl font-mono font-extrabold text-brand-800 tracking-wider">PPDB-20260330-0000</span>
          <p class="text-[10px] text-slate-400 mt-1">Harap simpan kode ini untuk mengecek hasil verifikasi seleksi.</p>
        </div>

        <div class="grid grid-cols-2 gap-3 text-xs">
          <div>
            <span class="text-slate-400 block text-[10px] uppercase">Nama Lengkap</span>
            <span id="modal-name" class="font-bold text-slate-800">-</span>
          </div>
          <div>
            <span class="text-slate-400 block text-[10px] uppercase">NISN Siswa</span>
            <span id="modal-nisn" class="font-mono font-bold text-slate-800">-</span>
          </div>
          <div>
            <span class="text-slate-400 block text-[10px] uppercase">Pilihan Jurusan</span>
            <span id="modal-major" class="font-bold text-brand-700">-</span>
          </div>
          <div>
            <span class="text-slate-400 block text-[10px] uppercase">Asal Sekolah</span>
            <span id="modal-school" class="font-bold text-slate-800">-</span>
          </div>
          <div>
            <span class="text-slate-400 block text-[10px] uppercase">Tanggal Daftar</span>
            <span id="modal-date" class="font-bold text-slate-800">-</span>
          </div>
          <div>
            <span class="text-slate-400 block text-[10px] uppercase">Status Berkas</span>
            <span id="modal-status" class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">PENDING</span>
          </div>
        </div>
      </div>

      <div class="no-print mt-6 flex items-center justify-end gap-3">
        <button onclick="window.print()" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-lg flex items-center gap-1.5 shadow">
          <i data-lucide="printer" class="w-4 h-4"></i> Cetak / Simpan PDF
        </button>
        <button onclick="closeModal('registration-card-modal')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg">
          Tutup
        </button>
      </div>
    </div>
  </div>

  <!-- MODAL: LOGIN ADMIN -->
  <div id="admin-login-modal" class="fixed inset-0 z-50 hidden bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 sm:p-8 shadow-2xl relative">
      <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-5">
        <div class="flex items-center gap-2">
          <div class="w-8 h-8 rounded-lg bg-slateCustom-900 text-white flex items-center justify-center">
            <i data-lucide="lock" class="w-4 h-4"></i>
          </div>
          <h3 class="font-bold text-slate-900 text-base">Portal Administrator</h3>
        </div>
        <button onclick="closeModal('admin-login-modal')" class="text-slate-400 hover:text-slate-600">
          <i data-lucide="x" class="w-5 h-5"></i>
        </button>
      </div>

      <!-- Demo Box 1-Klik Isi -->
      <div class="mb-5 p-3.5 bg-brand-50 border border-brand-200 rounded-xl text-xs space-y-2">
        <div class="flex items-center justify-between">
          <span class="font-bold text-brand-900">Akun Demo Panitia:</span>
          <button onclick="fillAdminDemo()" class="text-[11px] font-bold text-brand-700 underline hover:text-brand-900">1-Klik Isi Form</button>
        </div>
        <div class="text-[11px] text-slate-600 font-mono">
          Email: <span class="text-slate-900 font-semibold">admin@smk.sch.id</span> | Pass: <span class="text-slate-900 font-semibold">admin123</span>
        </div>
      </div>

      <form onsubmit="handleAdminLogin(event)" class="space-y-4">
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Email Staf</label>
          <input type="email" id="admin-email" required class="w-full h-11 px-3.5 text-sm rounded-lg border border-slate-300 focus:border-brand-700 outline-none">
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Kata Sandi</label>
          <input type="password" id="admin-password" required class="w-full h-11 px-3.5 text-sm rounded-lg border border-slate-300 focus:border-brand-700 outline-none">
        </div>
        <button type="submit" class="w-full h-11 bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs uppercase tracking-wider rounded-lg flex items-center justify-center gap-2">
          <i data-lucide="log-in" class="w-4 h-4"></i> Masuk Dashboard
        </button>
      </form>
    </div>
  </div>

  <!-- MODAL: DASHBOARD ADMIN TERINTEGRASI -->
  <div id="admin-dashboard-modal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm flex items-center justify-center p-3 sm:p-6">
    <div class="bg-white rounded-2xl w-full max-w-6xl h-[92vh] shadow-2xl flex flex-col overflow-hidden">
      
      <!-- Admin Header -->
      <div class="bg-slateCustom-900 text-white px-6 py-4 flex items-center justify-between shrink-0">
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 rounded-lg bg-brand-600 flex items-center justify-center">
            <i data-lucide="layout-dashboard" class="w-4 h-4 text-white"></i>
          </div>
          <div>
            <h3 class="font-bold text-sm">Panel Verifikasi PPDB & Master Sekolah</h3>
            <span class="text-[10px] text-slate-400">Login sebagai: Ust. Ahmad Fauzi, S.Kom (Ketua Panitia)</span>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <button onclick="exportPPDBToCSV()" class="px-3 py-1.5 bg-brand-700 hover:bg-brand-800 text-white text-xs font-bold rounded-lg flex items-center gap-1.5">
            <i data-lucide="download" class="w-3.5 h-3.5"></i> Ekspor CSV
          </button>
          <button onclick="closeModal('admin-dashboard-modal')" class="text-slate-400 hover:text-white px-2 py-1">
            <i data-lucide="x" class="w-5 h-5"></i>
          </button>
        </div>
      </div>

      <!-- Admin Body Content -->
      <div class="flex-1 overflow-y-auto p-6 space-y-6 bg-slate-50">
        
        <!-- Metrics Row -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
          <div class="bg-white p-4 rounded-xl border border-slate-200">
            <span class="text-[11px] font-bold text-slate-400 uppercase">Total Pendaftar</span>
            <p id="adm-count-total" class="text-2xl font-extrabold text-slate-900 mt-1">0</p>
          </div>
          <div class="bg-white p-4 rounded-xl border border-slate-200">
            <span class="text-[11px] font-bold text-amber-600 uppercase">Menunggu Verifikasi</span>
            <p id="adm-count-pending" class="text-2xl font-extrabold text-amber-600 mt-1">0</p>
          </div>
          <div class="bg-white p-4 rounded-xl border border-slate-200">
            <span class="text-[11px] font-bold text-emerald-600 uppercase">Diterima Seleksi</span>
            <p id="adm-count-accepted" class="text-2xl font-extrabold text-emerald-600 mt-1">0</p>
          </div>
          <div class="bg-white p-4 rounded-xl border border-slate-200">
            <span class="text-[11px] font-bold text-red-600 uppercase">Ditolak / Batal</span>
            <p id="adm-count-rejected" class="text-2xl font-extrabold text-red-600 mt-1">0</p>
          </div>
        </div>

        <!-- Filter and Search -->
        <div class="bg-white p-4 rounded-xl border border-slate-200 flex flex-col sm:flex-row gap-3 justify-between items-center">
          <div class="w-full sm:w-72 relative">
            <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
            <input type="text" id="admin-search-input" oninput="renderAdminTable()" placeholder="Cari nama, NISN, atau kode..." class="w-full h-9 pl-9 pr-3 text-xs rounded-lg border border-slate-300 outline-none">
          </div>
          <div class="flex items-center gap-2 w-full sm:w-auto">
            <select id="admin-status-filter" onchange="renderAdminTable()" class="h-9 px-3 text-xs rounded-lg border border-slate-300 outline-none font-semibold">
              <option value="ALL">Semua Status</option>
              <option value="pending">Pending</option>
              <option value="verified">Verified</option>
              <option value="accepted">Accepted</option>
              <option value="rejected">Rejected</option>
            </select>
          </div>
        </div>

        <!-- Registrations Table -->
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
              <thead class="bg-slate-100 text-slate-600 font-bold uppercase tracking-wider border-b border-slate-200">
                <tr>
                  <th class="p-3.5">Kode Registrasi</th>
                  <th class="p-3.5">Nama & NISN</th>
                  <th class="p-3.5">Jurusan</th>
                  <th class="p-3.5">Nilai</th>
                  <th class="p-3.5">Status Seleksi</th>
                  <th class="p-3.5 text-center">Aksi Verifikasi</th>
                </tr>
              </thead>
              <tbody id="admin-table-body" class="divide-y divide-slate-100 text-slate-700">
                <!-- Rendered by JS -->
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- APPLICATION LOGIC (JS MODULAR STATE ENGINE) -->
  <script>
    // 1. DATA MASTER AWAL (STATE REPRESENTASI DB)
    const MAJORS_DATA = [
      {
        id: 1,
        code: "RPL",
        name: "Rekayasa Perangkat Lunak",
        desc: "Fokus ke pembuatan aplikasi enterprise, cloud engineering, microservices, dan fullstack Laravel & Vue/React.",
        quota: 72,
        icon: "code-2",
        color: "text-emerald-700 bg-emerald-50"
      },
      {
        id: 2,
        code: "TKJ",
        name: "Teknik Komputer & Jaringan",
        desc: "Spesialisasi cloud computing, keamanan jaringan (cyber security), MikroTik, Cisco, dan fiber optic.",
        quota: 72,
        icon: "network",
        color: "text-sky-700 bg-sky-50"
      },
      {
        id: 3,
        code: "DKV",
        name: "Desain Komunikasi Visual",
        desc: "Keahlian UI/UX design, visual branding, multimedia broadcasting, 3D modelling, dan animasi kreatif Islami.",
        quota: 36,
        icon: "palette",
        color: "text-amber-700 bg-amber-50"
      },
      {
        id: 4,
        code: "TKRO",
        name: "Teknik Kendaraan Ringan Otomotif",
        desc: "Teknologi mesin EFI modern, kendaraan listrik (EV conversion), diagnosis komputerisasi dan manajemen bengkel.",
        quota: 36,
        icon: "wrench",
        color: "text-rose-700 bg-rose-50"
      }
    ];

    const FACILITIES_DATA = [
      {
        name: "Lab Cloud & AI Engineering",
        cat: "Laboratorium Komputer",
        desc: "36 Unit workstation Core i7, dual monitor, dedicated gigabit internet, dan server farm lokal.",
        icon: "server"
      },
      {
        name: "Bengkel Otomotif EV & EFI",
        cat: "Bengkel Praktik",
        desc: "Hydraulic car lift, engine scanner OBD-II, dan alat peraga konversi baterai ramah lingkungan.",
        icon: "settings"
      },
      {
        name: "Studio Multimedia & DKV",
        cat: "Studio Kreatif",
        desc: "Green screen acoustic chamber, kamera cinema 4K, lighting pro kit, dan Wacom graphic tablets.",
        icon: "video"
      },
      {
        name: "Masjid & Islamic Tech Hub",
        cat: "Fasilitas Karakter",
        desc: "Kapasitas 800 jamaah, perpustakaan kitab & IT terpadu, pusat halaqah pembinaan karakter adab.",
        icon: "moon"
      }
    ];

    const NEWS_DATA = [
      {
        category: "Prestasi",
        title: "Juara 1 LKS Cloud Computing Tingkat Provinsi Jawa Barat 2026",
        date: "24 Maret 2026",
        excerpt: "Ananda Rayhan (XII RPL) berhasil mengalahkan 27 perwakilan kota/kabupaten dengan implementasi arsitektur AWS Kubernetes berkeamanan tinggi."
      },
      {
        category: "Kemitraan DUDI",
        title: "MoU Bersama PT Telkom Indonesia & Penyerahan Lab Fiber Optik",
        date: "18 Maret 2026",
        excerpt: "Kerja sama strategis kelas industri untuk penyerapan langsung 100% lulusan jurusan TKJ ke anak perusahaan BUMN."
      },
      {
        category: "Agenda PPDB",
        title: "Tes Wawancara Pemetaan Minat & Bakat Gelombang 1 Dimulai",
        date: "15 Maret 2026",
        excerpt: "Panitia PPDB mengingatkan seluruh calon peserta yang telah terdaftar agar mengunduh kartu bukti registrasi sebelum 5 April."
      }
    ];

    // IN-MEMORY STORAGE INITIALIZATION WITH LOCALSTORAGE SYNC
    let ppdbList = JSON.parse(localStorage.getItem('smk_ppdb_registrations')) || [
      {
        code: "PPDB-20260330-1092",
        major_id: 1,
        major_name: "Rekayasa Perangkat Lunak",
        nisn: "0081234567",
        nik: "3201012304080001",
        full_name: "Muhammad Fadhil Pratama",
        gender: "L",
        birth_date: "2008-04-12",
        previous_school: "SMP Negeri 1 Cibinong",
        report_card_score: 88.50,
        student_phone: "081298765432",
        parent_phone: "081311223344",
        address: "Jl. Raya Bogor KM 42, Cibinong",
        status: "verified",
        notes: "Berkas rapor dan NISN valid. Siap mengikuti tes minat bakat.",
        created_at: "2026-03-28 09:30"
      },
      {
        code: "PPDB-20260330-8841",
        major_id: 2,
        major_name: "Teknik Komputer & Jaringan",
        nisn: "0087654321",
        nik: "3201011802080002",
        full_name: "Aisyah Nur Rahmah",
        gender: "P",
        birth_date: "2008-02-18",
        previous_school: "MTs Negeri 2 Bogor",
        report_card_score: 91.20,
        student_phone: "085712345678",
        parent_phone: "085811223344",
        address: "Komplek Pesona Karadenan No. 5",
        status: "accepted",
        notes: "Lulus seleksi berkas dan nilai rapor di atas KKM standar.",
        created_at: "2026-03-29 14:15"
      }
    ];

    function savePPDBStorage() {
      localStorage.setItem('smk_ppdb_registrations', JSON.stringify(ppdbList));
    }

    // 2. RENDER MAJORS, FACILITIES, NEWS
    function initPublicContent() {
      // Render Majors
      const majorsContainer = document.getElementById('majors-container');
      majorsContainer.innerHTML = MAJORS_DATA.map(m => `
        <div class="bg-white border border-slate-200 rounded-2xl p-6 hover:shadow-lg transition-all duration-200 flex flex-col justify-between group">
          <div>
            <div class="w-12 h-12 rounded-xl ${m.color} flex items-center justify-center mb-5 group-hover:scale-105 transition-transform">
              <i data-lucide="${m.icon}" class="w-6 h-6"></i>
            </div>
            <div class="flex items-center justify-between mb-2">
              <span class="text-xs font-mono font-bold text-slate-400">${m.code}</span>
              <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-700">Kuota: ${m.quota} Siswa</span>
            </div>
            <h3 class="text-base font-bold text-slateCustom-900 mb-2">${m.name}</h3>
            <p class="text-xs text-slate-500 leading-relaxed">${m.desc}</p>
          </div>
          <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between">
            <a href="#pendaftaran" class="text-xs font-bold text-brand-700 hover:text-brand-800 flex items-center gap-1">
              Pilih Jurusan <i data-lucide="chevron-right" class="w-3.5 h-3.5"></i>
            </a>
          </div>
        </div>
      `).join('');

      // Render Facilities
      const facilitiesContainer = document.getElementById('facilities-container');
      facilitiesContainer.innerHTML = FACILITIES_DATA.map(f => `
        <div class="bg-white border border-slate-200 rounded-xl p-5 hover:border-slate-300 transition-colors">
          <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center mb-4">
            <i data-lucide="${f.icon}" class="w-5 h-5 text-brand-700"></i>
          </div>
          <span class="text-[10px] font-bold text-brand-700 uppercase tracking-wider">${f.cat}</span>
          <h4 class="font-bold text-slate-900 text-sm mt-1 mb-1.5">${f.name}</h4>
          <p class="text-xs text-slate-500 leading-relaxed">${f.desc}</p>
        </div>
      `).join('');

      // Render News
      const newsContainer = document.getElementById('news-container');
      newsContainer.innerHTML = NEWS_DATA.map(n => `
        <article class="bg-white border border-slate-200 rounded-2xl p-6 hover:shadow-md transition-shadow flex flex-col justify-between">
          <div>
            <div class="flex items-center justify-between text-xs mb-3">
              <span class="font-bold text-brand-700 bg-brand-50 px-2.5 py-0.5 rounded-full">${n.category}</span>
              <span class="text-slate-400 text-[11px]">${n.date}</span>
            </div>
            <h3 class="font-bold text-slate-900 text-base mb-2 leading-snug">${n.title}</h3>
            <p class="text-xs text-slate-500 leading-relaxed">${n.excerpt}</p>
          </div>
          <div class="pt-4 mt-4 border-t border-slate-100">
            <span class="text-xs font-semibold text-slate-700 hover:text-brand-700 cursor-pointer flex items-center gap-1">
              Baca Warta Selengkapnya <i data-lucide="arrow-up-right" class="w-3.5 h-3.5"></i>
            </span>
          </div>
        </article>
      `).join('');

      lucide.createIcons();
    }

    // 3. STEPPER FORM REGISTRATION
    function goToStep(step) {
      document.getElementById('step-1').classList.add('hidden');
      document.getElementById('step-2').classList.add('hidden');
      document.getElementById('step-3').classList.add('hidden');

      document.getElementById(`step-${step}`).classList.remove('hidden');

      // Update Node indicators
      for (let i = 1; i <= 3; i++) {
        const node = document.getElementById(`step-node-${i}`).querySelector('div');
        if (i <= step) {
          node.className = "w-9 h-9 rounded-full bg-brand-700 text-white font-bold flex items-center justify-center text-xs shadow";
        } else {
          node.className = "w-9 h-9 rounded-full bg-slate-200 text-slate-600 font-bold flex items-center justify-center text-xs";
        }
      }
      lucide.createIcons();
    }

    // 4. SUBMIT PPDB HANDLER
    function handleRegistrationSubmit(e) {
      e.preventDefault();

      const majorId = parseInt(document.getElementById('major_id').value);
      const nisn = document.getElementById('nisn').value.trim();
      const nik = document.getElementById('nik').value.trim();
      const fullName = document.getElementById('full_name').value.trim();
      const gender = document.querySelector('input[name="gender"]:checked').value;
      const birthDate = document.getElementById('birth_date').value;
      const prevSchool = document.getElementById('previous_school').value.trim();
      const reportScore = parseFloat(document.getElementById('report_score').value);
      const studentPhone = document.getElementById('student_phone').value.trim();
      const parentPhone = document.getElementById('parent_phone').value.trim();
      const address = document.getElementById('address').value.trim();

      // VALIDASI INPUT KETAT
      if (nisn.length !== 10 || isNaN(nisn)) {
        alert("Peringatan: NISN wajib 10 digit angka valid!");
        goToStep(2);
        return;
      }
      if (nik.length !== 16 || isNaN(nik)) {
        alert("Peringatan: NIK wajib 16 digit angka valid!");
        goToStep(2);
        return;
      }

      // CEK KEUNIKAN NISN
      const duplicate = ppdbList.find(item => item.nisn === nisn);
      if (duplicate) {
        alert(`NISN ${nisn} sudah pernah didaftarkan dengan nomor ${duplicate.code}. Silakan cek status di menu Lacak Seleksi.`);
        return;
      }

      // GENERATE REGISTRATION CODE: PPDB-YYYYMMDD-XXXX
      const datePart = new Date().toISOString().slice(0, 10).replace(/-/g, '');
      const randomPart = Math.floor(1000 + Math.random() * 9000);
      const regCode = `PPDB-${datePart}-${randomPart}`;

      const selectedMajor = MAJORS_DATA.find(m => m.id === majorId);

      const newRegistration = {
        code: regCode,
        major_id: majorId,
        major_name: selectedMajor ? selectedMajor.name : 'RPL',
        nisn: nisn,
        nik: nik,
        full_name: fullName,
        gender: gender,
        birth_date: birthDate,
        previous_school: prevSchool,
        report_card_score: reportScore,
        student_phone: studentPhone,
        parent_phone: parentPhone,
        address: address,
        status: 'pending',
        notes: 'Pendaftaran mandiri berhasil. Menunggu verifikasi berkas oleh panitia.',
        created_at: new Date().toISOString().slice(0, 16).replace('T', ' ')
      };

      ppdbList.unshift(newRegistration);
      savePPDBStorage();

      // Tampilkan Modal Kartu Bukti Pendaftaran
      document.getElementById('modal-reg-code').innerText = newRegistration.code;
      document.getElementById('modal-name').innerText = newRegistration.full_name;
      document.getElementById('modal-nisn').innerText = newRegistration.nisn;
      document.getElementById('modal-major').innerText = newRegistration.major_name;
      document.getElementById('modal-school').innerText = newRegistration.previous_school;
      document.getElementById('modal-date').innerText = newRegistration.created_at;
      document.getElementById('modal-status').innerText = "PENDING VERIFIKASI";
      document.getElementById('modal-status').className = "inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800";

      openModal('registration-card-modal');

      // Reset form
      document.getElementById('ppdb-form').reset();
      goToStep(1);
    }

    // 5. CEK STATUS SISWA MANDIRI
    function handleCheckStatus(e) {
      e.preventDefault();
      const searchNisn = document.getElementById('check-nisn').value.trim();
      const searchCode = document.getElementById('check-code').value.trim().toUpperCase();
      const resultBox = document.getElementById('check-result');

      const found = ppdbList.find(p => p.nisn === searchNisn && p.code.toUpperCase() === searchCode);

      resultBox.classList.remove('hidden');
      if (!found) {
        resultBox.innerHTML = `
          <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-center">
            <i data-lucide="alert-circle" class="w-8 h-8 text-red-600 mx-auto mb-2"></i>
            <h4 class="font-bold text-red-900 text-sm">Data Tidak Ditemukan</h4>
            <p class="text-xs text-red-700 mt-1">Kombinasi NISN (${searchNisn}) dan Kode Registrasi (${searchCode}) tidak cocok dengan basis data pendaftar.</p>
          </div>
        `;
      } else {
        let badgeColor = "bg-amber-100 text-amber-800 border-amber-300";
        let statusTitle = "Menunggu Verifikasi Berkas";
        if (found.status === 'verified') {
          badgeColor = "bg-sky-100 text-sky-800 border-sky-300";
          statusTitle = "Berkas Terverifikasi / Siap Tes";
        } else if (found.status === 'accepted') {
          badgeColor = "bg-emerald-100 text-emerald-800 border-emerald-300";
          statusTitle = "SELAMAT! ANDA DITERIMA";
        } else if (found.status === 'rejected') {
          badgeColor = "bg-red-100 text-red-800 border-red-300";
          statusTitle = "Pendaftaran Tidak Memenuhi Syarat";
        }

        resultBox.innerHTML = `
          <div class="p-5 bg-white border border-slate-200 rounded-xl space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
              <div>
                <span class="text-[10px] text-slate-400 font-bold uppercase">Status Hasil Seleksi</span>
                <h4 class="font-extrabold text-slate-900 text-sm">${statusTitle}</h4>
              </div>
              <span class="px-3 py-1 rounded-full text-xs font-bold border ${badgeColor} uppercase tracking-wider">${found.status}</span>
            </div>
            <div class="grid grid-cols-2 gap-3 text-xs">
              <div>
                <span class="text-slate-400 block text-[10px]">Nama Siswa:</span>
                <span class="font-bold text-slate-800">${found.full_name}</span>
              </div>
              <div>
                <span class="text-slate-400 block text-[10px]">Pilihan Jurusan:</span>
                <span class="font-bold text-brand-700">${found.major_name}</span>
              </div>
              <div>
                <span class="text-slate-400 block text-[10px]">Rata-rata Rapor:</span>
                <span class="font-bold text-slate-800">${found.report_card_score}</span>
              </div>
              <div>
                <span class="text-slate-400 block text-[10px]">Catatan Panitia:</span>
                <span class="italic text-slate-600">${found.notes || '-'}</span>
              </div>
            </div>
          </div>
        `;
      }
      lucide.createIcons();
    }

    // 6. PORTAL ADMIN & VERIFIKASI PPDB
    function fillAdminDemo() {
      document.getElementById('admin-email').value = "admin@smk.sch.id";
      document.getElementById('admin-password').value = "admin123";
    }

    function handleAdminLogin(e) {
      e.preventDefault();
      const email = document.getElementById('admin-email').value;
      const pass = document.getElementById('admin-password').value;

      if (email === "admin@smk.sch.id" && pass === "admin123") {
        closeModal('admin-login-modal');
        openAdminDashboard();
      } else {
        alert("Email atau kata sandi admin salah! Gunakan tombol 1-Klik Isi Form demo.");
      }
    }

    function openAdminDashboard() {
      renderAdminDashboardStats();
      renderAdminTable();
      openModal('admin-dashboard-modal');
    }

    function renderAdminDashboardStats() {
      const total = ppdbList.length;
      const pending = ppdbList.filter(p => p.status === 'pending').length;
      const accepted = ppdbList.filter(p => p.status === 'accepted').length;
      const rejected = ppdbList.filter(p => p.status === 'rejected').length;

      document.getElementById('adm-count-total').innerText = total;
      document.getElementById('adm-count-pending').innerText = pending;
      document.getElementById('adm-count-accepted').innerText = accepted;
      document.getElementById('adm-count-rejected').innerText = rejected;
    }

    function renderAdminTable() {
      const keyword = (document.getElementById('admin-search-input').value || '').toLowerCase();
      const statusFilter = document.getElementById('admin-status-filter').value;
      const tableBody = document.getElementById('admin-table-body');

      const filtered = ppdbList.filter(item => {
        const matchKeyword = item.full_name.toLowerCase().includes(keyword) ||
                             item.nisn.includes(keyword) ||
                             item.code.toLowerCase().includes(keyword);
        const matchStatus = (statusFilter === 'ALL') ? true : (item.status === statusFilter);
        return matchKeyword && matchStatus;
      });

      if (filtered.length === 0) {
        tableBody.innerHTML = `<tr><td colspan="6" class="p-6 text-center text-slate-400">Tidak ada pendaftar yang cocok.</td></tr>`;
        return;
      }

      tableBody.innerHTML = filtered.map(row => {
        let statusBadge = "bg-amber-100 text-amber-800";
        if (row.status === 'verified') statusBadge = "bg-sky-100 text-sky-800";
        if (row.status === 'accepted') statusBadge = "bg-emerald-100 text-emerald-800";
        if (row.status === 'rejected') statusBadge = "bg-red-100 text-red-800";

        return `
          <tr class="hover:bg-slate-50 transition-colors">
            <td class="p-3.5 font-mono font-bold text-slate-800">${row.code}</td>
            <td class="p-3.5">
              <span class="font-bold text-slate-900 block">${row.full_name}</span>
              <span class="text-slate-400 font-mono text-[11px]">NISN: ${row.nisn}</span>
            </td>
            <td class="p-3.5 font-semibold text-slate-700">${row.major_name}</td>
            <td class="p-3.5 font-mono font-bold text-slate-900">${row.report_card_score}</td>
            <td class="p-3.5">
              <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase ${statusBadge}">${row.status}</span>
            </td>
            <td class="p-3.5 text-center">
              <div class="inline-flex items-center gap-1.5">
                <button onclick="updateApplicantStatus('${row.code}', 'accepted')" title="Terima Siswa" class="p-1 rounded bg-emerald-50 text-emerald-700 hover:bg-emerald-200">
                  <i data-lucide="check" class="w-3.5 h-3.5"></i>
                </button>
                <button onclick="updateApplicantStatus('${row.code}', 'verified')" title="Verifikasi Berkas" class="p-1 rounded bg-sky-50 text-sky-700 hover:bg-sky-200">
                  <i data-lucide="file-check" class="w-3.5 h-3.5"></i>
                </button>
                <button onclick="updateApplicantStatus('${row.code}', 'rejected')" title="Tolak Berkas" class="p-1 rounded bg-red-50 text-red-700 hover:bg-red-200">
                  <i data-lucide="x" class="w-3.5 h-3.5"></i>
                </button>
              </div>
            </td>
          </tr>
        `;
      }).join('');

      lucide.createIcons();
    }

    function updateApplicantStatus(code, newStatus) {
      const idx = ppdbList.findIndex(p => p.code === code);
      if (idx !== -1) {
        ppdbList[idx].status = newStatus;
        if (newStatus === 'accepted') ppdbList[idx].notes = 'Lulus verifikasi dan dinyatakan diterima sebagai Calon Siswa Baru.';
        if (newStatus === 'verified') ppdbList[idx].notes = 'Dokumen terverifikasi. Jadwal tes fisik & wawancara akan dikirim via WhatsApp.';
        if (newStatus === 'rejected') ppdbList[idx].notes = 'Berkas belum memenuhi kualifikasi kuota jurusan.';
        
        savePPDBStorage();
        renderAdminDashboardStats();
        renderAdminTable();
      }
    }

    function exportPPDBToCSV() {
      let csvContent = "data:text/csv;charset=utf-8,Kode_Registrasi,NISN,NIK,Nama_Lengkap,Jenis_Kelamin,Jurusan,Nilai_Rapor,Asal_Sekolah,No_HP_Siswa,No_HP_Ortu,Status\n";
      ppdbList.forEach(r => {
        csvContent += `"${r.code}","${r.nisn}","${r.nik}","${r.full_name}","${r.gender}","${r.major_name}",${r.report_card_score},"${r.previous_school}","${r.student_phone}","${r.parent_phone}","${r.status}"\n`;
      });
      const encodedUri = encodeURI(csvContent);
      const link = document.createElement("a");
      link.setAttribute("href", encodedUri);
      link.setAttribute("download", `Rekap_PPDB_SMK_${new Date().toISOString().slice(0,10)}.csv`);
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }

    // 7. MODAL UTILITY
    function openModal(id) {
      document.getElementById(id).classList.remove('hidden');
      lucide.createIcons();
    }
    function closeModal(id) {
      document.getElementById(id).classList.add('hidden');
    }
    function toggleMobileMenu() {
      const menu = document.getElementById('mobile-menu');
      menu.classList.toggle('hidden');
    }

    // Inisialisasi saat DOM siap
    document.addEventListener('DOMContentLoaded', () => {
      initPublicContent();
      lucide.createIcons();
    });
  </script>
</body>
</html>