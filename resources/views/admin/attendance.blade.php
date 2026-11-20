@extends('layouts.admin')

@section('title', 'Presensi Kehadiran Siswa Hari-H - Panitia Event')

@section('content')
<div class="space-y-6">

    <!-- Top Bar Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-300 uppercase tracking-wider">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    MEJA REGISTRASI HARI-H
                </span>
                <span class="text-xs text-slate-500 font-bold">&bull; Real-time Presensi</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Presensi Kehadiran Siswa</h1>
            <p class="text-xs text-slate-500 mt-0.5">Scan barcode QR Code E-Ticket siswa, gunakan kamera scanner, atau ketik 5 huruf kode registrasi / nama siswa.</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <button type="button" onclick="openQrScannerModal()" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black uppercase tracking-wider rounded-xl shadow-xs transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span>Buka Kamera QR</span>
            </button>

            <a href="{{ route('admin.export', ['tab' => 'all', 'session' => $sessionFilter]) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2.5 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl border border-slate-300 shadow-xs transition-colors">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Unduh CSV Presensi</span>
            </a>
        </div>
    </div>

    <!-- Quick Check-in Console -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-purple-950 rounded-3xl p-6 text-white shadow-xl border border-slate-800 space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
            <div>
                <span class="text-xs font-black uppercase tracking-wider text-emerald-400">INPUT CEPAT CHECK-IN</span>
                <h3 class="text-lg font-black tracking-tight mt-0.5">Ketik 5 Huruf Kode Registrasi / Scan Barcode</h3>
            </div>
            <span class="text-xs text-slate-300 bg-white/10 px-3 py-1 rounded-full border border-white/10">
                Support Barcode Gun &bull; Scanner Kamera &bull; Manual
            </span>
        </div>

        <form action="{{ route('admin.quickCheckIn') }}" method="POST" id="quickCheckInForm" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
            @csrf
            <div class="relative flex-grow">
                <input type="text" name="code" id="checkInCodeInput" autofocus placeholder="Arahkan barcode scanner / ketik 5 huruf (misal: KMPXW) / nama siswa..." class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-white text-slate-900 placeholder:text-slate-400 text-sm font-bold uppercase tracking-wider outline-none focus:ring-4 focus:ring-emerald-400/50 shadow-inner">
                <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
            </div>

            <button type="submit" class="px-6 py-3.5 bg-emerald-500 hover:bg-emerald-600 font-black text-xs uppercase tracking-wider rounded-2xl text-white shadow-md transition-all shrink-0 flex items-center justify-center gap-2">
                <span>Check-in Sekarang</span>
                <span class="text-sm">&rarr;</span>
            </button>

            <button type="button" onclick="openQrScannerModal()" class="px-4 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-xs uppercase tracking-wider shadow-md transition-all flex items-center justify-center gap-1.5 shrink-0 whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span>Kamera</span>
            </button>
        </form>

        <div id="liveCheckInFeedback" class="hidden p-3 rounded-xl text-xs font-bold transition-all"></div>
    </div>

    <!-- Attendance Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card Total Hadir -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs">
            <span class="text-[11px] font-black uppercase text-slate-400 block tracking-wider">TOTAL KEHADIRAN</span>
            <div class="flex items-baseline gap-2 mt-1">
                <span class="text-3xl font-black text-slate-900">{{ $totalAttended }}</span>
                <span class="text-xs font-bold text-slate-400">/ {{ $totalUtama }} Siswa</span>
            </div>
            <div class="w-full bg-slate-100 h-2 rounded-full mt-3 overflow-hidden">
                <div class="bg-emerald-500 h-full rounded-full transition-all duration-500" style="width: {{ $totalPercent }}%"></div>
            </div>
            <span class="text-[10px] text-slate-400 mt-1.5 block font-bold">{{ $totalPercent }}% Kehadiran Keseluruhan</span>
        </div>

        <!-- Card Sesi 1 -->
        <div class="bg-white rounded-2xl p-5 border-2 border-indigo-100 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-black uppercase text-indigo-600 tracking-wider">{{ strtoupper($s1Name) }}</span>
                <span class="text-[10px] px-1.5 py-0.5 rounded-md bg-indigo-50 font-bold text-indigo-700">{{ $s1Time }}</span>
            </div>
            <div class="flex items-baseline gap-2 mt-1">
                <span class="text-3xl font-black text-indigo-900">{{ $s1Attended }}</span>
                <span class="text-xs font-bold text-slate-400">/ {{ $s1TotalUtama }} Hadir</span>
            </div>
            <div class="w-full bg-slate-100 h-2 rounded-full mt-3 overflow-hidden">
                <div class="bg-indigo-600 h-full rounded-full transition-all duration-500" style="width: {{ $s1Percent }}%"></div>
            </div>
            <span class="text-[10px] text-slate-400 mt-1.5 block font-bold">{{ $s1Percent }}% dari {{ $s1TotalUtama }} Peserta Utama</span>
        </div>

        <!-- Card Sesi 2 -->
        <div class="bg-white rounded-2xl p-5 border-2 border-purple-100 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-black uppercase text-purple-600 tracking-wider">{{ strtoupper($s2Name) }}</span>
                <span class="text-[10px] px-1.5 py-0.5 rounded-md bg-purple-50 font-bold text-purple-700">{{ $s2Time }}</span>
            </div>
            <div class="flex items-baseline gap-2 mt-1">
                <span class="text-3xl font-black text-purple-900">{{ $s2Attended }}</span>
                <span class="text-xs font-bold text-slate-400">/ {{ $s2TotalUtama }} Hadir</span>
            </div>
            <div class="w-full bg-slate-100 h-2 rounded-full mt-3 overflow-hidden">
                <div class="bg-purple-600 h-full rounded-full transition-all duration-500" style="width: {{ $s2Percent }}%"></div>
            </div>
            <span class="text-[10px] text-slate-400 mt-1.5 block font-bold">{{ $s2Percent }}% dari {{ $s2TotalUtama }} Peserta Utama</span>
        </div>

        <!-- Card Belum Hadir -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs">
            <span class="text-[11px] font-black uppercase text-amber-600 tracking-wider">BELUM CHECK-IN</span>
            <div class="flex items-baseline gap-2 mt-1">
                <span class="text-3xl font-black text-amber-700">{{ max(0, $totalUtama - $totalAttended) }}</span>
                <span class="text-xs font-bold text-slate-400">Siswa Tersisa</span>
            </div>
            <div class="w-full bg-slate-100 h-2 rounded-full mt-3 overflow-hidden">
                @php
                    $unattendedPercent = $totalUtama > 0 ? round((max(0, $totalUtama - $totalAttended) / $totalUtama) * 100) : 0;
                @endphp
                <div class="bg-amber-400 h-full rounded-full transition-all duration-500" style="width: {{ $unattendedPercent }}%"></div>
            </div>
            <span class="text-[10px] text-slate-400 mt-1.5 block font-bold">Menunggu registrasi ulang</span>
        </div>
    </div>

    <!-- Recent Check-ins Stream -->
    @if($recentCheckIns->count() > 0)
    <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-xs">
        <span class="text-[11px] font-black uppercase tracking-wider text-slate-400 block mb-2.5">
            ⏱️ CHECK-IN TERBARU HARI-H
        </span>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2.5">
            @foreach($recentCheckIns as $recent)
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between gap-2">
                    <div class="min-w-0">
                        <span class="block text-xs font-bold text-slate-900 truncate">{{ $recent->student_name }}</span>
                        <div class="flex items-center gap-1.5 mt-0.5">
                            <span class="font-mono text-[10px] font-bold text-indigo-700 bg-indigo-50 px-1.5 py-0.5 rounded">{{ $recent->reg_code }}</span>
                            <span class="text-[10px] text-slate-500">Sesi {{ $recent->session }}</span>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-1 rounded-lg shrink-0">
                        {{ $recent->attended_at ? $recent->attended_at->format('H:i') : '-' }} WIB
                    </span>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Filter & Search Toolbar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 border-b border-slate-200 pb-3">
        <!-- Session Switcher -->
        <div class="inline-flex p-1 rounded-xl bg-slate-200 border border-slate-300 self-start md:self-auto">
            <a href="{{ route('admin.attendance', ['session' => '', 'status' => $statusFilter, 'search' => $search]) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ empty($sessionFilter) ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Semua Sesi
            </a>
            <a href="{{ route('admin.attendance', ['session' => '1', 'status' => $statusFilter, 'search' => $search]) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $sessionFilter === '1' ? 'bg-indigo-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                ☀️ Sesi 1 (Pagi)
            </a>
            <a href="{{ route('admin.attendance', ['session' => '2', 'status' => $statusFilter, 'search' => $search]) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $sessionFilter === '2' ? 'bg-purple-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                🌤️ Sesi 2 (Siang)
            </a>
        </div>

        <!-- Status Filter Badges -->
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.attendance', ['session' => $sessionFilter, 'status' => '', 'search' => $search]) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all {{ empty($statusFilter) ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
                Semua Siswa
            </a>
            <a href="{{ route('admin.attendance', ['session' => $sessionFilter, 'status' => 'attended', 'search' => $search]) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 {{ $statusFilter === 'attended' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
                <span>✓ Sudah Hadir</span>
                <span class="px-1.5 py-0.5 rounded-md text-[10px] {{ $statusFilter === 'attended' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $totalAttended }}</span>
            </a>
            <a href="{{ route('admin.attendance', ['session' => $sessionFilter, 'status' => 'unattended', 'search' => $search]) }}" class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 {{ $statusFilter === 'unattended' ? 'bg-amber-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
                <span>○ Belum Hadir</span>
                <span class="px-1.5 py-0.5 rounded-md text-[10px] {{ $statusFilter === 'unattended' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">{{ max(0, $totalUtama - $totalAttended) }}</span>
            </a>
        </div>
    </div>

    <!-- Search Box Card -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-xs">
        <form method="GET" action="{{ route('admin.attendance') }}" class="flex items-center gap-3">
            <input type="hidden" name="session" value="{{ $sessionFilter }}">
            <input type="hidden" name="status" value="{{ $statusFilter }}">

            <div class="relative flex-grow">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama siswa, kode 5 huruf (misal: KMPXW), sekolah, atau WA orang tua..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-xs transition-colors shrink-0">
                Filter
            </button>

            @if($search || $sessionFilter || $statusFilter)
                <a href="{{ route('admin.attendance') }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition-colors shrink-0">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Attendance Roster Table -->
    <div class="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-black text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 text-center w-12">No</th>
                        <th class="py-3.5 px-4">Kode Tiket</th>
                        <th class="py-3.5 px-4">Nama Siswa</th>
                        <th class="py-3.5 px-4">Asal Sekolah</th>
                        <th class="py-3.5 px-4 text-center">Sesi</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-center">Presensi Hari-H</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium">
                    @forelse($participants as $index => $p)
                        <tr class="hover:bg-slate-50/80 transition-colors {{ $p->is_attended ? 'bg-emerald-50/30' : '' }}">
                            <td class="py-3.5 px-4 text-center text-slate-400 font-bold">
                                {{ $participants->firstItem() + $index }}
                            </td>

                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <a href="{{ route('ticket.show', $p->reg_code) }}" target="_blank" class="font-mono font-black text-indigo-700 bg-indigo-50 hover:bg-indigo-100 px-2 py-1 rounded-lg border border-indigo-200 inline-block transition-colors" title="Lihat E-Ticket">
                                    {{ $p->reg_code }} &nearr;
                                </a>
                            </td>

                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-900 block">{{ $p->student_name }}</span>
                                @if($p->nickname)
                                    <span class="text-[11px] text-slate-400">Panggilan: {{ $p->nickname }} &bull; Ortu: {{ $p->parent_name }}</span>
                                @endif
                            </td>

                            <td class="py-3.5 px-4 text-slate-600">
                                {{ $p->school_name }}
                            </td>

                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                @if($p->session === '1')
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                        ☀️ {{ $p->session_name }}
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-200">
                                        🌤️ {{ $p->session_name }}
                                    </span>
                                @endif
                            </td>

                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                @if($p->status === 'UTAMA')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800">
                                        UTAMA
                                    </span>
                                @elseif($p->status === 'CADANGAN')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-100 text-amber-800">
                                        CADANGAN #{{ $p->waitlist_order ?? '1' }}
                                    </span>
                                @endif
                            </td>

                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                <form action="{{ route('admin.participants.checkin', $p->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 rounded-xl font-bold text-xs transition-all shadow-xs {{ $p->is_attended ? 'bg-emerald-600 hover:bg-emerald-700 text-white' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
                                        {{ $p->is_attended ? '✓ Hadir' : '○ Belum Hadir' }}
                                    </button>
                                </form>
                                @if($p->attended_at)
                                    <span class="text-[10px] text-emerald-700 font-bold block mt-1">
                                        {{ $p->attended_at->format('H:i') }} WIB
                                    </span>
                                @endif
                            </td>

                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ $p->whatsapp_confirmation_url }}" target="_blank" class="p-1.5 text-slate-400 hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors" title="Hubungi WhatsApp Orang Tua">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <p class="text-sm">Tidak ada data siswa ditemukan pada filter ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($participants->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $participants->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Modal Scanner QR Kamera -->
