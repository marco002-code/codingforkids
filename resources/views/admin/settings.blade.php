@extends('layouts.admin')

@section('title', 'Pengaturan Acara, Sesi & Stack Materi - Panitia Event')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Pengaturan Workshop &amp; Sesi</h1>
            <p class="text-xs text-slate-500 mt-1">Konfigurasi tanggal kegiatan, jam dan kuota per sesi (90 siswa/sesi), serta susunan stack materi rundown.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('home') }}#rundown" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl border border-slate-300 shadow-xs transition-colors">
                <span>Pratinjau di Web Publik &rarr;</span>
            </a>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex flex-wrap items-center gap-2 border-b border-slate-200 pb-3">
        <a href="{{ route('admin.settings', ['tab' => 'event']) }}" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ $activeTab === 'event' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <span>📅 Tanggal &amp; Acara</span>
        </a>

        <a href="{{ route('admin.settings', ['tab' => 'sessions']) }}" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ $activeTab === 'sessions' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>⏰ Jam &amp; Kuota Sesi</span>
        </a>

        <a href="{{ route('admin.settings', ['tab' => 'rundown']) }}" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ $activeTab === 'rundown' ? 'bg-indigo-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            <span>📚 Stack Materi Sesi (Rundown)</span>
        </a>
    </div>

    <!-- ===================================================================== -->
    <!-- TAB 1: PENGATURAN TANGGAL & ACARA -->
    <!-- ===================================================================== -->
    @if($activeTab === 'event')
    <form action="{{ route('admin.settings.update') }}" method="POST" class="max-w-4xl space-y-6">
        @csrf
        <input type="hidden" name="redirect_tab" value="event">

        <!-- Hidden Keep Session Values from Current Settings -->
        <input type="hidden" name="session_1_name" value="{{ $settings['session_1_name']->value ?? 'Sesi 1 (Pagi)' }}">
        <input type="hidden" name="session_1_time" value="{{ $settings['session_1_time']->value ?? '07:30 – 10:00 WIB' }}">
        <input type="hidden" name="session_1_quota" value="{{ $settings['session_1_quota']->value ?? 90 }}">
        <input type="hidden" name="session_1_waitlist_quota" value="{{ $settings['session_1_waitlist_quota']->value ?? 30 }}">
        <input type="hidden" name="session_2_name" value="{{ $settings['session_2_name']->value ?? 'Sesi 2 (Siang)' }}">
        <input type="hidden" name="session_2_time" value="{{ $settings['session_2_time']->value ?? '10:30 – 12:00 WIB' }}">
        <input type="hidden" name="session_2_quota" value="{{ $settings['session_2_quota']->value ?? 90 }}">
        <input type="hidden" name="session_2_waitlist_quota" value="{{ $settings['session_2_waitlist_quota']->value ?? 30 }}">

        <!-- Tanggal Pelaksanaan & Status Sistem -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <span class="text-xs font-black text-indigo-600 uppercase tracking-widest">WAKTU &amp; STATUS SISTEM</span>
                <h3 class="font-extrabold text-slate-900 text-base mt-0.5">Tanggal Pelaksanaan &amp; Kontrol Pendaftaran</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Pelaksanaan Kegiatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="event_date" value="{{ old('event_date', $settings['event_date']->value ?? 'Senin, 21 Desember 2026') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-indigo-500 outline-none">
                    <span class="text-[11px] text-slate-400 mt-1 block">Teks tanggal ini akan tampil di seluruh banner, e-ticket, dan halaman pengumuman (Contoh: <strong>Senin, 21 Desember 2026</strong>).</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Pendaftaran Global <span class="text-rose-500">*</span></label>
                    <select name="registration_status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-bold focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                        <option value="OPEN" {{ ($settings['registration_status']->value ?? 'OPEN') === 'OPEN' ? 'selected' : '' }}>🟢 DIBUKA (OPEN)</option>
                        <option value="CLOSED" {{ ($settings['registration_status']->value ?? 'OPEN') === 'CLOSED' ? 'selected' : '' }}>🔴 DITUTUP (CLOSED)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Publikasi Daftar Peserta Terpilih <span class="text-rose-500">*</span></label>
                    <select name="publish_selected_participants" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-bold focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                        <option value="0" {{ ($settings['publish_selected_participants']->value ?? '0') == '0' ? 'selected' : '' }}>⏳ Draf / Proses Validasi (Tampil pemberitahuan verifikasi)</option>
                        <option value="1" {{ ($settings['publish_selected_participants']->value ?? '0') == '1' ? 'selected' : '' }}>🟢 Sudah Rilis (Tampilkan tabel resmi peserta terpilih)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Detail Informasi Acara -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <span class="text-xs font-black text-indigo-600 uppercase tracking-widest">INFORMASI ACARA</span>
                <h3 class="font-extrabold text-slate-900 text-base mt-0.5">Nama Kegiatan &amp; Lokasi Laboratorium</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Kegiatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="event_name" value="{{ old('event_name', $settings['event_name']->value ?? 'Coding for Kids and A.I. for Learning') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tagline / Headline</label>
                    <input type="text" name="event_tagline" value="{{ old('event_tagline', $settings['event_tagline']->value ?? 'Belajar Block Programming, Pemanfaatan A.I. & Keamanan Digital') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Sub Headline</label>
                    <input type="text" name="event_subtitle" value="{{ old('event_subtitle', $settings['event_subtitle']->value ?? 'Khusus Siswa SD Kelas 6 &bull; 100% Gratis') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Lokasi Kegiatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="event_location" value="{{ old('event_location', $settings['event_location']->value ?? 'Lab TIK 1 & Lab TIK 3 Lantai 3 Gedung Selatan, SMP Muhammadiyah 1 Yogyakarta') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
            </div>
        </div>

        <!-- WhatsApp & Kontak -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <span class="text-xs font-black text-indigo-600 uppercase tracking-widest">KONTAK KOORDINASI</span>
                <h3 class="font-extrabold text-slate-900 text-base mt-0.5">Grup WhatsApp Orang Tua &amp; Hotline Panitia</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Link Undangan Grup WhatsApp Koordinasi</label>
                    <input type="url" name="whatsapp_group_link" value="{{ old('whatsapp_group_link', $settings['whatsapp_group_link']->value ?? '') }}" placeholder="https://chat.whatsapp.com/..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                    <span class="text-[11px] text-slate-400 mt-1 block">Tautan ini otomatis disertakan pada konfirmasi pendaftaran dan E-Ticket siswa.</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp Hotline Panitia</label>
                    <input type="text" name="contact_whatsapp" value="{{ old('contact_whatsapp', $settings['contact_whatsapp']->value ?? '081234567890') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Email Panitia</label>
                    <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email']->value ?? 'panitia@muhijunior.id') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <button type="submit" class="px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-sm rounded-2xl shadow-lg shadow-indigo-600/25 transition-all">
                Simpan Perubahan Tanggal &amp; Acara
            </button>
        </div>
    </form>
    @endif

    <!-- ===================================================================== -->
    <!-- TAB 2: PENGATURAN JAM & KUOTA SESI -->
    <!-- ===================================================================== -->
    @if($activeTab === 'sessions')
    <form action="{{ route('admin.settings.update') }}" method="POST" class="max-w-4xl space-y-6">
        @csrf
        <input type="hidden" name="redirect_tab" value="sessions">

        <!-- Hidden Keep Event Values -->
        <input type="hidden" name="event_name" value="{{ $settings['event_name']->value ?? 'Coding for Kids and A.I. for Learning' }}">
        <input type="hidden" name="event_tagline" value="{{ $settings['event_tagline']->value ?? '' }}">
        <input type="hidden" name="event_subtitle" value="{{ $settings['event_subtitle']->value ?? '' }}">
        <input type="hidden" name="event_date" value="{{ $settings['event_date']->value ?? 'Senin, 21 Desember 2026' }}">
        <input type="hidden" name="event_location" value="{{ $settings['event_location']->value ?? 'Laboratorium Komputer SMP Muhammadiyah 1 Yogyakarta' }}">
        <input type="hidden" name="registration_status" value="{{ $settings['registration_status']->value ?? 'OPEN' }}">
        <input type="hidden" name="publish_selected_participants" value="{{ $settings['publish_selected_participants']->value ?? '0' }}">
        <input type="hidden" name="whatsapp_group_link" value="{{ $settings['whatsapp_group_link']->value ?? '' }}">
        <input type="hidden" name="contact_whatsapp" value="{{ $settings['contact_whatsapp']->value ?? '081234567890' }}">
        <input type="hidden" name="contact_email" value="{{ $settings['contact_email']->value ?? 'panitia@muhijunior.id' }}">

        <!-- Sesi 1 Settings -->
        <div class="bg-white rounded-3xl p-6 border-2 border-indigo-200 shadow-xs space-y-4">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <div>
                    <span class="text-xs font-black text-indigo-600 uppercase tracking-widest">PENGATURAN SESI 1</span>
                    <h3 class="font-extrabold text-slate-900 text-base mt-0.5">Sesi 1 (Pagi)</h3>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                    {{ $settings['session_1_time']->value ?? '07:30 – 10:00 WIB' }}
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Label Sesi 1 <span class="text-rose-500">*</span></label>
                    <input type="text" name="session_1_name" value="{{ old('session_1_name', $settings['session_1_name']->value ?? 'Sesi 1 (Pagi)') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jam / Waktu Pelaksanaan <span class="text-rose-500">*</span></label>
                    <input type="text" name="session_1_time" value="{{ old('session_1_time', $settings['session_1_time']->value ?? '07:30 – 10:00 WIB') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-bold text-indigo-900 focus:ring-2 focus:ring-indigo-500 outline-none">
                    <span class="text-[11px] text-slate-400 mt-1 block">Contoh: <strong>07:30 – 10:00 WIB</strong></span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Batas Kuota Utama Sesi 1 <span class="text-rose-500">*</span></label>
                    <input type="number" name="session_1_quota" value="{{ old('session_1_quota', $settings['session_1_quota']->value ?? 90) }}" required min="1" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-black text-indigo-700 focus:ring-2 focus:ring-indigo-500 outline-none">
                    <span class="text-[11px] text-slate-400 mt-1 block">Standar: 90 kursi</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Batas Kuota Cadangan Sesi 1 <span class="text-rose-500">*</span></label>
                    <input type="number" name="session_1_waitlist_quota" value="{{ old('session_1_waitlist_quota', $settings['session_1_waitlist_quota']->value ?? 30) }}" required min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-black text-amber-600 focus:ring-2 focus:ring-indigo-500 outline-none">
                    <span class="text-[11px] text-slate-400 mt-1 block">Standar: 30 antrean</span>
                </div>
            </div>
        </div>

        <!-- Sesi 2 Settings -->
        <div class="bg-white rounded-3xl p-6 border-2 border-purple-200 shadow-xs space-y-4">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <div>
                    <span class="text-xs font-black text-purple-600 uppercase tracking-widest">PENGATURAN SESI 2</span>
                    <h3 class="font-extrabold text-slate-900 text-base mt-0.5">Sesi 2 (Siang)</h3>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-purple-50 text-purple-700 border border-purple-200">
                    {{ $settings['session_2_time']->value ?? '10:30 – 12:00 WIB' }}
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Label Sesi 2 <span class="text-rose-500">*</span></label>
                    <input type="text" name="session_2_name" value="{{ old('session_2_name', $settings['session_2_name']->value ?? 'Sesi 2 (Siang)') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-purple-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jam / Waktu Pelaksanaan <span class="text-rose-500">*</span></label>
                    <input type="text" name="session_2_time" value="{{ old('session_2_time', $settings['session_2_time']->value ?? '10:30 – 12:00 WIB') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-bold text-purple-900 focus:ring-2 focus:ring-purple-500 outline-none">
                    <span class="text-[11px] text-slate-400 mt-1 block">Contoh: <strong>10:30 – 12:00 WIB</strong></span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Batas Kuota Utama Sesi 2 <span class="text-rose-500">*</span></label>
                    <input type="number" name="session_2_quota" value="{{ old('session_2_quota', $settings['session_2_quota']->value ?? 90) }}" required min="1" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-black text-purple-700 focus:ring-2 focus:ring-purple-500 outline-none">
                    <span class="text-[11px] text-slate-400 mt-1 block">Standar: 90 kursi</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Batas Kuota Cadangan Sesi 2 <span class="text-rose-500">*</span></label>
                    <input type="number" name="session_2_waitlist_quota" value="{{ old('session_2_waitlist_quota', $settings['session_2_waitlist_quota']->value ?? 30) }}" required min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-black text-amber-600 focus:ring-2 focus:ring-purple-500 outline-none">
                    <span class="text-[11px] text-slate-400 mt-1 block">Standar: 30 antrean</span>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <button type="submit" class="px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-sm rounded-2xl shadow-lg shadow-indigo-600/25 transition-all">
                Simpan Perubahan Jam &amp; Kuota Sesi
            </button>
        </div>
    </form>
    @endif

    <!-- ===================================================================== -->
    <!-- TAB 3: STACK MATERI DALAM SESI (RUNDOWN) -->
    <!-- ===================================================================== -->
    @if($activeTab === 'rundown')
    <div class="max-w-5xl space-y-6">

        <!-- Sesi Selector Pills -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-2xl border border-slate-200/90 shadow-xs">
            <div>
                <span class="text-[11px] font-black uppercase text-indigo-600 tracking-wider">PILIH SESI YANG AKAN DIKELOLA:</span>
                <div class="flex items-center gap-2 mt-2">
                    <a href="{{ route('admin.settings', ['tab' => 'rundown', 'session' => 1]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ $activeSession === 1 ? 'bg-indigo-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        <span>☀️ Sesi 1 (Pagi)</span>
                        <span class="text-[10px] px-1.5 py-0.5 rounded-md {{ $activeSession === 1 ? 'bg-white/20 text-white' : 'bg-white text-slate-600' }}">{{ count($session1Rundown) }} Stack</span>
                    </a>

                    <a href="{{ route('admin.settings', ['tab' => 'rundown', 'session' => 2]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ $activeSession === 2 ? 'bg-purple-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        <span>🌤️ Sesi 2 (Siang)</span>
                        <span class="text-[10px] px-1.5 py-0.5 rounded-md {{ $activeSession === 2 ? 'bg-white/20 text-white' : 'bg-white text-slate-600' }}">{{ count($session2Rundown) }} Stack</span>
                    </a>
                </div>
            </div>

            <!-- Reset to Default Button -->
            <form action="{{ route('admin.settings.updateRundown') }}" method="POST" onsubmit="return confirm('Kembalikan susunan stack materi Sesi {{ $activeSession }} ke format default (5 stack standar)?')">
                @csrf
                <input type="hidden" name="session" value="{{ $activeSession }}">
                <input type="hidden" name="reset_default" value="1">
                <button type="submit" class="px-3 py-2 text-xs font-bold text-slate-600 hover:text-rose-700 hover:bg-rose-50 rounded-xl border border-slate-300 transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span>Reset ke 5 Stack Standar</span>
                </button>
            </form>
        </div>

        @php
            $currentRundown = ($activeSession === 1) ? $session1Rundown : $session2Rundown;
            $sessionBadgeColor = ($activeSession === 1) ? 'text-indigo-600' : 'text-purple-600';
            $sessionBorderColor = ($activeSession === 1) ? 'border-indigo-200' : 'border-purple-200';
        @endphp

        <!-- Rundown Items Form -->
        <form action="{{ route('admin.settings.updateRundown') }}" method="POST" class="space-y-4" id="rundownForm">
            @csrf
            <input type="hidden" name="session" value="{{ $activeSession }}">

            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-black text-slate-900 text-lg">
                        Daftar Stack Materi: Sesi {{ $activeSession }} ({{ $activeSession === 1 ? 'Pagi' : 'Siang' }})
                    </h3>
                    <p class="text-xs text-slate-500">Anda dapat mengubah jam, judul materi, durasi, deskripsi, dan tema warna border setiap stack.</p>
                </div>

                <button type="button" onclick="addNewStackItem()" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-xs transition-colors flex items-center gap-1.5 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Tambah Stack Baru</span>
                </button>
            </div>

            <!-- Items Container -->
            <div id="stackItemsContainer" class="space-y-4">
                @foreach($currentRundown as $index => $item)
                    <div class="stack-item-card bg-white rounded-3xl p-5 border-2 {{ $sessionBorderColor }} shadow-xs relative space-y-4 transition-all" data-index="{{ $index }}">
                        
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-lg bg-slate-900 text-white font-black text-xs flex items-center justify-center stack-number">
                                    {{ $index + 1 }}
                                </span>
                                <span class="text-xs font-black text-slate-800 uppercase tracking-wide">Stack Materi #<span class="stack-label-num">{{ $index + 1 }}</span></span>
                            </div>

                            <button type="button" onclick="removeStackItem(this)" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus stack ini">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                            <!-- Waktu / Jam -->
                            <div class="sm:col-span-3">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Jam / Rentang Waktu <span class="text-rose-500">*</span></label>
                                <input type="text" name="items[{{ $index }}][time]" value="{{ $item['time'] ?? '' }}" required placeholder="Contoh: 07:30 – 08:35" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-mono font-bold focus:ring-2 focus:ring-indigo-500 outline-none">
                            </div>

                            <!-- Judul Stack -->
                            <div class="sm:col-span-5">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Judul Modul / Kegiatan <span class="text-rose-500">*</span></label>
                                <input type="text" name="items[{{ $index }}][title]" value="{{ $item['title'] ?? '' }}" required placeholder="Contoh: Modul 1: Coding Game" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold focus:ring-2 focus:ring-indigo-500 outline-none">
                            </div>

                            <!-- Durasi -->
                            <div class="sm:col-span-2">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Durasi</label>
                                <input type="text" name="items[{{ $index }}][duration]" value="{{ $item['duration'] ?? '' }}" placeholder="Contoh: 65 Menit" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-indigo-500 outline-none">
                            </div>

                            <!-- Tema Warna / Type -->
                            <div class="sm:col-span-2">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Tema Kartu</label>
                                <select name="items[{{ $index }}][type]" class="w-full px-2.5 py-2 rounded-xl border border-slate-300 text-xs font-bold focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                                    <option value="blue" {{ ($item['type'] ?? '') === 'blue' ? 'selected' : '' }}>🔵 Biru (Coding)</option>
                                    <option value="purple" {{ ($item['type'] ?? '') === 'purple' ? 'selected' : '' }}>🟣 Ungu (A.I.)</option>
                                    <option value="emerald" {{ ($item['type'] ?? '') === 'emerald' ? 'selected' : '' }}>🟢 Hijau (Cyber Safety)</option>
                                    <option value="amber" {{ ($item['type'] ?? '') === 'amber' ? 'selected' : '' }}>🟠 Oranye (Snack / Break)</option>
                                    <option value="default" {{ ($item['type'] ?? '') === 'default' ? 'selected' : '' }}>⚪ Abu-abu (Registrasi)</option>
                                </select>
                            </div>

                            <!-- Deskripsi Singkat -->
                            <div class="sm:col-span-12">
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Deskripsi Stack Materi / Kegiatan</label>
                                <textarea name="items[{{ $index }}][description]" rows="2" placeholder="Ringkasan materi atau kegiatan..." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-indigo-500 outline-none">{{ $item['description'] ?? '' }}</textarea>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Bottom Actions -->
            <div class="flex items-center justify-between gap-4 pt-4 border-t border-slate-200">
                <button type="button" onclick="addNewStackItem()" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Tambah Stack Baru</span>
                </button>

                <button type="submit" class="px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-sm rounded-2xl shadow-lg shadow-indigo-600/25 transition-all">
                    Simpan Susunan Stack Materi Sesi {{ $activeSession }}
                </button>
            </div>
        </form>

    </div>

    <!-- Script Dynamic Add/Remove Stack Items -->
    <script>
        let stackCount = {{ count($currentRundown) }};
        const activeSessionNum = {{ $activeSession }};
        const borderColor = activeSessionNum === 1 ? 'border-indigo-200' : 'border-purple-200';

        function updateStackNumbers() {
            const cards = document.querySelectorAll('.stack-item-card');
            cards.forEach((card, idx) => {
                const num = idx + 1;
                const badge = card.querySelector('.stack-number');
                const label = card.querySelector('.stack-label-num');
                if (badge) badge.innerText = num;
                if (label) label.innerText = num;
            });
        }

        function addNewStackItem() {
            const container = document.getElementById('stackItemsContainer');
            const newIndex = Date.now(); // unique index
            const currentTotal = document.querySelectorAll('.stack-item-card').length + 1;

            const cardHtml = `
                <div class="stack-item-card bg-white rounded-3xl p-5 border-2 ${borderColor} shadow-xs relative space-y-4 transition-all" data-index="${newIndex}">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-black text-xs flex items-center justify-center stack-number">
                                ${currentTotal}
                            </span>
                            <span class="text-xs font-black text-slate-800 uppercase tracking-wide">Stack Materi #<span class="stack-label-num">${currentTotal}</span> (Baru)</span>
                        </div>
                        <button type="button" onclick="removeStackItem(this)" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus stack ini">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                        <div class="sm:col-span-3">
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Jam / Rentang Waktu <span class="text-rose-500">*</span></label>
                            <input type="text" name="items[${newIndex}][time]" required placeholder="Contoh: 08:00 – 08:45" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-mono font-bold focus:ring-2 focus:ring-indigo-500 outline-none">
                        </div>

                        <div class="sm:col-span-5">
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Judul Modul / Kegiatan <span class="text-rose-500">*</span></label>
                            <input type="text" name="items[${newIndex}][title]" required placeholder="Contoh: Modul Baru" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold focus:ring-2 focus:ring-indigo-500 outline-none">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Durasi</label>
                            <input type="text" name="items[${newIndex}][duration]" placeholder="Contoh: 45 Menit" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-indigo-500 outline-none">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Tema Kartu</label>
                            <select name="items[${newIndex}][type]" class="w-full px-2.5 py-2 rounded-xl border border-slate-300 text-xs font-bold focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                                <option value="blue">🔵 Biru (Coding)</option>
                                <option value="purple">🟣 Ungu (A.I.)</option>
                                <option value="emerald">🟢 Hijau (Cyber Safety)</option>
                                <option value="amber">🟠 Oranye (Snack / Break)</option>
                                <option value="default" selected>⚪ Abu-abu (Registrasi)</option>
                            </select>
                        </div>

                        <div class="sm:col-span-12">
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Deskripsi Stack Materi / Kegiatan</label>
                            <textarea name="items[${newIndex}][description]" rows="2" placeholder="Ringkasan materi atau kegiatan..." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', cardHtml);
            updateStackNumbers();
        }

        function removeStackItem(btn) {
            const cards = document.querySelectorAll('.stack-item-card');
            if (cards.length <= 1) {
                alert('Minimal harus ada 1 stack materi yang tersisa!');
                return;
            }
            if (confirm('Hapus stack materi ini?')) {
                const card = btn.closest('.stack-item-card');
                card.remove();
                updateStackNumbers();
            }
        }
    </script>
    @endif

</div>
@endsection
