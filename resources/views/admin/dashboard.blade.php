@extends('layouts.admin')

@section('title', 'Ringkasan Dashboard - Panitia Event')

@section('content')
<div class="space-y-8">

    <!-- Page Title & Top Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Dashboard Sistem Pendaftaran (2 Sesi)</h1>
            <p class="text-xs text-slate-500 mt-1">Monitoring kuota 90 peserta per sesi, antrean cadangan, dan presensi barcode hari-H.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.export', ['tab' => 'all']) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl shadow-xs transition-colors">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Export Semua CSV</span>
            </a>
            <a href="{{ route('admin.participants') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-xs transition-colors">
                <span>Kelola Data Peserta &rarr;</span>
            </a>
        </div>
    </div>

    <!-- Banner Menuju Meja Presensi Hari-H -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-purple-950 rounded-3xl p-6 text-white shadow-xl border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 uppercase tracking-wider">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Presensi &amp; Check-in Hari-H
                </span>
                <span class="text-xs text-slate-400 font-bold">&bull; {{ $totalAttended }} / {{ $totalUtama }} Siswa Hadir</span>
            </div>
            <h3 class="text-xl font-black tracking-tight">Meja Presensi Terpisah Hari-H</h3>
            <p class="text-xs text-slate-300 mt-1 max-w-xl">Presensi kehadiran dipisahkan ke dalam menu tersendiri agar panitia meja registrasi dapat fokus scan barcode QR E-Ticket atau input cepat 5 huruf kode registrasi.</p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('admin.attendance') }}" class="px-6 py-3.5 bg-emerald-500 hover:bg-emerald-600 font-black text-xs uppercase tracking-wider rounded-2xl text-white shadow-lg shadow-emerald-500/20 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                <span>Buka Menu Presensi &rarr;</span>
            </a>
        </div>
    </div>

    <!-- DUAL SESSION BREAKDOWN SECTION -->
    <div>
        <h2 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-3">Statistik Kapasitas Berdasarkan Sesi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Card Sesi 1 -->
            <div class="bg-white rounded-3xl p-6 border-2 border-indigo-200 shadow-sm relative overflow-hidden">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <span class="text-[11px] font-black uppercase tracking-wider text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg">SESI 1 (PAGI)</span>
                        <h3 class="text-lg font-black text-slate-900 mt-1">07:30 – 10:00 WIB</h3>
                    </div>
                    <span class="text-xs font-bold text-slate-400">Target: {{ $s1Max }} Siswa</span>
                </div>

                <div class="grid grid-cols-3 gap-3 mb-4 text-center">
                    <div class="bg-indigo-50/60 p-3 rounded-2xl border border-indigo-100">
                        <span class="text-xs text-slate-500 block">Peserta Utama</span>
                        <span class="text-2xl font-black text-indigo-700">{{ $s1Utama }}</span>
                        <span class="text-[10px] text-slate-400 block">/ {{ $s1Max }} kursi</span>
                    </div>

                    <div class="bg-emerald-50/60 p-3 rounded-2xl border border-emerald-100">
                        <span class="text-xs text-slate-500 block">Sisa Kursi</span>
                        <span class="text-2xl font-black text-emerald-600">{{ $s1Remaining }}</span>
                        <span class="text-[10px] text-slate-400 block">tersedia</span>
                    </div>

                    <div class="bg-amber-50/60 p-3 rounded-2xl border border-amber-100">
                        <span class="text-xs text-slate-500 block">Cadangan</span>
                        <span class="text-2xl font-black text-amber-600">{{ $s1Cadangan }}</span>
                        <span class="text-[10px] text-slate-400 block">antrean</span>
                    </div>
                </div>

                <!-- Progress Bar Sesi 1 -->
                <div class="space-y-1.5">
                    <div class="flex justify-between text-xs font-bold text-slate-500">
                        <span>Kapasitas Terisi: {{ min(100, round(($s1Utama / max(1, $s1Max)) * 100)) }}%</span>
                        <span>Presensi Hari-H: <strong class="text-indigo-600">{{ $s1Attended }}</strong> hadir</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-indigo-600 h-full rounded-full" style="width: {{ min(100, round(($s1Utama / max(1, $s1Max)) * 100)) }}%"></div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <a href="{{ route('admin.participants', ['session' => '1']) }}" class="font-bold text-indigo-600 hover:text-indigo-800">
                        Kelola Data Sesi 1 &rarr;
                    </a>
                    <a href="{{ route('admin.export', ['session' => '1']) }}" class="text-slate-400 hover:text-slate-600 font-semibold">
                        Export Sesi 1 CSV
                    </a>
                </div>
            </div>

            <!-- Card Sesi 2 -->
            <div class="bg-white rounded-3xl p-6 border-2 border-purple-200 shadow-sm relative overflow-hidden">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <span class="text-[11px] font-black uppercase tracking-wider text-purple-600 bg-purple-50 px-2.5 py-1 rounded-lg">SESI 2 (SIANG)</span>
                        <h3 class="text-lg font-black text-slate-900 mt-1">10:30 – 12:00 WIB</h3>
                    </div>
                    <span class="text-xs font-bold text-slate-400">Target: {{ $s2Max }} Siswa</span>
                </div>

                <div class="grid grid-cols-3 gap-3 mb-4 text-center">
                    <div class="bg-purple-50/60 p-3 rounded-2xl border border-purple-100">
                        <span class="text-xs text-slate-500 block">Peserta Utama</span>
                        <span class="text-2xl font-black text-purple-700">{{ $s2Utama }}</span>
                        <span class="text-[10px] text-slate-400 block">/ {{ $s2Max }} kursi</span>
                    </div>

                    <div class="bg-emerald-50/60 p-3 rounded-2xl border border-emerald-100">
                        <span class="text-xs text-slate-500 block">Sisa Kursi</span>
                        <span class="text-2xl font-black text-emerald-600">{{ $s2Remaining }}</span>
                        <span class="text-[10px] text-slate-400 block">tersedia</span>
                    </div>

                    <div class="bg-amber-50/60 p-3 rounded-2xl border border-amber-100">
                        <span class="text-xs text-slate-500 block">Cadangan</span>
                        <span class="text-2xl font-black text-amber-600">{{ $s2Cadangan }}</span>
                        <span class="text-[10px] text-slate-400 block">antrean</span>
                    </div>
                </div>

                <!-- Progress Bar Sesi 2 -->
                <div class="space-y-1.5">
                    <div class="flex justify-between text-xs font-bold text-slate-500">
                        <span>Kapasitas Terisi: {{ min(100, round(($s2Utama / max(1, $s2Max)) * 100)) }}%</span>
                        <span>Presensi Hari-H: <strong class="text-purple-600">{{ $s2Attended }}</strong> hadir</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-purple-600 h-full rounded-full" style="width: {{ min(100, round(($s2Utama / max(1, $s2Max)) * 100)) }}%"></div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <a href="{{ route('admin.participants', ['session' => '2']) }}" class="font-bold text-purple-600 hover:text-purple-800">
                        Kelola Data Sesi 2 &rarr;
                    </a>
                    <a href="{{ route('admin.export', ['session' => '2']) }}" class="text-slate-400 hover:text-slate-600 font-semibold">
                        Export Sesi 2 CSV
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- Global Statistics Overview -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs">
            <span class="text-xs font-bold text-slate-500 block mb-1">Total Pendaftar Utama</span>
            <div class="flex items-baseline gap-1.5">
                <span class="text-3xl font-black text-slate-900">{{ $totalUtama }}</span>
                <span class="text-xs font-semibold text-slate-400">/ {{ $totalMax }}</span>
            </div>
            <span class="text-[11px] text-indigo-600 font-semibold mt-2 block">{{ $totalRemaining }} kursi sisa total</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs">
            <span class="text-xs font-bold text-slate-500 block mb-1">Total Antrean Cadangan</span>
            <span class="text-3xl font-black text-amber-600">{{ $totalCadangan }}</span>
            <span class="text-[11px] text-slate-400 mt-2 block">S1: {{ $s1Cadangan }} | S2: {{ $s2Cadangan }}</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs">
            <span class="text-xs font-bold text-slate-500 block mb-1">Total Hadir Hari-H</span>
            <span class="text-3xl font-black text-emerald-600">{{ $totalAttended }}</span>
            <span class="text-[11px] text-slate-400 mt-2 block">{{ $totalUtama > 0 ? round(($totalAttended / $totalUtama) * 100) : 0 }}% dari peserta utama</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs">
            <span class="text-xs font-bold text-slate-500 block mb-1">Total Dibatalkan</span>
            <span class="text-3xl font-black text-rose-600">{{ $totalDibatalkan }}</span>
            <span class="text-[11px] text-slate-400 mt-2 block">Kursi dialihkan</span>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs col-span-2 lg:col-span-1">
            <span class="text-xs font-bold text-slate-500 block mb-1">Semua Riwayat Registrasi</span>
            <span class="text-3xl font-black text-slate-900">{{ $totalAll }}</span>
            <span class="text-[11px] text-slate-400 mt-2 block">Termasuk batal &amp; cadangan</span>
        </div>

    </div>

    <!-- Waitlist Priority per Session & Recent Registrations -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Waitlist Column -->
        <div class="bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs space-y-6">
            <div>
                <h3 class="font-black text-slate-900 text-sm">Prioritas Antrean Cadangan</h3>
                <p class="text-xs text-slate-400">Siap dipromosikan ke kursi utama per sesi</p>
            </div>

            <!-- Sesi 1 Cadangan -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-extrabold text-indigo-700">Sesi 1 (Pagi)</span>
                    <span class="text-[10px] font-bold bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded-full">{{ $s1Cadangan }} antre</span>
                </div>

                @if($waitlistS1->isEmpty())
                    <p class="text-xs text-slate-400 italic py-2">Tidak ada antrean cadangan Sesi 1.</p>
                @else
                    <div class="space-y-2">
                        @foreach($waitlistS1 as $wait)
                            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between gap-2">
                                <div>
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-[10px] font-black px-1.5 py-0.5 rounded-md bg-amber-500 text-white">#{{ $wait->waitlist_order }}</span>
                                        <span class="font-bold text-slate-900 text-xs">{{ $wait->student_name }}</span>
                                    </div>
                                    <span class="text-[10px] text-slate-400 block mt-0.5">{{ $wait->school_name }}</span>
                                </div>
                                <form action="{{ route('admin.participants.promote', $wait->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition-colors">
                                        Promosi &uarr;
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Sesi 2 Cadangan -->
            <div class="pt-4 border-t border-slate-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-extrabold text-purple-700">Sesi 2 (Siang)</span>
                    <span class="text-[10px] font-bold bg-purple-50 text-purple-700 px-2 py-0.5 rounded-full">{{ $s2Cadangan }} antre</span>
                </div>

                @if($waitlistS2->isEmpty())
                    <p class="text-xs text-slate-400 italic py-2">Tidak ada antrean cadangan Sesi 2.</p>
                @else
                    <div class="space-y-2">
                        @foreach($waitlistS2 as $wait)
                            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between gap-2">
                                <div>
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-[10px] font-black px-1.5 py-0.5 rounded-md bg-purple-500 text-white">#{{ $wait->waitlist_order }}</span>
                                        <span class="font-bold text-slate-900 text-xs">{{ $wait->student_name }}</span>
                                    </div>
                                    <span class="text-[10px] text-slate-400 block mt-0.5">{{ $wait->school_name }}</span>
                                </div>
                                <form action="{{ route('admin.participants.promote', $wait->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition-colors">
                                        Promosi &uarr;
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Registrations Table -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-200/90 p-6 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-black text-slate-900 text-sm">Pendaftar Terbaru</h3>
                    <p class="text-xs text-slate-400">Aktivitas pendaftaran siswa terakhir</p>
                </div>
                <a href="{{ route('admin.participants') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">
                    Lihat Semua Data &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider">
                            <th class="pb-3">Kode</th>
                            <th class="pb-3">Sesi</th>
                            <th class="pb-3">Nama Siswa</th>
                            <th class="pb-3">Asal Sekolah</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentParticipants as $p)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3 font-mono font-bold text-slate-900">{{ $p->reg_code }}</td>
                                <td class="py-3">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black {{ $p->session === '1' ? 'bg-indigo-100 text-indigo-700' : 'bg-purple-100 text-purple-700' }}">
                                        Sesi {{ $p->session }}
                                    </span>
                                </td>
                                <td class="py-3 font-bold text-slate-800">
                                    {{ $p->student_name }}
                                    <span class="text-slate-400 font-normal">({{ $p->nickname }})</span>
                                </td>
                                <td class="py-3 text-slate-500">{{ $p->school_name }}</td>
                                <td class="py-3">
                                    @if($p->status === 'UTAMA')
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">UTAMA</span>
                                    @elseif($p->status === 'CADANGAN')
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">CADANGAN #{{ $p->waitlist_order }}</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800">BATAL</span>
                                    @endif
                                </td>
                                <td class="py-3 text-right">
                                    <a href="{{ route('ticket.show', $p->reg_code) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 font-bold">
                                        Tiket &rarr;
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection
