<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Coding for Kids - SMP Muhammadiyah 1 Yogyakarta')</title>
    
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

        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            body { background: white !important; color: black !important; }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-amber-50/40 text-slate-800 antialiased min-h-screen flex flex-col selection:bg-amber-400 selection:text-slate-900">

    <!-- Top Announcement Bar -->
    <div class="bg-gradient-to-r from-blue-950 via-blue-900 to-indigo-950 text-white text-xs sm:text-sm py-2 px-4 text-center font-semibold shadow-xs no-print flex items-center justify-center gap-2">
        <span class="inline-block bg-amber-400 text-blue-950 px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider animate-pulse">
            Workshop Siswa SD
        </span>
        <span>Senin, 21 Desember 2026 &bull; Laboratorium Komputer SMP Muhammadiyah 1 Yogyakarta</span>
    </div>

    <!-- Navigation Bar: Muhijunior ISS & SMP Muh 1 Yogya -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-amber-200/80 shadow-xs no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            
            <!-- Left Branding: Muhijunior ISS -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="flex items-center gap-2">
                    <!-- Muhijunior styled logo -->
                    <div class="flex flex-col">
                        <div class="flex items-center gap-1">
                            <span class="w-2.5 h-2.5 rounded-xs bg-emerald-500"></span>
                            <span class="w-2.5 h-2.5 rounded-xs bg-blue-500"></span>
                            <span class="w-2.5 h-2.5 rounded-xs bg-amber-400"></span>
                            <span class="w-2.5 h-2.5 rounded-xs bg-rose-500"></span>
                        </div>
                        <span class="font-display font-black text-xl text-blue-950 tracking-tight leading-none mt-1">
                            muhijunior<span class="text-amber-500 text-sm ml-0.5 font-bold">iss</span>
                        </span>
                        <span class="text-[9px] text-slate-500 font-bold tracking-widest uppercase -mt-0.5">
                            School Of Creative People
                        </span>
                    </div>
                </div>
            </a>

            <!-- Center Nav Links -->
            <nav class="hidden md:flex items-center gap-7 text-xs sm:text-sm font-extrabold text-slate-600">
                <a href="{{ route('home') }}#materi" class="hover:text-amber-600 transition-colors">3 Materi Utama</a>
                <a href="{{ route('home') }}#rundown" class="hover:text-amber-600 transition-colors">Jadwal Sesi</a>
                <a href="{{ route('home') }}#lokasi" class="hover:text-amber-600 transition-colors">Lokasi Lab</a>
                <a href="{{ route('home') }}#faq" class="hover:text-amber-600 transition-colors">FAQ</a>
            </nav>

            <!-- Right: SMP Muhammadiyah 1 Badge & CTA -->
            <div class="flex items-center gap-2.5 sm:gap-3">
                <!-- SMP Muh 1 Crest Badge -->
                <div class="hidden lg:flex items-center gap-2 pl-3 border-l border-slate-200 text-right">
                    <div>
                        <span class="block text-[11px] font-black text-blue-900 leading-tight">SMP Muhammadiyah 1</span>
                        <span class="block text-[9px] font-bold text-slate-400 tracking-wider">YOGYAKARTA</span>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-blue-900 text-amber-400 flex items-center justify-center font-black text-xs border-2 border-amber-400 shadow-xs">
                        ★
                    </div>
                </div>

                <button type="button" onclick="openTicketSearchModal()" class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-blue-900 bg-amber-100 hover:bg-amber-200 rounded-xl border border-amber-300 transition-all">
                    <svg class="w-3.5 h-3.5 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <span>Cek Pembagian Sesi</span>
                </button>

                <a href="{{ route('home') }}#pendaftaran" class="inline-flex items-center justify-center px-4 py-2 text-xs sm:text-sm font-black text-white bg-blue-900 hover:bg-blue-950 rounded-xl shadow-md hover:shadow-lg transition-all">
                    Daftar Sekarang &rarr;
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer: Muhijunior & SMP Muhammadiyah 1 Yogyakarta Socials -->
    <footer class="bg-blue-950 text-slate-300 text-sm border-t-4 border-amber-400 no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                
                <div class="md:col-span-2 space-y-3">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-xs bg-emerald-400"></span>
                        <span class="w-3 h-3 rounded-xs bg-blue-400"></span>
                        <span class="w-3 h-3 rounded-xs bg-amber-400"></span>
                        <span class="w-3 h-3 rounded-xs bg-rose-400"></span>
                        <span class="font-display font-black text-2xl text-white tracking-tight">muhijunior</span>
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
                <p class="text-xs text-slate-500 mt-1">Masukkan Kode Registrasi (misal: AI26-S1-001) atau Nomor WhatsApp Orang Tua saat mendaftar.</p>
            </div>

            <form action="{{ route('ticket.check') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-1.5">Kode Registrasi / No. WhatsApp</label>
                    <input type="text" name="query" required placeholder="Contoh: AI26-S1-001 atau 08123456789" class="w-full px-4 py-3 rounded-2xl border-2 border-slate-300 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-all font-semibold">
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
    </script>
    @stack('scripts')
</body>
</html>
