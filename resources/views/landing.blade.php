@extends('layouts.app')

@section('title', 'Coding for Kids & A.I. for Learning - Workshop SD Kelas 6 | Muhijunior')

@section('content')

    <!-- Flash Alerts -->
    @if(session('error'))
        <div class="max-w-6xl mx-auto px-4 mt-6">
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start gap-3 shadow-sm animate-bounce">
                <span class="text-2xl">⚠️</span>
                <div>
                    <h4 class="font-bold text-sm">Pemberitahuan</h4>
                    <p class="text-xs font-medium mt-0.5">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('search_error'))
        <div class="max-w-6xl mx-auto px-4 mt-6">
            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 flex items-start gap-3 shadow-sm">
                <span class="text-2xl">🔍</span>
                <div>
                    <h4 class="font-bold text-sm">Pencarian Tidak Ditemukan</h4>
                    <p class="text-xs font-medium mt-0.5">{{ session('search_error') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('search_results'))
        <div class="max-w-6xl mx-auto px-4 mt-6">
            <div class="p-6 rounded-3xl bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 text-indigo-950 shadow-md">
                <h3 class="font-extrabold text-base mb-3 flex items-center gap-2">
                    <span>🎉</span> Ditemukan {{ count(session('search_results')) }} Tiket Pendaftaran:
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach(session('search_results') as $found)
                        <div class="p-4 bg-white rounded-2xl border border-indigo-100 flex items-center justify-between shadow-xs">
                            <div>
                                <p class="font-extrabold text-slate-900 text-sm">{{ $found->student_name }}</p>
                                <p class="text-xs text-slate-500 font-mono mt-0.5">
                                    {{ $found->reg_code }} &bull; 
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $found->session === '1' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700' }}">
                                        Sesi {{ $found->session }}
                                    </span>
                                </p>
                            </div>
                            <a href="{{ route('ticket.show', $found->reg_code) }}" class="px-3.5 py-2 text-xs font-extrabold bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors shadow-xs">
                                Buka E-Ticket &rarr;
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Hero Section: Modern & Engaging -->
    <section class="relative pt-12 pb-24 overflow-hidden bg-radial-[at_top] from-indigo-100/70 via-purple-50/40 to-slate-50 border-b border-slate-200/80">
        <!-- Floating abstract shapes -->
        <div class="absolute -top-20 -left-20 w-80 h-80 bg-indigo-300/40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/3 -right-20 w-96 h-96 bg-purple-300/40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 left-1/3 w-80 h-80 bg-amber-200/30 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                
                <!-- Pill Badges -->
                <div class="inline-flex flex-wrap items-center justify-center gap-2 mb-6">
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-black bg-indigo-600 text-white shadow-md shadow-indigo-600/30">
                        🚀 MUHIJUNIOR TECH FEST
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold bg-white text-indigo-800 border border-indigo-200 shadow-xs">
                        🎯 Khusus Siswa SD Kelas 6
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-300">
                        🎟️ 100% GRATIS
                    </span>
                </div>

                <!-- Headline -->
                <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black text-slate-900 tracking-tight leading-[1.1]">
                    Petualangan Seru <br class="hidden sm:inline">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600">
                        Coding &amp; A.I.
                    </span> Untuk Juara Cilik!
                </h1>
                
                <p class="mt-6 text-base sm:text-xl text-slate-600 leading-relaxed max-w-3xl mx-auto font-medium">
                    Workshop interaktif membuat game komputer pertamamu &amp; belajar cerdas bersama Kecerdasan Buatan (A.I.). Siapkan langkah awalmu menjadi kreator digital hebat di jenjang SMP!
                </p>

                <!-- Key Meta Highlights -->
                <div class="mt-8 flex flex-wrap items-center justify-center gap-3 sm:gap-6 text-xs sm:text-sm font-bold text-slate-700">
                    <span class="flex items-center gap-1.5 bg-white px-3.5 py-2 rounded-xl border border-slate-200 shadow-xs">
                        📅 {{ $eventDate }}
                    </span>
                    <span class="flex items-center gap-1.5 bg-white px-3.5 py-2 rounded-xl border border-slate-200 shadow-xs">
                        📍 Lab Komputer Muhijunior
                    </span>
                    <span class="flex items-center gap-1.5 bg-white px-3.5 py-2 rounded-xl border border-slate-200 shadow-xs">
                        👥 2 Sesi Pilihan (Maks 90 Siswa / Sesi)
                    </span>
                </div>

                <!-- DUAL SESSION LIVE QUOTA CARDS (Centerpiece) -->
                <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto text-left">
                    
                    <!-- SESI 1 CARD -->
                    <div class="bg-white/95 backdrop-blur-md rounded-3xl p-6 sm:p-7 border-2 {{ $s1RemainingMain > 0 ? 'border-indigo-400 shadow-xl shadow-indigo-100' : 'border-slate-200 shadow-md' }} relative transition-all hover:scale-[1.01]">
                        @if($s1RemainingMain > 0)
                            <div class="absolute -top-3.5 right-6 bg-indigo-600 text-white text-[11px] font-black uppercase tracking-wider px-3 py-1 rounded-full shadow-md">
                                Sesi Pagi Favorit ☀️
                            </div>
                        @endif

                        <div class="flex items-start justify-between gap-2 mb-4">
                            <div>
                                <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest block">PILIHAN SESI 1</span>
                                <h3 class="text-xl font-black text-slate-900 mt-0.5">{{ $s1Name }}</h3>
                                <div class="inline-flex items-center gap-1.5 mt-1 font-mono font-bold text-xs text-slate-600 bg-slate-100 px-2.5 py-1 rounded-lg">
                                    ⏰ {{ $s1Time }}
                                </div>
                            </div>

                            <div class="text-right">
                                @if($s1RemainingMain > 0)
                                    <span class="inline-flex items-center gap-1 text-xs font-black text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-full">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Tersedia
                                    </span>
                                @elseif($s1RemainingWaitlist > 0)
                                    <span class="inline-flex items-center gap-1 text-xs font-black text-amber-700 bg-amber-100 px-2.5 py-1 rounded-full">
                                        Jalur Cadangan
                                    </span>
                                @else
                                    <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-full">Penuh</span>
                                @endif
                            </div>
                        </div>

                        <!-- Progress Bar Sesi 1 -->
                        <div class="space-y-2 mt-4">
                            <div class="flex justify-between text-xs font-bold text-slate-600">
                                <span>Kursi Utama Terisi: <strong class="text-indigo-600">{{ $s1MainCount }}</strong> / {{ $s1Max }}</span>
                                <span>{{ $s1RemainingMain }} Kursi Tersisa</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-3.5 overflow-hidden p-0.5 border border-slate-200">
                                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-full rounded-full transition-all duration-500" style="width: {{ $s1Percent }}%"></div>
                            </div>
                        </div>

                        <!-- Meta stats -->
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <span>Antrean Cadangan: <strong>{{ $s1WaitlistCount }}</strong> / {{ $s1WaitlistMax }}</span>
                            <a href="#pendaftaran" onclick="selectSession('1')" class="font-extrabold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                                Pilih Sesi 1 &rarr;
                            </a>
                        </div>
                    </div>

                    <!-- SESI 2 CARD -->
                    <div class="bg-white/95 backdrop-blur-md rounded-3xl p-6 sm:p-7 border-2 {{ $s2RemainingMain > 0 ? 'border-purple-400 shadow-xl shadow-purple-100' : 'border-slate-200 shadow-md' }} relative transition-all hover:scale-[1.01]">
                        @if($s2RemainingMain > 0)
                            <div class="absolute -top-3.5 right-6 bg-purple-600 text-white text-[11px] font-black uppercase tracking-wider px-3 py-1 rounded-full shadow-md">
                                Sesi Siang Santai 🌤️
                            </div>
                        @endif

                        <div class="flex items-start justify-between gap-2 mb-4">
                            <div>
                                <span class="text-xs font-bold text-purple-600 uppercase tracking-widest block">PILIHAN SESI 2</span>
                                <h3 class="text-xl font-black text-slate-900 mt-0.5">{{ $s2Name }}</h3>
                                <div class="inline-flex items-center gap-1.5 mt-1 font-mono font-bold text-xs text-slate-600 bg-slate-100 px-2.5 py-1 rounded-lg">
                                    ⏰ {{ $s2Time }}
                                </div>
                            </div>

                            <div class="text-right">
                                @if($s2RemainingMain > 0)
                                    <span class="inline-flex items-center gap-1 text-xs font-black text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-full">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                        Tersedia
                                    </span>
                                @elseif($s2RemainingWaitlist > 0)
                                    <span class="inline-flex items-center gap-1 text-xs font-black text-amber-700 bg-amber-100 px-2.5 py-1 rounded-full">
                                        Jalur Cadangan
                                    </span>
                                @else
                                    <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-full">Penuh</span>
                                @endif
                            </div>
                        </div>

                        <!-- Progress Bar Sesi 2 -->
                        <div class="space-y-2 mt-4">
                            <div class="flex justify-between text-xs font-bold text-slate-600">
                                <span>Kursi Utama Terisi: <strong class="text-purple-600">{{ $s2MainCount }}</strong> / {{ $s2Max }}</span>
                                <span>{{ $s2RemainingMain }} Kursi Tersisa</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-3.5 overflow-hidden p-0.5 border border-slate-200">
                                <div class="bg-gradient-to-r from-purple-500 to-pink-600 h-full rounded-full transition-all duration-500" style="width: {{ $s2Percent }}%"></div>
                            </div>
                        </div>

                        <!-- Meta stats -->
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                            <span>Antrean Cadangan: <strong>{{ $s2WaitlistCount }}</strong> / {{ $s2WaitlistMax }}</span>
                            <a href="#pendaftaran" onclick="selectSession('2')" class="font-extrabold text-purple-600 hover:text-purple-800 flex items-center gap-1">
                                Pilih Sesi 2 &rarr;
                            </a>
                        </div>
                    </div>

                </div>

                <!-- Big CTA Button -->
                <div class="mt-10">
                    <a href="#pendaftaran" class="inline-flex items-center gap-3 px-8 py-4 text-base sm:text-lg font-black text-white bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:to-pink-700 rounded-2xl shadow-xl shadow-indigo-600/30 hover:shadow-indigo-600/40 hover:-translate-y-0.5 transition-all">
                        <span>Pilih Sesi &amp; Amankan Kursimu Sekarang</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    <p class="text-xs text-slate-500 mt-2 font-medium">Bebas Biaya Pendaftaran &bull; Kuota terbatas masing-masing 90 siswa</p>
                </div>

            </div>
        </div>
    </section>

    <!-- Section: 3 Hal Keren yang Akan Dibuat Siswa -->
    <section id="materi" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-indigo-600 font-extrabold text-xs uppercase tracking-widest bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">
                    KURIKULUM MENYENANGKAN
                </span>
                <h2 class="mt-3 text-3xl font-black text-slate-900 tracking-tight sm:text-4xl">
                    Apa yang Akan Dibuat Putra/Putri Anda?
                </h2>
                <p class="mt-3 text-slate-600 text-sm sm:text-base">
                    Bukan hanya teori membosankan! Siswa diajak praktik langsung menghasilkan karya digital yang bisa mereka tunjukkan dan banggakan ke orang tua.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="group relative rounded-3xl p-8 bg-gradient-to-b from-blue-50/60 to-white border border-blue-100 hover:border-blue-300 shadow-sm hover:shadow-xl transition-all">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center text-3xl font-bold mb-6 shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform">
                        🎮
                    </div>
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-wider block mb-1">PROYEK 1</span>
                    <h3 class="text-xl font-extrabold text-slate-900 mb-3">Membuat Game Interaktif Sendiri</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Menggunakan visual block coding (Scratch), siswa belajar mengontrol karakter, menambahkan skor, efek suara, dan rintangan game dengan logika komputasional yang runtut.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="group relative rounded-3xl p-8 bg-gradient-to-b from-purple-50/60 to-white border border-purple-100 hover:border-purple-300 shadow-sm hover:shadow-xl transition-all">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-purple-600 to-pink-600 text-white flex items-center justify-center text-3xl font-bold mb-6 shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform">
                        🤖
                    </div>
                    <span class="text-xs font-bold text-purple-600 uppercase tracking-wider block mb-1">PROYEK 2</span>
                    <h3 class="text-xl font-extrabold text-slate-900 mb-3">Membuat Chatbot &amp; Cerita Bersama A.I.</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Anak diajak memahami bagaimana Artificial Intelligence mengenali perintah, menyusun ide cerita petualangan komik, dan merancang ilustrasi karakter kartun dengan prompt cerdas.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="group relative rounded-3xl p-8 bg-gradient-to-b from-emerald-50/60 to-white border border-emerald-100 hover:border-emerald-300 shadow-sm hover:shadow-xl transition-all">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-600 text-white flex items-center justify-center text-3xl font-bold mb-6 shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform">
                        💡
                    </div>
                    <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider block mb-1">PROYEK 3</span>
                    <h3 class="text-xl font-extrabold text-slate-900 mb-3">A.I. for Learning (Asisten Belajar)</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Edukasi etika penting: bagaimana memanfaatkan A.I. untuk membantu memahami soal matematika sulit, latihan percakapan bahasa Inggris, tanpa mencontek secara pasif.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Rundown Kegiatan (Tabbed Sesi 1 vs Sesi 2) -->
    <section id="rundown" class="py-20 bg-slate-50 border-y border-slate-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span class="text-indigo-600 font-extrabold text-xs uppercase tracking-widest bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">
                    JADWAL TERPERINCI
                </span>
                <h2 class="mt-3 text-3xl font-black text-slate-900 tracking-tight sm:text-4xl">
                    Rundown Acara per Sesi
                </h2>
                <p class="mt-2 text-slate-600 text-sm sm:text-base">
                    Senin, 21 Desember 2026 &bull; Pilih jadwal yang paling nyaman untuk ananda
                </p>

                <!-- Rundown Tab Switcher -->
                <div class="mt-8 inline-flex p-1.5 rounded-2xl bg-slate-200/80 border border-slate-300 max-w-md w-full">
                    <button type="button" onclick="switchRundown('1')" id="tabBtn1" class="w-1/2 py-2.5 rounded-xl text-xs sm:text-sm font-extrabold transition-all bg-white text-indigo-700 shadow-sm">
                        ☀️ Sesi 1 (08:00 – 10:30)
                    </button>
                    <button type="button" onclick="switchRundown('2')" id="tabBtn2" class="w-1/2 py-2.5 rounded-xl text-xs sm:text-sm font-extrabold transition-all text-slate-600 hover:text-slate-900">
                        🌤️ Sesi 2 (12:30 – 14:00)
                    </button>
                </div>
            </div>

            <!-- RUNDOWN SESI 1 CONTENT -->
            <div id="rundownSesi1" class="space-y-3.5 transition-all">
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-slate-100 font-mono font-black text-xs text-slate-700 shrink-0">07:30 – 08:00</span>
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-sm">Registrasi Ulang &amp; Pengambilan Name Tag</h4>
                            <p class="text-xs text-slate-500">Check-in barcode E-Ticket, pembagian Name Tag dan snack pagi.</p>
                        </div>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 shrink-0">30 Menit</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border-l-4 border-l-indigo-600 border border-slate-200 shadow-xs flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-indigo-100 font-mono font-black text-xs text-indigo-800 shrink-0">08:00 – 09:15</span>
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-sm">Modul 1: Coding Interaktif &amp; Game Making</h4>
                            <p class="text-xs text-slate-500">Mempelajari logika sekuensial, loop, dan merakit game perdana dengan Scratch.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-indigo-600 shrink-0">75 Menit</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-amber-100 font-mono font-black text-xs text-amber-800 shrink-0">09:15 – 09:30</span>
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-sm">Snack Break &amp; Ice Breaking Games 🍪</h4>
                            <p class="text-xs text-slate-500">Waktu santai, kuis seru berhadiah, dan networking teman baru.</p>
                        </div>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 shrink-0">15 Menit</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border-l-4 border-l-purple-600 border border-slate-200 shadow-xs flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-purple-100 font-mono font-black text-xs text-purple-800 shrink-0">09:30 – 10:15</span>
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-sm">Modul 2: A.I. for Learning &amp; Prompt Cilik</h4>
                            <p class="text-xs text-slate-500">Eksplorasi kecerdasan buatan, membuat asisten belajar, dan prompt engineering ramah anak.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-purple-600 shrink-0">45 Menit</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-emerald-100 font-mono font-black text-xs text-emerald-800 shrink-0">10:15 – 10:30</span>
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-sm">Showcase Karya, Pembagian Sertifikat &amp; Foto 🎓</h4>
                            <p class="text-xs text-slate-500">Orang tua dipersilakan masuk menyaksikan karya siswa dan penyerahan e-certificate.</p>
                        </div>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 shrink-0">15 Menit</span>
                </div>
            </div>

            <!-- RUNDOWN SESI 2 CONTENT -->
            <div id="rundownSesi2" class="space-y-3.5 hidden transition-all">
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-slate-100 font-mono font-black text-xs text-slate-700 shrink-0">12:00 – 12:30</span>
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-sm">Registrasi Ulang Sesi 2 &amp; Welcome Drink</h4>
                            <p class="text-xs text-slate-500">Check-in barcode E-Ticket, pengambilan Name Tag dan persiapan laptop di lab.</p>
                        </div>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 shrink-0">30 Menit</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border-l-4 border-l-purple-600 border border-slate-200 shadow-xs flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-purple-100 font-mono font-black text-xs text-purple-800 shrink-0">12:30 – 13:20</span>
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-sm">Modul 1: Fast-Track Visual Coding &amp; Game</h4>
                            <p class="text-xs text-slate-500">Membuat game interaktif terpandu dengan fokus logika kreatif &amp; algoritma.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-purple-600 shrink-0">50 Menit</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border-l-4 border-l-pink-600 border border-slate-200 shadow-xs flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-pink-100 font-mono font-black text-xs text-pink-800 shrink-0">13:20 – 13:50</span>
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-sm">Modul 2: A.I. for Learning Studio</h4>
                            <p class="text-xs text-slate-500">Praktik A.I. sebagai sahabat belajar pintar, eksplorasi sains, dan kuis ceria.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-pink-600 shrink-0">30 Menit</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-emerald-100 font-mono font-black text-xs text-emerald-800 shrink-0">13:50 – 14:00</span>
                        <div>
                            <h4 class="font-extrabold text-slate-900 text-sm">Showcase Karya, Sertifikat &amp; Penutupan Resmi 🎓</h4>
                            <p class="text-xs text-slate-500">Apresiasi karya anak, sertifikat resmi kegiatan, dan foto bersama.</p>
                        </div>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 shrink-0">10 Menit</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Fasilitas & Keunggulan -->
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80">
                    <div class="text-3xl mb-2">💻</div>
                    <h4 class="font-bold text-sm text-slate-900">Lab Ber-AC &amp; Nyaman</h4>
                    <p class="text-xs text-slate-500 mt-1">Fasilitas lab komputer ber-AC dengan koneksi internet cepat.</p>
                </div>
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80">
                    <div class="text-3xl mb-2">👨‍🏫</div>
                    <h4 class="font-bold text-sm text-slate-900">Mentor Berpengalaman</h4>
                    <p class="text-xs text-slate-500 mt-1">Dipandu instruktur ramah anak dengan rasio pendampingan ideal.</p>
                </div>
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80">
                    <div class="text-3xl mb-2">📜</div>
                    <h4 class="font-bold text-sm text-slate-900">E-Sertifikat Resmi</h4>
                    <p class="text-xs text-slate-500 mt-1">Sertifikat keikutsertaan resmi yang berguna untuk portofolio siswa.</p>
                </div>
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80">
                    <div class="text-3xl mb-2">🍿</div>
                    <h4 class="font-bold text-sm text-slate-900">Snack Box &amp; Minuman</h4>
                    <p class="text-xs text-slate-500 mt-1">Konsumsi istirahat yang lezat dan higienis untuk setiap peserta.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Formulir Pendaftaran (Dengan Pilihan Sesi Interaktif) -->
    <section id="pendaftaran" class="py-20 bg-gradient-to-b from-slate-50 to-indigo-50/40 border-t border-slate-200">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <span class="text-indigo-600 font-extrabold text-xs uppercase tracking-widest bg-indigo-100/70 px-3 py-1 rounded-full border border-indigo-200">
                    FORMULIR REGISTRASI RESMI
                </span>
                <h2 class="mt-3 text-3xl font-black text-slate-900 tracking-tight sm:text-4xl">
                    Pilih Sesi &amp; Daftarkan Ananda
                </h2>
                <p class="mt-2 text-slate-600 text-sm sm:text-base">
                    Mohon diisi dengan cermat oleh <strong>Orang Tua / Wali Siswa</strong>.
                </p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-2xl border border-slate-200/90 relative">
                
                @if(!$isGlobalOpen)
                    <div class="text-center py-12">
                        <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-3xl mx-auto mb-4">
                            🔒
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">Pendaftaran Saat Ini Ditutup</h3>
                        <p class="text-slate-500 text-sm max-w-md mx-auto mt-2">
                            Seluruh kuota utama dan antrean cadangan untuk Sesi 1 dan Sesi 2 telah terpenuhi. Silakan hubungi panitia untuk informasi batch berikutnya.
                        </p>
                    </div>
                @else
                    <form action="{{ route('register.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- PILIHAN SESI (Radio Cards Interaktif) -->
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-3">
                                Langkah 1: Pilih Sesi Kegiatan <span class="text-rose-500">*</span>
                            </label>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Option Sesi 1 -->
                                <label class="session-card relative p-5 rounded-2xl border-2 cursor-pointer transition-all flex flex-col justify-between {{ old('session', '1') === '1' ? 'border-indigo-600 bg-indigo-50/50 shadow-md ring-2 ring-indigo-500/20' : 'border-slate-200 hover:border-indigo-200' }}" id="sessionCard1">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-center gap-2.5">
                                            <input type="radio" name="session" value="1" id="radioSession1" {{ old('session', '1') === '1' ? 'checked' : '' }} onchange="onSessionChange('1')" class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                                            <div>
                                                <span class="block font-black text-slate-900 text-sm">{{ $s1Name }}</span>
                                                <span class="block text-xs font-mono font-bold text-indigo-700">⏰ {{ $s1Time }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-3 border-t border-slate-200/80 flex items-center justify-between text-xs">
                                        <span class="text-slate-500">Sisa Kuota:</span>
                                        @if($s1RemainingMain > 0)
                                            <span class="font-extrabold text-emerald-600 bg-emerald-100 px-2 py-0.5 rounded-md">
                                                {{ $s1RemainingMain }} Kursi Utama
                                            </span>
                                        @elseif($s1RemainingWaitlist > 0)
                                            <span class="font-extrabold text-amber-600 bg-amber-100 px-2 py-0.5 rounded-md">
                                                Jalur Cadangan (#{{ $s1WaitlistCount + 1 }})
                                            </span>
                                        @else
                                            <span class="font-bold text-rose-600 bg-rose-100 px-2 py-0.5 rounded-md">Penuh</span>
                                        @endif
                                    </div>
                                </label>

                                <!-- Option Sesi 2 -->
                                <label class="session-card relative p-5 rounded-2xl border-2 cursor-pointer transition-all flex flex-col justify-between {{ old('session') === '2' ? 'border-purple-600 bg-purple-50/50 shadow-md ring-2 ring-purple-500/20' : 'border-slate-200 hover:border-purple-200' }}" id="sessionCard2">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-center gap-2.5">
                                            <input type="radio" name="session" value="2" id="radioSession2" {{ old('session') === '2' ? 'checked' : '' }} onchange="onSessionChange('2')" class="w-4 h-4 text-purple-600 focus:ring-purple-500">
                                            <div>
                                                <span class="block font-black text-slate-900 text-sm">{{ $s2Name }}</span>
                                                <span class="block text-xs font-mono font-bold text-purple-700">⏰ {{ $s2Time }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-3 border-t border-slate-200/80 flex items-center justify-between text-xs">
                                        <span class="text-slate-500">Sisa Kuota:</span>
                                        @if($s2RemainingMain > 0)
                                            <span class="font-extrabold text-emerald-600 bg-emerald-100 px-2 py-0.5 rounded-md">
                                                {{ $s2RemainingMain }} Kursi Utama
                                            </span>
                                        @elseif($s2RemainingWaitlist > 0)
                                            <span class="font-extrabold text-amber-600 bg-amber-100 px-2 py-0.5 rounded-md">
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
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-3">
                                Langkah 2: Data Siswa (Peserta SD Kelas 6) <span class="text-rose-500">*</span>
                            </label>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Siswa <span class="text-rose-500">*</span></label>
                                    <input type="text" name="student_name" value="{{ old('student_name') }}" required placeholder="Contoh: Muhammad Rizky Pratama" class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('student_name') ? 'border-rose-400' : 'border-slate-300' }} text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                                    @error('student_name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Panggilan <span class="text-slate-400 font-normal">(untuk Name Tag)</span> <span class="text-rose-500">*</span></label>
                                    <input type="text" name="nickname" value="{{ old('nickname') }}" required placeholder="Contoh: Rizky" class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('nickname') ? 'border-rose-400' : 'border-slate-300' }} text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                                    @error('nickname') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Jenis Kelamin <span class="text-rose-500">*</span></label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50">
                                            <input type="radio" name="gender" value="L" {{ old('gender', 'L') === 'L' ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500">
                                            <span class="text-xs font-semibold text-slate-700">Laki-laki</span>
                                        </label>
                                        <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50">
                                            <input type="radio" name="gender" value="P" {{ old('gender') === 'P' ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500">
                                            <span class="text-xs font-semibold text-slate-700">Perempuan</span>
                                        </label>
                                    </div>
                                    @error('gender') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Asal Sekolah (SD/MI) <span class="text-rose-500">*</span></label>
                                    <input type="text" name="school_name" value="{{ old('school_name') }}" required placeholder="Contoh: SD Negeri Menteng 01" class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('school_name') ? 'border-rose-400' : 'border-slate-300' }} text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                                    @error('school_name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Pengalaman Coding / Menggunakan Komputer <span class="text-rose-500">*</span></label>
                                    <select name="experience_level" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                                        <option value="Belum Pernah" {{ old('experience_level') === 'Belum Pernah' ? 'selected' : '' }}>Belum Pernah (Pemula sama sekali - Sangat Disambut!)</option>
                                        <option value="Pernah Sedikit" {{ old('experience_level') === 'Pernah Sedikit' ? 'selected' : '' }}>Pernah Sedikit (Pernah coba game edukasi / Scratch)</option>
                                        <option value="Sudah Terbiasa" {{ old('experience_level') === 'Sudah Terbiasa' ? 'selected' : '' }}>Sudah Terbiasa (Sering menggunakan laptop &amp; eksplorasi game)</option>
                                    </select>
                                    @error('experience_level') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- DATA ORANG TUA -->
                        <div class="pt-2">
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-3">
                                Langkah 3: Data Orang Tua / Wali Siswa <span class="text-rose-500">*</span>
                            </label>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Orang Tua / Wali <span class="text-rose-500">*</span></label>
                                    <input type="text" name="parent_name" value="{{ old('parent_name') }}" required placeholder="Contoh: Budi Pratama" class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('parent_name') ? 'border-rose-400' : 'border-slate-300' }} text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                                    @error('parent_name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp Aktif <span class="text-rose-500">*</span></label>
                                    <input type="tel" name="whatsapp" value="{{ old('whatsapp') }}" required placeholder="Contoh: 08123456789" class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('whatsapp') ? 'border-rose-400' : 'border-slate-300' }} text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                                    <span class="text-[11px] text-slate-400 mt-1 block">Tiket dan konfirmasi grup akan dikirim ke nomor ini.</span>
                                    @error('whatsapp') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Email <span class="text-slate-400 font-normal">(Opsional)</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Contoh: budi@gmail.com" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Catatan Tambahan untuk Panitia <span class="text-slate-400 font-normal">(Opsional)</span></label>
                                    <textarea name="notes" rows="2" placeholder="Contoh: Membawa laptop sendiri / kebutuhan khusus..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- PERSETUJUAN -->
                        <div class="pt-2 space-y-3 bg-slate-50 p-4 rounded-2xl border border-slate-200">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" name="terms_agreement" value="1" {{ old('terms_agreement') ? 'checked' : '' }} required class="mt-1 w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                                <span class="text-xs text-slate-700 leading-relaxed">
                                    Saya menyatakan data yang diisi adalah benar dan mengizinkan putra/putri saya untuk mengikuti kegiatan workshop ini di Kampus Muhijunior. <span class="text-rose-500">*</span>
                                </span>
                            </label>
                            @error('terms_agreement') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror

                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" name="waitlist_agreement" value="1" {{ old('waitlist_agreement') ? 'checked' : '' }} required class="mt-1 w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                                <span class="text-xs text-slate-700 leading-relaxed">
                                    Saya memahami bahwa setiap sesi dibatasi 90 peserta utama. Jika kuota 90 kursi pada sesi yang saya pilih penuh, pendaftar akan masuk ke antrean cadangan dan dihubungi panitia jika ada kursi kosong. <span class="text-rose-500">*</span>
                                </span>
                            </label>
                            @error('waitlist_agreement') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- TOMBOL SUBMIT -->
                        <div class="pt-2">
                            <button type="submit" class="w-full py-4 px-6 text-sm sm:text-base font-black text-white bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:to-pink-700 rounded-2xl shadow-xl shadow-indigo-600/25 transition-all flex items-center justify-center gap-2">
                                <span>Kirim Pendaftaran &amp; Dapatkan E-Ticket Resmi</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </button>
                            <p class="text-center text-xs text-slate-400 mt-2">100% Gratis &bull; Konfirmasi instan dengan E-Ticket digital</p>
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
                <span class="text-indigo-600 font-extrabold text-xs uppercase tracking-widest bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">
                    PUSAT BANTUAN
                </span>
                <h2 class="mt-3 text-3xl font-black text-slate-900 tracking-tight sm:text-4xl">
                    Pertanyaan yang Sering Diajukan
                </h2>
            </div>

            <div class="space-y-4">
                <details class="group bg-slate-50 p-6 rounded-2xl border border-slate-200 transition-all [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex items-center justify-between cursor-pointer font-bold text-slate-900 text-sm sm:text-base">
                        <span>Apa perbedaan antara Sesi 1 dan Sesi 2?</span>
                        <span class="w-7 h-7 rounded-full bg-white flex items-center justify-center text-indigo-600 group-open:rotate-180 transition-transform">▾</span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Materi pembelajaran inti keduanya sama persis (Visual Coding Scratch &amp; A.I. for Learning). Perbedaannya terletak pada waktu pelaksanaan: <strong>Sesi 1 berlangsung pukul 08:00 – 10:30 WIB</strong> (durasi 2,5 jam dengan waktu istirahat dan eksplorasi santai), sedangkan <strong>Sesi 2 berlangsung pukul 12:30 – 14:00 WIB</strong> (durasi 1,5 jam dengan format padat interaktif). Orang tua bebas memilih sesi yang paling cocok.
                    </p>
                </details>

                <details class="group bg-slate-50 p-6 rounded-2xl border border-slate-200 transition-all [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex items-center justify-between cursor-pointer font-bold text-slate-900 text-sm sm:text-base">
                        <span>Bagaimana jika kuota 90 peserta pada salah satu sesi sudah penuh?</span>
                        <span class="w-7 h-7 rounded-full bg-white flex items-center justify-center text-indigo-600 group-open:rotate-180 transition-transform">▾</span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Jika kuota utama 90 kursi pada sesi pilihan Anda sudah penuh, Anda dapat memilih sesi lainnya yang masih memiliki kursi utama, atau tetap mendaftar sebagai <strong>Peserta Cadangan (Waitlist)</strong> pada sesi tersebut. Peserta cadangan akan dipromosikan otomatis jika ada peserta utama yang berhalangan hadir.
                    </p>
                </details>

                <details class="group bg-slate-50 p-6 rounded-2xl border border-slate-200 transition-all [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex items-center justify-between cursor-pointer font-bold text-slate-900 text-sm sm:text-base">
                        <span>Apakah benar-benar 100% gratis?</span>
                        <span class="w-7 h-7 rounded-full bg-white flex items-center justify-center text-indigo-600 group-open:rotate-180 transition-transform">▾</span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Benar! Kegiatan ini 100% GRATIS tanpa biaya registrasi maupun biaya tambahan apapun. Fasilitas modul, sertifikat, dan snack disediakan gratis oleh Muhijunior.
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
            b1.className = 'w-1/2 py-2.5 rounded-xl text-xs sm:text-sm font-extrabold transition-all bg-white text-indigo-700 shadow-sm';
            b2.className = 'w-1/2 py-2.5 rounded-xl text-xs sm:text-sm font-extrabold transition-all text-slate-600 hover:text-slate-900';
        } else {
            s2.classList.remove('hidden');
            s1.classList.add('hidden');
            b2.className = 'w-1/2 py-2.5 rounded-xl text-xs sm:text-sm font-extrabold transition-all bg-white text-purple-700 shadow-sm';
            b1.className = 'w-1/2 py-2.5 rounded-xl text-xs sm:text-sm font-extrabold transition-all text-slate-600 hover:text-slate-900';
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
            card1.className = 'session-card relative p-5 rounded-2xl border-2 cursor-pointer transition-all flex flex-col justify-between border-indigo-600 bg-indigo-50/50 shadow-md ring-2 ring-indigo-500/20';
            card2.className = 'session-card relative p-5 rounded-2xl border-2 cursor-pointer transition-all flex flex-col justify-between border-slate-200 hover:border-purple-200';
        } else {
            card2.className = 'session-card relative p-5 rounded-2xl border-2 cursor-pointer transition-all flex flex-col justify-between border-purple-600 bg-purple-50/50 shadow-md ring-2 ring-purple-500/20';
            card1.className = 'session-card relative p-5 rounded-2xl border-2 cursor-pointer transition-all flex flex-col justify-between border-slate-200 hover:border-indigo-200';
        }
    }
</script>
@endpush
