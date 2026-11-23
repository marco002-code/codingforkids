<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Coding for Kids')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
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
        /* Custom scrollbar for sidebar */
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 4px; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex flex-col lg:flex-row">

    <!-- ===================================================================== -->
    <!-- MOBILE TOPBAR (Shown only on < lg screens) -->
    <!-- ===================================================================== -->
    <header class="lg:hidden bg-slate-900 text-white sticky top-0 z-40 border-b border-slate-800 shadow-md px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <button id="mobileSidebarToggle" type="button" class="p-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800 focus:outline-none" aria-label="Buka Menu Sidebar">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <div class="flex items-center gap-2 bg-white px-2 py-1 rounded-lg">
                <img src="{{ asset('images/logo-muhijunior-iss.png') }}" alt="Muhijunior" class="h-5 w-auto object-contain">
                <span class="w-px h-3.5 bg-slate-300"></span>
                <img src="{{ asset('images/logo-smp-muh1.png') }}" alt="SMP Muh 1" class="h-5 w-auto object-contain">
            </div>
            <span class="font-extrabold text-xs text-white tracking-tight truncate max-w-[130px] sm:max-w-none">Panel Panitia</span>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('home') }}" target="_blank" class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800" title="Buka Halaman Depan">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            </a>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-2.5 py-1 text-xs font-bold text-rose-300 hover:text-white hover:bg-rose-600/30 rounded-lg border border-rose-500/30" title="Keluar">
                    Keluar
                </button>
            </form>
        </div>
    </header>

    <!-- ===================================================================== -->
    <!-- MOBILE SIDEBAR OVERLAY & DRAWER -->
    <!-- ===================================================================== -->
    <div id="mobileBackdrop" class="fixed inset-0 bg-slate-950/70 z-50 backdrop-blur-xs transition-opacity duration-300 opacity-0 pointer-events-none lg:hidden"></div>

    <aside id="mobileDrawer" class="fixed inset-y-0 left-0 w-72 bg-slate-900 text-slate-300 z-50 transform -translate-x-full transition-transform duration-300 ease-in-out lg:hidden flex flex-col justify-between shadow-2xl border-r border-slate-800">
        <div class="p-5 border-b border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="bg-white px-2 py-1 rounded-lg flex items-center gap-1.5 shadow-xs">
                    <img src="{{ asset('images/logo-muhijunior-iss.png') }}" alt="Muhijunior" class="h-6 w-auto object-contain">
                    <span class="w-px h-4 bg-slate-300"></span>
                    <img src="{{ asset('images/logo-smp-muh1.png') }}" alt="SMP Muh 1" class="h-6 w-auto object-contain">
                </div>
                <div>
                    <h2 class="font-extrabold text-sm text-white leading-tight">Panel Panitia</h2>
                    <span class="text-[10px] text-slate-400 block font-medium">Coding &amp; A.I. 2026</span>
                </div>
            </div>
            <button id="mobileDrawerClose" type="button" class="p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800" aria-label="Tutup Menu">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Mobile Navigation List -->
        <div class="p-4 space-y-6 overflow-y-auto sidebar-scroll flex-grow">
            <div>
                <span class="px-3 text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-2">MENU UTAMA</span>
                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span>Ringkasan / Dashboard</span>
                    </a>
                    <a href="{{ route('admin.participants') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold transition-colors {{ request()->routeIs('admin.participants*') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span>Data Peserta</span>
                        </div>
                        <span class="px-2 py-0.5 rounded-md bg-white/20 text-[10px] font-black">{{ \App\Models\Participant::count() }}</span>
                    </a>

                    <a href="{{ route('admin.attendance') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold transition-colors {{ request()->routeIs('admin.attendance*') ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            <span>Presensi Kehadiran</span>
                        </div>
                        <span class="px-2 py-0.5 rounded-md {{ request()->routeIs('admin.attendance*') ? 'bg-white/20 text-white' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' }} text-[10px] font-black">
                            {{ \App\Models\Participant::where('is_attended', true)->count() }} Hadir
                        </span>
                    </a>
                </nav>
            </div>

            <div>
                <div class="px-3 flex items-center justify-between mb-2">
                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">PENGATURAN ACARA &amp; SESI</span>
                    @if(Auth::user()->isPanitia())
                        <span class="text-[9px] font-bold text-amber-400 bg-amber-950/60 px-1.5 py-0.5 rounded border border-amber-500/30">Read Only</span>
                    @endif
                </div>
                <nav class="space-y-1">
                    <a href="{{ route('admin.settings', ['tab' => 'event']) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-colors {{ request()->routeIs('admin.settings*') && (request()->query('tab') === 'event' || !request()->has('tab')) ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Atur Tanggal &amp; Acara</span>
                    </a>
                    <a href="{{ route('admin.settings', ['tab' => 'sessions']) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-colors {{ request()->routeIs('admin.settings*') && request()->query('tab') === 'sessions' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Atur Jam &amp; Kuota Sesi</span>
                    </a>
                    <a href="{{ route('admin.settings', ['tab' => 'rundown']) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-colors {{ request()->routeIs('admin.settings*') && request()->query('tab') === 'rundown' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span>Stack Materi Sesi (Rundown)</span>
                    </a>
                    <a href="{{ route('admin.settings', ['tab' => 'whatsapp']) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-colors {{ request()->routeIs('admin.settings*') && request()->query('tab') === 'whatsapp' ? 'bg-emerald-600 text-white shadow-sm' : 'text-emerald-300 hover:text-white hover:bg-emerald-950/40' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        <span>Grup &amp; Hotline WhatsApp</span>
                    </a>
                </nav>
            </div>

            <div>
                <span class="px-3 text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-2">PENGELOLAAN AKUN</span>
                <nav class="space-y-1">
                    <a href="{{ route('admin.users.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold transition-colors {{ request()->routeIs('admin.users*') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span>{{ Auth::user()->isPanitia() ? 'Profil & Ganti Password' : 'Akun & Password Panitia' }}</span>
                        </div>
                        @if(Auth::user()->isAdmin())
                            <span class="px-2 py-0.5 rounded-md bg-white/20 text-[10px] font-black">{{ \App\Models\User::count() }}</span>
                        @endif
                    </a>
                </nav>
            </div>

            <div>
                <span class="px-3 text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-2">HALAMAN PUBLIK</span>
                <nav class="space-y-1">
                    <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold text-slate-300 hover:text-white hover:bg-slate-800 transition-colors">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            <span>Halaman Pendaftaran</span>
                        </div>
                        <span class="text-[10px] text-slate-400">&nearr;</span>
                    </a>
                    <a href="{{ route('participants.selected') }}" target="_blank" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold text-slate-300 hover:text-white hover:bg-slate-800 transition-colors">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                            <span>Peserta Terpilih</span>
                        </div>
                        <span class="text-[10px] text-slate-400">&nearr;</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Mobile Drawer Footer: Admin Info & Logout -->
        <div class="p-4 border-t border-slate-800 bg-slate-950/40">
            <div class="flex items-center justify-between gap-3 mb-3">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-xs shrink-0">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <span class="block text-xs font-bold text-white truncate">{{ Auth::user()->name ?? 'Administrator' }}</span>
                        <div class="flex items-center gap-1.5 mt-0.5">
                            <span class="px-1.5 py-0.2 rounded text-[9px] font-black {{ Auth::user()->isAdmin() ? 'bg-indigo-500/20 text-indigo-300 border border-indigo-500/30' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' }}">
                                {{ Auth::user()->role_label }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 text-xs font-bold text-rose-300 hover:text-white bg-rose-950/40 hover:bg-rose-600/30 rounded-xl border border-rose-500/30 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span>Keluar dari Panel</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- ===================================================================== -->
    <!-- DESKTOP SIDEBAR (Visible on lg screens and wider) -->
    <!-- ===================================================================== -->
    <aside class="hidden lg:flex w-72 shrink-0 bg-slate-900 text-slate-300 border-r border-slate-800 min-h-screen flex-col justify-between sticky top-0 h-screen overflow-y-auto sidebar-scroll z-30 shadow-lg">
        <div>
            <!-- Branding Header -->
            <div class="p-6 border-b border-slate-800">
                <a href="{{ route('admin.dashboard') }}" class="block">
                    <div class="bg-white px-3 py-2 rounded-xl flex items-center justify-center gap-2 shadow-xs mb-3">
                        <img src="{{ asset('images/logo-muhijunior-iss.png') }}" alt="Muhijunior ISS" class="h-6 w-auto object-contain">
                        <span class="w-px h-5 bg-slate-300"></span>
                        <img src="{{ asset('images/logo-smp-muh1.png') }}" alt="SMP Muhammadiyah 1" class="h-6 w-auto object-contain">
                    </div>
                    <div class="text-center">
                        <h2 class="font-extrabold text-sm text-white tracking-tight">Panel Panitia Workshop</h2>
                        <p class="text-[11px] text-slate-400 mt-0.5">Coding for Kids &amp; A.I. 2026</p>
                    </div>
                </a>
            </div>

            <!-- Navigation Menu -->
            <div class="p-5 space-y-6">
                <!-- Group 1: Menu Utama -->
                <div>
                    <span class="px-3 text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-2">MENU UTAMA</span>
                    <nav class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            <span>Ringkasan / Dashboard</span>
                        </a>

                        <a href="{{ route('admin.participants') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.participants*') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <span>Data Peserta</span>
                            </div>
                            <span class="px-2 py-0.5 rounded-md bg-white/20 text-[10px] font-black text-white">{{ \App\Models\Participant::count() }}</span>
                        </a>

                        <a href="{{ route('admin.attendance') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.attendance*') ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                <span>Presensi Kehadiran</span>
                            </div>
                            <span class="px-2 py-0.5 rounded-md {{ request()->routeIs('admin.attendance*') ? 'bg-white/20 text-white' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' }} text-[10px] font-black">
                                {{ \App\Models\Participant::where('is_attended', true)->count() }} Hadir
                            </span>
                        </a>
                    </nav>
                </div>

                <!-- Group 2: Pengaturan Acara, Jam & Stack Materi -->
                <div>
                    <div class="px-3.5 flex items-center justify-between mb-2">
                        <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">PENGATURAN ACARA &amp; SESI</span>
                        @if(Auth::user()->isPanitia())
                            <span class="text-[9px] font-bold text-amber-400 bg-amber-950/60 px-1.5 py-0.5 rounded border border-amber-500/30">Read Only</span>
                        @endif
                    </div>
                    <nav class="space-y-1">
                        <a href="{{ route('admin.settings', ['tab' => 'event']) }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.settings*') && (request()->query('tab') === 'event' || !request()->has('tab')) ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Atur Tanggal &amp; Acara</span>
                        </a>

                        <a href="{{ route('admin.settings', ['tab' => 'sessions']) }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.settings*') && request()->query('tab') === 'sessions' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Atur Jam &amp; Kuota Sesi</span>
                        </a>

                        <a href="{{ route('admin.settings', ['tab' => 'rundown']) }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.settings*') && request()->query('tab') === 'rundown' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <span>Stack Materi Sesi (Rundown)</span>
                        </a>

                        <a href="{{ route('admin.settings', ['tab' => 'whatsapp']) }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.settings*') && request()->query('tab') === 'whatsapp' ? 'bg-emerald-600 text-white shadow-sm' : 'text-emerald-300 hover:text-white hover:bg-emerald-950/40' }}">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            <span>Grup &amp; Hotline WhatsApp</span>
                        </a>
                    </nav>
                </div>

                <!-- Group 3: Pengelolaan Akun -->
                <div>
                    <span class="px-3 text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-2">PENGELOLAAN AKUN</span>
                    <nav class="space-y-1">
                        <a href="{{ route('admin.users.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.users*') ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <span>{{ Auth::user()->isPanitia() ? 'Profil & Ganti Password' : 'Akun & Password Panitia' }}</span>
                            </div>
                            @if(Auth::user()->isAdmin())
                                <span class="px-2 py-0.5 rounded-md bg-white/20 text-[10px] font-black text-white">{{ \App\Models\User::count() }}</span>
                            @endif
                        </a>
                    </nav>
                </div>

                <!-- Group 4: Tautan Publik -->
                <div>
                    <span class="px-3 text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-2">HALAMAN PUBLIK</span>
                    <nav class="space-y-1">
                        <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-300 hover:text-white hover:bg-slate-800/80 transition-all">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                <span>Halaman Pendaftaran</span>
                            </div>
                            <span class="text-[10px] text-slate-400">&nearr;</span>
                        </a>

                        <a href="{{ route('participants.selected') }}" target="_blank" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold text-slate-300 hover:text-white hover:bg-slate-800/80 transition-all">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                                <span>Peserta Terpilih</span>
                            </div>
                            <span class="text-[10px] text-slate-400">&nearr;</span>
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Desktop Sidebar Footer -->
        <div class="p-5 border-t border-slate-800 bg-slate-950/40">
            <div class="flex items-center justify-between gap-3 mb-3">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-9 h-9 rounded-full bg-indigo-600 text-white flex items-center justify-center font-extrabold text-sm shrink-0 shadow-xs">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-1.5">
                            <span class="block text-xs font-bold text-white truncate">{{ Auth::user()->name ?? 'Administrator' }}</span>
                            <span class="px-1.5 py-0.2 rounded text-[9px] font-black {{ Auth::user()->isAdmin() ? 'bg-indigo-500/20 text-indigo-300 border border-indigo-500/30' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' }}">
                                {{ Auth::user()->role_label }}
                            </span>
                        </div>
                        <span class="block text-[10px] text-slate-400 truncate">{{ Auth::user()->email ?? 'admin@muhijunior.id' }}</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 text-xs font-bold text-rose-300 hover:text-white bg-rose-950/40 hover:bg-rose-600/30 rounded-xl border border-rose-500/30 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span>Keluar dari Panel</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- ===================================================================== -->
    <!-- MAIN WORKSPACE (Content Area) -->
    <!-- ===================================================================== -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen">

        <!-- Top Header for Desktop -->
        <header class="hidden lg:flex bg-white border-b border-slate-200/90 h-16 px-8 items-center justify-between sticky top-0 z-20 shadow-xs">
            <div class="flex items-center gap-3">
                <span class="text-xs font-bold text-slate-400">Panel Administrasi</span>
                <span class="text-slate-300">&bull;</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black {{ Auth::user()->isAdmin() ? 'bg-indigo-100 text-indigo-800' : 'bg-emerald-100 text-emerald-800' }}">
                    {{ Auth::user()->role_label }}
                </span>
                <span class="text-slate-300">&bull;</span>
                <h2 class="text-sm font-extrabold text-slate-800">
                    @yield('title', 'Coding for Kids & A.I. 2026')
                </h2>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-indigo-600 px-3 py-1.5 rounded-xl border border-slate-200 hover:border-indigo-300 transition-colors bg-slate-50">
                    <span>Lihat Halaman Pendaftaran</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                </a>
            </div>
        </header>

        <!-- Admin Main Content -->
        <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
            
            <!-- Global Flash Messages -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
                    <div class="flex items-center gap-2 text-xs sm:text-sm font-bold">
                        <span class="text-lg">✅</span>
                        <span>{{ session('success') }}</span>
                    </div>
                    @if(session('promoted_wa_url'))
                        <a href="{{ session('promoted_wa_url') }}" target="_blank" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-extrabold shadow-xs transition-colors shrink-0 text-center">
                            Kirim WA Pemberitahuan Promosi &rarr;
                        </a>
                    @endif
                </div>
            @endif

            @if(session('suggest_promote_id'))
                <div class="mb-6 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-xs">
                    <div class="flex items-center gap-2 text-xs sm:text-sm">
                        <span class="text-lg">💡</span>
                        <span>Kursi utama kosong! Anda dapat menaikkan antrean #1 <strong>{{ session('suggest_promote_name') }}</strong> ({{ session('suggest_promote_code') }}).</span>
                    </div>
                    <form action="{{ route('admin.participants.promote', session('suggest_promote_id')) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-extrabold shadow-xs transition-colors shrink-0">
                            Promosikan Sekarang &rarr;
                        </button>
                    </form>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 flex items-center gap-2 text-xs sm:text-sm font-bold shadow-xs">
                    <span class="text-lg">⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Admin Footer -->
        <footer class="bg-white border-t border-slate-200 py-4 px-4 sm:px-6 lg:px-8 text-center text-xs text-slate-500">
            Panel Panitia &bull; Coding for Kids and A.I. for Learning &bull; SMP Muhammadiyah 1 Yogyakarta &amp; Muhijunior ISS
        </footer>
    </div>

    <!-- Script Drawer Mobile -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('mobileSidebarToggle');
            const closeBtn = document.getElementById('mobileDrawerClose');
            const drawer = document.getElementById('mobileDrawer');
            const backdrop = document.getElementById('mobileBackdrop');

            function openSidebar() {
                drawer.classList.remove('-translate-x-full');
                backdrop.classList.remove('opacity-0', 'pointer-events-none');
                document.body.classList.add('overflow-hidden');
            }

            function closeSidebar() {
                drawer.classList.add('-translate-x-full');
                backdrop.classList.add('opacity-0', 'pointer-events-none');
                document.body.classList.remove('overflow-hidden');
            }

            if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (backdrop) backdrop.addEventListener('click', closeSidebar);
        });
    </script>

    @stack('scripts')
</body>
</html>
