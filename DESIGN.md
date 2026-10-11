# DESIGN.md - Web SMK (Vocational & Syariah Engineering Ecosystem)

Dokumen ini adalah spesifikasi desain sistem tunggal (*single source of truth*) untuk proyek **web_smk**. Ditujukan langsung untuk tim frontend developer agar implementasi UI presisi, konsisten, dan memenuhi standar aksesibilitas internasional (WCAG 2.1 AA).

---

## 1. Konteks & Scope Proyek
- **Domain:** Website Portal Edukasi & Profil Sekolah Menengah Kejuruan (SMK) berbasis teknologi modern dan nilai kepesantrenan/syariah (*Syariah Engineering*).
- **Audiens Utama:** Calon siswa (PPDB), siswa aktif, wali murid, guru/staf, dan mitra industri/DUDI.
- **Tujuan Desain:** Menampilkan citra SMK yang profesional, modern, tertib, berteknologi tinggi, namun tetap ramah dan inklusif. Aksesibilitas diutamakan di atas estetika dekoratif.

---

## 2. Sumber, Provenance & Status Ekstraksi
- **URL Referensi:** `https://github.com/RafiZaki1/Web-School-` (Repositori: Syariah Engineering team).
- **Status Scraping:** Ekstraksi scraping hanya menangkap kerangka HTML wrapper GitHub (navigasi GitHub, menu Copilot/Enterprise). File CSS, design tokens, dan screenshot aset visual asli **tidak terambil** dari sumber tersebut.
- **Keputusan Desain (Provenance):** Seluruh token warna, tipografi, dan gaya visual dalam dokumen ini berstatus **USULAN RESMI PIXEL** yang dirancang khusus dari nol berdasarkan domain SMK Vokasi & Syariah Engineering, bukan reverse-engineering visual mentah repo GitHub.

---

## 3. Asumsi Desain
1. Web diakses oleh spektrum perangkat yang luas, mulai dari smartphone Android kelas *entry-level* (layar 360px, koneksi 3G/4G) hingga monitor desktop kantor resolusi tinggi.
2. Pengguna wali murid membutuhkan ukuran teks yang terbaca jelas (*high legibility*) tanpa hierarki yang membingungkan.
3. Fitur utama mencakup: Beranda Publik, Profil Jurusan Vokasi, Alur PPDB Online, Berita/Agenda Sekolah, dan Galeri Karya Siswa.
4. Framework frontend diasumsikan berbasis modern utility-first CSS (seperti Tailwind CSS).

---

## 4. Color Palette & Target Rasio Kontras
Target kontras di bawah ini dirancang untuk memenuhi standar **WCAG 2.1 AA** (minimal 4.5:1 untuk teks reguler, 3.0:1 untuk teks besar/bold dan elemen UI interaktif).

### 4.1. Core Palette (Usulan)
| Token Semantik | Nama / Nilai Hex | Pasangan Background | Target Rasio Kontras | Kegunaan |
|---|---|---|---|---|
| `color-primary` | Emerald 700 (`#047857`) | Putih (`#FFFFFF`) | ~4.7:1 (Lolos AA) | Tombol CTA utama, brand header, active icon |
| `color-primary-hover`| Emerald 800 (`#065F46`) | Putih (`#FFFFFF`) | ~6.8:1 (Lolos AAA)| State hover CTA utama |
| `color-primary-surface`| Emerald 50 (`#ECFDF5`) | Teks Emerald 800 | ~7.2:1 (Lolos AAA)| Badge kategori, container highlight |
| `color-secondary` | Slate 800 (`#1E293B`) | Putih (`#FFFFFF`) | ~12.6:1 (Lolos AAA)| Sidebar, footer, tombol sekunder |
| `color-accent` | Amber 600 (`#D97706`) | Putih (`#FFFFFF`) | ~3.3:1 (Khusus Large/Badge)| Penanda jurusan/kejuruan unggulan |
| `color-bg-canvas` | Slate 50 (`#F8FAFC`) | Teks Slate 900 | ~15.8:1 (Lolos AAA)| Background utama aplikasi |
| `color-surface` | Pure White (`#FFFFFF`) | Border Slate 200 | Border 1.3:1 (Layout)| Permukaan Card, Container, Modal |
| `color-text-main` | Slate 900 (`#0F172A`) | Canvas / Surface | >15.0:1 (Lolos AAA)| Heading, teks isi utama |
| `color-text-muted` | Slate 600 (`#475569`) | Surface (`#FFFFFF`)| ~5.3:1 (Lolos AA) | Keterangan sekunder, metadata tanggal |
| `color-border` | Slate 200 (`#E2E8F0`) | Surface (`#FFFFFF`)| Pemisah layout | Garis batas card, divider tabel |

