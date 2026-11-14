<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Coding for Kids')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Admin Navigation Header -->
    <header class="bg-slate-900 text-white sticky top-0 z-40 border-b border-slate-800 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center font-extrabold text-sm text-white shadow-xs">
                        CK
                    </span>
                    <span class="font-extrabold text-base tracking-tight text-white hidden sm:inline">Panitia Dashboard</span>
                </a>

                <nav class="flex items-center gap-1 sm:gap-2 text-xs sm:text-sm font-semibold">
                    <a href="{{ route('admin.dashboard') }}" class="px-3 py-1.5 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:text-white hover:bg-slate-800' }} transition-colors">
                        Ringkasan
                    </a>
                    <a href="{{ route('admin.participants') }}" class="px-3 py-1.5 rounded-lg {{ request()->routeIs('admin.participants*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:text-white hover:bg-slate-800' }} transition-colors">
                        Data Peserta
                    </a>
                    <a href="{{ route('admin.settings') }}" class="px-3 py-1.5 rounded-lg {{ request()->routeIs('admin.settings') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:text-white hover:bg-slate-800' }} transition-colors">
                        Pengaturan Kuota
                    </a>
                </nav>
            </div>

            <!-- Right user controls -->
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" class="hidden md:inline-flex items-center gap-1.5 text-xs text-slate-400 hover:text-white px-2.5 py-1.5 rounded-lg border border-slate-700 hover:border-slate-500 transition-colors">
                    <span>Lihat Web Pendaftaran</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>

                <div class="text-right hidden sm:block">
                    <span class="block text-xs font-bold text-white">{{ Auth::user()->name ?? 'Administrator' }}</span>
                    <span class="block text-[10px] text-slate-400">{{ Auth::user()->email ?? 'admin@muhijunior.id' }}</span>
                </div>

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-3 py-1.5 text-xs font-bold text-rose-300 hover:text-white hover:bg-rose-600/30 rounded-lg border border-rose-500/30 transition-colors">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Admin Content Area -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Alerts -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2 text-sm font-semibold">
                    <span class="text-lg">✅</span>
                    <span>{{ session('success') }}</span>
                </div>
                @if(session('promoted_wa_url'))
                    <a href="{{ session('promoted_wa_url') }}" target="_blank" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold shadow-xs transition-colors shrink-0">
                        Kirim WA Pemberitahuan Promosi &rarr;
                    </a>
                @endif
            </div>
        @endif

        @if(session('suggest_promote_id'))
            <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2 text-sm">
                    <span class="text-lg">💡</span>
                    <span>Kursi utama kosong! Anda dapat menaikkan antrean #1 <strong>{{ session('suggest_promote_name') }}</strong> ({{ session('suggest_promote_code') }}).</span>
                </div>
                <form action="{{ route('admin.participants.promote', session('suggest_promote_id')) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-xs font-bold shadow-xs transition-colors shrink-0">
                        Promosikan Sekarang &rarr;
                    </button>
                </form>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 flex items-center gap-2 text-sm font-semibold shadow-xs">
                <span class="text-lg">⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Admin Footer -->
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-500">
        Dashboard Panitia &bull; Coding for Kids and A.I. for Learning &bull; Laravel on HestiaCP
    </footer>

    @stack('scripts')
</body>
</html>