<div id="qrScannerModal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full overflow-hidden shadow-2xl border-2 border-slate-700">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-950 to-indigo-950 p-4 sm:p-5 text-white flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 flex items-center justify-center text-base">
                    📷
                </div>
                <div>
                    <h3 class="font-extrabold text-base">Scanner QR Presensi</h3>
                    <p class="text-[11px] text-slate-300">Arahkan kamera ke QR Code pada E-Tiket siswa</p>
                </div>
            </div>
            <button type="button" onclick="closeQrScannerModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center font-bold text-sm transition-colors">
                &times;
            </button>
        </div>

        <!-- Video Viewport with Targeting Overlay -->
        <div class="relative bg-slate-950 flex items-center justify-center overflow-hidden" style="min-height: 320px; max-height: 400px;">
            <video id="qrScannerVideo" playsinline autoplay muted class="w-full h-full object-cover"></video>

            <!-- Viewfinder Overlay Box -->
            <div class="absolute inset-0 pointer-events-none flex items-center justify-center p-6">
                <div class="relative w-56 h-56 border-2 border-emerald-400/80 rounded-2xl shadow-[0_0_0_9999px_rgba(0,0,0,0.45)]">
                    <span class="absolute -top-1 -left-1 w-6 h-6 border-t-4 border-l-4 border-emerald-400 rounded-tl-lg"></span>
                    <span class="absolute -top-1 -right-1 w-6 h-6 border-t-4 border-r-4 border-emerald-400 rounded-tr-lg"></span>
                    <span class="absolute -bottom-1 -left-1 w-6 h-6 border-b-4 border-l-4 border-emerald-400 rounded-bl-lg"></span>
                    <span class="absolute -bottom-1 -right-1 w-6 h-6 border-b-4 border-r-4 border-emerald-400 rounded-br-lg"></span>
                </div>
            </div>

            <!-- Loading / Camera Request Placeholder -->
            <div id="qrScannerLoading" class="absolute inset-0 bg-slate-900 flex flex-col items-center justify-center text-white text-center p-6 space-y-3">
                <div class="w-10 h-10 border-4 border-emerald-400 border-t-transparent rounded-full animate-spin"></div>
                <p class="text-xs font-bold text-slate-300">Menghubungkan ke kamera...</p>
                <p class="text-[11px] text-slate-400">Pastikan izin kamera disetujui di browser.</p>
            </div>
        </div>

        <!-- Status Toast Banner -->
        <div id="qrScanResultToast" class="hidden p-4 text-center border-t transition-all"></div>

        <!-- Footer Actions -->
        <div class="p-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between gap-3">
            <span class="text-xs text-slate-500 font-medium">
                💡 Tip: Anda juga dapat mengetik 5 huruf kode registrasi di form utama.
            </span>

            <button type="button" onclick="closeQrScannerModal()" class="px-4 py-2 text-xs font-bold text-slate-700 bg-white border border-slate-300 hover:bg-slate-100 rounded-xl transition-colors shrink-0">
                Tutup Scanner
            </button>
        </div>

    </div>
