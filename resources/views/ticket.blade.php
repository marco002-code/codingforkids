@extends('layouts.app')

@section('title', 'E-Ticket: ' . $participant->reg_code . ' - ' . $participant->student_name)

@php
    $logo1 = asset('images/logo-muhijunior-iss.png');
    $logo2 = asset('images/logo-smp-muh1.png');
    if (file_exists(public_path('images/logo-muhijunior-iss.png'))) {
        $logo1 = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/logo-muhijunior-iss.png')));
    }
    if (file_exists(public_path('images/logo-smp-muh1.png'))) {
        $logo2 = 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/logo-smp-muh1.png')));
    }
@endphp

@push('styles')
<style>
    @media print {
        @page {
            size: A4 portrait;
            margin: 6mm 8mm;
        }
        html, body {
            background: #ffffff !important;
            margin: 0 !important;
            padding: 0 !important;
            font-size: 11px !important;
            line-height: 1.3 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .no-print {
            display: none !important;
        }
        .ticket-wrapper {
            padding: 0 !important;
            margin: 0 !important;
            min-height: auto !important;
            background: none !important;
        }
        #ticketCard {
            max-width: 100% !important;
            width: 100% !important;
            box-shadow: none !important;
            border: 2px solid #0f172a !important;
            border-radius: 16px !important;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            margin: 0 auto !important;
        }
        .ticket-header {
            padding: 12px 18px !important;
        }
        .ticket-body {
            padding: 12px 18px !important;
        }
        .ticket-qr-section {
            padding: 10px 14px !important;
            margin-bottom: 8px !important;
        }
        .ticket-qr-code svg {
            width: 110px !important;
            height: 110px !important;
        }
        .ticket-grid {
            gap: 6px !important;
            margin-bottom: 8px !important;
        }
        .ticket-grid-item {
            padding: 6px 10px !important;
        }
        .ticket-schedule-box {
            padding-top: 8px !important;
            margin-top: 8px !important;
            gap: 4px !important;
        }
        .ticket-guide-box {
            padding: 8px 12px !important;
            margin-top: 8px !important;
        }
        .ticket-footer {
            padding: 6px 14px !important;
        }
    }
</style>
@endpush

