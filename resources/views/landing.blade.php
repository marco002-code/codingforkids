@extends('layouts.app')

@section('title', 'Coding for Kids & A.I. for Learning - Workshop SD Kelas 6')

@section('content')

    <!-- Flash Alerts -->
    @if(session('error'))
        <div class="max-w-5xl mx-auto px-4 mt-6">
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start gap-3 shadow-xs">
                <span class="text-xl">⚠️</span>
                <div class="text-sm font-medium">{{ session('error') }}</div>
            </div>
        </div>
    @endif

    @if(session('search_error'))
        <div class="max-w-5xl mx-auto px-4 mt-6">
            <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 flex items-start gap-3 shadow-xs">
                <span class="text-xl">🔍</span>
                <div class="text-sm font-medium">{{ session('search_error') }}</div>
            </div>
        </div>
    @endif

    @if(session('search_results'))
        <div class="max-w-5xl mx-auto px-4 mt-6">
            <div class="p-6 rounded-2xl bg-indigo-50 border border-indigo-200 text-indigo-900 shadow-sm">
                <h3 class="font-bold text-base mb-2">Ditemukan {{ count(session('search_results')) }} Tiket Pendaftaran:</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach(session('search_results') as $found)
                        <div class="p-3 bg-white rounded-xl border border-indigo-100 flex items-center justify-between">
                            <div>
                                <p class="font-bold text-slate-800 text-sm">{{ $found->student_name }}</p>
                                <p class="text-xs text-slate-500">{{ $found->reg_code }} &bull; Status: <span class="font-semibold text-indigo-600">{{ $found->status }}</span></p>
                            </div>
                            <a href="{{ route('ticket.show', $found->reg_code) }}" class="px-3 py-1.5 text-xs font-bold bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                Buka Tiket &rarr;
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Hero Section -->
    <section class="relative pt-12 pb-20 overflow-hidden bg-gradient-to-b from-indigo-50/60 via-white to-slate-50 border-b border-slate-100">
        <!-- Background decorative blobs -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-purple-200/50 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 -right-24 w-96 h-96 bg-indigo-200/50 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto">
                <!-- Badges Row -->
                <div class="inline-flex flex-wrap items-center justify-center gap-2 mb-6">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800 border border-indigo-200">
                        🎯 Khusus Siswa SD Kelas 6
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                        🎟️ 100% Gratis
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                        ⚡ Kuota Terbatas
                    </span>
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    Kenalkan Dunia <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600">Coding &amp; A.I.</span> Sejak Dini!
                </h1>
                
                <p class="mt-6 text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto font-normal">
                    Workshop interaktif, seru, dan ramah anak. Melatih logika berpikir komputasional serta membimbing anak memanfaatkan Kecerdasan Buatan (A.I.) sebagai asisten belajar masa depan.
                </p>

                <!-- Key Event Meta Grid -->
                <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-2xl mx-auto text-left">
                    <div class="bg-white/80 backdrop-blur-sm p-4 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl shrink-0">
                            📅
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-slate-500 uppercase tracking-wider">Tanggal</span>
                            <span class="text-sm font-bold text-slate-900">Senin, 21 Des 2026</span>
                        </div>
                    </div>

                    <div class="bg-white/80 backdrop-blur-sm p-4 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl shrink-0">
                            ⏰
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-slate-500 uppercase tracking-wider">Waktu</span>
                            <span class="text-sm font-bold text-slate-900">08.30 – 12.30 WIB</span>
                        </div>
                    </div>

                    <div class="bg-white/80 backdrop-blur-sm p-4 rounded-2xl border border-slate-200/80 shadow-xs flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                            📍
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-slate-500 uppercase tracking-wider">Tempat</span>
                            <span class="text-sm font-bold text-slate-900">Lab Digital Hub</span>
                        </div>
                    </div>
                </div>

                <!-- Live Quota Status Card (Main Feature) -->
                <div class="mt-10 bg-white rounded-3xl p-6 sm:p-8 shadow-xl shadow-indigo-100/50 border border-slate-200/90 max-w-2xl mx-auto text-left transition-all">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                        <div class="flex items-center gap-2.5">
                            <span class="flex h-3.5 w-3.5 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $remainingMain > 0 ? 'bg-emerald-400' : 'bg-amber-400' }} opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3.5 w-3.5 {{ $remainingMain > 0 ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                            </span>
                            <h3 class="font-extrabold text-slate-900 text-base">Status Kuota Pendaftaran Real-Time</h3>
                        </div>

                        <div>
                            @if(!$isOpen)
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                    Pendaftaran Ditutup
                                </span>
                            @elseif($remainingMain > 0)
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    Kursi Utama Tersedia
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                    Jalur Cadangan (Waitlist)
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Quota Progress Bar -->
                    <div class="space-y-2">
                        <div class="flex justify-between text-xs font-bold text-slate-600">
                            <span>Kursi Utama Terisi: <span class="text-indigo-600">{{ $activeMainCount }}</span> / {{ $maxMain }}</span>
                            <span>{{ $percentMain }}% Terisi</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-3.5 overflow-hidden p-0.5 border border-slate-200">
                            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-full rounded-full transition-all duration-500" style="width: {{ $percentMain }}%"></div>
                        </div>
                    </div>

                    <!-- Counter Badges -->
                    <div class="mt-5 grid grid-cols-2 gap-3 pt-4 border-t border-slate-100 text-center sm:text-left">
                        <div class="p-3 bg-indigo-50/50 rounded-2xl border border-indigo-100/80">
                            <span class="block text-xs font-semibold text-slate-500">Sisa Kuota Kursi Utama</span>
                            <span class="text-2xl font-black {{ $remainingMain > 0 ? 'text-indigo-600' : 'text-slate-400' }}">
                                {{ $remainingMain }} <span class="text-xs font-bold text-slate-500">Kursi</span>
                            </span>
                        </div>

                        <div class="p-3 bg-amber-50/50 rounded-2xl border border-amber-100/80">
                            <span class="block text-xs font-semibold text-slate-500">Antrean Peserta Cadangan</span>
                            <span class="text-2xl font-black text-amber-600">
                                {{ $activeWaitlistCount }} <span class="text-xs font-bold text-slate-500">/ {{ $maxWaitlist }} maks</span>
                            </span>
                        </div>
                    </div>

                    <!-- Explanatory note -->
                    <div class="mt-4 text-xs text-slate-500 leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-200/60">
                        @if($remainingMain > 0)
                            💡 <strong>Pendaftar ke-1 s/d {{ $maxMain }}</strong> otomatis terdaftar sebagai <strong>Peserta Utama</strong> dan langsung mendapatkan e-ticket konfirmasi.
                        @elseif($remainingWaitlist > 0)
                            ⚠️ <strong>Kuota utama telah penuh.</strong> Pendaftar saat ini otomatis masuk ke <strong>Peserta Cadangan (Waitlist)</strong> dan akan dipromosikan jika ada peserta utama yang berhalangan hadir.
                        @else
                            🚫 Kuota utama dan batas antrean cadangan telah penuh. Hubungi panitia via WhatsApp jika membutuhkan informasi tambahan.
                        @endif
                    </div>

                    <!-- CTA Button -->
                    <div class="mt-6">
                        @if($isOpen)
                            <a href="#pendaftaran" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 text-sm font-bold text-white {{ $remainingMain > 0 ? 'bg-indigo-600 hover:bg-indigo-700' : 'bg-amber-600 hover:bg-amber-700' }} rounded-xl shadow-lg shadow-indigo-600/25 transition-all text-center">
                                <span>{{ $remainingMain > 0 ? 'Amankan Kursi Utama Sekarang' : 'Daftar Antrean Cadangan Sekarang' }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        @else
                            <button disabled class="w-full px-6 py-3.5 text-sm font-bold text-slate-400 bg-slate-100 rounded-xl cursor-not-allowed text-center">
                                Pendaftaran Telah Ditutup
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Section: Tentang Acara & Manfaat -->
    <section id="tentang" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-indigo-600 font-bold text-xs uppercase tracking-widest">Tentang Acara</span>
                <h2 class="mt-2 text-3xl font-extrabold text-slate-900 tracking-tight sm:text-4xl">
                    Mengapa Siswa SD Kelas 6 Perlu Belajar Coding &amp; A.I.?
                </h2>
                <p class="mt-4 text-slate-600 text-base leading-relaxed">
                    Siswa kelas 6 berada pada fase transisi krusial menuju jenjang SMP. Mengenalkan konsep komputasi dan kecerdasan buatan sejak dini akan mengubah pola pikir anak dari sekadar <em>konsumen konten</em> menjadi <em>kreator dan pemecah masalah</em> (problem solver).
                </p>
            </div>

            <!-- 3 Pillars Grid -->
            <div id="materi" class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gradient-to-b from-indigo-50/50 to-white p-8 rounded-3xl border border-indigo-100/80 shadow-xs hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-600 text-white flex items-center justify-center text-2xl font-bold mb-6 shadow-md shadow-indigo-600/30">
                        🧩
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">1. Logika Pemrograman Visual</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Anak belajar konsep algoritma, sekuensial, dan perulangan (loops) dengan menyusun blok kode visual tanpa pusing memikirkan sintaks yang rumit. Langsung membuat game sederhana!
                    </p>
                </div>

                <div class="bg-gradient-to-b from-purple-50/50 to-white p-8 rounded-3xl border border-purple-100/80 shadow-xs hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 rounded-2xl bg-purple-600 text-white flex items-center justify-center text-2xl font-bold mb-6 shadow-md shadow-purple-600/30">
                        🤖
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">2. Mengenal Cara Kerja A.I.</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Membedah apa itu Artificial Intelligence dengan analogi sederhana dan interaktif. Anak diajak memahami bagaimana komputer belajar mengenali gambar, teks, dan suara.
                    </p>
                </div>

                <div class="bg-gradient-to-b from-emerald-50/50 to-white p-8 rounded-3xl border border-emerald-100/80 shadow-xs hover:shadow-md transition-shadow">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-600 text-white flex items-center justify-center text-2xl font-bold mb-6 shadow-md shadow-emerald-600/30">
                        💡
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">3. A.I. for Learning (Asisten Belajar)</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Edukasi etika dan cara cerdas memakai A.I. untuk membantu tugas sekolah, mencari ide sains, berlatih bahasa, dan berkreasi tanpa bergantung secara pasif.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Rundown / Jadwal -->
    <section id="rundown" class="py-20 bg-slate-50 border-y border-slate-200/80">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="text-indigo-600 font-bold text-xs uppercase tracking-widest">Jadwal Pelaksanaan</span>
                <h2 class="mt-2 text-3xl font-extrabold text-slate-900 tracking-tight sm:text-4xl">
                    Rundown Kegiatan Workshop
                </h2>
                <p class="mt-3 text-slate-600 text-sm sm:text-base">
                    Senin, 21 Desember 2026 &bull; Pukul 08.30 s/d 12.30 WIB
                </p>
            </div>

            <!-- Rundown Timeline Cards -->
            <div class="space-y-4">
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-slate-100 text-slate-800 font-extrabold text-xs sm:text-sm tracking-wide shrink-0">
                            08.30 – 09.00
                        </span>
                        <div>
                            <h4 class="font-bold text-slate-900 text-base">Registrasi Ulang &amp; Pembukaan</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Check-in peserta utama, pembagian ID badge/name tag, dan sambutan pengantar.</p>
                        </div>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 sm:text-right">30 Menit</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border-l-4 border-l-indigo-600 border border-slate-200 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-indigo-100 text-indigo-800 font-extrabold text-xs sm:text-sm tracking-wide shrink-0">
                            09.00 – 10.30
                        </span>
                        <div>
                            <h4 class="font-bold text-slate-900 text-base">Sesi 1: Fun Coding for Kids</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Praktik membuat game dan animasi interaktif menggunakan blok pemrograman visual.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-indigo-600 sm:text-right">90 Menit</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-amber-100 text-amber-800 font-extrabold text-xs sm:text-sm tracking-wide shrink-0">
                            10.30 – 10.45
                        </span>
                        <div>
                            <h4 class="font-bold text-slate-900 text-base">Istirahat &amp; Snack Time 🍪</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Waktu santai, refreshment, dan networking antar sesama teman baru.</p>
                        </div>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 sm:text-right">15 Menit</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border-l-4 border-l-purple-600 border border-slate-200 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-purple-100 text-purple-800 font-extrabold text-xs sm:text-sm tracking-wide shrink-0">
                            10.45 – 12.00
                        </span>
                        <div>
                            <h4 class="font-bold text-slate-900 text-base">Sesi 2: A.I. for Learning</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Eksplorasi kecerdasan buatan, prompt crafting untuk anak, dan membuat asisten belajar sendiri.</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-purple-600 sm:text-right">75 Menit</span>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <span class="px-3.5 py-1.5 rounded-xl bg-emerald-100 text-emerald-800 font-extrabold text-xs sm:text-sm tracking-wide shrink-0">
                            12.00 – 12.30
                        </span>
                        <div>
                            <h4 class="font-bold text-slate-900 text-base">Showcase Karya, Sertifikat &amp; Penutup 🎓</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Presentasi mini hasil karya siswa, apresiasi, pembagian sertifikat, dan foto bersama orang tua.</p>
                        </div>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 sm:text-right">30 Menit</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Persyaratan & Ketentuan -->
    <section class="py-16 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-slate-900 text-white rounded-3xl p-8 sm:p-12 relative overflow-hidden">
                <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div>
                        <span class="text-indigo-400 font-bold text-xs uppercase tracking-wider">Kesiapan Peserta</span>
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-white mt-2 leading-tight">
                            Persyaratan &amp; Perlengkapan yang Perlu Disiapkan
                        </h3>
                        <p class="mt-3 text-slate-300 text-sm leading-relaxed">
                            Kami memastikan kegiatan berjalan nyaman, aman, dan kondusif bagi seluruh siswa peserta.
                        </p>
                    </div>

                    <ul class="space-y-3.5 text-sm text-slate-200">
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">✓</span>
                            <span><strong>Siswa aktif SD/MI Kelas 6</strong> (Tahun Ajaran 2026/2027).</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">✓</span>
                            <span>Membawa <strong>Laptop pribadi + charger</strong> (Windows / Mac / Chromebook).</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">✓</span>
                            <span>Didampingi atau mendapatkan <strong>izin tertulis orang tua/wali</strong>.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">✓</span>
                            <span>Tidak dipungut biaya apapun (<strong>100% Gratis</strong>).</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Formulir Pendaftaran (Embedded Form) -->
    <section id="pendaftaran" class="py-20 bg-slate-50 border-t border-slate-200">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
                <span class="text-indigo-600 font-bold text-xs uppercase tracking-widest">Pendaftaran Online</span>
                <h2 class="mt-2 text-3xl font-extrabold text-slate-900 tracking-tight sm:text-4xl">
                    Formulir Registrasi Siswa
                </h2>
                <p class="mt-3 text-slate-600 text-sm sm:text-base">
                    Mohon diisi dengan lengkap dan teliti oleh <strong>Orang Tua / Wali Siswa</strong>.
                </p>

                <!-- Current Allocation Notice -->
                <div class="mt-6 p-4 rounded-2xl text-xs sm:text-sm font-medium {{ $remainingMain > 0 ? 'bg-emerald-50 border border-emerald-200 text-emerald-900' : 'bg-amber-50 border border-amber-200 text-amber-900' }}">
                    @if($remainingMain > 0)
                        ✅ <strong>Status Kuota Utama Masih Tersedia:</strong> Pendaftaran Anda saat ini akan langsung dialokasikan ke <strong>PESERTA UTAMA</strong> (Tersisa {{ $remainingMain }} kursi).
                    @elseif($remainingWaitlist > 0)
                        📋 <strong>Pemberitahuan Jalur Cadangan:</strong> Kuota utama ({{ $maxMain }} kursi) telah terisi. Pendaftaran ini otomatis masuk ke <strong>PESERTA CADANGAN (Antrean #{{ $activeWaitlistCount + 1 }})</strong>.
                    @else
                        ❌ Kuota peserta utama dan batas antrean cadangan telah penuh.
                    @endif
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-xl border border-slate-200/90">
                @if(!$isOpen)
                    <div class="text-center py-10">
                        <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-3xl mx-auto mb-4">
                            🔒
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">Pendaftaran Saat Ini Ditutup</h3>
                        <p class="text-slate-500 text-sm max-w-md mx-auto mt-2">
                            Pendaftaran event telah ditutup karena kuota maksimal telah terpenuhi. Silakan hubungi panitia untuk informasi ketersediaan atau batch berikutnya.
                        </p>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('contact_whatsapp', '081234567890')) }}" target="_blank" class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 text-white font-bold text-sm hover:bg-emerald-700 transition-colors">
                            Chat Panitia via WhatsApp
                        </a>
                    </div>
                @else
                    <form action="{{ route('register.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Section: Data Siswa -->
                        <div>
                            <div class="flex items-center gap-2 pb-3 mb-4 border-b border-slate-100">
                                <span class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs">1</span>
                                <h3 class="font-bold text-slate-900 text-base">Data Siswa (Peserta)</h3>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 mb-1">
                                        Nama Lengkap Siswa <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" name="student_name" value="{{ old('student_name') }}" required placeholder="Contoh: Muhammad Rizky Pratama" class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('student_name') ? 'border-rose-400 ring-1 ring-rose-400' : 'border-slate-300' }} text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                                    @error('student_name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">
                                        Nama Panggilan <span class="text-rose-500">*</span> <span class="text-slate-400 font-normal">(untuk Name Tag)</span>
                                    </label>
                                    <input type="text" name="nickname" value="{{ old('nickname') }}" required placeholder="Contoh: Rizky" class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('nickname') ? 'border-rose-400 ring-1 ring-rose-400' : 'border-slate-300' }} text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                                    @error('nickname') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">
                                        Jenis Kelamin <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors">
                                            <input type="radio" name="gender" value="L" {{ old('gender', 'L') === 'L' ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500">
                                            <span class="text-xs font-semibold text-slate-700">Laki-laki</span>
                                        </label>
                                        <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors">
                                            <input type="radio" name="gender" value="P" {{ old('gender') === 'P' ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500">
                                            <span class="text-xs font-semibold text-slate-700">Perempuan</span>
                                        </label>
                                    </div>
                                    @error('gender') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 mb-1">
                                        Asal Sekolah (SD/MI) <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" name="school_name" value="{{ old('school_name') }}" required placeholder="Contoh: SD Negeri Menteng 01 Jakarta" class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('school_name') ? 'border-rose-400 ring-1 ring-rose-400' : 'border-slate-300' }} text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                                    @error('school_name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 mb-1">
                                        Pengalaman Coding / Menggunakan Komputer <span class="text-rose-500">*</span>
                                    </label>
                                    <select name="experience_level" required class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('experience_level') ? 'border-rose-400 ring-1 ring-rose-400' : 'border-slate-300' }} text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white transition-all">
                                        <option value="Belum Pernah" {{ old('experience_level') === 'Belum Pernah' ? 'selected' : '' }}>Belum Pernah (Pemula sama sekali - Sangat Disambut!)</option>
                                        <option value="Pernah Sedikit" {{ old('experience_level') === 'Pernah Sedikit' ? 'selected' : '' }}>Pernah Sedikit (Pernah coba Scratch / game edukasi)</option>
                                        <option value="Sudah Terbiasa" {{ old('experience_level') === 'Sudah Terbiasa' ? 'selected' : '' }}>Sudah Terbiasa (Sering pakai laptop / coding blok)</option>
                                    </select>
                                    @error('experience_level') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section: Data Orang Tua / Wali -->
                        <div class="pt-4">
                            <div class="flex items-center gap-2 pb-3 mb-4 border-b border-slate-100">
                                <span class="w-7 h-7 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs">2</span>
                                <h3 class="font-bold text-slate-900 text-base">Data Orang Tua / Wali</h3>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 mb-1">
                                        Nama Lengkap Orang Tua / Wali <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" name="parent_name" value="{{ old('parent_name') }}" required placeholder="Contoh: Budi Pratama" class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('parent_name') ? 'border-rose-400 ring-1 ring-rose-400' : 'border-slate-300' }} text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                                    @error('parent_name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">
                                        Nomor WhatsApp Aktif <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="tel" name="whatsapp" value="{{ old('whatsapp') }}" required placeholder="Contoh: 08123456789" class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('whatsapp') ? 'border-rose-400 ring-1 ring-rose-400' : 'border-slate-300' }} text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                                    <p class="text-[11px] text-slate-400 mt-1">Penting: Tiket dan koordinasi grup akan dikirimkan ke nomor ini.</p>
                                    @error('whatsapp') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">
                                        Alamat Email <span class="text-slate-400 font-normal">(Opsional)</span>
                                    </label>
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Contoh: budi@gmail.com" class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('email') ? 'border-rose-400 ring-1 ring-rose-400' : 'border-slate-300' }} text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                                    @error('email') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-xs font-bold text-slate-700 mb-1">
                                        Catatan Tambahan untuk Panitia <span class="text-slate-400 font-normal">(Opsional)</span>
                                    </label>
                                    <textarea name="notes" rows="2" placeholder="Contoh: Ananda membutuhkan meja khusus / alergi tertentu..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Section: Persetujuan (Checkboxes) -->
                        <div class="pt-4 space-y-3 bg-slate-50 p-4 rounded-2xl border border-slate-200/80">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" name="terms_agreement" value="1" {{ old('terms_agreement') ? 'checked' : '' }} required class="mt-1 w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                                <span class="text-xs text-slate-700 leading-relaxed">
                                    Saya menyatakan data di atas adalah benar dan mengizinkan putra/putri saya untuk mengikuti seluruh rangkaian kegiatan workshop ini. <span class="text-rose-500">*</span>
                                </span>
                            </label>
                            @error('terms_agreement') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror

                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" name="waitlist_agreement" value="1" {{ old('waitlist_agreement') ? 'checked' : '' }} required class="mt-1 w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                                <span class="text-xs text-slate-700 leading-relaxed">
                                    Saya memahami sistem kuota event: apabila kuota utama penuh, pendaftar akan otomatis dialokasikan ke <strong>Peserta Cadangan (Waitlist)</strong> dan akan dihubungi jika terdapat kursi kosong. <span class="text-rose-500">*</span>
                                </span>
                            </label>
                            @error('waitlist_agreement') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit" class="w-full py-4 px-6 text-sm sm:text-base font-extrabold text-white {{ $remainingMain > 0 ? 'bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700' : 'bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700' }} rounded-xl shadow-lg transition-all flex items-center justify-center gap-2">
                                <span>{{ $remainingMain > 0 ? 'Kirim Pendaftaran (Peserta Utama)' : 'Kirim Pendaftaran (Daftar Antrean Cadangan)' }}</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </button>
                            <p class="text-center text-xs text-slate-400 mt-2">Data Anda aman dan hanya digunakan untuk keperluan koordinasi kegiatan edukasi ini.</p>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </section>

    <!-- Section: FAQ (Pertanyaan yang Sering Diajukan) -->
    <section id="faq" class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-indigo-600 font-bold text-xs uppercase tracking-widest">Pusat Bantuan</span>
                <h2 class="mt-2 text-3xl font-extrabold text-slate-900 tracking-tight sm:text-4xl">
                    Pertanyaan yang Sering Diajukan (FAQ)
                </h2>
            </div>

            <div class="space-y-4">
                <!-- FAQ 1 -->
                <details class="group bg-slate-50 p-6 rounded-2xl border border-slate-200/80 transition-all [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex items-center justify-between cursor-pointer font-bold text-slate-900 text-sm sm:text-base">
                        <span>Apakah kegiatan workshop ini benar-benar 100% gratis?</span>
                        <span class="w-7 h-7 rounded-full bg-white flex items-center justify-center text-indigo-600 group-open:rotate-180 transition-transform">▾</span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Ya, benar! Kegiatan ini sepenuhnya <strong>GRATIS tanpa dipungut biaya sepeserpun</strong>. Seluruh fasilitas workshop, materi panduan, modul, e-certificate resmi, serta konsumsi ringan (snack) disediakan oleh panitia.
                    </p>
                </details>

                <!-- FAQ 2 -->
                <details class="group bg-slate-50 p-6 rounded-2xl border border-slate-200/80 transition-all [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex items-center justify-between cursor-pointer font-bold text-slate-900 text-sm sm:text-base">
                        <span>Bagaimana cara kerja sistem Peserta Cadangan (Waitlist)?</span>
                        <span class="w-7 h-7 rounded-full bg-white flex items-center justify-center text-indigo-600 group-open:rotate-180 transition-transform">▾</span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Jika kuota 50 kursi utama telah terisi, pendaftar berikutnya akan memperoleh nomor antrean cadangan (#1, #2, dst). Apabila ada peserta utama yang berhalangan hadir dan membatalkan keikutsertaannya, panitia akan langsung menghubungi peserta cadangan nomor teratas paling lambat H-2 acara (Sabtu, 19 Desember 2026) untuk dipromosikan ke kursi utama.
                    </p>
                </details>

                <!-- FAQ 3 -->
                <details class="group bg-slate-50 p-6 rounded-2xl border border-slate-200/80 transition-all [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex items-center justify-between cursor-pointer font-bold text-slate-900 text-sm sm:text-base">
                        <span>Apakah anak harus memiliki kemampuan coding sebelumnya?</span>
                        <span class="w-7 h-7 rounded-full bg-white flex items-center justify-center text-indigo-600 group-open:rotate-180 transition-transform">▾</span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Sama sekali tidak! Kurikulum dirancang dari tingkat dasar khusus untuk siswa kelas 6 SD. Materi disampaikan secara menyenangkan melalui pendekatan visual dan berbasis permainan (gamified learning) dengan bimbingan mentor berpengalaman.
                    </p>
                </details>

                <!-- FAQ 4 -->
                <details class="group bg-slate-50 p-6 rounded-2xl border border-slate-200/80 transition-all [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex items-center justify-between cursor-pointer font-bold text-slate-900 text-sm sm:text-base">
                        <span>Apakah orang tua boleh ikut mendampingi selama workshop?</span>
                        <span class="w-7 h-7 rounded-full bg-white flex items-center justify-center text-indigo-600 group-open:rotate-180 transition-transform">▾</span>
                    </summary>
                    <p class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Orang tua/wali dipersilakan mengantar dan hadir pada sesi pembukaan serta sesi penutup (showcase karya & penyerahan sertifikat). Untuk ruang workshop utama, siswa akan didampingi secara mandiri oleh tim instruktur agar anak dapat fokus dan bereksplorasi secara aktif bersama rekan sebayanya.
                    </p>
                </details>
            </div>
        </div>
    </section>

@endsection
