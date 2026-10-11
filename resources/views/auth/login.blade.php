<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Petugas PPDB & Admin - SMK TI Syariah Engineering</title>
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
              800: '#065f46',
            }
          }
        }
      }
    }
  </script>
</head>
<body class="bg-[#0b0f19] text-slate-100 min-h-screen flex items-center justify-center p-4 selection:bg-brand-500 selection:text-white font-sans">
  <div class="w-full max-w-md">
    <!-- Header Card -->
    <div class="text-center mb-6">
      <div class="inline-flex w-14 h-14 rounded-2xl bg-gradient-to-tr from-brand-700 to-brand-500 items-center justify-center text-white shadow-lg shadow-brand-700/30 mb-3">
        <i data-lucide="shield-check" class="w-8 h-8"></i>
      </div>
      <h1 class="text-2xl font-black tracking-tight text-white">Portal Petugas & Admin</h1>
      <p class="text-xs text-slate-400 mt-1">SMK TI Syariah Engineering — Verifikasi & Pengelolaan PPDB</p>
    </div>

    <!-- Login Box -->
    <div class="bg-[#131b2e] border border-slate-800 rounded-2xl p-6 sm:p-8 shadow-2xl backdrop-blur-xl relative overflow-hidden">
      <!-- Top glowing bar -->
      <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-brand-500 via-emerald-400 to-teal-500"></div>

      @if(session('info'))
        <div class="mb-4 p-3 rounded-xl bg-blue-950/60 border border-blue-800 text-blue-300 text-xs flex items-center gap-2">
          <i data-lucide="info" class="w-4 h-4 shrink-0"></i>
          <span>{{ session('info') }}</span>
        </div>
      @endif

      @if($errors->any())
        <div class="mb-4 p-3 rounded-xl bg-red-950/60 border border-red-800 text-red-300 text-xs flex items-center gap-2">
          <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
          <span>{{ $errors->first() }}</span>
        </div>
      @endif

      <form action="{{ url('/login') }}" method="POST" class="space-y-4">
        @csrf
        <div>
          <label class="block text-xs font-semibold text-slate-300 mb-1.5 uppercase tracking-wider">Email Petugas</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
              <i data-lucide="mail" class="w-4 h-4"></i>
            </span>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="admin@smk.sch.id"
              class="w-full pl-10 pr-4 py-2.5 bg-[#0d1322] border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors">
          </div>
        </div>

        <div>
          <label class="block text-xs font-semibold text-slate-300 mb-1.5 uppercase tracking-wider">Kata Sandi</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
              <i data-lucide="lock" class="w-4 h-4"></i>
            </span>
            <input type="password" id="password" name="password" required placeholder="••••••••"
              class="w-full pl-10 pr-4 py-2.5 bg-[#0d1322] border border-slate-700 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-colors">
          </div>
        </div>

        <div class="flex items-center justify-between text-xs pt-1">
          <label class="flex items-center gap-2 text-slate-400 cursor-pointer">
            <input type="checkbox" name="remember" class="rounded bg-slate-800 border-slate-700 text-brand-600 focus:ring-brand-500">
            <span>Ingat sesi saya</span>
          </label>
          <a href="#" class="text-brand-400 hover:text-brand-300">Lupa sandi?</a>
        </div>

        <button type="submit" class="w-full py-3 px-4 rounded-xl font-bold text-sm text-white bg-brand-600 hover:bg-brand-500 active:scale-[0.99] transition-all shadow-lg shadow-brand-700/25 flex items-center justify-center gap-2 mt-2">
          <i data-lucide="log-in" class="w-4 h-4"></i> Masuk ke Dashboard
        </button>
      </form>

      <!-- 1-Click Demo Accounts -->
      <div class="mt-6 pt-5 border-t border-slate-800">
        <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 text-center mb-3">⚡ Quick Fill Akun Demo 1-Klik:</span>
        <div class="grid grid-cols-2 gap-2">
          <button type="button" onclick="fillDemo('admin@smk.sch.id', 'password123')"
            class="text-left p-2.5 rounded-lg bg-slate-800/60 hover:bg-slate-800 border border-slate-700/70 hover:border-brand-500/50 transition-all text-xs">
            <span class="block font-semibold text-white">Superadmin</span>
            <span class="block text-[10px] text-slate-400 truncate">admin@smk.sch.id</span>
          </button>
          <button type="button" onclick="fillDemo('verifikator@smk.sch.id', 'password123')"
            class="text-left p-2.5 rounded-lg bg-slate-800/60 hover:bg-slate-800 border border-slate-700/70 hover:border-brand-500/50 transition-all text-xs">
            <span class="block font-semibold text-emerald-400">Verifikator PPDB</span>
            <span class="block text-[10px] text-slate-400 truncate">verifikator@smk.sch.id</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Back to portal link -->
    <div class="text-center mt-5">
      <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-400 hover:text-slate-200 transition-colors">
        <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Kembali ke Beranda Sekolah
      </a>
    </div>
  </div>

  <script>
    lucide.createIcons();
    function fillDemo(email, pass) {
      document.getElementById('email').value = email;
      document.getElementById('password').value = pass;
    }
  </script>
</body>
</html>
