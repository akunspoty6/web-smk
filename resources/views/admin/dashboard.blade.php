<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin & Verifikator PPDB - SMK TI Syariah Engineering</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
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
              500: '#10b981',
              600: '#059669',
              700: '#047857',
            }
          }
        }
      }
    }
  </script>
</head>
<body class="bg-[#090b10] text-slate-100 min-h-screen font-sans antialiased">
  <!-- Top Navigation Bar -->
  <header class="border-b border-slate-800 bg-[#0d111a]/80 backdrop-blur sticky top-0 z-30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-lg bg-emerald-600 flex items-center justify-center text-white font-black text-sm">
          SMK
        </div>
        <div>
          <span class="block text-sm font-bold text-white leading-tight">Backoffice PPDB & Akademik</span>
          <span class="text-[10px] text-slate-400 font-mono">SMK TI Syariah Engineering</span>
        </div>
      </div>

      <div class="flex items-center gap-4">
        <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-300 hover:text-white bg-slate-800/80 px-3 py-1.5 rounded-lg border border-slate-700/60 hover:border-slate-600 transition-colors">
          <i data-lucide="external-link" class="w-3.5 h-3.5 text-emerald-400"></i> Lihat Web Publik
        </a>
        <div class="h-4 w-px bg-slate-800"></div>
        <div class="flex items-center gap-2">
          <div class="w-7 h-7 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-xs font-bold text-emerald-400">
            {{ substr(Auth::user()->name, 0, 1) }}
          </div>
          <div class="text-left hidden sm:block">
            <span class="block text-xs font-semibold text-white leading-tight">{{ Auth::user()->name }}</span>
            <span class="text-[10px] text-emerald-400 uppercase tracking-wider font-mono">{{ Auth::user()->role }}</span>
          </div>
        </div>
        <form action="{{ url('/logout') }}" method="POST" class="inline">
          @csrf
          <button type="submit" class="p-2 text-slate-400 hover:text-red-400 hover:bg-red-950/30 rounded-lg transition-colors" title="Keluar">
            <i data-lucide="log-out" class="w-4 h-4"></i>
          </button>
        </form>
      </div>
    </div>
  </header>

  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <!-- Success Banner -->
    @if(session('success'))
      <div class="p-4 rounded-xl bg-emerald-950/60 border border-emerald-800 text-emerald-200 text-xs sm:text-sm flex items-center justify-between">
        <div class="flex items-center gap-2.5">
          <i data-lucide="check-circle" class="w-5 h-5 text-emerald-400 shrink-0"></i>
          <span>{{ session('success') }}</span>
        </div>
      </div>
    @endif

    <!-- Metric Counters -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <div class="bg-[#111622] border border-slate-800/80 p-5 rounded-xl">
        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block mb-1">Total Pendaftar</span>
        <div class="flex items-baseline gap-2">
          <span class="text-3xl font-extrabold text-white font-mono">{{ $stats['total_registrations'] }}</span>
          <span class="text-xs text-slate-400">berkas</span>
        </div>
      </div>

      <div class="bg-[#111622] border border-slate-800/80 p-5 rounded-xl">
        <span class="text-[11px] font-semibold text-amber-400 uppercase tracking-wider block mb-1">Menunggu Verifikasi</span>
        <div class="flex items-baseline gap-2">
          <span class="text-3xl font-extrabold text-amber-300 font-mono">{{ $stats['pending_count'] }}</span>
          <span class="text-xs text-amber-400/80">antre</span>
        </div>
      </div>

      <div class="bg-[#111622] border border-slate-800/80 p-5 rounded-xl">
        <span class="text-[11px] font-semibold text-blue-400 uppercase tracking-wider block mb-1">Terverifikasi</span>
        <div class="flex items-baseline gap-2">
          <span class="text-3xl font-extrabold text-blue-300 font-mono">{{ $stats['verified_count'] }}</span>
          <span class="text-xs text-blue-400/80">lolos berkas</span>
        </div>
      </div>

      <div class="bg-[#111622] border border-slate-800/80 p-5 rounded-xl">
        <span class="text-[11px] font-semibold text-emerald-400 uppercase tracking-wider block mb-1">Diterima Resmi</span>
        <div class="flex items-baseline gap-2">
          <span class="text-3xl font-extrabold text-emerald-300 font-mono">{{ $stats['accepted_count'] }}</span>
          <span class="text-xs text-slate-400">/ {{ $stats['total_quota'] }} kuota</span>
        </div>
      </div>
    </div>

    <!-- Section: PPDB Registrations Management -->
    <div class="bg-[#111622] border border-slate-800 rounded-xl overflow-hidden shadow-xl">
      <div class="p-5 border-b border-slate-800 flex flex-wrap justify-between items-center gap-4">
        <div>
          <h2 class="text-lg font-bold text-white flex items-center gap-2">
            <i data-lucide="users" class="w-5 h-5 text-emerald-400"></i> Antrean Verifikasi Berkas PPDB
          </h2>
          <p class="text-xs text-slate-400 mt-0.5">Kelola kelulusan seleksi berkas calon siswa gelombang 1 tahun ajaran 2026/2027</p>
        </div>
        <span class="text-xs font-mono text-slate-400 bg-slate-800/60 px-3 py-1.5 rounded-lg border border-slate-700/50">
          Total: {{ $registrations->count() }} Data
        </span>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
          <thead class="bg-[#0d121c] text-slate-400 uppercase tracking-wider font-semibold border-b border-slate-800">
            <tr>
              <th class="py-3 px-4">Kode & Waktu</th>
              <th class="py-3 px-4">Nama Siswa / NISN</th>
              <th class="py-3 px-4">Asal Sekolah</th>
              <th class="py-3 px-4">Pilihan Jurusan</th>
              <th class="py-3 px-4">Rapor</th>
              <th class="py-3 px-4">Status</th>
              <th class="py-3 px-4 text-right">Tindakan Petugas</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-800/60 text-slate-300">
            @forelse($registrations as $reg)
              <tr class="hover:bg-slate-800/30 transition-colors">
                <td class="py-3.5 px-4 font-mono">
                  <span class="text-white font-bold block">{{ $reg->registration_code }}</span>
                  <span class="text-[10px] text-slate-400">{{ $reg->created_at->format('d M Y, H:i') }}</span>
                </td>
                <td class="py-3.5 px-4">
                  <span class="font-semibold text-white block">{{ $reg->full_name }}</span>
                  <span class="text-[11px] text-slate-400 font-mono">NISN: {{ $reg->nisn }} | HP: {{ $reg->student_phone }}</span>
                </td>
                <td class="py-3.5 px-4 text-slate-300">
                  {{ $reg->previous_school }}
                </td>
                <td class="py-3.5 px-4">
                  <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-950/70 text-emerald-300 border border-emerald-800/50">
                    {{ $reg->major->code }} - {{ $reg->major->name }}
                  </span>
                </td>
                <td class="py-3.5 px-4 font-mono font-bold text-white">
                  {{ number_format($reg->report_card_score, 1) }}
                </td>
                <td class="py-3.5 px-4">
                  @if($reg->status === 'accepted')
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                      <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> DITERIMA
                    </span>
                  @elseif($reg->status === 'verified')
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                      <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span> VERIFIED
                    </span>
                  @elseif($reg->status === 'rejected')
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-500/10 text-red-400 border border-red-500/20">
                      <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> DITOLAK
                    </span>
                  @else
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                      <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span> PENDING
                    </span>
                  @endif
                </td>
                <td class="py-3.5 px-4 text-right">
                  <form action="{{ route('admin.ppdb.status', $reg->id) }}" method="POST" class="inline-flex items-center gap-1.5">
                    @csrf
                    @if($reg->status !== 'accepted')
                      <button type="submit" name="status" value="accepted" class="px-2.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-[11px] transition-colors" title="Terima Siswa">
                        Terima
                      </button>
                    @endif
                    @if($reg->status !== 'verified')
                      <button type="submit" name="status" value="verified" class="px-2.5 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-500 text-white font-bold text-[11px] transition-colors" title="Verifikasi Berkas">
                        Verifikasi
                      </button>
                    @endif
                    @if($reg->status !== 'rejected')
                      <button type="submit" name="status" value="rejected" class="px-2.5 py-1.5 rounded-lg bg-red-900/60 hover:bg-red-800 text-red-200 font-bold text-[11px] border border-red-700/50 transition-colors" title="Tolak">
                        Tolak
                      </button>
                    @endif
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="py-8 text-center text-slate-500 italic">Belum ada calon siswa yang mendaftar di database.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Section: Manage Quota & Majors -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-[#111622] border border-slate-800 rounded-xl p-5">
        <h3 class="text-sm font-bold text-white mb-3 flex items-center gap-2">
          <i data-lucide="layers" class="w-4 h-4 text-emerald-400"></i> Kelola Kuota Konsentrasi Keahlian
        </h3>
        <div class="space-y-3">
          @foreach($majors as $m)
            <div class="p-3.5 rounded-xl bg-[#0c1017] border border-slate-800/80 flex items-center justify-between gap-3">
              <div>
                <span class="block text-xs font-bold text-white">{{ $m->name }} ({{ $m->code }})</span>
                <span class="text-[11px] text-slate-400">Terdaftar: {{ $m->ppdb_registrations_count }} calon | Kuota Aktif: {{ $m->quota }} siswa</span>
              </div>
              <form action="{{ route('admin.major.quota', $m->id) }}" method="POST" class="flex items-center gap-1.5 shrink-0">
                @csrf
                <input type="number" name="quota" value="{{ $m->quota }}" min="1" max="500" class="w-16 px-2 py-1 bg-slate-900 border border-slate-700 rounded text-xs text-white font-mono text-center">
                <button type="submit" class="px-2.5 py-1 bg-slate-800 hover:bg-emerald-600 text-white font-semibold text-[11px] rounded transition-colors">
                  Update
                </button>
              </form>
            </div>
          @endforeach
        </div>
      </div>

      <div class="bg-[#111622] border border-slate-800 rounded-xl p-5">
        <h3 class="text-sm font-bold text-white mb-3 flex items-center gap-2">
          <i data-lucide="newspaper" class="w-4 h-4 text-emerald-400"></i> Warta & Pengumuman Sekolah
        </h3>
        <div class="space-y-3">
          @foreach($news as $item)
            <div class="p-3.5 rounded-xl bg-[#0c1017] border border-slate-800/80 flex items-center justify-between gap-3">
              <div>
                <span class="block text-xs font-bold text-white leading-tight">{{ $item->title }}</span>
                <span class="text-[10px] text-slate-400 font-mono uppercase">{{ $item->category }} | {{ $item->status }}</span>
              </div>
              <span class="text-[10px] text-emerald-400 font-mono px-2 py-1 rounded bg-emerald-950/40 border border-emerald-900/60">
                Published
              </span>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </main>

  <script>
    lucide.createIcons();
  </script>
</body>
</html>
