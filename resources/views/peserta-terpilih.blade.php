@extends('layouts.app')

@section('title', 'Daftar Peserta Terpilih - Coding for Kids & A.I. | SMP Muhammadiyah 1 Yogyakarta')

@section('content')
<div class="py-12 bg-coding-grid min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Top Navigation / Breadcrumb -->
        <div class="flex items-center justify-between mb-6 no-print">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-black text-blue-950 hover:text-amber-600 transition-colors">
                &larr; Kembali ke Beranda
            </a>

            <div class="flex items-center gap-2">
                <button type="button" onclick="window.print()" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-black text-blue-950 bg-white border-2 border-blue-950 rounded-xl shadow-xs hover:bg-amber-50 transition-all">
                    <svg class="w-4 h-4 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    <span>Cetak Daftar (PDF)</span>
                </button>
            </div>
        </div>

        <!-- Header Banner -->
        <div class="cartoon-box p-8 sm:p-10 mb-8 bg-gradient-to-r from-amber-400 via-amber-300 to-yellow-400 relative overflow-hidden">
            <!-- Background Doodles -->
            <div class="absolute -right-8 -bottom-8 text-blue-950/15 text-8xl font-black select-none pointer-events-none">
                🏆
            </div>

            <div class="relative z-10 max-w-3xl">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-950 text-white text-xs font-black uppercase tracking-wider mb-3">
                    <span>📢 PENGUMUMAN RESMI PESERTA</span>
                </div>
                <h1 class="font-display font-black text-3xl sm:text-5xl text-blue-950 tracking-tight leading-tight">
                    Daftar Peserta Terpilih
                </h1>
                <p class="font-display font-bold text-sm sm:text-base text-blue-950/90 mt-2">
                    Workshop Coding for Kids and A.I. for Learning 2026 &bull; SMP Muhammadiyah 1 Yogyakarta
                </p>
                <div class="mt-4 flex flex-wrap gap-4 text-xs font-bold text-blue-950">
                    <span class="flex items-center gap-1.5">
                        📅 <strong>{{ $eventDate }}</strong>
                    </span>
                    <span class="flex items-center gap-1.5">
                        📍 <strong>Lab TIK 1 &amp; 3 (Lantai 3 Gedung Selatan)</strong>
                    </span>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="cartoon-box p-5 bg-white flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Total Peserta Terpilih</span>
                    <span class="font-display font-black text-3xl text-blue-950 mt-1 block">{{ $totalSelected }} Siswa</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-950 flex items-center justify-center text-2xl font-black">
                    🎓
                </div>
            </div>

            <div class="cartoon-box p-5 bg-white flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">☀️ Sesi 1 (Pagi)</span>
                    <span class="font-display font-black text-3xl text-blue-900 mt-1 block">{{ $s1Total }} / 90</span>
                    <span class="text-[11px] text-slate-500 font-semibold">Pukul 08:00 – 10:30 WIB</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-800 flex items-center justify-center text-2xl font-black">
                    ☀️
                </div>
            </div>

            <div class="cartoon-box p-5 bg-white flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">🌤️ Sesi 2 (Siang)</span>
                    <span class="font-display font-black text-3xl text-purple-900 mt-1 block">{{ $s2Total }} / 90</span>
                    <span class="text-[11px] text-slate-500 font-semibold">Pukul 12:30 – 14:00 WIB</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-800 flex items-center justify-center text-2xl font-black">
                    🌤️
                </div>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="cartoon-box p-5 bg-white mb-6 no-print">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                
                <!-- Session Tabs -->
                <div class="inline-flex p-1 bg-slate-100 rounded-2xl border-2 border-slate-200">
                    <a href="{{ route('participants.selected', ['session' => 'all', 'search' => $search]) }}" class="px-4 py-2 rounded-xl text-xs font-extrabold transition-all {{ $session === 'all' ? 'bg-blue-950 text-white shadow-xs' : 'text-slate-600 hover:text-blue-950' }}">
                        Semua Sesi ({{ $totalSelected }})
                    </a>
                    <a href="{{ route('participants.selected', ['session' => '1', 'search' => $search]) }}" class="px-4 py-2 rounded-xl text-xs font-extrabold transition-all {{ $session === '1' ? 'bg-blue-950 text-white shadow-xs' : 'text-slate-600 hover:text-blue-950' }}">
                        ☀️ Sesi 1 ({{ $s1Total }})
                    </a>
                    <a href="{{ route('participants.selected', ['session' => '2', 'search' => $search]) }}" class="px-4 py-2 rounded-xl text-xs font-extrabold transition-all {{ $session === '2' ? 'bg-purple-900 text-white shadow-xs' : 'text-slate-600 hover:text-purple-900' }}">
                        🌤️ Sesi 2 ({{ $s2Total }})
                    </a>
                </div>

                <!-- Search Input -->
                <form action="{{ route('participants.selected') }}" method="GET" class="flex items-center gap-2 max-w-md w-full">
                    <input type="hidden" name="session" value="{{ $session }}">
                    <div class="relative w-full">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama siswa / asal sekolah / kode..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border-2 border-slate-300 text-xs font-semibold focus:border-blue-950 focus:ring-0 outline-none">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <button type="submit" class="px-4 py-2.5 bg-blue-950 text-white text-xs font-black rounded-xl hover:bg-blue-900 transition-colors shrink-0">
                        Cari
                    </button>
                    @if($search)
                        <a href="{{ route('participants.selected', ['session' => $session]) }}" class="p-2.5 text-slate-400 hover:text-rose-500 rounded-xl hover:bg-slate-100" title="Reset filter">
                            ✕
                        </a>
                    @endif
                </form>

            </div>
        </div>

        <!-- Participants Table Card -->
        <div class="cartoon-box overflow-hidden bg-white mb-8">
            <div class="p-5 border-b-2 border-slate-200 flex items-center justify-between">
                <h3 class="font-display font-black text-lg text-blue-950 flex items-center gap-2">
                    <span>📋</span> Daftar Peserta Terdaftar
                </h3>
                <span class="text-xs font-bold text-slate-500">
                    Menampilkan {{ $participants->total() }} Peserta
                </span>
            </div>

            @if($participants->isEmpty())
                <div class="text-center py-16 px-4">
                    <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-3xl mx-auto mb-3">
                        🔍
                    </div>
                    <h4 class="font-display font-black text-lg text-slate-800">Tidak Ada Peserta yang Sesuai</h4>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto font-medium">
                        Coba periksa kata kunci pencarian Anda atau ganti filter sesi kegiatan.
                    </p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-700 uppercase tracking-wider font-display font-black border-b-2 border-slate-200">
                            <tr>
                                <th class="py-3 px-4 w-12 text-center">No</th>
                                <th class="py-3 px-4">Kode Tiket</th>
                                <th class="py-3 px-4">Nama Siswa</th>
                                <th class="py-3 px-4">Asal Sekolah</th>
                                <th class="py-3 px-4">Pilihan Sesi</th>
                                <th class="py-3 px-4 text-center">Status</th>
                                <th class="py-3 px-4 text-center no-print">E-Ticket</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium">
                            @foreach($participants as $idx => $student)
                                <tr class="hover:bg-amber-50/60 transition-colors">
                                    <td class="py-3.5 px-4 text-center font-bold text-slate-400">
                                        {{ $participants->firstItem() + $idx }}
                                    </td>
                                    <td class="py-3.5 px-4 font-mono font-bold text-blue-950">
                                        {{ $student->reg_code }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <strong class="text-slate-900 font-extrabold text-sm block">{{ $student->student_name }}</strong>
                                        <span class="text-[11px] text-slate-500">Gender: {{ $student->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                    </td>
                                    <td class="py-3.5 px-4 font-bold text-slate-700">
                                        {{ $student->school_name }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <span class="inline-block px-2.5 py-1 rounded-lg text-[10px] font-black {{ $student->session === '1' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                            Sesi {{ $student->session }} ({{ $student->session_time }})
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-300">
                                            ✓ TERPILIH
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center no-print">
                                        <a href="{{ route('ticket.show', $student->reg_code) }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-[11px] font-black bg-blue-950 text-white rounded-lg hover:bg-blue-900 transition-colors shadow-xs">
                                            <span>Buka Tiket</span> &rarr;
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($participants->hasPages())
                    <div class="p-4 border-t-2 border-slate-200 no-print">
                        {{ $participants->links() }}
                    </div>
                @endif
            @endif
        </div>

        <!-- Panduan & Informasi Hari-H -->
        <div class="cartoon-box p-6 bg-amber-50 border-2 border-amber-300">
            <h4 class="font-display font-black text-base text-blue-950 flex items-center gap-2 mb-2">
                <span>📌</span> Informasi Penting untuk Peserta Terpilih
            </h4>
            <ul class="text-xs text-slate-700 space-y-1.5 list-disc list-inside font-medium leading-relaxed">
                <li>Peserta wajib hadir <strong>30 menit sebelum sesi dimulai</strong> untuk registrasi ulang dan pengambilan Name Tag resmi.</li>
                <li>Membawa <strong>E-Ticket (cetak atau tunjukkan di HP)</strong> saat tiba di Lab TIK SMP Muhammadiyah 1 Yogyakarta.</li>
                <li>Peserta disarankan membawa <strong>laptop pribadi + charger</strong> masing-masing (Windows / Mac / Chromebook).</li>
                <li>Memakai seragam sekolah masing-masing atau pakaian bebas rapi bersepatu.</li>
            </ul>
        </div>

    </div>
</div>
@endsection
