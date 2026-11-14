@extends('layouts.admin')

@section('title', 'Pengaturan Acara & Kuota - Panitia Event')

@section('content')
<div class="max-w-4xl space-y-6">

    <div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Pengaturan Event &amp; Kuota</h1>
        <p class="text-xs text-slate-500 mt-1">Konfigurasi batas kuota utama, kuota cadangan, status buka/tutup pendaftaran, dan informasi kontak.</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Quota & Registration Control -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="font-bold text-slate-900 text-base">Manajemen Kuota &amp; Status Pendaftaran</h3>
                <p class="text-xs text-slate-400 mt-0.5">Sistem akan otomatis mengalihkan ke cadangan atau menolak jika kuota ini tercapai.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Batas Kuota Utama <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" name="max_main_quota" value="{{ old('max_main_quota', $settings['max_main_quota']->value ?? 50) }}" required min="1" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-bold text-indigo-700 focus:ring-2 focus:ring-indigo-500 outline-none">
                    <span class="text-[11px] text-slate-400 mt-1 block">Default: 50 kursi</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Batas Kuota Cadangan (Waitlist) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" name="max_waitlist_quota" value="{{ old('max_waitlist_quota', $settings['max_waitlist_quota']->value ?? 20) }}" required min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-bold text-amber-700 focus:ring-2 focus:ring-indigo-500 outline-none">
                    <span class="text-[11px] text-slate-400 mt-1 block">Default: 20 antrean</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Status Pendaftaran <span class="text-rose-500">*</span>
                    </label>
                    <select name="registration_status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm font-bold focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                        <option value="OPEN" {{ ($settings['registration_status']->value ?? 'OPEN') === 'OPEN' ? 'selected' : '' }}>🟢 DIBUKA (OPEN)</option>
                        <option value="CLOSED" {{ ($settings['registration_status']->value ?? 'OPEN') === 'CLOSED' ? 'selected' : '' }}>🔴 DITUTUP (CLOSED)</option>
                    </select>
                    <span class="text-[11px] text-slate-400 mt-1 block">Tutup manual jika diperlukan</span>
                </div>
            </div>
        </div>

        <!-- Event Details -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="font-bold text-slate-900 text-base">Informasi Detail Kegiatan</h3>
                <p class="text-xs text-slate-400 mt-0.5">Informasi ini akan ditampilkan pada Landing Page dan E-Ticket siswa.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Pelaksanaan <span class="text-rose-500">*</span></label>
                    <input type="text" name="event_date" value="{{ old('event_date', $settings['event_date']->value ?? 'Senin, 21 Desember 2026') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Waktu / Jam Acara <span class="text-rose-500">*</span></label>
                    <input type="text" name="event_time" value="{{ old('event_time', $settings['event_time']->value ?? '08.30 – 12.30 WIB') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Lokasi Kegiatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="event_location" value="{{ old('event_location', $settings['event_location']->value ?? 'Lab Komputer & Auditorium Gedung Edukasi Teknologi, Lt. 3') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
            </div>
        </div>

        <!-- WhatsApp & Contact -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="font-bold text-slate-900 text-base">Kontak Panitia &amp; Grup Koordinasi</h3>
                <p class="text-xs text-slate-400 mt-0.5">Tautan grup WhatsApp koordinasi orang tua dan hotline panitia.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Link Undangan Grup WhatsApp Koordinasi</label>
                    <input type="url" name="whatsapp_group_link" value="{{ old('whatsapp_group_link', $settings['whatsapp_group_link']->value ?? '') }}" placeholder="https://chat.whatsapp.com/..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                    <span class="text-[11px] text-slate-400 mt-1 block">Tautan ini muncul pada e-ticket peserta utama.</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp Hotline Panitia</label>
                    <input type="text" name="contact_whatsapp" value="{{ old('contact_whatsapp', $settings['contact_whatsapp']->value ?? '081234567890') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Email Panitia</label>
                    <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email']->value ?? 'panitia@codingforkids.id') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-md transition-colors">
                Simpan Perubahan Pengaturan
            </button>
        </div>
    </form>

</div>
@endsection