</div>

@push('scripts')
<script>
let qrMediaStream = null;
let qrScanInterval = null;
let isProcessingQr = false;
let barcodeDetector = null;

if ('BarcodeDetector' in window) {
    try {
        barcodeDetector = new BarcodeDetector({ formats: ['qr_code'] });
    } catch(e) {
        console.warn('BarcodeDetector format qr_code not supported:', e);
    }
}

function playSuccessBeep() {
    try {
        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        const osc = audioCtx.createOscillator();
        const gain = audioCtx.createGain();
        osc.connect(gain);
        gain.connect(audioCtx.destination);
        osc.type = 'sine';
        osc.frequency.setValueAtTime(880, audioCtx.currentTime);
        osc.frequency.exponentialRampToValueAtTime(1760, audioCtx.currentTime + 0.15);
        gain.gain.setValueAtTime(0.3, audioCtx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.2);
        osc.start();
        osc.stop(audioCtx.currentTime + 0.2);
    } catch(e) {}
}

async function openQrScannerModal() {
    const modal = document.getElementById('qrScannerModal');
    const video = document.getElementById('qrScannerVideo');
    const loading = document.getElementById('qrScannerLoading');
    const toast = document.getElementById('qrScanResultToast');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    toast.className = 'hidden';
    loading.style.display = 'flex';
    isProcessingQr = false;

    try {
        qrMediaStream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: 'environment', width: { ideal: 1280 }, height: { ideal: 720 } }
        });
        video.srcObject = qrMediaStream;
        await video.play();
        loading.style.display = 'none';

        startScanLoop();
    } catch(err) {
        loading.innerHTML = `
            <div class="text-rose-400 text-3xl">⚠️</div>
            <p class="text-xs font-bold text-rose-300">Tidak dapat mengakses kamera</p>
            <p class="text-[11px] text-slate-400 max-w-xs">${err.message || 'Izin kamera ditolak atau perangkat tidak memiliki kamera.'}</p>
        `;
    }
}