### 4.2. Status Feedback Semantics
| Status | Background Token | Border Token | Teks / Icon Token | Target Kontras Teks ke BG |
|---|---|---|---|---|
| **Success** | Emerald 50 (`#ECFDF5`) | Emerald 300 (`#6EE7B7`) | Emerald 800 (`#065F46`) | ~7.2:1 |
| **Warning** | Amber 50 (`#FFFBEB`) | Amber 300 (`#FCD34D`) | Amber 900 (`#78350F`) | ~8.5:1 |
| **Danger** | Red 50 (`#FEF2F2`) | Red 300 (`#FCA5A5`) | Red 700 (`#B91C1C`) | ~5.8:1 |
| **Info** | Sky 50 (`#F0F9FF`) | Sky 300 (`#7DD3FC`) | Sky 800 (`#075985`) | ~6.4:1 |

*Catatan: Seluruh rasio di atas adalah target kalkulasi matematis standar sRGB WCAG. Dev dilarang mengganti pasangan warna teks dan background di luar panduan tabel ini.*

---

## 5. Tipografi
Font utama diusulkan menggunakan **Plus Jakarta Sans** (Google Fonts / Variable Font), dengan fallback `Inter`, `system-ui`, `-apple-system`, `sans-serif`. Font ini netral, modern, dan memiliki legibilitas angka/simbol yang tinggi untuk data teknis.

| Level | Size (px / rem) | Weight | Line Height | Tracking | Penggunaan |
|---|---|---|---|---|---|
| **Display H1** | 36px / 2.25rem | 700 (Bold) | 1.2 (44px) | -0.02em | Hero headline halaman utama |
| **H2 Section** | 28px / 1.75rem | 700 (Bold) | 1.25 (36px) | -0.015em | Judul seksi halaman (Profil, Jurusan) |
| **H3 Subsection**| 20px / 1.25rem | 600 (Semibold) | 1.3 (26px) | 0 | Judul card, header modal |
| **Body Regular** | 16px / 1.00rem | 400 (Regular) | 1.5 (24px) | 0 | Paragraf berita, deskripsi materi |
| **Body Medium** | 16px / 1.00rem | 500 (Medium) | 1.5 (24px) | 0 | Form input, label form |
| **Caption / Meta**| 13px / 0.8125rem | 500 (Medium) | 1.4 (18px) | +0.01em | Tanggal agenda, error message, badge |
| **Code / Monospace**| 14px / 0.875rem | 400 (Regular) | 1.4 (20px) | 0 | NIK, NISN, nomor registrasi PPDB (`font-mono`) |

---

## 6. Spacing, Sizing & Radius (8-Point Grid)
Sistem jarak mengadopsi standar kelipatan 4px/8px untuk menjamin ritme vertikal dan horizontal yang modular.

### 6.1. Spacing Scale
- `space-1`: 4px (micro-gap ikon & teks)
- `space-2`: 8px (padding tombol kecil, gap tag)
- `space-3`: 12px (form input internal vertical padding)
- `space-4`: 16px (gutter standard, padding card mobile)
- `space-6`: 24px (padding card desktop, gap form)
- `space-8`: 32px (margin antar komponen besar)
- `space-12`: 48px (section vertical padding mobile)
- `space-16`: 64px (section vertical padding desktop)

