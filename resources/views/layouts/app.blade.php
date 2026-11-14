<!DOCTYPE html>
<html lang="id" class="scroll-smooth scroll-pt-28">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Coding for Kids - SMP Muhammadiyah 1 Yogyakarta')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Google Fonts: Fredoka (Playful poster style) & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        display: ['"Fredoka"', 'sans-serif'],
                    },
                    colors: {
                        muhi: {
                            yellow: '#fbb017',
                            gold: '#f59e0b',
                            blue: '#0b2347',
                            navy: '#061730',
                            orange: '#f97316',
                            red: '#e11d48',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-display { font-family: 'Fredoka', cursive, sans-serif; }
        
        /* Burst badge for FREE */
        .badge-free {
            position: relative;
            background: #ef4444;
            color: #fff;
            font-family: 'Fredoka', sans-serif;
            font-weight: 900;
            display: inline-block;
            transform: rotate(-10deg);
            box-shadow: 0 10px 20px -5px rgba(239, 68, 68, 0.5);
        }

        /* Floating keyframe animations */
        @keyframes float-slow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-12px) rotate(1.5deg); }
        }
        @keyframes float-reverse {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(10px) rotate(-2deg); }
        }
        @keyframes float-gentle {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        @keyframes pulse-glow {
            0%, 100% { opacity: 0.6; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.05); }
        }
        @keyframes robot-wave {
            0%, 100% { transform: rotate(0deg); }
            20% { transform: rotate(18deg); }
            40% { transform: rotate(-10deg); }
            60% { transform: rotate(18deg); }
            80% { transform: rotate(-5deg); }
        }
        @keyframes antenna-glow {
            0%, 100% { fill: #38bdf8; filter: drop-shadow(0 0 2px #38bdf8); }
            50% { fill: #facc15; filter: drop-shadow(0 0 10px #facc15); }
        }
        @keyframes spin-gear {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .animate-float {
            animation: float-slow 4s ease-in-out infinite;
        }
        .animate-float-reverse {
            animation: float-reverse 5s ease-in-out infinite;
        }
        .animate-float-gentle {
            animation: float-gentle 3s ease-in-out infinite;
        }
        .animate-glow {
            animation: pulse-glow 2.5s ease-in-out infinite;
        }
        .animate-wave {
            transform-origin: 75% 75%;
            animation: robot-wave 3s ease-in-out infinite;
        }
        .animate-spin-slow {
            animation: spin-gear 18s linear infinite;
        }
        .animate-spin-reverse {
            animation: spin-gear 22s linear infinite reverse;
        }

        /* 3D Tactile Cartoon Button */
        .btn-cartoon-blue {
            background: #0b2347;
            color: #ffffff;
            box-shadow: 0 6px 0 #051326, 0 10px 20px -2px rgba(11, 35, 71, 0.4);
            transition: all 0.12s ease-in-out;
        }
        .btn-cartoon-blue:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 0 #051326, 0 14px 24px -2px rgba(11, 35, 71, 0.5);
        }
        .btn-cartoon-blue:active {
            transform: translateY(4px);
            box-shadow: 0 2px 0 #051326;
        }

        .btn-cartoon-amber {
            background: #f59e0b;
            color: #0b2347;
            box-shadow: 0 6px 0 #b45309, 0 10px 20px -2px rgba(245, 158, 11, 0.4);
            transition: all 0.12s ease-in-out;
        }
        .btn-cartoon-amber:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 0 #b45309, 0 14px 24px -2px rgba(245, 158, 11, 0.5);
        }
        .btn-cartoon-amber:active {
            transform: translateY(4px);
            box-shadow: 0 2px 0 #b45309;
        }

        /* Cartoon Card with 3D drop depth */
        .cartoon-box {
            border: 3.5px solid #0b2347;
            box-shadow: 6px 6px 0 #0b2347;
            border-radius: 1.5rem;
            background: #ffffff;
        }
        .cartoon-box-amber {
            border: 3.5px solid #0b2347;
            box-shadow: 6px 6px 0 #b45309;
            border-radius: 1.5rem;
            background: #ffffff;
        }

        /* Scratch / Blockly Visual Puzzle Block Tokens */
        .scratch-block {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.85rem;
            border-radius: 0.65rem;
            font-family: 'Fredoka', sans-serif;
            font-size: 0.825rem;
            font-weight: 700;
            color: #ffffff;
            box-shadow: 0 4px 0 rgba(0, 0, 0, 0.2), 0 8px 16px -2px rgba(0,0,0,0.15);
            position: relative;
            user-select: none;
            border: 1.5px solid rgba(255, 255, 255, 0.25);
        }
        .scratch-events { background: #FFBF00; color: #573b00; text-shadow: 0 1px 0 rgba(255,255,255,0.4); border-color: #d99b00; }
        .scratch-motion { background: #4C97FF; color: #ffffff; border-color: #2b7af0; }
        .scratch-looks  { background: #9966FF; color: #ffffff; border-color: #7b45f0; }
        .scratch-control { background: #FFAB19; color: #ffffff; border-color: #d68900; }
        .scratch-sensing { background: #5CB1D6; color: #ffffff; border-color: #3b93b8; }
        .scratch-operator { background: #59C059; color: #ffffff; border-color: #3ca23c; }

        .scratch-pill {
            background: #ffffff;
            color: #0b2347;
            padding: 0.15rem 0.55rem;
            border-radius: 9999px;
            font-weight: 800;
            font-size: 0.75rem;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.15);
        }
        .scratch-pill-dark {
            background: rgba(0,0,0,0.2);
            color: #ffffff;
            padding: 0.15rem 0.55rem;
            border-radius: 9999px;
            font-weight: 800;
            font-size: 0.75rem;
        }

        /* Comic Speech Bubble */
        .speech-bubble-bottom {
            position: relative;
        }
        .speech-bubble-bottom::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 2rem;
            width: 0;
            height: 0;
            border-left: 12px solid transparent;
            border-right: 12px solid transparent;
            border-top: 14px solid #ffffff;
        }
        .speech-bubble-left {
            position: relative;
        }
        .speech-bubble-left::after {
            content: '';
            position: absolute;
            left: -14px;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-top: 10px solid transparent;
            border-bottom: 10px solid transparent;
            border-right: 14px solid #ffffff;
        }

        /* Web Coding Background Pattern Styles */
        .bg-coding-grid {
            background-color: #fffdf5;
            background-image: 
                radial-gradient(rgba(11, 35, 71, 0.12) 1px, transparent 1px),
                url("/images/pattern-coding.svg");
            background-size: 24px 24px, 180px 180px;
            background-repeat: repeat;
        }

        .bg-hero-coding {
            background-color: #fbb017;
            background-image: 
                radial-gradient(rgba(11, 35, 71, 0.14) 1.2px, transparent 1.2px),
                url("/images/pattern-coding.svg");
            background-size: 28px 28px, 180px 180px;
            background-repeat: repeat;
        }

        .bg-dark-coding {
            background-color: #061730;
            background-image: 
                radial-gradient(rgba(56, 189, 248, 0.18) 1px, transparent 1px),
                url("/images/pattern-coding-dark.svg");
            background-size: 24px 24px, 180px 180px;
            background-repeat: repeat;
        }

        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            body { background: white !important; color: black !important; }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-coding-grid text-slate-800 antialiased min-h-screen flex flex-col selection:bg-amber-400 selection:text-slate-900">

    <!-- Top Announcement Bar -->
    <div class="bg-gradient-to-r from-blue-950 via-blue-900 to-indigo-950 text-white text-xs sm:text-sm py-2 px-4 text-center font-semibold shadow-xs no-print flex items-center justify-center gap-2">
        <span class="inline-block bg-amber-400 text-blue-950 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider animate-pulse">
            Workshop Siswa SD
        </span>
        <span>Senin, 21 Desember 2026 &bull; Laboratorium Komputer SMP Muhammadiyah 1 Yogyakarta</span>
    </div>

    <!-- Navigation Bar: Muhijunior ISS & SMP Muh 1 Yogya -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b-2 border-amber-200/90 shadow-sm no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            
            <!-- Left Branding: Muhijunior ISS & SMP Muh 1 Official Logos -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-3 shrink-0">
                <img src="/images/logo-muhijunior-iss.png" alt="Muhijunior ISS - School Of Creative People" class="h-10 sm:h-12 w-auto object-contain transition-transform hover:scale-105">
                <span class="hidden sm:block w-px h-8 bg-slate-300"></span>
                <img src="/images/logo-smp-muh1.png" alt="SMP Muhammadiyah 1 Yogyakarta" class="hidden sm:block h-10 sm:h-11 w-auto object-contain transition-transform hover:scale-105">
            </a>

            <!-- Center Nav Links (Desktop) -->
            <nav class="hidden lg:flex items-center gap-6 xl:gap-8 text-sm font-extrabold text-slate-700">
                <a href="{{ request()->routeIs('home') ? '#materi' : route('home') . '#materi' }}" class="hover:text-amber-600 transition-colors whitespace-nowrap">
                    Materi Workshop
                </a>
                <a href="{{ request()->routeIs('home') ? '#rundown' : route('home') . '#rundown' }}" class="hover:text-amber-600 transition-colors whitespace-nowrap">
                    Jadwal Sesi
                </a>
                <a href="{{ request()->routeIs('home') ? '#lokasi' : route('home') . '#lokasi' }}" class="hover:text-amber-600 transition-colors whitespace-nowrap">
                    Lokasi Lab
                </a>
                <a href="{{ request()->routeIs('home') ? '#pendaftaran' : route('home') . '#pendaftaran' }}" class="hover:text-amber-600 transition-colors whitespace-nowrap">
                    Pendaftaran
                </a>
                <a href="{{ request()->routeIs('home') ? '#faq' : route('home') . '#faq' }}" class="hover:text-amber-600 transition-colors whitespace-nowrap">
                    FAQ
                </a>
                <a href="{{ route('participants.selected') }}" class="hover:text-amber-600 transition-colors whitespace-nowrap inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-300 font-extrabold text-xs shadow-xs hover:bg-emerald-100">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Peserta Terpilih
                </a>
            </nav>

            <!-- Right Actions Area -->
            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <!-- SMP Muh 1 Crest Badge (Compact & Elegant) -->
                <div class="hidden xl:flex items-center gap-2 pl-3 border-l border-slate-200 text-right">
                    <img src="/images/logo-smp-muh1.png" alt="SMP Muhammadiyah 1 Yogyakarta" class="h-9 w-9 object-contain rounded-full border-2 border-amber-400 shadow-xs">
                    <div>
                        <span class="block text-[11px] font-black text-blue-900 leading-tight">SMP Muh 1</span>
                        <span class="block text-[9px] font-bold text-slate-400 tracking-wider">YOGYAKARTA</span>
                    </div>
                </div>

                <button type="button" onclick="openTicketSearchModal()" class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-blue-950 bg-amber-100 hover:bg-amber-200 rounded-xl border border-amber-300 transition-all whitespace-nowrap">
                    <svg class="w-3.5 h-3.5 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <span>Cek Sesi</span>
                </button>

                <a href="{{ request()->routeIs('home') ? '#pendaftaran' : route('home') . '#pendaftaran' }}" class="btn-cartoon-blue inline-flex items-center justify-center px-4 py-2 text-xs sm:text-sm font-black rounded-xl whitespace-nowrap">
                    Daftar Sekarang &rarr;
                </a>

                <!-- Mobile Hamburger Toggle -->
                <button type="button" onclick="toggleMobileMenu()" class="lg:hidden p-2 rounded-xl text-slate-700 hover:bg-slate-100 border border-slate-200" aria-label="Toggle navigation">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Dropdown Navigation -->
        <div id="mobileMenu" class="hidden lg:hidden bg-white border-t border-amber-200 px-4 pt-3 pb-5 space-y-2 shadow-xl">
            <div class="flex items-center gap-3 pb-3 border-b border-slate-100 mb-2">
                <img src="/images/logo-muhijunior-iss.png" alt="Muhijunior ISS" class="h-8 w-auto object-contain">
                <span class="w-px h-6 bg-slate-300"></span>
                <img src="/images/logo-smp-muh1.png" alt="SMP Muhammadiyah 1 Yogyakarta" class="h-8 w-auto object-contain">
                <span class="text-xs font-black text-blue-950">SMP Muh 1 Yogya</span>
            </div>
            <a href="{{ request()->routeIs('home') ? '#materi' : route('home') . '#materi' }}" onclick="toggleMobileMenu()" class="block py-2.5 px-3 rounded-xl text-sm font-extrabold text-slate-800 hover:bg-amber-50">
                🎮 Materi Workshop
            </a>
            <a href="{{ request()->routeIs('home') ? '#rundown' : route('home') . '#rundown' }}" onclick="toggleMobileMenu()" class="block py-2.5 px-3 rounded-xl text-sm font-extrabold text-slate-800 hover:bg-amber-50">
                ⏰ Jadwal Sesi 1 &amp; Sesi 2
            </a>
            <a href="{{ request()->routeIs('home') ? '#lokasi' : route('home') . '#lokasi' }}" onclick="toggleMobileMenu()" class="block py-2.5 px-3 rounded-xl text-sm font-extrabold text-slate-800 hover:bg-amber-50">
                📍 Lokasi Lab TIK
            </a>
            <a href="{{ request()->routeIs('home') ? '#pendaftaran' : route('home') . '#pendaftaran' }}" onclick="toggleMobileMenu()" class="block py-2.5 px-3 rounded-xl text-sm font-extrabold text-slate-800 hover:bg-amber-50">
                📝 Formulir Pendaftaran
            </a>
            <a href="{{ request()->routeIs('home') ? '#faq' : route('home') . '#faq' }}" onclick="toggleMobileMenu()" class="block py-2.5 px-3 rounded-xl text-sm font-extrabold text-slate-800 hover:bg-amber-50">
                💡 Pertanyaan (FAQ)
            </a>
            <a href="{{ route('participants.selected') }}" onclick="toggleMobileMenu()" class="block py-2.5 px-3 rounded-xl text-sm font-extrabold text-emerald-800 bg-emerald-50 hover:bg-emerald-100 border border-emerald-300">
                🏆 Daftar Peserta Terpilih
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer: Muhijunior & SMP Muhammadiyah 1 Yogyakarta Socials -->
    <footer class="bg-dark-coding text-slate-300 text-sm border-t-4 border-amber-400 no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="bg-white p-2.5 rounded-2xl inline-block shadow-md border-2 border-amber-300">
                            <img src="/images/logo-muhijunior-iss.png" alt="Muhijunior ISS - School Of Creative People" class="h-9 w-auto object-contain">
                        </div>
                        <div class="bg-white p-2 rounded-2xl inline-block shadow-md border-2 border-amber-300">
                            <img src="/images/logo-smp-muh1.png" alt="SMP Muhammadiyah 1 Yogyakarta" class="h-9 w-auto object-contain">
                        </div>
                    </div>
                    <h3 class="font-extrabold text-white text-base">SMP Muhammadiyah 1 Yogyakarta</h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed max-w-md">
                        Mini workshop <strong>Coding for Kids</strong>: Membekali siswa SD dengan logika pemrograman visual Scratch, pemanfaatan A.I. untuk belajar, serta etika &amp; keamanan digital bersertifikat Google Interland.
                    </p>
                    <p class="text-xs text-amber-300 font-semibold">
                        📍 Lab TIK 1 &amp; Lab TIK 3 (Lantai 3 Gedung Selatan), SMP Muhammadiyah 1 Yogyakarta
                    </p>
                </div>

                <div>
                    <h4 class="font-bold text-amber-400 text-xs uppercase tracking-wider mb-3">Tautan Cepat</h4>
                    <ul class="space-y-2 text-xs font-semibold">
                        <li><a href="{{ route('participants.selected') }}" class="text-emerald-400 hover:text-emerald-300 font-bold transition-colors flex items-center gap-1.5"><span>🏆</span> Daftar Peserta Terpilih</a></li>
                        <li><a href="{{ route('home') }}#materi" class="hover:text-white transition-colors">3 Materi Utama</a></li>
                        <li><a href="{{ route('home') }}#rundown" class="hover:text-white transition-colors">Jadwal Sesi 1 &amp; Sesi 2</a></li>
                        <li><a href="{{ route('home') }}#pendaftaran" class="hover:text-white transition-colors">Formulir Pendaftaran</a></li>
                        <li><button type="button" onclick="openTicketSearchModal()" class="text-amber-400 hover:text-amber-300 transition-colors">Cek Status &amp; Tiket Pendaftaran</button></li>
                        <li><a href="{{ route('admin.login') }}" class="text-slate-400 hover:text-white transition-colors">Login Panitia &rarr;</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-amber-400 text-xs uppercase tracking-wider mb-3">Media Sosial Resmi</h4>
                    <ul class="space-y-2 text-xs text-slate-300">
                        <li class="flex items-center gap-2">
                            <span>🌐</span>
                            <a href="https://smpmuh1-yog.sch.id" target="_blank" class="hover:text-white font-mono">smpmuh1-yog.sch.id</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <span>📸</span>
                            <a href="https://instagram.com/smpmuh1ykofficial" target="_blank" class="hover:text-white font-mono">@smpmuh1ykofficial</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <span>📘</span>
                            <span class="font-mono">smpmuh1yogya</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span>▶️</span>
                            <span class="font-mono">SMPMuhammadiyah1Yogyakarta</span>
                        </li>
                    </ul>

                    <div class="mt-4 pt-3 border-t border-blue-900">
                        <span class="block text-[11px] text-slate-400">Website Pendaftaran Resmi:</span>
                        <code class="text-xs text-amber-400 font-bold bg-blue-900/80 px-2 py-1 rounded-md inline-block mt-1">coding.muhijunior.id</code>
                    </div>
                </div>

            </div>

            <div class="pt-8 border-t border-blue-900 text-center text-xs text-slate-400 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p>&copy; 2026 Coding for Kids &bull; SMP Muhammadiyah 1 Yogyakarta. All rights reserved.</p>
                <p class="text-slate-500 font-mono text-[11px]">School Of Creative People &bull; coding.muhijunior.id</p>
            </div>
        </div>
    </footer>

    <!-- Ticket Search Modal -->
    <div id="ticketSearchModal" class="fixed inset-0 z-50 bg-blue-950/70 backdrop-blur-xs hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl relative border-2 border-amber-300">
            <button type="button" onclick="closeTicketSearchModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 p-1.5 rounded-xl hover:bg-slate-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <div class="text-center mb-6">
                <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center mx-auto mb-3 text-2xl font-black shadow-xs">
                    🎟️
                </div>
                <h3 class="text-xl font-display font-black text-slate-900">Cek Pembagian Sesi &amp; E-Ticket</h3>
                <p class="text-xs text-slate-500 mt-1">Masukkan 5 Huruf Kode Registrasi (misal: <strong>KMPXW</strong>) atau Nomor WhatsApp saat mendaftar.</p>
            </div>

            <form action="{{ route('ticket.check') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-1.5">Kode Registrasi (5 Huruf) / No. WhatsApp</label>
                    <input type="text" name="query" required placeholder="Contoh: KMPXW atau 08123456789" class="w-full px-4 py-3 rounded-2xl border-2 border-slate-300 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-all font-semibold uppercase tracking-wider">
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <button type="button" onclick="closeTicketSearchModal()" class="w-1/2 px-4 py-3 text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-2xl transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="w-1/2 px-4 py-3 text-xs font-black text-white bg-blue-900 hover:bg-blue-950 rounded-2xl shadow-md transition-colors">
                        Cari Tiket &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script for Modal -->
    <script>
        function openTicketSearchModal() {
            document.getElementById('ticketSearchModal').classList.remove('hidden');
            document.getElementById('ticketSearchModal').classList.add('flex');
        }
        function closeTicketSearchModal() {
            document.getElementById('ticketSearchModal').classList.add('hidden');
            document.getElementById('ticketSearchModal').classList.remove('flex');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeTicketSearchModal();
        });

        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }

        // Smooth scroll with sticky navbar offset (so section headers are never blocked by navbar)
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    const hash = this.getAttribute('href');
                    if (hash === '#' || hash === '') return;
                    const target = document.querySelector(hash);
                    if (target) {
                        e.preventDefault();
                        const navOffset = 90;
                        const elementTop = target.getBoundingClientRect().top + window.pageYOffset - navOffset;
                        window.scrollTo({
                            top: elementTop,
                            behavior: 'smooth'
                        });
                        history.pushState(null, null, hash);
                        const mobileMenu = document.getElementById('mobileMenu');
                        if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                            mobileMenu.classList.add('hidden');
                        }
                    }
                });
            });

            // Handle direct URL hash landing e.g. http://127.0.0.1:8000/#rundown
            if (window.location.hash) {
                const target = document.querySelector(window.location.hash);
                if (target) {
                    setTimeout(() => {
                        const navOffset = 90;
                        const elementTop = target.getBoundingClientRect().top + window.pageYOffset - navOffset;
                        window.scrollTo({
                            top: elementTop,
                            behavior: 'smooth'
                        });
                    }, 150);
                }
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