function closeQrScannerModal() {
    const modal = document.getElementById('qrScannerModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');

    if (qrScanInterval) {
        clearInterval(qrScanInterval);
        qrScanInterval = null;
    }
    if (qrMediaStream) {
        qrMediaStream.getTracks().forEach(track => track.stop());
        qrMediaStream = null;
    }
}

function startScanLoop() {
    const video = document.getElementById('qrScannerVideo');

    if (qrScanInterval) clearInterval(qrScanInterval);

    qrScanInterval = setInterval(async () => {
        if (isProcessingQr || !video.videoWidth || !barcodeDetector) return;

        try {
            const barcodes = await barcodeDetector.detect(video);
            if (barcodes.length > 0) {
                const detectedCode = barcodes[0].rawValue;
                handleDetectedQrCode(detectedCode);
            }
        } catch (e) {
            console.error('QR detection error:', e);
        }
    }, 300);
}

async function handleDetectedQrCode(rawCode) {
    if (isProcessingQr) return;
    isProcessingQr = true;

    playSuccessBeep();

    const toast = document.getElementById('qrScanResultToast');
    toast.className = 'p-3 bg-amber-50 text-amber-900 text-xs font-bold border-t border-amber-200 block';
    toast.innerHTML = `Memproses Check-in untuk: <span class="font-mono text-sm">${rawCode}</span>...`;

    try {
        const response = await fetch("{{ route('admin.quickCheckIn') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: 'code=' + encodeURIComponent(rawCode)
        });

        const data = await response.json();

        if (response.ok && data.success) {
            toast.className = 'p-4 bg-emerald-50 text-emerald-950 text-xs font-bold border-t-2 border-emerald-400 block';
            toast.innerHTML = `
                <div class="text-base font-black text-emerald-700">✅ CHECK-IN BERHASIL!</div>
                <div class="text-sm font-bold text-slate-800 mt-1">${data.student_name} (${data.reg_code})</div>
                <div class="text-xs text-slate-600 mt-0.5">${data.session_label} &bull; Status: <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">${data.status}</span></div>
            `;
            document.getElementById('checkInCodeInput').value = data.reg_code;
        } else {
            toast.className = 'p-3 bg-rose-50 text-rose-900 text-xs font-bold border-t border-rose-200 block';
            toast.innerHTML = `❌ ${data.message || 'Peserta tidak ditemukan atau gagal check-in.'}`;
        }
    } catch(err) {
        toast.className = 'p-3 bg-rose-50 text-rose-900 text-xs font-bold border-t border-rose-200 block';
        toast.innerHTML = `❌ Kesalahan jaringan / server.`;
    }

    setTimeout(() => {
        isProcessingQr = false;
    }, 2500);
}
</script>
@endpush
@endsection

