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

    <!-- Quick Check-in Hari-H Bar -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-purple-950 rounded-3xl p-6 text-white shadow-xl border border-slate-800">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 uppercase tracking-wider mb-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Presensi Otomatis QR Code &bull; 5 Huruf Registrasi
                </span>
                <h3 class="text-xl font-black tracking-tight">Check-in Kehadiran Siswa Hari-H</h3>
                <p class="text-xs text-slate-300 mt-0.5">Scan QR Code tiket atau ketik 5 huruf kode registrasi (misal: <strong>KMPXW</strong>) / nama siswa.</p>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 max-w-xl w-full">
                <form action="{{ route('admin.quickCheckIn') }}" method="POST" id="quickCheckInForm" class="flex items-center gap-2 flex-grow">
                    @csrf
                    <input type="text" name="code" id="checkInCodeInput" autofocus placeholder="Scan QR / ketik 5 huruf (misal: KMPXW)..." class="flex-grow px-4 py-3 rounded-2xl bg-white text-slate-900 placeholder:text-slate-400 text-sm font-bold uppercase tracking-wider outline-none focus:ring-2 focus:ring-emerald-400 shadow-inner">
                    <button type="submit" class="px-5 py-3 bg-emerald-500 hover:bg-emerald-600 font-black text-xs uppercase tracking-wider rounded-2xl text-white shadow-md transition-colors shrink-0">
                        Check-in
                    </button>
                </form>

                <button type="button" onclick="openQrScannerModal()" class="px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-xs uppercase tracking-wider shadow-md transition-all flex items-center justify-center gap-1.5 shrink-0 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Kamera QR</span>
                </button>
            </div>
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
                    <!-- Corner Brackets -->
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
            // Refresh main input
            document.getElementById('checkInCodeInput').value = data.reg_code;
        } else {
            toast.className = 'p-3 bg-rose-50 text-rose-900 text-xs font-bold border-t border-rose-200 block';
            toast.innerHTML = `❌ ${data.message || 'Peserta tidak ditemukan atau gagal check-in.'}`;
        }
    } catch(err) {
        toast.className = 'p-3 bg-rose-50 text-rose-900 text-xs font-bold border-t border-rose-200 block';
        toast.innerHTML = `❌ Kesalahan jaringan / server.`;
    }

    // Resume scanning after 2.5 seconds
    setTimeout(() => {
        isProcessingQr = false;
    }, 2500);
}
</script>
@endpush
@endsection
