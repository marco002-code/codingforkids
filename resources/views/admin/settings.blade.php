@extends('layouts.admin')

@section('title', 'Pengaturan Acara & Kuota Sesi - Panitia Event')

@section('content')
<div class="max-w-4xl space-y-6">

    <div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Pengaturan Event &amp; Kuota Sesi</h1>
        <p class="text-xs text-slate-500 mt-1">Konfigurasi batas kuota per sesi (90 siswa/sesi), waktu pelaksanaan, status buka/tutup pendaftaran, dan hotline.</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Sesi 1 Settings -->
        <div class="bg-white rounded-3xl p-6 border-2 border-indigo-200 shadow-xs space-y-4">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <div>
                    <span class="text-xs font-black text-indigo-600 uppercase tracking-widest">PENGATURAN SESI 1</span>
                    <h3 class="font-extrabold text-slate-900 text-base mt-0.5">Sesi 1 (Pagi)</h3>
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700">08:00 – 10:30 WIB</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Label Sesi 1 <span class="text-rose-500">*</span></label>
                    <input type="text" name="session_1_name" value="{{ old('session_1_name', $settings['session_1_name']->value ?? 'Sesi 1 (Pagi)') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jam / Waktu Pelaksanaan <span class="text-rose-500">*</span></label>
                    <input type="text" name="session_1_time" value="{{ old('session_1_time', $settings['session_1_time']->value ?? '08:00 – 10:30 WIB') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Batas Kuota Utama Sesi 1 <span class="text-rose-500">*</span></label>
                    <input type="number" name="session_1_quota" value="{{ old('session_1_quota', $settings['session_1_quota']->value ?? 90) }}" required min="1" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-black text-indigo-700 focus:ring-2 focus:ring-indigo-500 outline-none">
                    <span class="text-[11px] text-slate-400 mt-1 block">Default: 90 kursi</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Batas Kuota Cadangan Sesi 1 <span class="text-rose-500">*</span></label>
                    <input type="number" name="session_1_waitlist_quota" value="{{ old('session_1_waitlist_quota', $settings['session_1_waitlist_quota']->value ?? 30) }}" required min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-black text-amber-600 focus:ring-2 focus:ring-indigo-500 outline-none">
                    <span class="text-[11px] text-slate-400 mt-1 block">Default: 30 antrean</span>
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
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-purple-50 text-purple-700">12:30 – 14:00 WIB</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Label Sesi 2 <span class="text-rose-500">*</span></label>
                    <input type="text" name="session_2_name" value="{{ old('session_2_name', $settings['session_2_name']->value ?? 'Sesi 2 (Siang)') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-purple-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jam / Waktu Pelaksanaan <span class="text-rose-500">*</span></label>
                    <input type="text" name="session_2_time" value="{{ old('session_2_time', $settings['session_2_time']->value ?? '12:30 – 14:00 WIB') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-purple-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Batas Kuota Utama Sesi 2 <span class="text-rose-500">*</span></label>
                    <input type="number" name="session_2_quota" value="{{ old('session_2_quota', $settings['session_2_quota']->value ?? 90) }}" required min="1" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-black text-purple-700 focus:ring-2 focus:ring-purple-500 outline-none">
                    <span class="text-[11px] text-slate-400 mt-1 block">Default: 90 kursi</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Batas Kuota Cadangan Sesi 2 <span class="text-rose-500">*</span></label>
                    <input type="number" name="session_2_waitlist_quota" value="{{ old('session_2_waitlist_quota', $settings['session_2_waitlist_quota']->value ?? 30) }}" required min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-black text-amber-600 focus:ring-2 focus:ring-purple-500 outline-none">
                    <span class="text-[11px] text-slate-400 mt-1 block">Default: 30 antrean</span>
                </div>
            </div>
        </div>

        <!-- Global Event & Registration Status -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="font-extrabold text-slate-900 text-base">Status Sistem &amp; Detail Acara</h3>
                <p class="text-xs text-slate-400 mt-0.5">Pengaturan global pendaftaran dan informasi tempat.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Pendaftaran Global <span class="text-rose-500">*</span></label>
                    <select name="registration_status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-bold focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                        <option value="OPEN" {{ ($settings['registration_status']->value ?? 'OPEN') === 'OPEN' ? 'selected' : '' }}>🟢 DIBUKA (OPEN)</option>
                        <option value="CLOSED" {{ ($settings['registration_status']->value ?? 'OPEN') === 'CLOSED' ? 'selected' : '' }}>🔴 DITUTUP (CLOSED)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Pelaksanaan <span class="text-rose-500">*</span></label>
                    <input type="text" name="event_date" value="{{ old('event_date', $settings['event_date']->value ?? 'Senin, 21 Desember 2026') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Kegiatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="event_name" value="{{ old('event_name', $settings['event_name']->value ?? 'Coding for Kids and A.I. for Learning') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tagline / Headline</label>
                    <input type="text" name="event_tagline" value="{{ old('event_tagline', $settings['event_tagline']->value ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Sub Headline</label>
                    <input type="text" name="event_subtitle" value="{{ old('event_subtitle', $settings['event_subtitle']->value ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Lokasi Kegiatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="event_location" value="{{ old('event_location', $settings['event_location']->value ?? 'Lab Komputer & Auditorium Utama Kampus Muhijunior') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
            </div>
        </div>

        <!-- WhatsApp & Contact -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-xs space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="font-extrabold text-slate-900 text-base">Kontak Panitia &amp; Grup Koordinasi</h3>
                <p class="text-xs text-slate-400 mt-0.5">Tautan grup WhatsApp koordinasi orang tua dan nomor hotline panitia.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Link Undangan Grup WhatsApp Koordinasi</label>
                    <input type="url" name="whatsapp_group_link" value="{{ old('whatsapp_group_link', $settings['whatsapp_group_link']->value ?? '') }}" placeholder="https://chat.whatsapp.com/..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
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
                Simpan Perubahan Pengaturan
            </button>
        </div>
    </form>

</div>
@endsection
