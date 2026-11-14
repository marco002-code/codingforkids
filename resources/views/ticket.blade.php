@extends('layouts.app')

@section('title', 'E-Ticket: ' . $participant->reg_code . ' - ' . $participant->student_name)

@section('content')
<div class="py-12 bg-slate-100 min-h-screen">
    <div class="max-w-2xl mx-auto px-4 sm:px-6">

        <!-- Status Notification Flash -->
        @if(session('status_message'))
            <div class="mb-6 p-4 rounded-2xl {{ $participant->status === 'UTAMA' ? 'bg-emerald-50 border border-emerald-200 text-emerald-900' : 'bg-amber-50 border border-amber-200 text-amber-900' }} shadow-sm flex items-start gap-3 no-print">
                <span class="text-2xl">{{ $participant->status === 'UTAMA' ? '🎉' : '📋' }}</span>
                <div>
                    <h4 class="font-bold text-sm">{{ $participant->status === 'UTAMA' ? 'Pendaftaran Berhasil!' : 'Pendaftaran Dicatat (Antrean Cadangan)' }}</h4>
                    <p class="text-xs mt-0.5 leading-relaxed">{{ session('status_message') }}</p>
                </div>
            </div>
        @endif

        <!-- Action Bar (Top) -->
        <div class="flex items-center justify-between mb-4 no-print">
            <a href="{{ route('home') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                &larr; Kembali ke Beranda
            </a>

            <div class="flex items-center gap-2">
                <button type="button" onclick="window.print()" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-bold text-slate-700 bg-white border border-slate-300 rounded-xl shadow-xs hover:bg-slate-50 transition-colors">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak / Simpan PDF
                </button>
            </div>
        </div>

        <!-- Printable E-Ticket Card -->
        <div class="bg-white rounded-3xl shadow-xl border border-slate-200/90 overflow-hidden relative">
            
            <!-- Ticket Header Ribbon -->
            <div class="{{ $participant->status === 'UTAMA' ? ($participant->session === '1' ? 'bg-gradient-to-r from-blue-700 via-indigo-700 to-purple-700' : 'bg-gradient-to-r from-purple-700 via-pink-700 to-indigo-800') : ($participant->status === 'CADANGAN' ? 'bg-gradient-to-r from-amber-600 via-orange-600 to-amber-700' : 'bg-slate-700') }} text-white p-6 sm:p-8 text-center relative overflow-hidden">
                <div class="relative z-10 flex flex-col items-center">
                    <div class="flex items-center gap-3 bg-white/95 backdrop-blur-xs px-4 py-2 rounded-2xl shadow-md mb-3 border border-white/50">
                        <img src="/images/logo-muhijunior-iss.png" alt="Muhijunior ISS" class="h-8 sm:h-9 w-auto object-contain">
                        <span class="w-px h-6 bg-slate-300"></span>
                        <img src="/images/logo-smp-muh1.png" alt="SMP Muhammadiyah 1 Yogyakarta" class="h-8 w-8 object-contain rounded-full">
                    </div>
                    <span class="inline-block px-3 py-1 rounded-full text-[11px] font-extrabold uppercase tracking-widest bg-white/20 backdrop-blur-md mb-2">
                        Official Workshop Pass &bull; Muhijunior
                    </span>
                    <h1 class="text-xl sm:text-2xl font-black tracking-tight">{{ $eventName }}</h1>
                    
                    <!-- High-contrast Session Banner -->
                    <div class="mt-3 inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white text-slate-900 font-black text-xs sm:text-sm shadow-md">
                        <span>⏰ {{ $participant->session_label }}</span>
                    </div>
                </div>

                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-black/10 rounded-full blur-xl pointer-events-none"></div>
            </div>

            <!-- Status Banner -->
            <div class="py-3 px-6 text-center border-b {{ $participant->status === 'UTAMA' ? 'bg-emerald-50 text-emerald-800 border-emerald-100' : ($participant->status === 'CADANGAN' ? 'bg-amber-50 text-amber-800 border-amber-100' : 'bg-rose-50 text-rose-800 border-rose-100') }}">
                @if($participant->status === 'UTAMA')
                    <div class="flex items-center justify-center gap-2 font-black text-sm sm:text-base">
                        <span>✅</span>
                        <span>STATUS: PESERTA UTAMA (TERDAFTAR RESMI)</span>
                    </div>
                @elseif($participant->status === 'CADANGAN')
                    <div class="flex items-center justify-center gap-2 font-black text-sm sm:text-base">
                        <span>📋</span>
                        <span>STATUS: PESERTA CADANGAN (ANTREAN #{{ $participant->waitlist_order }})</span>
                    </div>
                @else
                    <div class="flex items-center justify-center gap-2 font-black text-sm sm:text-base">
                        <span>❌</span>
                        <span>STATUS: DIBATALKAN</span>
                    </div>
                @endif
            </div>

            <!-- Body Details -->
            <div class="p-6 sm:p-8 space-y-6">

                <!-- Reg Code & QR Code for Panitia Presensi -->
                <div class="bg-gradient-to-b from-slate-50 to-amber-50/40 p-6 rounded-3xl border-2 border-slate-200 text-center relative overflow-hidden">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-100 text-blue-900 text-[11px] font-black uppercase tracking-wider mb-2">
                        <span>📲</span> QR Code Presensi Hari-H
                    </div>

                    <!-- 5-Huruf Unik Random Code -->
                    <div class="my-2">
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-widest block">Kode Registrasi (5 Huruf)</span>
                        <div class="inline-flex items-center gap-3 mt-1">
                            <span class="text-4xl sm:text-5xl font-black text-blue-950 tracking-widest font-mono bg-white px-5 py-2 rounded-2xl border-2 border-blue-950 shadow-sm select-all">
                                {{ $participant->reg_code }}
                            </span>
                            <button type="button" onclick="navigator.clipboard.writeText('{{ $participant->reg_code }}'); alert('Kode {{ $participant->reg_code }} disalin!')" title="Salin Kode" class="p-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition-colors border border-slate-300 no-print">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- High-Resolution QR Code -->
                    <div class="my-4 flex flex-col items-center justify-center">
                        <div class="p-3 bg-white rounded-2xl shadow-md border-2 border-blue-950 inline-block hover:scale-105 transition-transform duration-200">
                            {!! $qrSvg ?? \App\Services\QrCodeService::svg($participant->reg_code, 190) !!}
                        </div>
                        <span class="text-xs font-black text-blue-900 mt-2 flex items-center gap-1">
                            <span>⚡</span> Scan QR untuk Presensi Langsung
                        </span>
                        <p class="text-[11px] text-slate-500 max-w-sm mt-0.5">
                            Tunjukkan QR code ini ke panitia di meja registrasi, atau cukup sebutkan 5 huruf kode registrasi di atas.
                        </p>
                    </div>
                </div>

                <!-- Participant Info Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/60">
                        <span class="block text-xs font-medium text-slate-400">Nama Lengkap Siswa</span>
                        <span class="font-bold text-slate-900 text-base">{{ $participant->student_name }}</span>
                    </div>

                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/60">
                        <span class="block text-xs font-medium text-slate-400">Nama Panggilan (Name Tag)</span>
                        <span class="font-bold text-slate-900 text-base">{{ $participant->nickname }}</span>
                    </div>

                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/60">
                        <span class="block text-xs font-medium text-slate-400">Asal Sekolah</span>
                        <span class="font-semibold text-slate-800">{{ $participant->school_name }}</span>
                    </div>

                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/60">
                        <span class="block text-xs font-medium text-slate-400">Jenis Kelamin &amp; Pengalaman</span>
                        <span class="font-semibold text-slate-800">
                            {{ $participant->gender === 'L' ? 'Laki-laki' : 'Perempuan' }} &bull; {{ $participant->experience_level }}
                        </span>
                    </div>

                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/60">
                        <span class="block text-xs font-medium text-slate-400">No. WhatsApp Orang Tua</span>
                        <span class="font-semibold text-slate-800">{{ $participant->whatsapp }}</span>
                    </div>

                    @if($participant->student_whatsapp)
                        <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200/60">
                            <span class="block text-xs font-medium text-slate-400">No. WhatsApp Siswa</span>
                            <span class="font-semibold text-slate-800">{{ $participant->student_whatsapp }}</span>
                        </div>
                    @endif
                </div>

                <!-- Schedule & Location Info -->
                <div class="border-t border-slate-100 pt-5 space-y-2.5 text-xs sm:text-sm text-slate-600">
                    <div class="flex items-center gap-2">
                        <span class="w-5 text-center">📅</span>
                        <span><strong>Hari / Tanggal:</strong> {{ $eventDate }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-5 text-center">⏰</span>
                        <span><strong>Jadwal Sesi Anda:</strong> <strong class="text-indigo-600">{{ $participant->session_label }}</strong></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-5 text-center">📍</span>
                        <span><strong>Lokasi Acara:</strong> {{ $eventLocation }}</span>
                    </div>
                    <div class="flex items-start gap-2 text-emerald-900 bg-emerald-50 p-3 rounded-xl border border-emerald-200">
                        <span class="w-5 text-center text-base shrink-0">🖥️</span>
                        <span><strong>Catatan Komputer:</strong> Peserta <strong>tidak perlu membawa PC, Laptop, atau Tablet</strong>. Seluruh praktikum mini workshop dilaksanakan di Lab Komputer menggunakan fasilitas PC Lab lengkap SMP Muhammadiyah 1 Yogyakarta.</span>
                    </div>
                </div>

                <!-- Status Explanations & Next Steps -->
                @if($participant->status === 'UTAMA')
                    <div class="p-4 rounded-2xl bg-indigo-50 border border-indigo-200 text-xs sm:text-sm text-indigo-950 space-y-2">
                        <div class="font-bold flex items-center gap-1.5 text-indigo-800">
                            <span>📌</span> Panduan Waktu Kehadiran:
                        </div>
                        <p class="text-slate-700 leading-relaxed">
                            @if($participant->session === '1')
                                Siswa <strong>Sesi 1</strong> diharapkan tiba di lokasi pada pukul <strong>07:00 – 07:15 WIB</strong> untuk registrasi ulang dan persiapan perangkat sebelum sesi dimulai tepat pukul 07:30 WIB.
                            @else
                                Siswa <strong>Sesi 2</strong> diharapkan tiba di lokasi pada pukul <strong>10:00 – 10:15 WIB</strong> untuk registrasi ulang dan persiapan perangkat sebelum sesi dimulai tepat pukul 10:30 WIB.
                            @endif
                        </p>
                    </div>

                    <!-- WhatsApp Group CTA -->
                    <div class="no-print pt-2">
                        <a href="{{ $whatsappGroupLink }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2.5 py-3.5 px-6 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-sm sm:text-base shadow-lg shadow-emerald-600/25 transition-all text-center">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                            <span>Gabung Grup WhatsApp Koordinasi Peserta</span>
                        </a>
                    </div>

                @elseif($participant->status === 'CADANGAN')
                    <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-xs sm:text-sm text-amber-950 space-y-2">
                        <div class="font-bold flex items-center gap-1.5 text-amber-800">
                            <span>ℹ️</span> Informasi Jalur Antrean Cadangan:
                        </div>
                        <p class="text-slate-700 leading-relaxed">
                            Ananda berada pada nomor antrean <strong>#{{ $participant->waitlist_order }}</strong> untuk <strong>{{ $participant->session_label }}</strong>. Panitia akan mengonfirmasi kehadiran seluruh 90 peserta utama pada sesi ini. Jika ada yang berhalangan, ananda akan langsung dipromosikan otomatis dan panitia akan mengabari Anda via WhatsApp paling lambat H-2 acara (19 Desember 2026).
                        </p>
                    </div>

                    <!-- Contact Hotline Button -->
                    <div class="no-print pt-2">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactWhatsapp) }}?text={{ urlencode('Halo Panitia Muhijunior, saya orang tua dari ' . $participant->student_name . ' (' . $participant->reg_code . ') ingin konfirmasi antrean cadangan ' . $participant->session_label) }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 py-3 px-6 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-sm shadow-md transition-all text-center">
                            <span>Hubungi Hotline Panitia via WhatsApp</span>
                        </a>
                    </div>
                @endif

            </div>

            <!-- Ticket Footer Timestamp -->
            <div class="bg-slate-50 border-t border-slate-100 px-6 py-3 text-center text-[11px] text-slate-400">
                Waktu Pendaftaran: {{ $participant->created_at->format('d F Y, H:i:s') }} WIB &bull; Sistem Otomasi Muhijunior
            </div>
        </div>

    </div>
</div>
@endsection
