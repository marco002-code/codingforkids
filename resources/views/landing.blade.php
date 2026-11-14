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
            <div class="p-6 rounded-3xl bg-white border-3 border-blue-950 text-slate-900 shadow-xl">
                <h3 class="font-display font-black text-lg mb-3 flex items-center gap-2 text-blue-950">
                    <span>🎉</span> Ditemukan {{ count(session('search_results')) }} E-Ticket Siswa:
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach(session('search_results') as $found)
                        <div class="p-4 bg-amber-50 rounded-2xl border-2 border-amber-200 flex items-center justify-between">
                            <div>
                                <p class="font-black text-slate-900 text-sm">{{ $found->student_name }}</p>
                                <p class="text-xs text-slate-600 font-mono mt-0.5">
                                    {{ $found->reg_code }} &bull; 
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ $found->session === '1' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                        Sesi {{ $found->session }} ({{ $found->session_time }})
                                    </span>
                                </p>
                            </div>
                            <a href="{{ route('ticket.show', $found->reg_code) }}" class="btn-cartoon-blue px-4 py-2 text-xs font-black rounded-xl">
                                Buka Tiket &rarr;
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- HERO SECTION (Ekosistem Kartun, Robot Asisten & Block Programming Scratch Floating) -->
    <section class="relative pt-8 pb-20 overflow-hidden bg-hero-coding border-b-4 border-blue-950">
        
        <!-- Animated Doodles & Cartoon Atmosphere Background -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <!-- Cartoon Sun / Lightburst Glow -->
            <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-amber-300/40 blur-3xl"></div>
            <div class="absolute top-1/2 -right-24 w-96 h-96 rounded-full bg-yellow-300/30 blur-3xl"></div>
            
            <!-- Floating Cartoon Gears -->
            <div class="absolute top-12 left-10 text-blue-950/15 animate-spin-slow">
                <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 15.5A3.5 3.5 0 0 1 8.5 12 3.5 3.5 0 0 1 12 8.5a3.5 3.5 0 0 1 3.5 3.5 3.5 3.5 0 0 1-3.5 3.5m7.43-2.53c.04-.32.07-.64.07-.97 0-.33-.03-.66-.07-1l2.11-1.63c.19-.15.24-.42.12-.64l-2-3.46c-.12-.22-.39-.31-.61-.22l-2.49 1c-.52-.39-1.06-.73-1.69-.98l-.37-2.65A.506.506 0 0 0 14 2h-4c-.25 0-.46.18-.5.42l-.37 2.65c-.63.25-1.17.59-1.69.98l-2.49-1c-.22-.09-.49 0-.61.22l-2 3.46c-.13.22-.07.49.12.64L4.57 11c-.04.34-.07.67-.07 1 0 .33.03.65.07.97l-2.11 1.66c-.19.15-.25.42-.12.64l2 3.46c.12.22.39.3.61.22l2.49-1.01c.52.4 1.06.74 1.69.99l.37 2.65c.04.24.25.42.5.42h4c.25 0 .46-.18.5-.42l.37-2.65c.63-.26 1.17-.59 1.69-.99l2.49 1.01c.22.08.49 0 .61-.22l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.66Z"/></svg>
            </div>
            <div class="absolute bottom-16 right-12 text-blue-950/15 animate-spin-reverse">
                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 15.5A3.5 3.5 0 0 1 8.5 12 3.5 3.5 0 0 1 12 8.5a3.5 3.5 0 0 1 3.5 3.5 3.5 3.5 0 0 1-3.5 3.5m7.43-2.53c.04-.32.07-.64.07-.97 0-.33-.03-.66-.07-1l2.11-1.63c.19-.15.24-.42.12-.64l-2-3.46c-.12-.22-.39-.31-.61-.22l-2.49 1c-.52-.39-1.06-.73-1.69-.98l-.37-2.65A.506.506 0 0 0 14 2h-4c-.25 0-.46.18-.5.42l-.37 2.65c-.63.25-1.17.59-1.69.98l-2.49-1c-.22-.09-.49 0-.61.22l-2 3.46c-.13.22-.07.49.12.64L4.57 11c-.04.34-.07.67-.07 1 0 .33.03.65.07.97l-2.11 1.66c-.19.15-.25.42-.12.64l2 3.46c.12.22.39.3.61.22l2.49-1.01c.52.4 1.06.74 1.69.99l.37 2.65c.04.24.25.42.5.42h4c.25 0 .46-.18.5-.42l.37-2.65c.63-.26 1.17-.59 1.69-.99l2.49 1.01c.22.08.49 0 .61-.22l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.66Z"/></svg>
            </div>

            <!-- Floating Code Symbols -->
            <div class="absolute top-28 right-1/4 font-mono font-black text-2xl text-blue-950/20 select-none animate-float">&lt;code&gt;</div>
            <div class="absolute bottom-32 left-1/4 font-mono font-black text-3xl text-blue-950/20 select-none animate-float-reverse">&#123; A.I. &#125;</div>
            <div class="absolute top-44 left-1/3 text-3xl text-blue-950/25 select-none animate-float-gentle">⭐</div>
            <div class="absolute bottom-20 left-12 text-3xl text-blue-950/20 select-none">🎮</div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Poster Top Branding Bar (Matching Original Poster Layout) -->
            <div class="flex items-center justify-between gap-4 max-w-5xl mx-auto mb-6">
                <!-- Left: Official Muhijunior ISS Logo -->
                <div class="bg-white px-5 py-2.5 rounded-2xl border-3 border-blue-950 shadow-md">
                    <img src="{{ asset('images/logo-muhijunior-iss.png') }}" alt="Muhijunior ISS - School Of Creative People" class="h-10 sm:h-12 w-auto object-contain">
                </div>
                <!-- Right: Official SMP Muhammadiyah 1 Yogyakarta Crest -->
                <div class="inline-flex items-center gap-3 px-4 py-2 rounded-2xl bg-blue-950 text-white text-xs sm:text-sm font-black uppercase tracking-wider shadow-md border-3 border-amber-300">
                    <img src="{{ asset('images/logo-smp-muh1.png') }}" alt="SMP Muhammadiyah 1 Yogyakarta" class="h-9 w-9 object-contain rounded-full border border-amber-300">
                    <span>SMP Muhammadiyah 1 Yogyakarta</span>
                </div>
            </div>

            <!-- Main Hero Header -->
            <div class="text-center max-w-4xl mx-auto">
                <!-- Main Poster Heading (Fredoka Block Font) -->
                <h1 class="mt-2 font-display font-black text-5xl sm:text-7xl lg:text-8xl text-blue-950 tracking-tight leading-none drop-shadow-sm uppercase">
                    CODING FOR KIDS
                </h1>

                <p class="mt-3 font-display font-bold text-lg sm:text-2xl text-blue-950 max-w-3xl mx-auto leading-snug">
                    Belajar Block Programming, Pemanfaatan A.I. &amp; Keamanan Digital untuk Siswa SD
                </p>

                <!-- URL Badge (Matching the iconic green pill from poster) -->
                <div class="mt-4 inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-white border-3 border-blue-950 shadow-md">
                    <span class="w-7 h-7 rounded-full bg-emerald-500 text-white flex items-center justify-center font-black text-sm">@</span>
                    <span class="font-display font-black text-base sm:text-lg text-blue-950 tracking-wide">coding.muhijunior.id</span>
                </div>
            </div>

            <!-- FLOATING SCRATCH / BLOCK PROGRAMMING PIECES (Tampil di Desktop & Tablet) -->
            <div class="hidden md:flex justify-between items-center max-w-6xl mx-auto mt-6 px-4">
                <!-- Scratch Block Left: When Flag Clicked -->
                <div class="animate-float">
                    <div class="scratch-block scratch-events">
                        <span>when</span>
                        <span class="text-base">🚩</span>
                        <span>clicked</span>
                    </div>
                </div>

                <!-- Scratch Block Center-Left: Forever Move -->
                <div class="animate-float-reverse">
                    <div class="scratch-block scratch-motion">
                        <span>move</span>
                        <span class="scratch-pill">10</span>
                        <span>steps</span>
                    </div>
                </div>

                <!-- Scratch Block Center-Right: Looks A.I. -->
                <div class="animate-float">
                    <div class="scratch-block scratch-looks">
                        <span>say</span>
                        <span class="scratch-pill">Halo A.I.! 🤖</span>
                        <span>for</span>
                        <span class="scratch-pill">2</span>
                        <span>secs</span>
                    </div>
                </div>

                <!-- Scratch Block Right: Control Forever -->
                <div class="animate-float-reverse">
                    <div class="scratch-block scratch-control">
                        <span>forever 🔄</span>
                    </div>
                </div>
            </div>

            <!-- Two-Column Poster Layout: Left Cards (Details + FREE!) & Right Cartoon Robot + Kid Coder -->
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center max-w-6xl mx-auto">
                
                <!-- LEFT COLUMN (7 cols): Main Feature Card with "FREE!" Burst Badge -->
                <div class="lg:col-span-7 space-y-6">
                    
                    <!-- White Container Card with 3D cartoon box style -->
                    <div class="cartoon-box p-6 sm:p-8 relative">
                        
                        <!-- Angled Red Burst "FREE!" Badge (Exact match with poster) -->
                        <div class="absolute -top-7 right-6 sm:right-10 z-20">
                            <div class="badge-free px-5 py-2.5 rounded-2xl border-4 border-white text-xl sm:text-2xl font-display font-black tracking-widest uppercase">
                                FREE! 🔥
                            </div>
                        </div>

                        <!-- Card Subtitle -->
                        <div class="mb-4">
                            <span class="inline-block px-3.5 py-1.5 rounded-xl bg-amber-100 text-blue-950 font-display font-black text-xs uppercase tracking-wider border-2 border-amber-300">
                                🎯 Khusus Siswa SD Kelas 6
                            </span>
                            <h3 class="font-display font-black text-2xl sm:text-3xl text-blue-950 mt-2">
                                Kuota Terbatas (90 Siswa per Sesi)
                            </h3>
                        </div>

                        <!-- 3 Materi Bullet Points (Matching Poster) with Cartoon Badges -->
                        <ul class="space-y-3 font-display font-bold text-slate-800 text-sm sm:text-base">
                            <li class="flex items-center gap-3">
                                <span class="w-7 h-7 rounded-xl bg-blue-900 text-white flex items-center justify-center text-xs shrink-0 shadow-xs">🎮</span>
                                <span>Coding dan Praktik Membuat Game (Block Programming)</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="w-7 h-7 rounded-xl bg-purple-900 text-white flex items-center justify-center text-xs shrink-0 shadow-xs">🤖</span>
                                <span>Pemanfaatan A.I. untuk Belajar Cerdas &amp; Asyik</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <span class="w-7 h-7 rounded-xl bg-emerald-800 text-white flex items-center justify-center text-xs shrink-0 shadow-xs">🛡️</span>
                                <span>Keamanan dan Etika Digital *</span>
                            </li>
                        </ul>

                        <!-- Google Interland Note (Key Highlight from poster) -->
                        <div class="mt-4 text-xs font-bold text-blue-950 bg-amber-100/80 p-3 rounded-2xl border-2 border-amber-300 flex items-center gap-2">
                            <span class="text-xl">🏆</span>
                            <span>* Mendapatkan E-Sertifikat Resmi &amp; <strong>Sertifikat Google Interland</strong></span>
                        </div>

                        <!-- Date & Location Box (Orange box like poster) -->
                        <div class="mt-5 p-4 rounded-2xl bg-gradient-to-r from-orange-500 to-amber-500 text-white border-2 border-amber-600 shadow-md">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs sm:text-sm">
                                <div>
                                    <span class="text-white/80 text-[11px] font-black uppercase tracking-wider block">Waktu Pelaksanaan:</span>
                                    <strong class="font-display font-black text-base sm:text-lg">{{ $eventDate }}</strong>
                                    <span class="block text-white/95 text-xs font-bold mt-0.5">2 Pilihan Sesi: Pagi (08:00) &amp; Siang (12:30)</span>
                                </div>
                                <div class="border-t sm:border-t-0 sm:border-l border-white/30 sm:pl-3 pt-2 sm:pt-0">
                                    <span class="text-white/80 text-[11px] font-black uppercase tracking-wider block">Lokasi Laboratorium:</span>
                                    <strong class="font-display font-black text-sm sm:text-base">Lab TIK 1 &amp; Lab TIK 3</strong>
                                    <span class="block text-white/95 text-xs font-medium mt-0.5">Lantai 3 Gedung Selatan, SMP Muhammadiyah 1 Yogyakarta</span>
                                </div>
                            </div>
                        </div>

                        <!-- CTA 3D Buttons on Card -->
                        <div class="mt-6 flex flex-col sm:flex-row items-center gap-3">
                            <a href="#pendaftaran" class="btn-cartoon-blue w-full sm:w-auto flex-grow text-center py-4 px-6 font-display font-black text-base sm:text-lg rounded-2xl">
                                DAFTAR SEKARANG 🚀
                            </a>
                            <button type="button" onclick="openTicketSearchModal()" class="btn-cartoon-amber w-full sm:w-auto py-3.5 px-5 font-display font-black text-xs sm:text-sm rounded-2xl">
                                Cek Pembagian Sesi 🔍
                            </button>
                        </div>

                    </div>

                </div>

                <!-- RIGHT COLUMN (5 cols): Cartoon Robot & Kid Coder Ecosystem -->
                <div class="lg:col-span-5 flex flex-col items-center">
                    
                    <!-- Cartoon Robot Ecosystem Container -->
                    <div class="w-full max-w-md cartoon-box p-6 text-center relative overflow-hidden bg-gradient-to-b from-sky-50 to-white">
                        
                        <!-- Floating Scratch Block inside Illustration Card -->
                        <div class="absolute top-3 left-4 z-10 animate-float-gentle">
                            <div class="scratch-block scratch-operator !text-[11px] !py-1 !px-2.5">
                                <span>A.I. + Kreativitas = 🌟</span>
                            </div>
                        </div>

                        <!-- Robot Speech Bubble -->
                        <div class="mt-6 mb-2 bg-white border-2 border-blue-950 rounded-2xl p-3 shadow-md speech-bubble-bottom text-left">
                            <div class="flex items-center gap-2 text-xs font-black text-blue-950 font-display">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                                <span>Robo-Muhi Assistant:</span>
                            </div>
                            <p class="text-xs text-slate-700 font-bold mt-1 leading-snug">
                                "Halo teman-teman SD! Ayo belajar coding visual, bikin game sendiri &amp; kenalan sama kecerdasan buatan! 🎮🤖"
                            </p>
                        </div>

                        <!-- SVG: Cartoon Robot & Kid Coder Side-by-Side -->
                        <div class="w-full h-56 mx-auto relative flex items-center justify-center my-2">
                            <svg class="w-full h-full" viewBox="0 0 320 220" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Desk -->
                                <rect x="30" y="170" width="260" height="14" rx="4" fill="#0b2347"/>
                                <rect x="45" y="184" width="12" height="32" fill="#0b2347"/>
                                <rect x="263" y="184" width="12" height="32" fill="#0b2347"/>
                                
                                <!-- Computer Monitor with Scratch Blocks -->
                                <rect x="110" y="80" width="100" height="72" rx="8" fill="#e2e8f0" stroke="#0b2347" stroke-width="4"/>
                                <rect x="117" y="87" width="86" height="58" rx="4" fill="#38bdf8"/>
                                <!-- Mini Scratch Blocks on screen -->
                                <rect x="124" y="94" width="34" height="8" rx="3" fill="#ffbf00"/>
                                <rect x="124" y="105" width="50" height="8" rx="3" fill="#4c97ff"/>
                                <rect x="124" y="116" width="40" height="8" rx="3" fill="#9966ff"/>
                                <rect x="124" y="127" width="44" height="8" rx="3" fill="#59c059"/>
                                <!-- Monitor Stand -->
                                <rect x="154" y="152" width="12" height="18" fill="#94a3b8"/>
                                <ellipse cx="160" cy="168" rx="26" ry="6" fill="#cbd5e1" stroke="#0b2347" stroke-width="2.5"/>
                                <!-- Keyboard & Mouse -->
                                <rect x="115" y="166" width="52" height="6" rx="2" fill="#f8fafc" stroke="#64748b" stroke-width="1.5"/>
                                <ellipse cx="185" cy="168" rx="7" ry="4" fill="#f8fafc" stroke="#64748b" stroke-width="1.5"/>

                                <!-- FRIENDLY CARTOON ROBOT (Right Side) -->
                                <g class="animate-float-gentle">
                                    <!-- Robot Antenna -->
                                    <line x1="245" y1="65" x2="245" y2="48" stroke="#0b2347" stroke-width="3.5" stroke-linecap="round"/>
                                    <circle cx="245" cy="45" r="7" fill="#facc15" stroke="#0b2347" stroke-width="2.5" class="animate-pulse"/>
                                    
                                    <!-- Robot Ears -->
                                    <rect x="220" y="76" width="6" height="12" rx="3" fill="#38bdf8" stroke="#0b2347" stroke-width="2"/>
                                    <rect x="264" y="76" width="6" height="12" rx="3" fill="#38bdf8" stroke="#0b2347" stroke-width="2"/>

                                    <!-- Robot Head -->
                                    <rect x="224" y="65" width="42" height="34" rx="8" fill="#e0f2fe" stroke="#0b2347" stroke-width="3"/>
                                    <!-- Screen Face -->
                                    <rect x="229" y="70" width="32" height="24" rx="4" fill="#0f172a"/>
                                    <!-- Cyan Glowing Eyes -->
                                    <ellipse cx="238" cy="80" rx="3.5" ry="4.5" fill="#38bdf8"/>
                                    <ellipse cx="252" cy="80" rx="3.5" ry="4.5" fill="#38bdf8"/>
                                    <path d="M239 88Q245 92 251 88" stroke="#38bdf8" stroke-width="2" stroke-linecap="round"/>

                                    <!-- Robot Body -->
                                    <rect x="222" y="103" width="46" height="42" rx="8" fill="#bae6fd" stroke="#0b2347" stroke-width="3"/>
                                    <!-- Chest Meter / Battery -->
                                    <rect x="232" y="112" width="26" height="12" rx="3" fill="#ffffff" stroke="#0b2347" stroke-width="1.5"/>
                                    <rect x="234" y="114" width="8" height="8" rx="1.5" fill="#22c55e"/>
                                    <rect x="243" y="114" width="8" height="8" rx="1.5" fill="#22c55e"/>
                                    <rect x="252" y="114" width="4" height="8" rx="1.5" fill="#22c55e"/>
                                    <!-- Robot Buttons -->
                                    <circle cx="236" cy="133" r="3" fill="#ef4444"/>
                                    <circle cx="245" cy="133" r="3" fill="#f59e0b"/>
                                    <circle cx="254" cy="133" r="3" fill="#10b981"/>

                                    <!-- Waving Robot Arm (Left side of robot) -->
                                    <g class="animate-wave">
                                        <path d="M222 110C210 105 204 90 208 82" stroke="#0b2347" stroke-width="5" stroke-linecap="round"/>
                                        <circle cx="208" cy="80" r="4" fill="#38bdf8" stroke="#0b2347" stroke-width="2"/>
                                    </g>
                                    <!-- Right Arm resting on desk -->
                                    <path d="M268 115C275 125 272 155 258 168" stroke="#0b2347" stroke-width="4.5" stroke-linecap="round"/>
                                </g>

                                <!-- HAPPY KID CODER (Left Side, Red Shirt like Poster) -->
                                <g>
                                    <!-- Chair back -->
                                    <rect x="52" y="100" width="8" height="60" rx="3" fill="#f97316" stroke="#0b2347" stroke-width="2"/>
                                    <ellipse cx="65" cy="155" rx="18" ry="6" fill="#f97316" stroke="#0b2347" stroke-width="2"/>

                                    <!-- Kid Head -->
                                    <circle cx="78" cy="85" r="22" fill="#fed7aa" stroke="#0b2347" stroke-width="3"/>
                                    <!-- Dark Curly Hair -->
                                    <path d="M58 80C56 62 70 52 88 52C102 52 108 64 104 80C94 74 82 72 70 76C64 77 60 79 58 80Z" fill="#1e293b"/>
                                    <circle cx="63" cy="65" r="7" fill="#1e293b"/>
                                    <circle cx="74" cy="58" r="8" fill="#1e293b"/>
                                    <circle cx="86" cy="57" r="7" fill="#1e293b"/>
                                    <circle cx="97" cy="63" r="7" fill="#1e293b"/>

                                    <!-- Kid Face: Smile & Eyes -->
                                    <circle cx="82" cy="85" r="2.5" fill="#0f172a"/>
                                    <path d="M76 94Q83 100 89 94" stroke="#0f172a" stroke-width="2.5" stroke-linecap="round"/>
                                    <!-- Rosy Cheek -->
                                    <circle cx="75" cy="89" r="3" fill="#fca5a5" opacity="0.6"/>

                                    <!-- Red Shirt Body -->
                                    <path d="M60 110C60 106 68 104 80 104C92 104 98 106 98 110L102 165H58L60 110Z" fill="#ef4444" stroke="#0b2347" stroke-width="3"/>
                                    <!-- Arm on Chin (Curious coder pose like poster) -->
                                    <path d="M72 122L80 100" stroke="#fed7aa" stroke-width="6" stroke-linecap="round"/>
                                    <path d="M72 122L80 100" stroke="#0b2347" stroke-width="1.5" stroke-linecap="round"/>

                                    <!-- Desk Accessories: Pen cup with dots -->
                                    <rect x="96" y="146" width="12" height="18" rx="2" fill="#ef4444" stroke="#0b2347" stroke-width="1.5"/>
                                    <circle cx="100" cy="151" r="1.2" fill="#fff"/>
                                    <circle cx="104" cy="156" r="1.2" fill="#fff"/>
                                    <line x1="99" y1="138" x2="101" y2="146" stroke="#f59e0b" stroke-width="2" stroke-linecap="round"/>
                                    <line x1="104" y1="136" x2="103" y2="146" stroke="#3b82f6" stroke-width="2" stroke-linecap="round"/>
                                </g>
                            </svg>
                        </div>

                        <h4 class="font-display font-black text-xl text-blue-950 mt-1">
                            "Serunya Bikin Game &amp; Kenal A.I.!"
                        </h4>
                        <p class="text-xs text-slate-600 font-bold mt-1 leading-relaxed">
                            Belajar logika pemrograman visual seperti menyusun puzzle balok warna-warni yang asyik!
                        </p>

                        <!-- Previous Agenda Social Proof Badge -->
                        <div class="mt-4 p-3 rounded-2xl bg-amber-100/90 border-2 border-amber-300 text-left flex items-start gap-2.5">
                            <span class="text-xl">📢</span>
                            <p class="text-[11px] text-blue-950 leading-snug font-bold">
                                <strong>Kilas Balik:</strong> Pada agenda sebelumnya, pendaftar membludak hingga 2x lipat kapasitas! Segera amankan kursi ananda sebelum kuota penuh.
                            </p>
                        </div>

                    </div>

                </div>

            </div>

            <!-- LIVE QUOTA ARENA CARDS (Sesi 1 & Sesi 2) -->
            <div class="mt-14 max-w-5xl mx-auto">
                <div class="text-center mb-6">
                    <span class="font-display font-black text-xs uppercase tracking-widest text-blue-950 bg-white/90 px-4 py-1.5 rounded-full border-2 border-blue-950 shadow-xs">
                        ⚡ MONITORING KUOTA REAL-TIME (90 SISWA PER SESI)
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- SESI 1 CARD -->
                    <div class="cartoon-box p-6 relative">
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <div>
                                <span class="text-xs font-black uppercase tracking-wider text-blue-900 bg-blue-100 px-3 py-1 rounded-xl border border-blue-300">
                                    ☀️ SESI 1 (PAGI)
                                </span>
                                <h3 class="font-display font-black text-xl text-blue-950 mt-2">{{ $s1Name }}</h3>
                                <p class="font-mono font-bold text-xs text-slate-600">⏰ {{ $s1Time }}</p>
                            </div>
                            <div class="text-right">
                                @if($s1RemainingMain > 0)
                                    <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 border-2 border-emerald-400">
                                        Tersedia
                                    </span>
                                @elseif($s1RemainingWaitlist > 0)
                                    <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-100 text-amber-800 border-2 border-amber-400">
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
                            <div class="w-full bg-slate-100 rounded-full h-4 overflow-hidden p-0.5 border-2 border-blue-950">
                                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 h-full rounded-full transition-all duration-500" style="width: {{ $s1Percent }}%"></div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-200 flex items-center justify-between text-xs text-slate-500">
                            <span>Antrean Cadangan: <strong>{{ $s1WaitlistCount }}</strong> / {{ $s1WaitlistMax }}</span>
                            <a href="#pendaftaran" onclick="selectSession('1')" class="font-display font-black text-blue-900 hover:text-blue-700 flex items-center gap-1">
                                Pilih Sesi 1 &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- SESI 2 CARD -->
                    <div class="cartoon-box p-6 relative">
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <div>
                                <span class="text-xs font-black uppercase tracking-wider text-purple-900 bg-purple-100 px-3 py-1 rounded-xl border border-purple-300">
                                    🌤️ SESI 2 (SIANG)
                                </span>
                                <h3 class="font-display font-black text-xl text-blue-950 mt-2">{{ $s2Name }}</h3>
                                <p class="font-mono font-bold text-xs text-slate-600">⏰ {{ $s2Time }}</p>
                            </div>
                            <div class="text-right">
                                @if($s2RemainingMain > 0)
                                    <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 border-2 border-emerald-400">
                                        Tersedia
                                    </span>
                                @elseif($s2RemainingWaitlist > 0)
                                    <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-100 text-amber-800 border-2 border-amber-400">
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
                            <div class="w-full bg-slate-100 rounded-full h-4 overflow-hidden p-0.5 border-2 border-blue-950">
                                <div class="bg-gradient-to-r from-purple-600 to-pink-600 h-full rounded-full transition-all duration-500" style="width: {{ $s2Percent }}%"></div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-200 flex items-center justify-between text-xs text-slate-500">
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

    <!-- Section: 3 Materi Utama Kegiatan (Gamified Quest Stages with Block Code & Robot Badges) -->
    <section id="materi" class="py-20 bg-coding-grid border-b-4 border-blue-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="font-display font-black text-xs uppercase tracking-widest text-blue-950 bg-amber-100 px-4 py-1.5 rounded-full border-2 border-blue-950 shadow-xs">
                    KURIKULUM &amp; MATERI WORKSHOP
                </span>
                <h2 class="mt-3 font-display font-black text-3xl sm:text-5xl text-blue-950 tracking-tight">
                    3 Petualangan Hebat yang Dipelajari Siswa
                </h2>
                <p class="mt-3 text-slate-600 text-sm sm:text-base leading-relaxed font-medium">
                    Dirancang aplikatif, seru dan ramah anak kelas 6 SD oleh instruktur SMP Muhammadiyah 1 Yogyakarta agar ananda siap menjadi kreator teknologi berakhlak mulia.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Card 1: Coding dan Praktik membuat Game -->
                <div class="cartoon-box p-8 bg-blue-50/40 hover:-translate-y-1 transition-all flex flex-col justify-between">
                    <div>
                        <!-- Header Level & Icon -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 rounded-2xl bg-blue-900 text-white flex items-center justify-center text-3xl shadow-md border-2 border-blue-950">
                                🎮
                            </div>
                            <span class="px-3 py-1 rounded-xl bg-blue-200 text-blue-950 font-display font-black text-xs uppercase tracking-wider border border-blue-300">
                                LEVEL 1: GAME MAKER
                            </span>
                        </div>

                        <h3 class="font-display font-black text-2xl text-blue-950 mb-3">
                            Coding &amp; Praktik Membuat Game
                        </h3>
                        <p class="text-slate-600 text-sm leading-relaxed font-medium">
                            Mempelajari logika komputasi dasar dan algoritma melalui visual block coding (Scratch/Blockly). Siswa langsung merakit game komputer interaktif karyanya sendiri: mengontrol karakter, merancang level rintangan, animasi, dan sistem skor.
                        </p>
                    </div>

                    <!-- Scratch Block Preview Widget -->
                    <div class="mt-6 pt-4 border-t-2 border-blue-200/80 bg-white p-3.5 rounded-2xl border border-blue-100">
                        <span class="block text-[11px] font-black text-blue-900 uppercase tracking-wider mb-2 font-display">Contoh Balok Logika:</span>
                        <div class="space-y-1.5">
                            <div class="scratch-block scratch-events !text-xs !py-1 !px-2.5">
                                <span>when [space key] pressed 🕹️</span>
                            </div>
                            <div class="scratch-block scratch-motion !text-xs !py-1 !px-2.5">
                                <span>change y by <strong class="scratch-pill">25</strong> (Lompat!)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Pemanfaatan A.I. untuk belajar -->
                <div class="cartoon-box p-8 bg-purple-50/40 hover:-translate-y-1 transition-all flex flex-col justify-between">
                    <div>
                        <!-- Header Level & Icon -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 rounded-2xl bg-purple-900 text-white flex items-center justify-center text-3xl shadow-md border-2 border-blue-950">
                                🤖
                            </div>
                            <span class="px-3 py-1 rounded-xl bg-purple-200 text-purple-950 font-display font-black text-xs uppercase tracking-wider border border-purple-300">
                                LEVEL 2: A.I. EXPLORER
                            </span>
                        </div>

                        <h3 class="font-display font-black text-2xl text-purple-950 mb-3">
                            Pemanfaatan A.I. untuk Belajar
                        </h3>
                        <p class="text-slate-600 text-sm leading-relaxed font-medium">
                            Mengenal konsep Artificial Intelligence dengan pendekatan ramah anak. Siswa mempraktikkan A.I. sebagai sahabat belajar pintar: membantu memahami konsep pelajaran sekolah, brainstorming ide sains kreatif, dan melatih nalar kritis tanpa ketergantungan pasif.
                        </p>
                    </div>

                    <!-- AI Prompt Bubble Preview Widget -->
                    <div class="mt-6 pt-4 border-t-2 border-purple-200/80 bg-white p-3.5 rounded-2xl border border-purple-100">
                        <span class="block text-[11px] font-black text-purple-900 uppercase tracking-wider mb-2 font-display">Prompt Sahabat Pintar:</span>
                        <div class="bg-purple-50 p-2.5 rounded-xl border border-purple-200 text-xs font-bold text-purple-950 flex items-center gap-2">
                            <span>💬</span>
                            <span>"Hai Robo-AI, bantu jelaskan proses fotosintesis tumbuhan seperti cerita petualangan seru!"</span>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Keamanan dan Etika Digital -->
                <div class="cartoon-box p-8 bg-emerald-50/40 hover:-translate-y-1 transition-all flex flex-col justify-between">
                    <div>
                        <!-- Header Level & Icon -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 rounded-2xl bg-emerald-800 text-white flex items-center justify-center text-3xl shadow-md border-2 border-blue-950">
                                🛡️
                            </div>
                            <span class="px-3 py-1 rounded-xl bg-emerald-200 text-emerald-950 font-display font-black text-xs uppercase tracking-wider border border-emerald-300">
                                LEVEL 3: INTERLAND HERO
                            </span>
                        </div>

                        <h3 class="font-display font-black text-2xl text-emerald-950 mb-3">
                            Keamanan &amp; Etika Digital
                        </h3>
                        <p class="text-slate-600 text-sm leading-relaxed font-medium">
                            Membekali siswa dengan pemahaman <em>cyber safety</em>: menjaga kerahasiaan password dan data pribadi, bersikap santun saat online, serta cerdas mengenali hoax. <span class="font-bold text-emerald-900">*Mendapatkan sertifikat Google Interland</span>.
                        </p>
                    </div>

                    <!-- Google Interland Trophy Badge -->
                    <div class="mt-6 pt-4 border-t-2 border-emerald-200/80 bg-white p-3.5 rounded-2xl border border-emerald-100">
                        <span class="block text-[11px] font-black text-emerald-900 uppercase tracking-wider mb-2 font-display">Penghargaan Peserta:</span>
                        <div class="bg-emerald-50 p-2.5 rounded-xl border border-emerald-200 text-xs font-bold text-emerald-950 flex items-center gap-2">
                            <span class="text-xl">🏆</span>
                            <span>E-Sertifikat Workshop + Sertifikat Google Interland Resmi!</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Section: Rundown Kegiatan (Tabbed Sesi 1 vs Sesi 2) -->
    <section id="rundown" class="py-20 bg-amber-50/60 border-y-4 border-blue-950">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span class="font-display font-black text-xs uppercase tracking-widest text-blue-950 bg-white px-4 py-1.5 rounded-full border-2 border-blue-950 shadow-xs">
                    JADWAL RUNDOWN ACARA
                </span>
                <h2 class="mt-3 font-display font-black text-3xl sm:text-5xl text-blue-950 tracking-tight">
                    Rundown Kegiatan per Sesi
                </h2>
                <p class="mt-2 text-slate-700 text-sm sm:text-base font-semibold">
                    Senin, 21 Desember 2026 &bull; Laboratorium Komputer SMP Muhammadiyah 1 Yogyakarta
                </p>

                <!-- Rundown Tab Switcher -->
                <div class="mt-8 inline-flex p-1.5 rounded-2xl bg-white border-3 border-blue-950 max-w-md w-full shadow-md">
                    <button type="button" onclick="switchRundown('1')" id="tabBtn1" class="w-1/2 py-2.5 rounded-xl font-display font-black text-xs sm:text-sm transition-all bg-blue-950 text-white shadow-xs">
                        ☀️ Sesi 1 (08:00 – 10:30)
                    </button>
                    <button type="button" onclick="switchRundown('2')" id="tabBtn2" class="w-1/2 py-2.5 rounded-xl font-display font-black text-xs sm:text-sm transition-all text-slate-600 hover:text-blue-950">
                        🌤️ Sesi 2 (12:30 – 14:00)
                    </button>
                </div>
            </div>

            <!-- RUNDOWN SESI 1 CONTENT -->
            <div id="rundownSesi1" class="space-y-4 transition-all">
                <div class="cartoon-box p-5 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-slate-100 font-mono font-black text-xs text-slate-800 shrink-0 border border-slate-300">07:30 – 08:00</span>
                        <div>
                            <h4 class="font-display font-black text-slate-900 text-sm sm:text-base">Registrasi Ulang &amp; Pengambilan Name Tag</h4>
                            <p class="text-xs text-slate-600 font-medium">Check-in barcode E-Ticket, pembagian Name Tag dan snack pagi di Lab TIK 1 &amp; Lab TIK 3.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-slate-500 shrink-0">30 Menit</span>
                </div>

                <div class="cartoon-box p-5 border-l-8 border-l-blue-900 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-blue-100 font-mono font-black text-xs text-blue-900 shrink-0 border border-blue-300">08:00 – 09:15</span>
                        <div>
                            <h4 class="font-display font-black text-slate-900 text-sm sm:text-base">Modul 1: Coding &amp; Praktik Membuat Game 🎮</h4>
                            <p class="text-xs text-slate-600 font-medium">Logika sekuensial, algoritma visual Scratch, dan merakit game interaktif perdana.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-blue-900 shrink-0">75 Menit</span>
                </div>

                <div class="cartoon-box p-5 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-amber-100 font-mono font-black text-xs text-amber-800 shrink-0 border border-amber-300">09:15 – 09:30</span>
                        <div>
                            <h4 class="font-display font-black text-slate-900 text-sm sm:text-base">Snack Break &amp; Fun Quiz 🍪</h4>
                            <p class="text-xs text-slate-600 font-medium">Waktu istirahat, snack lezat, kuis seru berhadiah, dan networking teman baru.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-amber-700 shrink-0">15 Menit</span>
                </div>

                <div class="cartoon-box p-5 border-l-8 border-l-purple-900 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-purple-100 font-mono font-black text-xs text-purple-900 shrink-0 border border-purple-300">09:30 – 10:05</span>
                        <div>
                            <h4 class="font-display font-black text-slate-900 text-sm sm:text-base">Modul 2: Pemanfaatan A.I. untuk Belajar 🤖</h4>
                            <p class="text-xs text-slate-600 font-medium">Eksplorasi kecerdasan buatan ramah anak, prompt cilik, dan praktik A.I. sebagai sahabat belajar pintar.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-purple-900 shrink-0">35 Menit</span>
                </div>

                <div class="cartoon-box p-5 border-l-8 border-l-emerald-800 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-emerald-100 font-mono font-black text-xs text-emerald-900 shrink-0 border border-emerald-300">10:05 – 10:30</span>
                        <div>
                            <h4 class="font-display font-black text-slate-900 text-sm sm:text-base">Modul 3: Keamanan Digital + Showcase &amp; Sertifikat 🎓</h4>
                            <p class="text-xs text-slate-600 font-medium">Cyber safety, Google Interland, pameran hasil karya game, dan penyerahan sertifikat.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-emerald-800 shrink-0">25 Menit</span>
                </div>
            </div>

            <!-- RUNDOWN SESI 2 CONTENT -->
            <div id="rundownSesi2" class="space-y-4 hidden transition-all">
                <div class="cartoon-box p-5 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-slate-100 font-mono font-black text-xs text-slate-800 shrink-0 border border-slate-300">12:00 – 12:30</span>
                        <div>
                            <h4 class="font-display font-black text-slate-900 text-sm sm:text-base">Registrasi Ulang Sesi 2 &amp; Welcome Drink</h4>
                            <p class="text-xs text-slate-600 font-medium">Check-in barcode E-Ticket, pengambilan Name Tag dan persiapan komputer di Lab TIK.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-slate-500 shrink-0">30 Menit</span>
                </div>

                <div class="cartoon-box p-5 border-l-8 border-l-blue-900 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-blue-100 font-mono font-black text-xs text-blue-900 shrink-0 border border-blue-300">12:30 – 13:15</span>
                        <div>
                            <h4 class="font-display font-black text-slate-900 text-sm sm:text-base">Modul 1: Coding &amp; Praktik Membuat Game 🎮</h4>
                            <p class="text-xs text-slate-600 font-medium">Mempelajari logika pemrograman visual Scratch dan merakit game kreasi mandiri.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-blue-900 shrink-0">45 Menit</span>
                </div>

                <div class="cartoon-box p-5 border-l-8 border-l-purple-900 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-purple-100 font-mono font-black text-xs text-purple-900 shrink-0 border border-purple-300">13:15 – 13:40</span>
                        <div>
                            <h4 class="font-display font-black text-slate-900 text-sm sm:text-base">Modul 2: Pemanfaatan A.I. untuk Belajar 🤖</h4>
                            <p class="text-xs text-slate-600 font-medium">Praktik menggunakan A.I. sebagai mitra belajar cerdas, eksplorasi ide sains &amp; nalar kreatif.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-purple-900 shrink-0">25 Menit</span>
                </div>

                <div class="cartoon-box p-5 border-l-8 border-l-emerald-800 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-emerald-100 font-mono font-black text-xs text-emerald-900 shrink-0 border border-emerald-300">13:40 – 14:00</span>
                        <div>
                            <h4 class="font-display font-black text-slate-900 text-sm sm:text-base">Modul 3: Keamanan Digital + Penutup &amp; Sertifikat 🎓</h4>
                            <p class="text-xs text-slate-600 font-medium">Etika digital, Google Interland, showcase game karya siswa &amp; penyerahan sertifikat.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-emerald-800 shrink-0">20 Menit</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Detail Lokasi Laboratorium (Lab TIK 1 & 3 Lantai 3 Gedung Selatan) -->
    <section id="lokasi" class="py-16 bg-white border-b-4 border-blue-950">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-dark-coding text-white rounded-3xl p-8 sm:p-12 relative overflow-hidden border-4 border-amber-400 shadow-2xl">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div>
                        <span class="font-display font-black text-xs text-amber-400 uppercase tracking-widest bg-blue-900 px-3.5 py-1.5 rounded-full border border-amber-400/50">
                            LOKASI ACARA RESMI
                        </span>
                        <h3 class="font-display font-black text-2xl sm:text-3xl text-white mt-3 leading-tight">
                            Laboratorium Komputer SMP Muhammadiyah 1 Yogyakarta
                        </h3>
                        <p class="mt-3 text-slate-300 text-xs sm:text-sm leading-relaxed font-medium">
                            Kegiatan diselenggarakan di <strong>Lab TIK 1 dan Lab TIK 3 (Lantai 3 Gedung Selatan)</strong> dengan fasilitas ber-AC, proyektor interaktif, dan koneksi internet fiber optik berkecepatan tinggi.
                        </p>
                    </div>

                    <div class="bg-blue-900/70 p-6 rounded-2xl border-2 border-blue-800 space-y-3.5 text-xs sm:text-sm font-medium">
                        <div class="flex items-start gap-3">
                            <span class="text-xl">📍</span>
                            <span><strong>Alamat:</strong> Jl. Purwodiningratan NG I/902, Ngampilan, Kota Yogyakarta, D.I. Yogyakarta 55261</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-xl">💻</span>
                            <span><strong>Perlengkapan:</strong> Siswa disarankan membawa laptop pribadi + charger (Windows / Mac / Chromebook). Lab juga menyediakan PC cadangan.</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-xl">📜</span>
                            <span><strong>Fasilitas Peserta:</strong> Snack box lezat, modul panduan, E-Sertifikat resmi &amp; Sertifikat Google Interland.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Formulir Pendaftaran Gamified (Pilih Sesi 1 atau Sesi 2) -->
    <section id="pendaftaran" class="py-20 bg-coding-grid border-b-4 border-blue-950">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <span class="font-display font-black text-xs uppercase tracking-widest text-blue-950 bg-amber-300 px-4 py-1.5 rounded-full border-2 border-blue-950 shadow-xs">
                    FORMULIR PENDAFTARAN RESMI
                </span>
                <h2 class="mt-3 font-display font-black text-3xl sm:text-5xl text-blue-950 tracking-tight">
                    Pilih Sesi &amp; Amankan Kursimu!
                </h2>
                <p class="mt-2 text-slate-600 text-sm sm:text-base font-semibold">
                    Mohon diisi dengan lengkap dan teliti oleh <strong>Orang Tua / Wali Siswa</strong>.
                </p>
            </div>

            <!-- Form Card with Coding IDE Header Style -->
            <div class="cartoon-box p-6 sm:p-10 relative overflow-hidden">
                <!-- Code IDE Editor Header -->
                <div class="flex items-center justify-between pb-4 mb-6 border-b-2 border-slate-200">
                    <div class="flex items-center gap-2">
                        <span class="w-3.5 h-3.5 rounded-full bg-rose-500 inline-block shadow-xs"></span>
                        <span class="w-3.5 h-3.5 rounded-full bg-amber-400 inline-block shadow-xs"></span>
                        <span class="w-3.5 h-3.5 rounded-full bg-emerald-500 inline-block shadow-xs"></span>
                        <span class="font-mono text-xs text-slate-500 font-bold ml-2">~/terminal/registrasi-coder.sh</span>
                    </div>
                    <span class="font-mono text-[11px] font-black text-blue-950 bg-amber-200 px-2.5 py-0.5 rounded-md border border-amber-400">
                        SESSION_SELECT_MODE: ACTIVE
                    </span>
                </div>
                
                @if(!$isGlobalOpen)
                    <div class="text-center py-12">
                        <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-3xl mx-auto mb-4 border-2 border-slate-300">
                            🔒
                        </div>
                        <h3 class="font-display font-black text-xl text-slate-800">Pendaftaran Telah Ditutup</h3>
                        <p class="text-slate-500 text-sm max-w-md mx-auto mt-2 font-medium">
                            Seluruh kuota utama dan antrean cadangan untuk Sesi 1 dan Sesi 2 telah terpenuhi. Silakan hubungi panitia untuk informasi ketersediaan.
                        </p>
                    </div>
                @else
                    <form action="{{ route('register.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- PILIHAN SESI (Radio Cards Interaktif) -->
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <span class="w-6 h-6 rounded-full bg-blue-950 text-white flex items-center justify-center font-black text-xs">1</span>
                                <label class="font-display font-black text-xs sm:text-sm uppercase tracking-wider text-blue-950">
                                    Pilih Sesi Kegiatan <span class="text-rose-500">*</span>
                                </label>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Option Sesi 1 -->
                                <label class="session-card relative p-5 rounded-2xl border-3 cursor-pointer transition-all flex flex-col justify-between {{ old('session', '1') === '1' ? 'border-blue-950 bg-blue-50/70 shadow-md ring-2 ring-blue-900/30' : 'border-slate-200 hover:border-blue-300 bg-white' }}" id="sessionCard1">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-center gap-2.5">
                                            <input type="radio" name="session" value="1" id="radioSession1" {{ old('session', '1') === '1' ? 'checked' : '' }} onchange="onSessionChange('1')" class="w-4 h-4 text-blue-950 focus:ring-blue-900">
                                            <div>
                                                <span class="block font-display font-black text-blue-950 text-base sm:text-lg">{{ $s1Name }}</span>
                                                <span class="block text-xs font-mono font-bold text-blue-800">⏰ {{ $s1Time }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-3 border-t border-slate-200 flex items-center justify-between text-xs">
                                        <span class="text-slate-500 font-bold">Status Kuota:</span>
                                        @if($s1RemainingMain > 0)
                                            <span class="font-display font-black text-emerald-800 bg-emerald-100 px-2.5 py-0.5 rounded-lg border border-emerald-300">
                                                {{ $s1RemainingMain }} Kursi Utama
                                            </span>
                                        @elseif($s1RemainingWaitlist > 0)
                                            <span class="font-display font-black text-amber-800 bg-amber-100 px-2.5 py-0.5 rounded-lg border border-amber-300">
                                                Jalur Cadangan (#{{ $s1WaitlistCount + 1 }})
                                            </span>
                                        @else
                                            <span class="font-bold text-rose-600 bg-rose-100 px-2 py-0.5 rounded-lg">Penuh</span>
                                        @endif
                                    </div>
                                </label>

                                <!-- Option Sesi 2 -->
                                <label class="session-card relative p-5 rounded-2xl border-3 cursor-pointer transition-all flex flex-col justify-between {{ old('session') === '2' ? 'border-purple-900 bg-purple-50/70 shadow-md ring-2 ring-purple-900/30' : 'border-slate-200 hover:border-purple-300 bg-white' }}" id="sessionCard2">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-center gap-2.5">
                                            <input type="radio" name="session" value="2" id="radioSession2" {{ old('session') === '2' ? 'checked' : '' }} onchange="onSessionChange('2')" class="w-4 h-4 text-purple-900 focus:ring-purple-900">
                                            <div>
                                                <span class="block font-display font-black text-purple-950 text-base sm:text-lg">{{ $s2Name }}</span>
                                                <span class="block text-xs font-mono font-bold text-purple-800">⏰ {{ $s2Time }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-3 border-t border-slate-200 flex items-center justify-between text-xs">
                                        <span class="text-slate-500 font-bold">Status Kuota:</span>
                                        @if($s2RemainingMain > 0)
                                            <span class="font-display font-black text-emerald-800 bg-emerald-100 px-2.5 py-0.5 rounded-lg border border-emerald-300">
                                                {{ $s2RemainingMain }} Kursi Utama
                                            </span>
                                        @elseif($s2RemainingWaitlist > 0)
                                            <span class="font-display font-black text-amber-800 bg-amber-100 px-2.5 py-0.5 rounded-lg border border-amber-300">
                                                Jalur Cadangan (#{{ $s2WaitlistCount + 1 }})
                                            </span>
                                        @else
                                            <span class="font-bold text-rose-600 bg-rose-100 px-2 py-0.5 rounded-lg">Penuh</span>
                                        @endif
                                    </div>
                                </label>
                            </div>
                            @error('session') <p class="text-xs text-rose-500 mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <!-- DATA SISWA -->
                        <div class="pt-2">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="w-6 h-6 rounded-full bg-blue-950 text-white flex items-center justify-center font-black text-xs">2</span>
                                <label class="font-display font-black text-xs sm:text-sm uppercase tracking-wider text-blue-950">
                                    Data Coder Cilik (Siswa SD Kelas 6) <span class="text-rose-500">*</span>
                                </label>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Siswa <span class="text-rose-500">*</span></label>
                                    <input type="text" name="student_name" value="{{ old('student_name') }}" required placeholder="Contoh: Muhammad Rizky Pratama" class="w-full px-4 py-2.5 rounded-xl border-2 {{ $errors->has('student_name') ? 'border-rose-400' : 'border-slate-300' }} text-sm focus:border-blue-950 focus:ring-0 outline-none">
                                    @error('student_name') <p class="text-xs text-rose-500 mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Panggilan <span class="text-slate-400 font-normal">(untuk Name Tag)</span> <span class="text-rose-500">*</span></label>
                                    <input type="text" name="nickname" value="{{ old('nickname') }}" required placeholder="Contoh: Rizky" class="w-full px-4 py-2.5 rounded-xl border-2 {{ $errors->has('nickname') ? 'border-rose-400' : 'border-slate-300' }} text-sm focus:border-blue-950 focus:ring-0 outline-none">
                                    @error('nickname') <p class="text-xs text-rose-500 mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Jenis Kelamin <span class="text-rose-500">*</span></label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <label class="flex items-center gap-2 p-2.5 rounded-xl border-2 border-slate-200 cursor-pointer hover:bg-slate-50">
                                            <input type="radio" name="gender" value="L" {{ old('gender', 'L') === 'L' ? 'checked' : '' }} class="text-blue-950 focus:ring-blue-950">
                                            <span class="text-xs font-bold text-slate-700">Laki-laki 👦</span>
                                        </label>
                                        <label class="flex items-center gap-2 p-2.5 rounded-xl border-2 border-slate-200 cursor-pointer hover:bg-slate-50">
                                            <input type="radio" name="gender" value="P" {{ old('gender') === 'P' ? 'checked' : '' }} class="text-blue-950 focus:ring-blue-950">
                                            <span class="text-xs font-bold text-slate-700">Perempuan 👧</span>
                                        </label>
                                    </div>
                                    @error('gender') <p class="text-xs text-rose-500 mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Asal Sekolah (SD / MI) <span class="text-rose-500">*</span></label>
                                    <input type="text" name="school_name" value="{{ old('school_name') }}" required placeholder="Contoh: SD Muhammadiyah Sukonandi" class="w-full px-4 py-2.5 rounded-xl border-2 {{ $errors->has('school_name') ? 'border-rose-400' : 'border-slate-300' }} text-sm focus:border-blue-950 focus:ring-0 outline-none">
                                    @error('school_name') <p class="text-xs text-rose-500 mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Pengalaman Coding / Menggunakan Komputer <span class="text-rose-500">*</span></label>
                                    <select name="experience_level" required class="w-full px-4 py-2.5 rounded-xl border-2 border-slate-300 text-sm focus:border-blue-950 focus:ring-0 outline-none bg-white font-medium">
                                        <option value="Belum Pernah" {{ old('experience_level') === 'Belum Pernah' ? 'selected' : '' }}>Belum Pernah (Pemula sama sekali - Sangat Disambut! 😊)</option>
                                        <option value="Pernah Sedikit" {{ old('experience_level') === 'Pernah Sedikit' ? 'selected' : '' }}>Pernah Sedikit (Pernah coba Scratch / game edukasi)</option>
                                        <option value="Sudah Terbiasa" {{ old('experience_level') === 'Sudah Terbiasa' ? 'selected' : '' }}>Sudah Terbiasa (Sering menggunakan laptop di rumah)</option>
                                    </select>
                                    @error('experience_level') <p class="text-xs text-rose-500 mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- DATA ORANG TUA -->
                        <div class="pt-2">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="w-6 h-6 rounded-full bg-blue-950 text-white flex items-center justify-center font-black text-xs">3</span>
                                <label class="font-display font-black text-xs sm:text-sm uppercase tracking-wider text-blue-950">
                                    Data Orang Tua / Wali Siswa <span class="text-rose-500">*</span>
                                </label>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Orang Tua / Wali <span class="text-rose-500">*</span></label>
                                    <input type="text" name="parent_name" value="{{ old('parent_name') }}" required placeholder="Contoh: Budi Pratama" class="w-full px-4 py-2.5 rounded-xl border-2 {{ $errors->has('parent_name') ? 'border-rose-400' : 'border-slate-300' }} text-sm focus:border-blue-950 focus:ring-0 outline-none">
                                    @error('parent_name') <p class="text-xs text-rose-500 mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp Aktif <span class="text-rose-500">*</span></label>
                                    <input type="tel" name="whatsapp" value="{{ old('whatsapp') }}" required placeholder="Contoh: 08123456789" class="w-full px-4 py-2.5 rounded-xl border-2 {{ $errors->has('whatsapp') ? 'border-rose-400' : 'border-slate-300' }} text-sm focus:border-blue-950 focus:ring-0 outline-none">
                                    <span class="text-[11px] text-slate-500 mt-1 block font-medium">Tiket &amp; info grup koordinasi akan dikirimkan ke nomor ini.</span>
                                    @error('whatsapp') <p class="text-xs text-rose-500 mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Email <span class="text-slate-400 font-normal">(Opsional)</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Contoh: budi@gmail.com" class="w-full px-4 py-2.5 rounded-xl border-2 border-slate-300 text-sm focus:border-blue-950 focus:ring-0 outline-none">
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Catatan Tambahan untuk Panitia <span class="text-slate-400 font-normal">(Opsional)</span></label>
                                    <textarea name="notes" rows="2" placeholder="Contoh: Ananda membawa laptop pribadi..." class="w-full px-4 py-2.5 rounded-xl border-2 border-slate-300 text-sm focus:border-blue-950 focus:ring-0 outline-none font-medium">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- PERSETUJUAN -->
                        <div class="pt-2 space-y-3 bg-amber-50 p-4 rounded-2xl border-2 border-amber-300">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" name="terms_agreement" value="1" {{ old('terms_agreement') ? 'checked' : '' }} required class="mt-1 w-4 h-4 text-blue-950 rounded border-slate-300 focus:ring-blue-950">
                                <span class="text-xs text-slate-700 leading-relaxed font-semibold">
                                    Saya menyatakan data yang diisi adalah benar dan mengizinkan putra/putri saya untuk mengikuti kegiatan workshop ini di Laboratorium Komputer SMP Muhammadiyah 1 Yogyakarta. <span class="text-rose-500">*</span>
                                </span>
                            </label>
                            @error('terms_agreement') <p class="text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror

                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" name="waitlist_agreement" value="1" {{ old('waitlist_agreement') ? 'checked' : '' }} required class="mt-1 w-4 h-4 text-blue-950 rounded border-slate-300 focus:ring-blue-950">
                                <span class="text-xs text-slate-700 leading-relaxed font-semibold">
                                    Saya memahami bahwa setiap sesi dibatasi 90 peserta utama. Jika kuota 90 kursi pada sesi yang saya pilih penuh, pendaftar akan masuk ke antrean cadangan dan dihubungi panitia jika ada pembatalan. <span class="text-rose-500">*</span>
                                </span>
                            </label>
                            @error('waitlist_agreement') <p class="text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <!-- TOMBOL SUBMIT (3D Cartoon Button) -->
                        <div class="pt-2">
                            <button type="submit" class="btn-cartoon-blue w-full py-4 px-6 text-base sm:text-lg font-display font-black rounded-2xl flex items-center justify-center gap-2">
                                <span>KIRIM PENDAFTARAN &amp; AMBIL E-TICKET 🎫</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </button>
                            <p class="text-center text-xs text-slate-600 mt-3 font-bold">100% Gratis &bull; Mendapatkan E-Ticket Resmi &amp; Sertifikat Google Interland</p>
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
                <span class="font-display font-black text-xs uppercase tracking-widest text-blue-950 bg-amber-100 px-4 py-1.5 rounded-full border-2 border-blue-950 shadow-xs">
                    PUSAT BANTUAN
                </span>
                <h2 class="mt-3 font-display font-black text-3xl sm:text-5xl text-blue-950 tracking-tight">
                    Pertanyaan yang Sering Diajukan
                </h2>
            </div>

            <div class="space-y-4">
                <details class="group cartoon-box p-6 transition-all [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex items-center justify-between cursor-pointer font-display font-black text-slate-900 text-sm sm:text-base">
                        <span>Apa perbedaan antara Sesi 1 dan Sesi 2?</span>
                        <span class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center text-blue-950 group-open:rotate-180 transition-transform">▾</span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                        Materi pembelajaran inti keduanya sama persis (Block Programming Game, A.I. for Learning, dan Keamanan Digital Google Interland). Perbedaannya terletak pada waktu: <strong>Sesi 1 berlangsung pukul 08:00 – 10:30 WIB</strong>, sedangkan <strong>Sesi 2 berlangsung pukul 12:30 – 14:00 WIB</strong>. Orang tua bebas memilih sesi yang paling nyaman.
                    </p>
                </details>

                <details class="group cartoon-box p-6 transition-all [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex items-center justify-between cursor-pointer font-display font-black text-slate-900 text-sm sm:text-base">
                        <span>Apakah siswa wajib membawa laptop sendiri?</span>
                        <span class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center text-blue-950 group-open:rotate-180 transition-transform">▾</span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
                        Laboratorium TIK SMP Muhammadiyah 1 Yogyakarta menyediakan perangkat komputer, namun siswa disarankan membawa laptop pribadi + charger masing-masing agar karya game dan proyek A.I. yang dibuat dapat langsung disimpan dan dilanjutkan di rumah.
                    </p>
                </details>

                <details class="group cartoon-box p-6 transition-all [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex items-center justify-between cursor-pointer font-display font-black text-slate-900 text-sm sm:text-base">
                        <span>Apakah benar-benar 100% gratis?</span>
                        <span class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center text-blue-950 group-open:rotate-180 transition-transform">▾</span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed font-medium">
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
            card1.className = 'session-card relative p-5 rounded-2xl border-3 cursor-pointer transition-all flex flex-col justify-between border-blue-950 bg-blue-50/70 shadow-md ring-2 ring-blue-900/30';
            card2.className = 'session-card relative p-5 rounded-2xl border-3 cursor-pointer transition-all flex flex-col justify-between border-slate-200 hover:border-purple-300 bg-white';
        } else {
            card2.className = 'session-card relative p-5 rounded-2xl border-3 cursor-pointer transition-all flex flex-col justify-between border-purple-900 bg-purple-50/70 shadow-md ring-2 ring-purple-900/30';
            card1.className = 'session-card relative p-5 rounded-2xl border-3 cursor-pointer transition-all flex flex-col justify-between border-slate-200 hover:border-blue-300 bg-white';
        }
    }
</script>
@endpush