### 6.2. Border Radius
- `radius-sm`: 4px (Badge, checklist, tooltip)
- `radius-md`: 8px (Form control, tombol, alert box)
- `radius-lg`: 12px (Card konten, modal dialog)
- `radius-full`: 9999px (Avatar, pill badge)

### 6.3. Elevation & Shadow
- `shadow-sm`: `0 1px 2px 0 rgba(15, 23, 42, 0.05)` (Default card flat)
- `shadow-md`: `0 4px 6px -1px rgba(15, 23, 42, 0.08), 0 2px 4px -2px rgba(15, 23, 42, 0.05)` (Card hover, dropdown)
- `shadow-lg`: `0 10px 15px -3px rgba(15, 23, 42, 0.1), 0 4px 6px -4px rgba(15, 23, 42, 0.05)` (Modal window, floating menu)

---

## 7. Breakpoints & Layout Responsif
Pendekatan wajib **Mobile-First**.

| Breakpoint | Target Layar | Lebar Container Maksimal | Layout Behavior |
|---|---|---|---|
| `sm` (default) | < 768px (Mobile) | 100% (Padding `16px`) | Single-column, stacked elements, drawer navigation |
| `md` | >= 768px (Tablet) | 720px | Grid 2 kolom, horizontal form split |
| `lg` | >= 1024px (Desktop) | 960px | Grid 3-4 kolom, persistent topbar + menu dropdown |
| `xl` | >= 1280px (Wide) | 1200px | Max-width centered dengan margin `auto` |

---

## 8. Spesifikasi Komponen Inti

### 8.1. Buttons
- **Touch Target:** Minimal `44px x 44px` di mobile (tambahkan padding tak terlihat jika ukuran visual lebih ringkas).
- **Primary Button:**
  - Background: `#047857`, Teks: `#FFFFFF`, Radius: `8px`, Font: 14px Semibold.
  - Hover: Background `#065F46`.
  - Active: Background `#064E3B`, scale down `0.98`.
  - Focus-visible: Outline solid `2px #047857`, outline-offset `2px`.
  - Disabled: Background `#E2E8F0`, Teks `#94A3B8`, `cursor: not-allowed`.
- **Secondary / Outline Button:**
  - Background: `#FFFFFF`, Border: `1px solid #CBD5E1`, Teks: `#1E293B`.
  - Hover: Background `#F8FAFC`, Border: `#94A3B8`.
- **Ghost / Link Button:**
  - Background: `transparent`, Teks: `#047857`, Underline pada hover.

### 8.2. Cards (Profil Jurusan & Berita)
- **Container:** Background `#FFFFFF`, Border `1px solid #E2E8F0`, Radius `12px`, Shadow `shadow-sm`.
- **Hover Behavior:** Elevasi naik ke `shadow-md`, border berubah ke `#CBD5E1`, translasi Y `-2px` (durasi 200ms).
- **Internal Padding:** `16px` (Mobile), `24px` (Desktop).

### 8.3. Form Inputs (PPDB & Kontak)
- **Label:** 14px Medium, Warna `#0F172A`, Margin bawah `6px`. Wajib menggunakan elemen `<label for="...">` eksplisit.
- **Field:** Tinggi minimal `44px`, Padding `10px 14px`, Border `1px solid #CBD5E1`, Radius `8px`, Background `#FFFFFF`, Teks 16px (menghindari auto-zoom iOS Safari).
- **Focus State:** Border `#047857`, Ring `3px rgba(4, 120, 87, 0.2)`, tanpa outline default browser.
- **Error State:** Border `#DC2626`, Ring `3px rgba(220, 38, 38, 0.15)`. Pesan error wajib muncul di bawah field: Teks 13px Red 700 (`#B91C1C`) disertai icon warning.
- **Disabled State:** Background `#F1F5F9`, border `#E2E8F0`, text `#94A3B8`.

