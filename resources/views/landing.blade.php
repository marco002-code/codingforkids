@extends('layouts.app')

@section('title', 'Coding for Kids - Belajar Block Programming, A.I. & Keamanan Digital | Muhijunior')

@section('content')

    <!-- Flash Alerts -->
    @if(session('error'))
        <div class="max-w-6xl mx-auto px-4 mt-6">
            <div class="p-4 rounded-2xl bg-rose-50 border-2 border-rose-300 text-rose-900 flex items-start gap-3 shadow-md animate-bounce">
                <span class="text-2xl">⚠️</span>
                <div>
                    <h4 class="font-bold text-sm">Pemberitahuan</h4>
                    <p class="text-xs font-semibold mt-0.5">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('search_error'))
        <div class="max-w-6xl mx-auto px-4 mt-6">
            <div class="p-4 rounded-2xl bg-amber-50 border-2 border-amber-300 text-amber-900 flex items-start gap-3 shadow-md">
                <span class="text-2xl">🔍</span>
                <div>
                    <h4 class="font-bold text-sm">Pencarian Tidak Ditemukan</h4>
                    <p class="text-xs font-semibold mt-0.5">{{ session('search_error') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('search_results'))
        <div class="max-w-6xl mx-auto px-4 mt-6">
            <div class="p-6 rounded-3xl bg-white border-2 border-blue-900 text-slate-900 shadow-xl">
                <h3 class="font-display font-black text-lg mb-3 flex items-center gap-2 text-blue-950">
                    <span>🎉</span> Ditemukan {{ count(session('search_results')) }} E-Ticket Siswa:
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach(session('search_results') as $found)
                        <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200 flex items-center justify-between">
                            <div>
                                <p class="font-black text-slate-900 text-sm">{{ $found->student_name }}</p>
                                <p class="text-xs text-slate-600 font-mono mt-0.5">
                                    {{ $found->reg_code }} &bull; 
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ $found->session === '1' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                        Sesi {{ $found->session }} ({{ $found->session_time }})
                                    </span>
                                </p>
                            </div>
                            <a href="{{ route('ticket.show', $found->reg_code) }}" class="px-4 py-2 text-xs font-black bg-blue-900 text-white rounded-xl hover:bg-blue-950 transition-colors shadow-xs">
                                Buka Tiket &rarr;
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- HERO SECTION (Sesuai Gaya Visual Poster: Sunny Yellow, Bold Poster Typography, Doodles, Red Burst Badge) -->
    <section class="relative pt-10 pb-20 overflow-hidden bg-gradient-to-b from-[#FBB017] via-[#F59E0B] to-[#FBB017] border-b-4 border-blue-950">
        
        <!-- Background Doodles SVG Simulation -->
        <div class="absolute inset-0 opacity-15 pointer-events-none flex justify-between p-8 text-blue-950">
            <!-- Chip Doodle Top Left -->
            <div class="w-24 h-24 border-2 border-dashed border-blue-950 rounded-2xl p-3 flex flex-col justify-between">
                <div class="flex justify-between"><span class="w-2 h-2 rounded-full bg-blue-950"></span><span class="w-2 h-2 rounded-full bg-blue-950"></span></div>
                <div class="text-center font-mono font-bold text-xs">CPU</div>
                <div class="flex justify-between"><span class="w-2 h-2 rounded-full bg-blue-950"></span><span class="w-2 h-2 rounded-full bg-blue-950"></span></div>
            </div>
            <!-- Lightbulb Doodle Top Right -->
            <div class="w-20 h-20 text-4xl text-right">💡</div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Poster Style Main Hero Header -->
            <div class="text-center max-w-4xl mx-auto">
                
                <!-- School & Event Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-950 text-white text-xs font-black uppercase tracking-wider shadow-lg mb-4">
                    <span>🏫 SMP Muhammadiyah 1 Yogyakarta</span> &bull; 
                    <span class="text-amber-400">Muhijunior ISS</span>
                </div>

                <!-- Main Poster Heading (Fredoka Block Font) -->
                <h1 class="font-display font-black text-5xl sm:text-7xl lg:text-8xl text-blue-950 tracking-tight leading-none drop-shadow-xs uppercase">
                    CODING FOR KIDS
                </h1>

                <p class="mt-3 font-display font-bold text-lg sm:text-2xl text-blue-950 max-w-2xl mx-auto leading-snug">
                    Belajar Block Programming, Pemanfaatan A.I., dan Keamanan Digital untuk Siswa SD
                </p>

                <!-- URL Badge (Matching the iconic green pill from poster) -->
                <div class="mt-5 inline-flex items-center gap-2 px-5 py-2 rounded-full bg-white border-2 border-blue-950 shadow-md">
                    <span class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-xs">@</span>
                    <span class="font-display font-black text-base text-blue-950 tracking-wide">coding.muhijunior.id</span>
                </div>

            </div>

            <!-- Two-Column Poster Layout: Left Cards (Details + FREE!) & Right Kid Coder Illustration -->
            <div class="mt-12 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center max-w-6xl mx-auto">
                
                <!-- LEFT COLUMN (7 cols): Main Feature Card with "FREE!" Burst Badge -->
                <div class="lg:col-span-7 space-y-6">
                    
                    <!-- White Container Card -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border-4 border-blue-950 shadow-2xl relative">
                        
                        <!-- Angled Red Burst "FREE!" Badge (Exact match with poster) -->
                        <div class="absolute -top-6 right-6 sm:right-10 z-20">
                            <div class="badge-free px-5 py-2.5 rounded-2xl border-3 border-white text-xl sm:text-2xl font-display font-black tracking-widest uppercase">
                                FREE! 🔥
                            </div>
                        </div>

                        <!-- Card Subtitle -->
                        <div class="mb-4">
                            <span class="inline-block px-3 py-1 rounded-xl bg-amber-100 text-blue-950 font-display font-black text-xs uppercase tracking-wider border border-amber-300">
                                🎯 Khusus Siswa SD Kelas 6
                            </span>
                            <h3 class="font-display font-black text-2xl text-blue-950 mt-1">
                                Kuota Terbatas (90 Siswa per Sesi)
                            </h3>
                        </div>

                        <!-- 3 Materi Bullet Points (Matching Poster) -->
                        <ul class="space-y-3 font-display font-bold text-slate-800 text-sm sm:text-base">
                            <li class="flex items-center gap-3">
                                <span class="w-3.5 h-3.5 rounded-full bg-blue-950 shrink-0"></span>
                                <span>Coding dan Praktik Membuat Game (Block Programming)</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="w-3.5 h-3.5 rounded-full bg-blue-950 shrink-0"></span>
                                <span>Pemanfaatan A.I. untuk Belajar Cerdas</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="w-3.5 h-3.5 rounded-full bg-blue-950 shrink-0"></span>
                                <span>Keamanan dan Etika Digital *</span>
                            </li>
                        </ul>

                        <!-- Google Interland Note (Key Highlight from poster) -->
                        <div class="mt-3 text-xs font-bold text-blue-900 bg-amber-50 p-2.5 rounded-xl border border-amber-200">
                            * Mendapatkan E-Sertifikat Resmi &amp; <strong>Sertifikat Google Interland</strong>
                        </div>

                        <!-- Date & Location Box (Orange box like poster) -->
                        <div class="mt-5 p-4 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 text-white shadow-md">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs sm:text-sm">
                                <div>
                                    <span class="text-white/80 text-[11px] font-black uppercase tracking-wider block">Waktu Pelaksanaan:</span>
                                    <strong class="font-display font-black text-base">{{ $eventDate }}</strong>
                                    <span class="block text-white/90 text-xs font-semibold">2 Sesi: Pagi (08:00) &amp; Siang (12:30)</span>
                                </div>
                                <div class="border-t sm:border-t-0 sm:border-l border-white/30 sm:pl-3 pt-2 sm:pt-0">
                                    <span class="text-white/80 text-[11px] font-black uppercase tracking-wider block">Lokasi Laboratorium:</span>
                                    <strong class="font-display font-black text-sm">Lab TIK 1 &amp; Lab TIK 3</strong>
                                    <span class="block text-white/90 text-xs font-medium">Lantai 3 Gedung Selatan, SMP Muhammadiyah 1 Yogyakarta</span>
                                </div>
                            </div>
                        </div>

                        <!-- CTA Button on Card -->
                        <div class="mt-6 flex flex-col sm:flex-row items-center gap-3">
                            <a href="#pendaftaran" class="w-full sm:w-auto flex-grow text-center py-3.5 px-6 font-display font-black text-base sm:text-lg text-white bg-blue-950 hover:bg-blue-900 rounded-2xl shadow-lg transition-all hover:scale-[1.02]">
                                DAFTAR SEKARANG &rarr;
                            </a>
                            <button type="button" onclick="openTicketSearchModal()" class="w-full sm:w-auto py-3.5 px-4 font-bold text-xs text-blue-950 bg-amber-100 hover:bg-amber-200 rounded-2xl border-2 border-amber-300 transition-colors">
                                Cek Pembagian Sesi
                            </button>
                        </div>

                    </div>

                </div>

                <!-- RIGHT COLUMN (5 cols): Kid Coder Graphic & Social Proof -->
                <div class="lg:col-span-5 flex flex-col items-center">
                    
                    <!-- Cute Kid Coder Character SVG Container -->
                    <div class="w-full max-w-sm bg-white/90 backdrop-blur-xs rounded-3xl p-6 border-4 border-blue-950 shadow-xl text-center relative">
                        
                        <!-- Illustration SVG (Cute Boy at Computer like the poster) -->
                        <div class="w-48 h-48 mx-auto relative flex items-center justify-center">
                            <svg class="w-full h-full" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Desk -->
                                <rect x="20" y="160" width="160" height="12" rx="4" fill="#0b2347"/>
                                <rect x="35" y="172" width="10" height="28" fill="#0b2347"/>
                                <rect x="155" y="172" width="10" height="28" fill="#0b2347"/>
                                <!-- Computer Monitor -->
                                <rect x="70" y="70" width="90" height="65" rx="6" fill="#e2e8f0" stroke="#0b2347" stroke-width="4"/>
                                <rect x="76" y="76" width="78" height="50" rx="3" fill="#38bdf8"/>
                                <!-- Code blocks on screen -->
                                <rect x="82" y="84" width="30" height="6" rx="2" fill="#facc15"/>
                                <rect x="82" y="94" width="45" height="6" rx="2" fill="#4ade80"/>
                                <rect x="82" y="104" width="38" height="6" rx="2" fill="#fb7185"/>
                                <!-- Monitor Stand -->
                                <rect x="110" y="135" width="10" height="18" fill="#94a3b8"/>
                                <ellipse cx="115" cy="155" rx="22" ry="5" fill="#cbd5e1" stroke="#0b2347" stroke-width="2"/>
                                <!-- Keyboard & Mouse -->
                                <rect x="75" y="152" width="45" height="6" rx="2" fill="#f1f5f9" stroke="#64748b" stroke-width="1.5"/>
                                <ellipse cx="135" cy="155" rx="6" ry="4" fill="#f1f5f9" stroke="#64748b" stroke-width="1.5"/>
                                <!-- Pencil Holder with red polka dots -->
                                <rect x="52" y="132" width="16" height="22" rx="3" fill="#ef4444"/>
                                <circle cx="56" cy="138" r="1.5" fill="#fff"/>
                                <circle cx="62" cy="144" r="1.5" fill="#fff"/>
                                <circle cx="57" cy="149" r="1.5" fill="#fff"/>
                                <line x1="56" y1="124" x2="58" y2="132" stroke="#f59e0b" stroke-width="2" stroke-linecap="round"/>
                                <line x1="62" y1="122" x2="60" y2="132" stroke="#3b82f6" stroke-width="2" stroke-linecap="round"/>
                                <!-- Happy Coder Kid (boy in red shirt) -->
                                <circle cx="45" cy="85" r="22" fill="#fbcfe8"/>
                                <!-- Hair -->
                                <path d="M25 80C25 65 35 55 52 55C65 55 72 65 70 80C60 76 50 75 40 78Z" fill="#1e293b"/>
                                <!-- Smile & Eyes -->
                                <circle cx="48" cy="85" r="2.5" fill="#0f172a"/>
                                <path d="M42 94C45 98 52 98 55 94" stroke="#0f172a" stroke-width="2" stroke-linecap="round"/>
                                <!-- Red Shirt Body -->
                                <path d="M25 107C25 105 32 103 45 103C58 103 65 105 65 107L68 155H22L25 107Z" fill="#ef4444"/>
                                <!-- Arm on chin (curious pose like poster) -->
                                <path d="M38 120L45 100" stroke="#fbcfe8" stroke-width="6" stroke-linecap="round"/>
                            </svg>
                        </div>

                        <h4 class="font-display font-black text-lg text-blue-950 mt-1">
                            "Serunya Bikin Game Sendiri!"
                        </h4>
                        <p class="text-xs text-slate-600 font-medium mt-1 leading-relaxed">
                            Dipandu mentor yang ramah &amp; asyik. Belajar coding visual blok seperti bermain lego di komputer!
                        </p>

                        <!-- Previous Agenda Social Proof Badge -->
                        <div class="mt-4 p-3 rounded-2xl bg-amber-50 border border-amber-200 text-left flex items-start gap-2.5">
                            <span class="text-lg">📢</span>
                            <p class="text-[11px] text-blue-950 leading-snug font-semibold">
                                <strong>Kilas Balik:</strong> Pada agenda sebelumnya, pendaftar membludak hingga 2x lipat kapasitas! Segera daftarkan ananda sebelum kuota penuh.
                            </p>
                        </div>

                    </div>

                </div>

            </div>

            <!-- LIVE QUOTA CARDS (Sesi 1 & Sesi 2) -->
            <div class="mt-14 max-w-5xl mx-auto">
                <div class="text-center mb-6">
                    <span class="font-display font-black text-xs uppercase tracking-widest text-blue-950 bg-white/70 px-4 py-1.5 rounded-full border border-blue-950">
                        MONITORING KUOTA REAL-TIME (90 SISWA / SESI)
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- SESI 1 CARD -->
                    <div class="bg-white rounded-3xl p-6 border-4 border-blue-950 shadow-xl relative">
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <div>
                                <span class="text-xs font-black uppercase tracking-wider text-blue-900 bg-blue-100 px-2.5 py-0.5 rounded-md">
                                    ☀️ SESI 1 (PAGI)
                                </span>
                                <h3 class="font-display font-black text-xl text-blue-950 mt-1">{{ $s1Name }}</h3>
                                <p class="font-mono font-bold text-xs text-slate-600">⏰ {{ $s1Time }}</p>
                            </div>
                            <div class="text-right">
                                @if($s1RemainingMain > 0)
                                    <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        Tersedia
                                    </span>
                                @elseif($s1RemainingWaitlist > 0)
                                    <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-100 text-amber-800 border border-amber-300">
                                        Cadangan
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">Penuh</span>
                                @endif
                            </div>
                        </div>

                        <!-- Progress Bar Sesi 1 -->
                        <div class="space-y-1.5 mt-4">
                            <div class="flex justify-between text-xs font-bold text-slate-600">
                                <span>Kursi Utama Terisi: <strong class="text-blue-900">{{ $s1MainCount }}</strong> / {{ $s1Max }}</span>
                                <span class="font-black text-emerald-700">{{ $s1RemainingMain }} Kursi Sisa</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-4 overflow-hidden p-0.5 border-2 border-slate-300">
                                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 h-full rounded-full transition-all duration-500" style="width: {{ $s1Percent }}%"></div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <span>Antrean Cadangan: <strong>{{ $s1WaitlistCount }}</strong> / {{ $s1WaitlistMax }}</span>
                            <a href="#pendaftaran" onclick="selectSession('1')" class="font-display font-black text-blue-900 hover:text-blue-700 flex items-center gap-1">
                                Pilih Sesi 1 &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- SESI 2 CARD -->
                    <div class="bg-white rounded-3xl p-6 border-4 border-blue-950 shadow-xl relative">
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <div>
                                <span class="text-xs font-black uppercase tracking-wider text-purple-900 bg-purple-100 px-2.5 py-0.5 rounded-md">
                                    🌤️ SESI 2 (SIANG)
                                </span>
                                <h3 class="font-display font-black text-xl text-blue-950 mt-1">{{ $s2Name }}</h3>
                                <p class="font-mono font-bold text-xs text-slate-600">⏰ {{ $s2Time }}</p>
                            </div>
                            <div class="text-right">
                                @if($s2RemainingMain > 0)
                                    <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        Tersedia
                                    </span>
                                @elseif($s2RemainingWaitlist > 0)
                                    <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-100 text-amber-800 border border-amber-300">
                                        Cadangan
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-600">Penuh</span>
                                @endif
                            </div>
                        </div>

                        <!-- Progress Bar Sesi 2 -->
                        <div class="space-y-1.5 mt-4">
                            <div class="flex justify-between text-xs font-bold text-slate-600">
                                <span>Kursi Utama Terisi: <strong class="text-purple-900">{{ $s2MainCount }}</strong> / {{ $s2Max }}</span>
                                <span class="font-black text-emerald-700">{{ $s2RemainingMain }} Kursi Sisa</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-4 overflow-hidden p-0.5 border-2 border-slate-300">
                                <div class="bg-gradient-to-r from-purple-600 to-pink-600 h-full rounded-full transition-all duration-500" style="width: {{ $s2Percent }}%"></div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <span>Antrean Cadangan: <strong>{{ $s2WaitlistCount }}</strong> / {{ $s2WaitlistMax }}</span>
                            <a href="#pendaftaran" onclick="selectSession('2')" class="font-display font-black text-purple-900 hover:text-purple-700 flex items-center gap-1">
                                Pilih Sesi 2 &rarr;
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- Section: 3 Materi Utama Kegiatan -->
    <section id="materi" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="font-display font-black text-xs uppercase tracking-widest text-blue-900 bg-amber-100 px-3.5 py-1.5 rounded-full border border-amber-300">
                    MATERI &amp; KURIKULUM WORKSHOP
                </span>
                <h2 class="mt-3 font-display font-black text-3xl sm:text-5xl text-blue-950 tracking-tight">
                    3 Hal Hebat yang Dipelajari Siswa
                </h2>
                <p class="mt-3 text-slate-600 text-sm sm:text-base leading-relaxed">
                    Dirancang aplikatif dan ramah anak kelas 6 SD oleh instruktur SMP Muhammadiyah 1 Yogyakarta agar anak siap menjadi kreator teknologi yang cerdas dan berkarakter.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1: Coding dan Praktik membuat Game -->
                <div class="rounded-3xl p-8 bg-blue-50/50 border-3 border-blue-900 shadow-md hover:shadow-xl transition-all">
                    <div class="w-16 h-16 rounded-2xl bg-blue-900 text-white flex items-center justify-center text-3xl mb-6 shadow-md shadow-blue-900/30">
                        🎮
                    </div>
                    <span class="font-display font-black text-xs text-blue-700 uppercase tracking-wider block mb-1">MATERI 1</span>
                    <h3 class="font-display font-black text-xl text-blue-950 mb-3">Coding dan Praktik Membuat Game</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Mempelajari logika komputasi dasar dan algoritma melalui visual block coding (Scratch/Blockly). Siswa langsung merakit game komputer interaktif karyanya sendiri: mengontrol karakter, merancang level rintangan, animasi, dan sistem skor.
                    </p>
                </div>

                <!-- Card 2: Pemanfaatan A.I. untuk belajar -->
                <div class="rounded-3xl p-8 bg-purple-50/50 border-3 border-purple-900 shadow-md hover:shadow-xl transition-all">
                    <div class="w-16 h-16 rounded-2xl bg-purple-900 text-white flex items-center justify-center text-3xl mb-6 shadow-md shadow-purple-900/30">
                        🤖
                    </div>
                    <span class="font-display font-black text-xs text-purple-700 uppercase tracking-wider block mb-1">MATERI 2</span>
                    <h3 class="font-display font-black text-xl text-purple-950 mb-3">Pemanfaatan A.I. untuk Belajar</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Mengenal konsep Artificial Intelligence dengan pendekatan ramah anak. Siswa mempraktikkan A.I. sebagai sahabat belajar pintar: membantu memahami konsep pelajaran sekolah, brainstorming ide sains kreatif, dan melatih nalar kritis tanpa ketergantungan pasif.
                    </p>
                </div>

                <!-- Card 3: Keamanan dan Etika Digital -->
                <div class="rounded-3xl p-8 bg-emerald-50/50 border-3 border-emerald-900 shadow-md hover:shadow-xl transition-all">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-800 text-white flex items-center justify-center text-3xl mb-6 shadow-md shadow-emerald-900/30">
                        🛡️
                    </div>
                    <span class="font-display font-black text-xs text-emerald-800 uppercase tracking-wider block mb-1">MATERI 3</span>
                    <h3 class="font-display font-black text-xl text-emerald-950 mb-3">Keamanan dan Etika Digital</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Membekali siswa dengan pemahaman <em>cyber safety</em>: menjaga kerahasiaan data pribadi, bersikap santun saat online, serta cerdas membedakan informasi fakta vs hoax. <span class="font-bold text-emerald-800">*Mendapatkan sertifikat Google Interland</span>.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Rundown Kegiatan (Tabbed Sesi 1 vs Sesi 2) -->
    <section id="rundown" class="py-20 bg-amber-50/50 border-y-2 border-amber-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span class="font-display font-black text-xs uppercase tracking-widest text-blue-900 bg-white px-4 py-1.5 rounded-full border border-blue-950">
                    JADWAL RUNDOWN LENGKAP
                </span>
                <h2 class="mt-3 font-display font-black text-3xl sm:text-5xl text-blue-950 tracking-tight">
                    Rundown Acara per Sesi
                </h2>
                <p class="mt-2 text-slate-600 text-sm sm:text-base">
                    Senin, 21 Desember 2026 &bull; Laboratorium Komputer SMP Muhammadiyah 1 Yogyakarta
                </p>

                <!-- Rundown Tab Switcher -->
                <div class="mt-8 inline-flex p-1.5 rounded-2xl bg-white border-2 border-blue-950 max-w-md w-full shadow-md">
                    <button type="button" onclick="switchRundown('1')" id="tabBtn1" class="w-1/2 py-2.5 rounded-xl font-display font-black text-xs sm:text-sm transition-all bg-blue-950 text-white shadow-xs">
                        ☀️ Sesi 1 (08:00 – 10:30)
                    </button>
                    <button type="button" onclick="switchRundown('2')" id="tabBtn2" class="w-1/2 py-2.5 rounded-xl font-display font-black text-xs sm:text-sm transition-all text-slate-600 hover:text-blue-950">
                        🌤️ Sesi 2 (12:30 – 14:00)
                    </button>
                </div>
            </div>

            <!-- RUNDOWN SESI 1 CONTENT -->
            <div id="rundownSesi1" class="space-y-3.5 transition-all">
                <div class="bg-white p-5 rounded-2xl border-2 border-slate-200 shadow-xs flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-slate-100 font-mono font-black text-xs text-slate-800 shrink-0">07:30 – 08:00</span>
                        <div>
                            <h4 class="font-display font-black text-slate-900 text-sm">Registrasi Ulang &amp; Pengambilan Name Tag</h4>
                            <p class="text-xs text-slate-500">Check-in barcode E-Ticket, pembagian Name Tag dan snack pagi di Lab TIK 1 &amp; Lab TIK 3.</p>
                        </div>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 shrink-0">30 Menit</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border-l-6 border-l-blue-900 border-2 border-slate-200 shadow-xs flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-blue-100 font-mono font-black text-xs text-blue-900 shrink-0">08:00 – 09:15</span>
                        <div>
                            <h4 class="font-display font-black text-slate-900 text-sm">Modul 1: Coding &amp; Praktik Membuat Game</h4>
                            <p class="text-xs text-slate-500">Logika sekuensial, algoritma visual Scratch, dan merakit game interaktif perdana.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-blue-900 shrink-0">75 Menit</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border-2 border-slate-200 shadow-xs flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-amber-100 font-mono font-black text-xs text-amber-800 shrink-0">09:15 – 09:30</span>
                        <div>
                            <h4 class="font-display font-black text-slate-900 text-sm">Snack Break &amp; Fun Quiz 🍪</h4>
                            <p class="text-xs text-slate-500">Waktu istirahat, snack lezat, kuis seru berhadiah, dan networking teman baru.</p>
                        </div>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 shrink-0">15 Menit</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border-l-6 border-l-purple-900 border-2 border-slate-200 shadow-xs flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-purple-100 font-mono font-black text-xs text-purple-900 shrink-0">09:30 – 10:05</span>
                        <div>
                            <h4 class="font-display font-black text-slate-900 text-sm">Modul 2: Pemanfaatan A.I. untuk Belajar</h4>
                            <p class="text-xs text-slate-500">Eksplorasi kecerdasan buatan, prompt cilik, dan praktik A.I. sebagai sahabat belajar pintar.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-purple-900 shrink-0">35 Menit</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border-l-6 border-l-emerald-800 border-2 border-slate-200 shadow-xs flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-emerald-100 font-mono font-black text-xs text-emerald-900 shrink-0">10:05 – 10:30</span>
                        <div>
                            <h4 class="font-display font-black text-slate-900 text-sm">Modul 3: Keamanan &amp; Etika Digital + Showcase 🎓</h4>
                            <p class="text-xs text-slate-500">Cyber safety, Google Interland, pameran hasil karya game, dan penyerahan sertifikat.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-emerald-800 shrink-0">25 Menit</span>
                </div>
            </div>

            <!-- RUNDOWN SESI 2 CONTENT -->
            <div id="rundownSesi2" class="space-y-3.5 hidden transition-all">
                <div class="bg-white p-5 rounded-2xl border-2 border-slate-200 shadow-xs flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-slate-100 font-mono font-black text-xs text-slate-800 shrink-0">12:00 – 12:30</span>
                        <div>
                            <h4 class="font-display font-black text-slate-900 text-sm">Registrasi Ulang Sesi 2 &amp; Welcome Drink</h4>
                            <p class="text-xs text-slate-500">Check-in barcode E-Ticket, pengambilan Name Tag dan persiapan laptop di Lab TIK.</p>
                        </div>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 shrink-0">30 Menit</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border-l-6 border-l-blue-900 border-2 border-slate-200 shadow-xs flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-blue-100 font-mono font-black text-xs text-blue-900 shrink-0">12:30 – 13:15</span>
                        <div>
                            <h4 class="font-display font-black text-slate-900 text-sm">Modul 1: Coding &amp; Praktik Membuat Game</h4>
                            <p class="text-xs text-slate-500">Mempelajari logika pemrograman visual Scratch dan merakit game kreasi mandiri.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-blue-900 shrink-0">45 Menit</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border-l-6 border-l-purple-900 border-2 border-slate-200 shadow-xs flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-purple-100 font-mono font-black text-xs text-purple-900 shrink-0">13:15 – 13:40</span>
                        <div>
                            <h4 class="font-display font-black text-slate-900 text-sm">Modul 2: Pemanfaatan A.I. untuk Belajar</h4>
                            <p class="text-xs text-slate-500">Praktik menggunakan A.I. sebagai mitra belajar cerdas, eksplorasi ide sains &amp; nalar kreatif.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-purple-900 shrink-0">25 Menit</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border-l-6 border-l-emerald-800 border-2 border-slate-200 shadow-xs flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-emerald-100 font-mono font-black text-xs text-emerald-900 shrink-0">13:40 – 14:00</span>
                        <div>
                            <h4 class="font-display font-black text-slate-900 text-sm">Modul 3: Keamanan &amp; Etika Digital + Penutup 🎓</h4>
                            <p class="text-xs text-slate-500">Etika digital, Google Interland, showcase game karya siswa &amp; penyerahan sertifikat.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-emerald-800 shrink-0">20 Menit</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Detail Lokasi Laboratorium (Lab TIK 1 & 3 Lantai 3 Gedung Selatan) -->
    <section id="lokasi" class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-blue-950 text-white rounded-3xl p-8 sm:p-12 relative overflow-hidden border-4 border-amber-400">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div>
                        <span class="font-display font-black text-xs text-amber-400 uppercase tracking-widest bg-blue-900 px-3 py-1 rounded-full">
                            LOKASI ACARA
                        </span>
                        <h3 class="font-display font-black text-2xl sm:text-3xl text-white mt-2 leading-tight">
                            Laboratorium Komputer SMP Muhammadiyah 1 Yogyakarta
                        </h3>
                        <p class="mt-3 text-slate-300 text-xs sm:text-sm leading-relaxed">
                            Kegiatan diselenggarakan di <strong>Lab TIK 1 dan Lab TIK 3 (Lantai 3 Gedung Selatan)</strong> dengan fasilitas ber-AC, proyektor interaktif, dan koneksi internet stabil.
                        </p>
                    </div>

                    <div class="bg-blue-900/60 p-6 rounded-2xl border border-blue-800 space-y-3 text-xs sm:text-sm">
                        <div class="flex items-start gap-2.5">
                            <span class="text-base">📍</span>
                            <span><strong>Alamat:</strong> Jl. Purwodiningratan NG I/902, Ngampilan, Kota Yogyakarta, D.I. Yogyakarta 55261</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <span class="text-base">💻</span>
                            <span><strong>Perlengkapan:</strong> Siswa disarankan membawa laptop pribadi + charger (Windows / Mac / Chromebook).</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <span class="text-base">📜</span>
                            <span><strong>Fasilitas Peserta:</strong> Snack box, modul panduan, E-Sertifikat resmi &amp; Sertifikat Google Interland.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Formulir Pendaftaran Interaktif -->
    <section id="pendaftaran" class="py-20 bg-gradient-to-b from-amber-50 to-white border-t-2 border-amber-200">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <span class="font-display font-black text-xs uppercase tracking-widest text-blue-950 bg-amber-200 px-4 py-1.5 rounded-full border border-amber-400">
                    FORMULIR PENDAFTARAN RESMI
                </span>
                <h2 class="mt-3 font-display font-black text-3xl sm:text-5xl text-blue-950 tracking-tight">
                    Pilih Sesi &amp; Amankan Kursimu
                </h2>
                <p class="mt-2 text-slate-600 text-sm sm:text-base">
                    Mohon diisi dengan lengkap dan teliti oleh <strong>Orang Tua / Wali Siswa</strong>.
                </p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-2xl border-4 border-blue-950 relative">
                
                @if(!$isGlobalOpen)
                    <div class="text-center py-12">
                        <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-3xl mx-auto mb-4">
                            🔒
                        </div>
                        <h3 class="font-display font-black text-xl text-slate-800">Pendaftaran Telah Ditutup</h3>
                        <p class="text-slate-500 text-sm max-w-md mx-auto mt-2">
                            Seluruh kuota utama dan antrean cadangan untuk Sesi 1 dan Sesi 2 telah terpenuhi. Silakan hubungi panitia untuk informasi ketersediaan.
                        </p>
                    </div>
                @else
                    <form action="{{ route('register.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- PILIHAN SESI (Radio Cards Interaktif) -->
                        <div>
                            <label class="block font-display font-black text-xs uppercase tracking-wider text-blue-950 mb-3">
                                Langkah 1: Pilih Sesi Kegiatan <span class="text-rose-500">*</span>
                            </label>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Option Sesi 1 -->
                                <label class="session-card relative p-5 rounded-2xl border-3 cursor-pointer transition-all flex flex-col justify-between {{ old('session', '1') === '1' ? 'border-blue-950 bg-blue-50/60 shadow-md ring-2 ring-blue-900/20' : 'border-slate-200 hover:border-blue-300' }}" id="sessionCard1">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-center gap-2.5">
                                            <input type="radio" name="session" value="1" id="radioSession1" {{ old('session', '1') === '1' ? 'checked' : '' }} onchange="onSessionChange('1')" class="w-4 h-4 text-blue-950 focus:ring-blue-900">
                                            <div>
                                                <span class="block font-display font-black text-blue-950 text-base">{{ $s1Name }}</span>
                                                <span class="block text-xs font-mono font-bold text-blue-800">⏰ {{ $s1Time }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-3 border-t border-slate-200 flex items-center justify-between text-xs">
                                        <span class="text-slate-500 font-semibold">Sisa Kursi:</span>
                                        @if($s1RemainingMain > 0)
                                            <span class="font-display font-black text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-md">
                                                {{ $s1RemainingMain }} Kursi Utama
                                            </span>
                                        @elseif($s1RemainingWaitlist > 0)
                                            <span class="font-display font-black text-amber-700 bg-amber-100 px-2 py-0.5 rounded-md">
                                                Jalur Cadangan (#{{ $s1WaitlistCount + 1 }})
                                            </span>
                                        @else
                                            <span class="font-bold text-rose-600 bg-rose-100 px-2 py-0.5 rounded-md">Penuh</span>
                                        @endif
                                    </div>
                                </label>

                                <!-- Option Sesi 2 -->
                                <label class="session-card relative p-5 rounded-2xl border-3 cursor-pointer transition-all flex flex-col justify-between {{ old('session') === '2' ? 'border-purple-900 bg-purple-50/60 shadow-md ring-2 ring-purple-900/20' : 'border-slate-200 hover:border-purple-300' }}" id="sessionCard2">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-center gap-2.5">
                                            <input type="radio" name="session" value="2" id="radioSession2" {{ old('session') === '2' ? 'checked' : '' }} onchange="onSessionChange('2')" class="w-4 h-4 text-purple-900 focus:ring-purple-900">
                                            <div>
                                                <span class="block font-display font-black text-purple-950 text-base">{{ $s2Name }}</span>
                                                <span class="block text-xs font-mono font-bold text-purple-800">⏰ {{ $s2Time }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-3 border-t border-slate-200 flex items-center justify-between text-xs">
                                        <span class="text-slate-500 font-semibold">Sisa Kursi:</span>
                                        @if($s2RemainingMain > 0)
                                            <span class="font-display font-black text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-md">
                                                {{ $s2RemainingMain }} Kursi Utama
                                            </span>
                                        @elseif($s2RemainingWaitlist > 0)
                                            <span class="font-display font-black text-amber-700 bg-amber-100 px-2 py-0.5 rounded-md">
                                                Jalur Cadangan (#{{ $s2WaitlistCount + 1 }})
                                            </span>
                                        @else
                                            <span class="font-bold text-rose-600 bg-rose-100 px-2 py-0.5 rounded-md">Penuh</span>
                                        @endif
                                    </div>
                                </label>
                            </div>
                            @error('session') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- DATA SISWA -->
                        <div class="pt-2">
                            <label class="block font-display font-black text-xs uppercase tracking-wider text-blue-950 mb-3">
                                Langkah 2: Data Siswa (Peserta SD Kelas 6) <span class="text-rose-500">*</span>
                            </label>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Siswa <span class="text-rose-500">*</span></label>
                                    <input type="text" name="student_name" value="{{ old('student_name') }}" required placeholder="Contoh: Muhammad Rizky Pratama" class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('student_name') ? 'border-rose-400' : 'border-slate-300' }} text-sm focus:ring-2 focus:ring-blue-900 outline-none">
                                    @error('student_name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Panggilan <span class="text-slate-400 font-normal">(untuk Name Tag)</span> <span class="text-rose-500">*</span></label>
                                    <input type="text" name="nickname" value="{{ old('nickname') }}" required placeholder="Contoh: Rizky" class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('nickname') ? 'border-rose-400' : 'border-slate-300' }} text-sm focus:ring-2 focus:ring-blue-900 outline-none">
                                    @error('nickname') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Jenis Kelamin <span class="text-rose-500">*</span></label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50">
                                            <input type="radio" name="gender" value="L" {{ old('gender', 'L') === 'L' ? 'checked' : '' }} class="text-blue-900 focus:ring-blue-900">
                                            <span class="text-xs font-semibold text-slate-700">Laki-laki</span>
                                        </label>
                                        <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50">
                                            <input type="radio" name="gender" value="P" {{ old('gender') === 'P' ? 'checked' : '' }} class="text-blue-900 focus:ring-blue-900">
                                            <span class="text-xs font-semibold text-slate-700">Perempuan</span>
                                        </label>
                                    </div>
                                    @error('gender') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Asal Sekolah (SD/MI) <span class="text-rose-500">*</span></label>
                                    <input type="text" name="school_name" value="{{ old('school_name') }}" required placeholder="Contoh: SD Muhammadiyah Sukonandi" class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('school_name') ? 'border-rose-400' : 'border-slate-300' }} text-sm focus:ring-2 focus:ring-blue-900 outline-none">
                                    @error('school_name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Pengalaman Coding / Menggunakan Komputer <span class="text-rose-500">*</span></label>
                                    <select name="experience_level" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-900 outline-none bg-white">
                                        <option value="Belum Pernah" {{ old('experience_level') === 'Belum Pernah' ? 'selected' : '' }}>Belum Pernah (Pemula sama sekali - Sangat Disambut!)</option>
                                        <option value="Pernah Sedikit" {{ old('experience_level') === 'Pernah Sedikit' ? 'selected' : '' }}>Pernah Sedikit (Pernah coba Scratch / game edukasi)</option>
                                        <option value="Sudah Terbiasa" {{ old('experience_level') === 'Sudah Terbiasa' ? 'selected' : '' }}>Sudah Terbiasa (Sering menggunakan laptop di rumah)</option>
                                    </select>
                                    @error('experience_level') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- DATA ORANG TUA -->
                        <div class="pt-2">
                            <label class="block font-display font-black text-xs uppercase tracking-wider text-blue-950 mb-3">
                                Langkah 3: Data Orang Tua / Wali Siswa <span class="text-rose-500">*</span>
                            </label>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Orang Tua / Wali <span class="text-rose-500">*</span></label>
                                    <input type="text" name="parent_name" value="{{ old('parent_name') }}" required placeholder="Contoh: Budi Pratama" class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('parent_name') ? 'border-rose-400' : 'border-slate-300' }} text-sm focus:ring-2 focus:ring-blue-900 outline-none">
                                    @error('parent_name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp Aktif <span class="text-rose-500">*</span></label>
                                    <input type="tel" name="whatsapp" value="{{ old('whatsapp') }}" required placeholder="Contoh: 08123456789" class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('whatsapp') ? 'border-rose-400' : 'border-slate-300' }} text-sm focus:ring-2 focus:ring-blue-900 outline-none">
                                    <span class="text-[11px] text-slate-400 mt-1 block">Tiket dan info grup koordinasi akan dikirimkan ke nomor ini.</span>
                                    @error('whatsapp') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Email <span class="text-slate-400 font-normal">(Opsional)</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Contoh: budi@gmail.com" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-900 outline-none">
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Catatan Tambahan untuk Panitia <span class="text-slate-400 font-normal">(Opsional)</span></label>
                                    <textarea name="notes" rows="2" placeholder="Contoh: Ananda membawa laptop pribadi..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-blue-900 outline-none">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- PERSETUJUAN -->
                        <div class="pt-2 space-y-3 bg-amber-50/70 p-4 rounded-2xl border-2 border-amber-200">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" name="terms_agreement" value="1" {{ old('terms_agreement') ? 'checked' : '' }} required class="mt-1 w-4 h-4 text-blue-900 rounded border-slate-300 focus:ring-blue-900">
                                <span class="text-xs text-slate-700 leading-relaxed font-medium">
                                    Saya menyatakan data yang diisi adalah benar dan mengizinkan putra/putri saya untuk mengikuti kegiatan workshop ini di Laboratorium Komputer SMP Muhammadiyah 1 Yogyakarta. <span class="text-rose-500">*</span>
                                </span>
                            </label>
                            @error('terms_agreement') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror

                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" name="waitlist_agreement" value="1" {{ old('waitlist_agreement') ? 'checked' : '' }} required class="mt-1 w-4 h-4 text-blue-900 rounded border-slate-300 focus:ring-blue-900">
                                <span class="text-xs text-slate-700 leading-relaxed font-medium">
                                    Saya memahami bahwa setiap sesi dibatasi 90 peserta utama. Jika kuota 90 kursi pada sesi yang saya pilih penuh, pendaftar akan masuk ke antrean cadangan dan dihubungi panitia jika ada kursi kosong. <span class="text-rose-500">*</span>
                                </span>
                            </label>
                            @error('waitlist_agreement') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- TOMBOL SUBMIT -->
                        <div class="pt-2">
                            <button type="submit" class="w-full py-4 px-6 text-base sm:text-lg font-display font-black text-white bg-blue-950 hover:bg-blue-900 rounded-2xl shadow-xl transition-all flex items-center justify-center gap-2">
                                <span>KIRIM PENDAFTARAN &amp; AMBIL E-TICKET</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </button>
                            <p class="text-center text-xs text-slate-500 mt-2 font-semibold">100% Gratis &bull; Mendapatkan E-Ticket Resmi &amp; Sertifikat Google Interland</p>
                        </div>
                    </form>
                @endif

            </div>
        </div>
    </section>

    <!-- Section: FAQ -->
    <section id="faq" class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="font-display font-black text-xs uppercase tracking-widest text-blue-900 bg-amber-100 px-3.5 py-1.5 rounded-full border border-amber-300">
                    PUSAT BANTUAN
                </span>
                <h2 class="mt-3 font-display font-black text-3xl sm:text-5xl text-blue-950 tracking-tight">
                    Pertanyaan yang Sering Diajukan
                </h2>
            </div>

            <div class="space-y-4">
                <details class="group bg-slate-50 p-6 rounded-2xl border-2 border-slate-200 transition-all [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex items-center justify-between cursor-pointer font-display font-black text-slate-900 text-sm sm:text-base">
                        <span>Apa perbedaan antara Sesi 1 dan Sesi 2?</span>
                        <span class="w-7 h-7 rounded-full bg-white flex items-center justify-center text-blue-950 group-open:rotate-180 transition-transform">▾</span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Materi pembelajaran inti keduanya sama persis (Block Programming Game, A.I. for Learning, dan Keamanan Digital Google Interland). Perbedaannya terletak pada waktu: <strong>Sesi 1 berlangsung pukul 08:00 – 10:30 WIB</strong>, sedangkan <strong>Sesi 2 berlangsung pukul 12:30 – 14:00 WIB</strong>. Orang tua bebas memilih sesi yang paling nyaman.
                    </p>
                </details>

                <details class="group bg-slate-50 p-6 rounded-2xl border-2 border-slate-200 transition-all [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex items-center justify-between cursor-pointer font-display font-black text-slate-900 text-sm sm:text-base">
                        <span>Apakah siswa wajib membawa laptop sendiri?</span>
                        <span class="w-7 h-7 rounded-full bg-white flex items-center justify-center text-blue-950 group-open:rotate-180 transition-transform">▾</span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Laboratorium TIK SMP Muhammadiyah 1 Yogyakarta menyediakan perangkat komputer, namun siswa disarankan membawa laptop pribadi + charger masing-masing agar karya game dan proyek A.I. yang dibuat dapat langsung disimpan dan dilanjutkan di rumah.
                    </p>
                </details>

                <details class="group bg-slate-50 p-6 rounded-2xl border-2 border-slate-200 transition-all [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex items-center justify-between cursor-pointer font-display font-black text-slate-900 text-sm sm:text-base">
                        <span>Apakah benar-benar 100% gratis?</span>
                        <span class="w-7 h-7 rounded-full bg-white flex items-center justify-center text-blue-950 group-open:rotate-180 transition-transform">▾</span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Benar! Kegiatan ini 100% GRATIS tanpa dipungut biaya apapun. Seluruh fasilitas workshop, snack box, modul, dan sertifikat resmi disediakan oleh Muhijunior ISS - SMP Muhammadiyah 1 Yogyakarta.
                    </p>
                </details>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    function switchRundown(session) {
        const s1 = document.getElementById('rundownSesi1');
        const s2 = document.getElementById('rundownSesi2');
        const b1 = document.getElementById('tabBtn1');
        const b2 = document.getElementById('tabBtn2');

        if (session === '1') {
            s1.classList.remove('hidden');
            s2.classList.add('hidden');
            b1.className = 'w-1/2 py-2.5 rounded-xl font-display font-black text-xs sm:text-sm transition-all bg-blue-950 text-white shadow-xs';
            b2.className = 'w-1/2 py-2.5 rounded-xl font-display font-black text-xs sm:text-sm transition-all text-slate-600 hover:text-blue-950';
        } else {
            s2.classList.remove('hidden');
            s1.classList.add('hidden');
            b2.className = 'w-1/2 py-2.5 rounded-xl font-display font-black text-xs sm:text-sm transition-all bg-purple-900 text-white shadow-xs';
            b1.className = 'w-1/2 py-2.5 rounded-xl font-display font-black text-xs sm:text-sm transition-all text-slate-600 hover:text-blue-950';
        }
    }

    function selectSession(session) {
        const radio1 = document.getElementById('radioSession1');
        const radio2 = document.getElementById('radioSession2');
        if (session === '1') {
            radio1.checked = true;
            onSessionChange('1');
        } else {
            radio2.checked = true;
            onSessionChange('2');
        }
    }

    function onSessionChange(session) {
        const card1 = document.getElementById('sessionCard1');
        const card2 = document.getElementById('sessionCard2');

        if (session === '1') {
            card1.className = 'session-card relative p-5 rounded-2xl border-3 cursor-pointer transition-all flex flex-col justify-between border-blue-950 bg-blue-50/60 shadow-md ring-2 ring-blue-900/20';
            card2.className = 'session-card relative p-5 rounded-2xl border-3 cursor-pointer transition-all flex flex-col justify-between border-slate-200 hover:border-purple-300';
        } else {
            card2.className = 'session-card relative p-5 rounded-2xl border-3 cursor-pointer transition-all flex flex-col justify-between border-purple-900 bg-purple-50/60 shadow-md ring-2 ring-purple-900/20';
            card1.className = 'session-card relative p-5 rounded-2xl border-3 cursor-pointer transition-all flex flex-col justify-between border-slate-200 hover:border-blue-300';
        }
    }
</script>
@endpush
