@extends('layouts.admin')

@section('title', 'Ringkasan Dashboard - Panitia Event')

@section('content')
<div class="space-y-8">

    <!-- Page Title & Top Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Ringkasan Sistem Pendaftaran</h1>
            <p class="text-xs text-slate-500 mt-1">Monitoring kuota pendaftar, antrean cadangan, dan presensi kedatangan hari-H.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.export', ['tab' => 'all']) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl shadow-xs transition-colors">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Export CSV / Excel</span>
            </a>
            <a href="{{ route('admin.participants') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-xs transition-colors">
                <span>Kelola Peserta &rarr;</span>
            </a>
        </div>
    </div>

    <!-- Quick Check-in Hari-H Bar -->
    <div class="bg-gradient-to-r from-indigo-900 via-indigo-800 to-purple-900 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-white/20 text-indigo-100 uppercase tracking-wider mb-1">
                    Fitur Presensi Hari-H
                </span>
                <h3 class="text-lg font-black tracking-tight">Presensi Cepat / Barcode Scanner</h3>
                <p class="text-xs text-indigo-200 mt-0.5">Ketik Kode Registrasi (misal: AI26-001) atau Nama Siswa lalu tekan Enter.</p>
            </div>

            <form action="{{ route('admin.quickCheckIn') }}" method="POST" class="flex items-center gap-2 max-w-md w-full">
                @csrf
                <input type="text" name="code" autofocus placeholder="Scan / Ketik kode: AI26-001..." class="flex-grow px-4 py-2.5 rounded-xl bg-white text-slate-900 placeholder:text-slate-400 text-sm font-semibold outline-none focus:ring-2 focus:ring-emerald-400 shadow-inner">
                <button type="submit" class="px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 font-bold text-xs uppercase tracking-wider rounded-xl text-white shadow-md transition-colors shrink-0">
                    Check-in
                </button>
            </form>
        </div>
    </div>

    <!-- Statistics Metric Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        
        <!-- Peserta Utama -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-500 mb-2">
                <span>Peserta Utama</span>
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
            </div>
            <div class="flex items-baseline gap-1.5">
                <span class="text-3xl font-black text-slate-900">{{ $countUtama }}</span>
                <span class="text-xs font-semibold text-slate-400">/ {{ $maxMain }}</span>
            </div>
            <div class="mt-3 w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                <div class="bg-emerald-500 h-full rounded-full" style="width: {{ min(100, round(($countUtama / max(1, $maxMain)) * 100)) }}%"></div>
            </div>
            <span class="text-[11px] text-slate-400 mt-2 block">{{ $remainingMain }} kursi tersisa</span>
        </div>

        <!-- Peserta Cadangan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-500 mb-2">
                <span>Antrean Cadangan</span>
                <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
            </div>
            <div class="flex items-baseline gap-1.5">
                <span class="text-3xl font-black text-amber-600">{{ $countCadangan }}</span>
                <span class="text-xs font-semibold text-slate-400">/ {{ $maxWaitlist }} maks</span>
            </div>
            <div class="mt-3 w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                <div class="bg-amber-500 h-full rounded-full" style="width: {{ min(100, round(($countCadangan / max(1, $maxWaitlist)) * 100)) }}%"></div>
            </div>
            <span class="text-[11px] text-slate-400 mt-2 block">{{ $remainingWaitlist }} slot antrean</span>
        </div>

        <!-- Hadir Hari-H -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-500 mb-2">
                <span>Kehadiran Hari-H</span>
                <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span>
            </div>
            <div class="flex items-baseline gap-1.5">
                <span class="text-3xl font-black text-indigo-600">{{ $countAttended }}</span>
                <span class="text-xs font-semibold text-slate-400">hadir</span>
            </div>
            <div class="mt-3 w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                <div class="bg-indigo-500 h-full rounded-full" style="width: {{ $countUtama > 0 ? min(100, round(($countAttended / $countUtama) * 100)) : 0 }}%"></div>
            </div>
            <span class="text-[11px] text-slate-400 mt-2 block">{{ $countUtama > 0 ? round(($countAttended / $countUtama) * 100) : 0 }}% dari peserta utama</span>
        </div>

        <!-- Dibatalkan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs">
            <div class="flex items-center justify-between text-xs font-bold text-slate-500 mb-2">
                <span>Dibatalkan</span>
                <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
            </div>
            <div class="flex items-baseline gap-1.5">
                <span class="text-3xl font-black text-rose-600">{{ $countDibatalkan }}</span>
                <span class="text-xs font-semibold text-slate-400">orang</span>
            </div>
            <span class="text-[11px] text-slate-400 mt-5 block">Kursi dialihkan</span>
        </div>

        <!-- Total Pendaftar -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs col-span-2 lg:col-span-1">
            <div class="flex items-center justify-between text-xs font-bold text-slate-500 mb-2">
                <span>Total Registrasi</span>
                <span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span>
            </div>
            <div class="flex items-baseline gap-1.5">
                <span class="text-3xl font-black text-slate-900">{{ $totalAll }}</span>
                <span class="text-xs font-semibold text-slate-400">total</span>
            </div>
            <span class="text-[11px] text-slate-400 mt-5 block">Utama + Cadangan + Batal</span>
        </div>

    </div>

    <!-- Two Columns: Waitlist Top Priority & Recent Registrations -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Waitlist Top Candidates -->
        <div class="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-bold text-slate-900 text-sm">Prioritas Antrean Cadangan</h3>
                    <p class="text-xs text-slate-400">Siap dipromosikan ke peserta utama</p>
                </div>
                <span class="text-xs font-bold text-amber-700 bg-amber-50 px-2.5 py-1 rounded-full border border-amber-200">
                    {{ $countCadangan }} antre
                </span>
            </div>

            @if($waitlistTop->isEmpty())
                <div class="text-center py-10 text-xs text-slate-400">
                    Belum ada pendaftar di antrean cadangan.
                </div>
            @else
                <div class="space-y-3">
                    @foreach($waitlistTop as $wait)
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between gap-2">
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-[10px] font-black px-1.5 py-0.5 rounded-md bg-amber-500 text-white">#{{ $wait->waitlist_order }}</span>
                                    <span class="font-bold text-slate-900 text-xs">{{ $wait->student_name }}</span>
                                </div>
                                <span class="text-[11px] text-slate-400 block mt-0.5">{{ $wait->school_name }} &bull; {{ $wait->whatsapp }}</span>
                            </div>

                            <form action="{{ route('admin.participants.promote', $wait->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold shadow-xs transition-colors shrink-0" title="Promosikan ke Utama">
                                    Promosi &uarr;
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="mt-4 pt-4 border-t border-slate-100 text-center">
                <a href="{{ route('admin.participants', ['tab' => 'cadangan']) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">
                    Lihat Semua Cadangan &rarr;
                </a>
            </div>
        </div>

        <!-- Recent Registrations -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/90 p-6 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-bold text-slate-900 text-sm">Pendaftar Terbaru</h3>
                    <p class="text-xs text-slate-400">Aktivitas pendaftaran siswa terakhir</p>
                </div>
                <a href="{{ route('admin.participants') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">
                    Semua Data &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider">
                            <th class="pb-3">Kode</th>
                            <th class="pb-3">Nama Siswa</th>
                            <th class="pb-3">Asal Sekolah</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3">Waktu Daftar</th>
                            <th class="pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentParticipants as $p)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3 font-mono font-bold text-slate-900">{{ $p->reg_code }}</td>
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
                                <td class="py-3 text-slate-400">{{ $p->created_at->diffForHumans() }}</td>
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