### 8.4. Tables (Data Daya Tampung & Agenda)
- **Header (`<th>`):** Background `#F8FAFC`, Teks 13px Semibold Uppercase `#475569`, Padding `12px 16px`, Border-bottom `1px solid #CBD5E1`.
- **Row (`<tr>`):** Border-bottom `1px solid #E2E8F0`, zebra-striping opsional (`nth-child(even)`: `#F8FAFC`).
- **Responsive Table:** Wajib dibungkus `<div class="overflow-x-auto">` dengan scroll hint indicator pada layar mobile.

### 8.5. Modals & Dialogs
- **Backdrop:** Background `rgba(15, 23, 42, 0.6)`, backdrop-filter `blur(4px)`.
- **Container:** Max-width `540px`, Width `92%`, Background `#FFFFFF`, Radius `12px`, Padding `24px`.
- **Behavior:** Kunci scroll body saat modal aktif (`overflow: hidden`), tombol close sudut kanan atas minimal target area `44px x 44px`.

---

## 9. State Handling (Loading, Empty, Error)

### 9.1. Loading State
- **Skeleton Screen:** Gunakan skeleton pulsasi abu-abu (`#E2E8F0` ke `#F1F5F9`) untuk daftar berita dan kartu jurusan. Hindari spinner melayang di tengah layar jika konten berbentuk daftar.
- **Inline Loading:** Pada tombol form submit, ganti teks dengan spinner SVG `20px x 20px` dan label "Memproses...", tombol otomatis dinonaktifkan (`disabled`).

### 9.2. Empty State (Contoh: Pengumuman Belum Ada)
- **Struktur:** 
  1. Ikon ilustratif netral (ukuran 64px, warna Slate 400).
  2. Judul ringkas: "Belum Ada Pengumuman" (18px Semibold `#0F172A`).
  3. Paragraf deskriptif: "Jadwal dan pengumuman resmi PPDB akan diumumkan sesuai kalender akademik." (14px Regular `#475569`).
  4. Tombol aksi sekunder opsional: "Kembali ke Beranda" atau "Muat Ulang".
- **Container:** Padding vertikal minimal `64px`, text-align centered.

### 9.3. Error State (Form & Network Failures)
- **Banner Peringatan:** Alert box di bagian atas formulir dengan background `Red 50`, border `Red 300`, teks `Red 700`.
- **Pesan Non-Warna:** Dilarang hanya mengandalkan outline merah pada input. Wajib ada teks eksplisit: *"Format NISN harus berupa 10 digit angka."*

---

## 10. Aksesibilitas (a11y) & Keyboard Navigation
1. **Focus Ring:** Semua elemen interaktif (`a`, `button`, `input`, `select`, `textarea`) wajib memiliki focus indicator yang jelas:
   ```css
   :focus-visible {
     outline: 2px solid #047857;
     outline-offset: 2px;
   }
   ```
2. **Skip Navigation:** Wajib sediakan link tersembunyi di posisi DOM pertama:
   ```html
   <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:bg-emerald-700 focus:text-white focus:p-3 focus:rounded-md">
     Langsung ke Konten Utama
   </a>
   ```
3. **Screen Reader Tags:**
   - Ikon dekoratif diberi atribut `aria-hidden="true"`.
   - Tombol hanya-ikon (seperti hamburger menu atau modal close) wajib memiliki `aria-label="Tutup menu"` atau teks tersembunyi `.sr-only`.
4. **Modal Trap Focus:** Saat modal terbuka, tombol Tab tidak boleh keluar dari modal sebelum ditutup. Menekan `Escape` harus menutup modal.

---

## 11. Motion & Micro-Interactions
- **Durasi Standar:** `150ms` - `200ms` untuk interaksi tombol & hover. `300ms` untuk modal enter/exit dan mobile drawer.
- **Easing:** `cubic-bezier(0.4, 0, 0.2, 1)` (standar ease-in-out).
- **Reduced Motion:** Wajib hormati preferensi pengguna sistem operasi:
  ```css
  @media (prefers-reduced-motion: reduce) {
    *, ::before, ::after {
      animation-duration: 0.01ms !important;
      animation-iteration-count: 1 !important;
      transition-duration: 0.01ms !important;
      scroll-behavior: auto !important;
    }
  }
  ```

---

## 12. Voice, Tone & Microcopy UX
- **Karakter Bahasa:** Santun, jelas, mengayomi, mengedepankan etika akademik dan ketepatan vokasi.
- **Aturan Penulisan:**
  - *Tombol Form:* Gunakan kata kerja langsung. Contoh: `"Kirim Formulir PPDB"`, bukan `"Submit"`.
  - *Status Berhasil:* `"Pendaftaran Anda Berhasil Dikirim. Simpan bukti nomor registrasi berikut."`
  - *Status Galat:* `"Terjadi kendala koneksi. Silakan periksa jaringan Anda dan coba lagi."` (Hindari istilah teknis mentah seperti "500 Internal Server Error").

---

## 13. Larangan Desain (Anti-Patterns)
1. **DILARANG** menggunakan teks abu-abu terang (`#94A3B8` atau `#CBD5E1`) di atas background putih untuk teks penting (pelanggaran berat WCAG).
2. **DILARANG** membuat ukuran teks isi di bawah 12px pada perangkat apapun.
3. **DILARANG** menonaktifkan properti outline browser (`outline: none`) tanpa memberikan styling `:focus-visible` pengganti.
4. **DILARANG** menyematkan teks penting di dalam gambar banner/poster tanpa teks HTML pendamping (mengabaikan pembaca layar).
5. **DILARANG** membuat dua CTA primer berdampingan dalam satu card. Gunakan satu tombol primer, selebihnya tombol sekunder atau tautan ghost.

---

## 14. Handoff Dev (Token Implementation)

### 14.1. Tailwind CSS Configuration Helper (`tailwind.config.js`)
```javascript
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,jsx,ts,tsx,vue}"],
  theme: {
    screens: {
      sm: '640px',
      md: '768px',
      lg: '1024px',
      xl: '1280px',
    },
    extend: {
      colors: {
        brand: {
          50: '#ECFDF5',
          100: '#D1FAE5',
          500: '#10B981',
          600: '#059669',
          700: '#047857', // Primary
          800: '#065F46', // Primary Hover
          900: '#064E3B',
        },
        surface: {
          canvas: '#F8FAFC',
          card: '#FFFFFF',
          border: '#E2E8F0',
        },
        ink: {
          main: '#0F172A',
          muted: '#475569',
          disabled: '#94A3B8',
        }
      },
      fontFamily: {
        sans: ['"Plus Jakarta Sans"', 'Inter', 'system-ui', 'sans-serif'],
        mono: ['ui-monospace', 'SFMono-Regular', 'Menlo', 'monospace'],
      },
      boxShadow: {
        sm: '0 1px 2px 0 rgba(15, 23, 42, 0.05)',
        md: '0 4px 6px -1px rgba(15, 23, 42, 0.08), 0 2px 4px -2px rgba(15, 23, 42, 0.05)',
        lg: '0 10px 15px -3px rgba(15, 23, 42, 0.1), 0 4px 6px -4px rgba(15, 23, 42, 0.05)',
      },
      borderRadius: {
        DEFAULT: '8px',
        card: '12px',
      }
    },
  },
  plugins: [],
}
```

### 14.2. Native CSS Variables Snippet (`tokens.css`)
```css
:root {
  --color-primary: #047857;
  --color-primary-hover: #065F46;
  --color-primary-surface: #ECFDF5;
  --color-bg-canvas: #F8FAFC;
  --color-surface: #FFFFFF;
  --color-text-main: #0F172A;
  --color-text-muted: #475569;
  --color-border: #E2E8F0;
  --color-danger: #DC2626;
  --color-warning: #D97706;

  --font-family-base: 'Plus Jakarta Sans', system-ui, sans-serif;
  --radius-button: 8px;
  --radius-card: 12px;
  --focus-ring: 2px solid #047857;
}

body {
  margin: 0;
  font-family: var(--font-family-base);
  background-color: var(--color-bg-canvas);
  color: var(--color-text-main);
  line-height: 1.5;
}
```