@section('content')
<div class="ticket-wrapper py-8 sm:py-12 bg-slate-100 min-h-screen">
    <div class="max-w-2xl mx-auto px-4 sm:px-6">

        <!-- Status Notification Flash -->
        @if(session('status_message'))
            <div class="mb-4 p-4 rounded-2xl {{ $participant->status === 'UTAMA' ? 'bg-emerald-50 border border-emerald-200 text-emerald-900' : 'bg-amber-50 border border-amber-200 text-amber-900' }} shadow-xs flex items-start gap-3 no-print">
                <span class="text-2xl">{{ $participant->status === 'UTAMA' ? '🎉' : '📋' }}</span>
                <div>
                    <h4 class="font-bold text-sm">{{ $participant->status === 'UTAMA' ? 'Pendaftaran Berhasil!' : 'Pendaftaran Dicatat (Antrean Cadangan)' }}</h4>
                    <p class="text-xs mt-0.5 leading-relaxed">{{ session('status_message') }}</p>
                </div>
            </div>
        @endif

        <!-- Action Bar (Top) -->
        <div class="flex flex-wrap items-center justify-between gap-2.5 mb-4 no-print">
            <a href="{{ route('home') }}" class="text-xs font-bold text-indigo-700 hover:text-indigo-900 flex items-center gap-1">
                &larr; Kembali ke Beranda
            </a>

            <div class="flex items-center gap-2">
                <!-- Button Simpan JPG -->
                <button type="button" id="btnDownloadJpg" onclick="downloadTicketJpg()" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-black text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-xs transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>Simpan Gambar (JPG)</span>
                </button>

                <!-- Button Cetak 1 Hal A4 -->
                <button type="button" onclick="window.print()" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-black text-slate-700 bg-white border border-slate-300 rounded-xl shadow-xs hover:bg-slate-50 transition-colors">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    <span>Cetak PDF (1 Halaman A4)</span>
                </button>
            </div>
        </div>

        <!-- ============================================================= -->
        <!-- PRINTABLE & EXPORTABLE E-TICKET CARD (FITS 1 PAGE A4 & CRISP JPG) -->
        <!-- ============================================================= -->
        <div id="ticketCard" class="bg-white rounded-3xl shadow-xl border-2 border-slate-300 overflow-hidden relative">
            
            <!-- Ticket Header Ribbon -->
            <div class="ticket-header {{ $participant->status === 'UTAMA' ? ($participant->session === '1' ? 'bg-gradient-to-r from-blue-700 via-indigo-700 to-purple-700' : 'bg-gradient-to-r from-purple-700 via-pink-700 to-indigo-800') : ($participant->status === 'CADANGAN' ? 'bg-gradient-to-r from-amber-600 via-orange-600 to-amber-700' : 'bg-slate-700') }} text-white p-5 sm:p-6 text-center relative overflow-hidden">
                <div class="relative z-10 flex flex-col items-center">
                    <div class="flex items-center gap-3 bg-white/95 px-3.5 py-1.5 rounded-2xl shadow-sm mb-2 border border-white/60">
                        <img src="{{ $logo1 }}" alt="Muhijunior ISS" class="h-7 sm:h-8 w-auto object-contain">
                        <span class="w-px h-5 bg-slate-300"></span>
                        <img src="{{ $logo2 }}" alt="SMP Muhammadiyah 1 Yogyakarta" class="h-7 sm:h-8 w-auto object-contain">
                    </div>
                    <span class="inline-block px-3 py-0.5 rounded-full text-[10px] sm:text-[11px] font-extrabold uppercase tracking-widest bg-white/20 mb-1.5">
                        Official Workshop Pass &bull; Muhijunior
                    </span>
                    <h1 class="text-lg sm:text-xl font-black tracking-tight leading-tight">{{ $eventName }}</h1>
                    
                    <!-- Session Banner -->
                    <div class="mt-2.5 inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white text-slate-900 font-black text-xs sm:text-sm shadow-sm">
                        <span>⏰ {{ $participant->session_label }}</span>
                    </div>
                </div>
            </div>

            <!-- Status Banner -->
            <div class="py-2.5 px-4 text-center border-b {{ $participant->status === 'UTAMA' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : ($participant->status === 'CADANGAN' ? 'bg-amber-50 text-amber-800 border-amber-200' : 'bg-rose-50 text-rose-800 border-rose-200') }}">
                @if($participant->status === 'UTAMA')
                    <div class="flex items-center justify-center gap-1.5 font-black text-xs sm:text-sm tracking-wide">
                        <span>✅</span>
                        <span>STATUS: PESERTA UTAMA (TERDAFTAR RESMI)</span>
                    </div>
                @elseif($participant->status === 'CADANGAN')
                    <div class="flex items-center justify-center gap-1.5 font-black text-xs sm:text-sm tracking-wide">
                        <span>📋</span>
                        <span>STATUS: PESERTA CADANGAN (ANTREAN #{{ $participant->waitlist_order }})</span>
                    </div>
                @else
                    <div class="flex items-center justify-center gap-1.5 font-black text-xs sm:text-sm tracking-wide">
                        <span>❌</span>
                        <span>STATUS: DIBATALKAN</span>
                    </div>
                @endif
            </div>

            <!-- Body Details (Compact layout to guarantee 1-page A4) -->
            <div class="ticket-body p-5 sm:p-6 space-y-4">

                <!-- Reg Code & QR Code (Side-by-side compact) -->
                <div class="ticket-qr-section bg-gradient-to-r from-slate-50 via-amber-50/30 to-indigo-50/30 p-4 rounded-2xl border-2 border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    
                    <!-- Left: QR Code -->
                    <div class="ticket-qr-code flex flex-col items-center justify-center shrink-0">
                        <div class="p-2 bg-white rounded-xl shadow-xs border border-slate-300">
                            {!! $qrSvg ?? \App\Services\QrCodeService::svg($participant->reg_code, 125) !!}
                        </div>
                        <span class="text-[10px] font-black text-blue-900 mt-1 flex items-center gap-1">
                            <span>⚡</span> QR Code Presensi Hari-H
                        </span>
                    </div>

                    <!-- Right: Reg Code & Instructions -->
                    <div class="flex-1 text-center sm:text-left space-y-1">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Kode Registrasi (5 Huruf)</span>
                        <div class="inline-flex items-center gap-2">
                            <span class="text-3xl sm:text-4xl font-black text-blue-950 tracking-widest font-mono bg-white px-3.5 py-1.5 rounded-xl border-2 border-blue-950 shadow-xs select-all">
                                {{ $participant->reg_code }}
                            </span>
                            <button type="button" onclick="navigator.clipboard.writeText('{{ $participant->reg_code }}'); alert('Kode {{ $participant->reg_code }} disalin!')" title="Salin Kode" class="p-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 border border-slate-300 no-print">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                            </button>
                        </div>
                        <p class="text-[11px] text-slate-500 leading-tight pt-1">
                            Tunjukkan QR code ini ke panitia di meja registrasi, atau sebutkan 5 huruf kode registrasi di atas.
                        </p>
                    </div>
                </div>

                <!-- Participant Info Grid (2 Columns) -->
                <div class="ticket-grid grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs">
                    <div class="ticket-grid-item p-2.5 bg-slate-50 rounded-xl border border-slate-200">
                        <span class="block text-[10px] font-medium text-slate-400">Nama Lengkap Siswa</span>
                        <strong class="text-slate-900 text-sm font-black">{{ $participant->student_name }}</strong>
                    </div>

                    <div class="ticket-grid-item p-2.5 bg-slate-50 rounded-xl border border-slate-200">
                        <span class="block text-[10px] font-medium text-slate-400">Nama Panggilan (Name Tag)</span>
                        <strong class="text-slate-900 text-sm font-black">{{ $participant->nickname }}</strong>
                    </div>

                    <div class="ticket-grid-item p-2.5 bg-slate-50 rounded-xl border border-slate-200">
                        <span class="block text-[10px] font-medium text-slate-400">Asal Sekolah</span>
                        <strong class="text-slate-800 font-bold">{{ $participant->school_name }}</strong>
                    </div>

                    <div class="ticket-grid-item p-2.5 bg-slate-50 rounded-xl border border-slate-200">
                        <span class="block text-[10px] font-medium text-slate-400">Jenis Kelamin &amp; Pengalaman</span>
                        <strong class="text-slate-800 font-bold">
                            {{ $participant->gender === 'L' ? 'Laki-laki' : 'Perempuan' }} &bull; {{ $participant->experience_level }}
                        </strong>
                    </div>

                    <div class="ticket-grid-item p-2.5 bg-slate-50 rounded-xl border border-slate-200">
                        <span class="block text-[10px] font-medium text-slate-400">No. WhatsApp Orang Tua</span>
                        <strong class="text-slate-800 font-bold font-mono">{{ $participant->whatsapp }}</strong>
                    </div>

                    @if($participant->student_whatsapp)
                        <div class="ticket-grid-item p-2.5 bg-slate-50 rounded-xl border border-slate-200">
                            <span class="block text-[10px] font-medium text-slate-400">No. WhatsApp Siswa</span>
                            <strong class="text-slate-800 font-bold font-mono">{{ $participant->student_whatsapp }}</strong>
                        </div>
                    @else
                        <div class="ticket-grid-item p-2.5 bg-slate-50 rounded-xl border border-slate-200">
                            <span class="block text-[10px] font-medium text-slate-400">Nama Orang Tua / Wali</span>
                            <strong class="text-slate-800 font-bold">{{ $participant->parent_name }}</strong>
                        </div>
                    @endif
                </div>

                <!-- Schedule & Venue Details -->
                <div class="ticket-schedule-box border-t border-slate-100 pt-3 space-y-1.5 text-xs text-slate-700">
                    <div class="flex items-center gap-2">
                        <span class="w-4 text-center">📅</span>
                        <span><strong>Hari / Tanggal:</strong> {{ $eventDate }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-4 text-center">⏰</span>
                        <span><strong>Jadwal Sesi Anda:</strong> <strong class="text-indigo-700">{{ $participant->session_label }}</strong></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-4 text-center">📍</span>
                        <span><strong>Lokasi Acara:</strong> {{ $eventLocation }}</span>
                    </div>
                    <div class="flex items-start gap-2 text-emerald-900 bg-emerald-50/80 p-2 rounded-xl border border-emerald-200 text-[11px]">
                        <span class="w-4 text-center shrink-0">🖥️</span>
                        <span><strong>Fasilitas:</strong> Seluruh praktikum menggunakan PC Lab lengkap SMP Muhammadiyah 1 Yogyakarta. Peserta <strong>tidak perlu membawa laptop / PC</strong>.</span>
                    </div>
                </div>

                <!-- Guidance Box -->
                @if($participant->status === 'UTAMA')
                    <div class="ticket-guide-box p-3 rounded-xl bg-indigo-50/90 border border-indigo-200 text-xs text-indigo-950 space-y-1">
                        <div class="font-black flex items-center gap-1.5 text-indigo-900">
                            <span>📌</span> Panduan Waktu Kehadiran:
                        </div>
                        <p class="text-slate-700 leading-relaxed text-[11px]">
                            Siswa <strong>{{ $participant->session_name }}</strong> diharapkan tiba di lokasi <strong>15–30 menit</strong> sebelum sesi dimulai untuk registrasi ulang dan persiapan perangkat komputer (Jadwal Sesi: <strong>{{ $participant->session_time }}</strong>).
                        </p>
                    </div>
                @elseif($participant->status === 'CADANGAN')
                    <div class="ticket-guide-box p-3 rounded-xl bg-amber-50/90 border border-amber-200 text-xs text-amber-950 space-y-1">
                        <div class="font-black flex items-center gap-1.5 text-amber-900">
                            <span>ℹ️</span> Informasi Jalur Antrean Cadangan:
                        </div>
                        <p class="text-slate-700 leading-relaxed text-[11px]">
                            Ananda berada pada nomor antrean <strong>#{{ $participant->waitlist_order }}</strong> untuk <strong>{{ $participant->session_label }}</strong>. Jika ada peserta utama yang berhalangan, ananda otomatis dipromosikan dan dikabari via WhatsApp.
                        </p>
                    </div>
                @endif

            </div>

            <!-- Ticket Footer Timestamp -->
            <div class="ticket-footer bg-slate-50 border-t border-slate-200 px-4 py-2.5 text-center text-[10px] text-slate-400 flex flex-wrap items-center justify-between gap-1">
                <span>Registrasi: {{ $participant->created_at->format('d/m/Y H:i') }} WIB</span>
                <span class="font-bold text-slate-500 font-mono">{{ $participant->reg_code }} &bull; Muhijunior ISS</span>
                <span>coding.muhijunior.id</span>
            </div>
        </div>

        <!-- WhatsApp Group CTA (Outside Ticket Card - no-print) -->
        @if($participant->status === 'UTAMA')
            <div class="no-print mt-4">
                <a href="{{ $whatsappGroupLink }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2.5 py-3.5 px-6 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-sm sm:text-base shadow-md transition-all text-center">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                    <span>Gabung Grup WhatsApp Koordinasi Peserta</span>
                </a>
            </div>
        @elseif($participant->status === 'CADANGAN')
            <div class="no-print mt-4">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactWhatsapp) }}?text={{ urlencode('Halo Panitia Muhijunior, saya orang tua dari ' . $participant->student_name . ' (' . $participant->reg_code . ') ingin konfirmasi antrean cadangan ' . $participant->session_label) }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 py-3 px-6 rounded-2xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-sm shadow-md transition-all text-center">
                    <span>Hubungi Hotline Panitia via WhatsApp</span>
                </a>
            </div>
        @endif

    </div>
</div>

<!-- html2canvas for High-Quality JPG Export -->
<script src="{{ asset('js/html2canvas.min.js') }}"></script>
<script>
    function downloadTicketJpg() {
        const card = document.getElementById('ticketCard');
        const btn = document.getElementById('btnDownloadJpg');
        const originalHtml = btn.innerHTML;

        btn.disabled = true;
        btn.innerHTML = `
            <svg class="w-4 h-4 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
            <span>Membuat JPG...</span>
        `;

        // Render at 2x resolution for crystal clear quality on mobile and desktop
        html2canvas(card, {
            scale: 2,
            useCORS: true,
            allowTaint: true,
            backgroundColor: '#ffffff',
            logging: false,
        }).then(canvas => {
            const link = document.createElement('a');
            link.download = 'E-Ticket-{{ $participant->reg_code }}-{{ \Illuminate\Support\Str::slug($participant->student_name) }}.jpg';
            link.href = canvas.toDataURL('image/jpeg', 0.95);
            link.click();
        }).catch(err => {
            console.error('Error generating ticket JPG:', err);
            alert('Gagal membuat file gambar JPG. Anda dapat menggunakan tombol Cetak / Simpan PDF.');
        }).finally(() => {
            btn.disabled = false;
            btn.innerHTML = originalHtml;
        });
    }
</script>
@endsection
