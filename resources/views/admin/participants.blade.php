@extends('layouts.admin')

@section('title', 'Manajemen Data Peserta - Panitia Event')

@section('content')
<div class="space-y-6">

    <!-- Top Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Data Peserta Event</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola data peserta utama 90/sesi, antrean cadangan, promosi otomatis, dan absensi hari-H.</p>
        </div>

        @php
            $isPublished = \App\Models\Setting::get('publish_selected_participants', '0') == '1';
        @endphp
        <div class="flex flex-wrap items-center gap-2">
            <form action="{{ route('admin.participants.togglePublish') }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold border transition-colors shadow-xs {{ $isPublished ? 'bg-emerald-50 text-emerald-800 border-emerald-300 hover:bg-emerald-100' : 'bg-amber-50 text-amber-800 border-amber-300 hover:bg-amber-100' }}" title="Klik untuk mengubah status publikasi pengumuman peserta terpilih">
                    <span>{{ $isPublished ? '🟢 Pengumuman: Rilis Publik' : '⏳ Pengumuman: Draf / Validasi' }}</span>
                    <span class="underline text-[10px]">({{ $isPublished ? 'Tarik ke Draf' : 'Publikasikan' }})</span>
                </button>
            </form>

            <a href="{{ route('participants.selected') }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl border border-slate-300 transition-colors" title="Lihat Halaman Publik Peserta Terpilih">
                <span>Lihat Pengumuman &rarr;</span>
            </a>

            <a href="{{ route('admin.export', ['tab' => $tab, 'session' => $sessionFilter]) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-xs transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Unduh CSV</span>
            </a>
        </div>
    </div>

    <!-- Filters Row: Session Pill & Tab Badges -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-200 pb-4">
        
        <!-- Status Tabs -->
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.participants', ['tab' => 'utama', 'session' => $sessionFilter, 'search' => $search]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ $tab === 'utama' ? 'bg-emerald-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
                <span>Peserta Utama</span>
                <span class="px-1.5 py-0.5 rounded-md text-[10px] {{ $tab === 'utama' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $counts['utama'] }}</span>
            </a>

            <a href="{{ route('admin.participants', ['tab' => 'cadangan', 'session' => $sessionFilter, 'search' => $search]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ $tab === 'cadangan' ? 'bg-amber-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
                <span>Peserta Cadangan</span>
                <span class="px-1.5 py-0.5 rounded-md text-[10px] {{ $tab === 'cadangan' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $counts['cadangan'] }}</span>
            </a>

            <a href="{{ route('admin.participants', ['tab' => 'dibatalkan', 'session' => $sessionFilter, 'search' => $search]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ $tab === 'dibatalkan' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
                <span>Dibatalkan</span>
                <span class="px-1.5 py-0.5 rounded-md text-[10px] {{ $tab === 'dibatalkan' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $counts['dibatalkan'] }}</span>
            </a>

            <a href="{{ route('admin.participants', ['tab' => 'all', 'session' => $sessionFilter, 'search' => $search]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-2 {{ $tab === 'all' ? 'bg-slate-800 text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-50 border border-slate-200' }}">
                <span>Semua Data</span>
                <span class="px-1.5 py-0.5 rounded-md text-[10px] {{ $tab === 'all' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $counts['all'] }}</span>
            </a>
        </div>

        <!-- Session Filter Switcher -->
        <div class="inline-flex p-1 rounded-xl bg-slate-200 border border-slate-300 self-start md:self-auto">
            <a href="{{ route('admin.participants', ['tab' => $tab, 'session' => '', 'search' => $search]) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ empty($sessionFilter) ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                Semua Sesi
            </a>
            <a href="{{ route('admin.participants', ['tab' => $tab, 'session' => '1', 'search' => $search]) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $sessionFilter === '1' ? 'bg-indigo-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                ☀️ Sesi 1 (Pagi)
            </a>
            <a href="{{ route('admin.participants', ['tab' => $tab, 'session' => '2', 'search' => $search]) }}" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all {{ $sessionFilter === '2' ? 'bg-purple-600 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900' }}">
                🌤️ Sesi 2 (Siang)
            </a>
        </div>

    </div>

    <!-- Search & Filter Card -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-xs">
        <form method="GET" action="{{ route('admin.participants') }}" class="flex flex-col sm:flex-row items-center gap-3">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <input type="hidden" name="session" value="{{ $sessionFilter }}">
            
            <div class="relative flex-grow w-full">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama siswa, panggilan, kode 5 huruf (misal: KMPXW), WA, atau sekolah..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <select name="gender" class="px-3 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm bg-white outline-none">
                    <option value="">Semua Gender</option>
                    <option value="L" {{ $gender === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ $gender === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>

                <button type="submit" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-xs transition-colors shrink-0">
                    Filter
                </button>

                @if($search || $gender)
                    <a href="{{ route('admin.participants', ['tab' => $tab, 'session' => $sessionFilter]) }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition-colors shrink-0">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4">No.</th>
                        <th class="py-3.5 px-4">Kode</th>
                        <th class="py-3.5 px-4">Sesi Acara</th>
                        <th class="py-3.5 px-4">Data Siswa</th>
                        <th class="py-3.5 px-4">Orang Tua / Kontak</th>
                        <th class="py-3.5 px-4">Status &amp; Antrean</th>
                        <th class="py-3.5 px-4 text-center">Presensi Hari-H</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($participants as $index => $p)
                        <tr class="hover:bg-slate-50/80 transition-colors {{ $p->is_attended ? 'bg-emerald-50/30' : '' }}">
                            <!-- No -->
                            <td class="py-4 px-4 font-semibold text-slate-400">
                                {{ $participants->firstItem() + $index }}
                            </td>

                            <!-- Code -->
                            <td class="py-4 px-4 font-mono font-bold text-slate-900 whitespace-nowrap">
                                <a href="{{ route('ticket.show', $p->reg_code) }}" target="_blank" class="hover:text-indigo-600 underline decoration-indigo-300">
                                    {{ $p->reg_code }}
                                </a>
                            </td>

                            <!-- Session -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-extrabold {{ $p->session === '1' ? 'bg-indigo-100 text-indigo-800' : 'bg-purple-100 text-purple-800' }}">
                                    <span>{{ $p->session === '1' ? '☀️' : '🌤️' }} Sesi {{ $p->session }}</span>
                                </span>
                                <span class="block text-[10px] text-slate-400 font-mono mt-0.5">{{ $p->session_time }}</span>
                            </td>

                            <!-- Student Info -->
                            <td class="py-4 px-4">
                                <div class="font-extrabold text-slate-900 text-sm">
                                    {{ $p->student_name }}
                                </div>
                                <div class="text-[11px] text-slate-500 mt-0.5 flex flex-wrap items-center gap-1.5">
                                    <span class="px-1.5 py-0.5 rounded-md bg-slate-100 text-slate-700 font-bold">Tag: {{ $p->nickname }}</span>
                                    <span>&bull; {{ $p->school_name }}</span>
                                    <span>&bull; {{ $p->gender === 'L' ? 'L' : 'P' }}</span>
                                    <span>&bull; <span class="italic text-slate-400">{{ $p->experience_level }}</span></span>
                                </div>
                            </td>

                            <!-- Parent Info -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <div class="font-semibold text-slate-800">{{ $p->parent_name }}</div>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <a href="{{ $p->whatsapp_url }}" target="_blank" class="text-emerald-600 hover:text-emerald-700 font-mono font-bold flex items-center gap-1">
                                        <span>💬 {{ $p->whatsapp }}</span>
                                    </a>
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                @if($p->status === 'UTAMA')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> UTAMA
                                    </span>
                                @elseif($p->status === 'CADANGAN')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-extrabold bg-amber-100 text-amber-800 border border-amber-200">
                                        <span>📋 ANTREAN #{{ $p->waitlist_order }}</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-extrabold bg-rose-100 text-rose-800 border border-rose-200">
                                        <span>❌ DIBATALKAN</span>
                                    </span>
                                    @if($p->cancellation_reason)
                                        <span class="block text-[10px] text-slate-400 max-w-xs truncate mt-0.5">{{ $p->cancellation_reason }}</span>
                                    @endif
                                @endif
                            </td>

                            <!-- Presensi Toggle -->
                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                @if($p->status !== 'DIBATALKAN')
                                    <form action="{{ route('admin.participants.checkin', $p->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-xl font-bold text-xs transition-all {{ $p->is_attended ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
                                            {{ $p->is_attended ? '✓ Hadir' : '○ Belum Hadir' }}
                                        </button>
                                    </form>
                                    @if($p->attended_at)
                                        <span class="text-[10px] text-slate-400 block mt-0.5">{{ $p->attended_at->format('H:i') }} WIB</span>
                                    @endif
                                @else
                                    <span class="text-slate-300 text-xs">-</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    
                                    <!-- Send WhatsApp Notification -->
                                    <a href="{{ $p->whatsapp_confirmation_url }}" target="_blank" class="p-1.5 text-slate-500 hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors" title="Kirim WA Konfirmasi / Tiket">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                    </a>

                                    <!-- Promote to Utama (For Cadangan) -->
                                    @if($p->status === 'CADANGAN')
                                        <form action="{{ route('admin.participants.promote', $p->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Promosikan {{ $p->student_name }} menjadi Peserta Utama Sesi {{ $p->session }}?')" class="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold shadow-xs transition-colors" title="Naikkan ke Peserta Utama Sesi Ini">
                                                Promosi &uarr;
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Cancel Participant -->
                                    @if($p->status !== 'DIBATALKAN')
                                        <button type="button" onclick="openCancelModal({{ $p->id }}, '{{ addslashes($p->student_name) }}', '{{ $p->reg_code }}', '{{ $p->session }}')" class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg text-xs font-bold transition-colors">
                                            Batalkan
                                        </button>
                                    @else
                                        <!-- Restore Participant -->
                                        <form action="{{ route('admin.participants.restore', $p->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Pulihkan kembali {{ $p->student_name }} ke Sesi {{ $p->session }}?')" class="px-2.5 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg text-xs font-bold transition-colors">
                                                Pulihkan
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <p class="text-sm">Tidak ada data peserta ditemukan pada kriteria filter ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($participants->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $participants->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Cancellation Modal -->
<div id="cancelModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl relative border border-slate-100">
        <h3 class="text-base font-bold text-slate-900 mb-2">Batalkan Pendaftaran Peserta</h3>
        <p class="text-xs text-slate-500 mb-4" id="cancelParticipantText">Apakah Anda yakin ingin membatalkan peserta ini?</p>

        <form id="cancelForm" method="POST" action="">
            @csrf
            <div class="mb-4">
                <label class="block text-xs font-bold text-slate-700 mb-1.5">Alasan Pembatalan (Opsional)</label>
                <textarea name="reason" rows="2" placeholder="Contoh: Konfirmasi orang tua berhalangan hadir..." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-rose-500 outline-none"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2">
                <button type="button" onclick="closeCancelModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                    Kembali
                </button>
                <button type="submit" class="px-4 py-2 text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-xs transition-colors">
                    Ya, Batalkan Pendaftaran
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCancelModal(id, name, code, session) {
        document.getElementById('cancelParticipantText').innerText = `Apakah Anda yakin ingin membatalkan peserta ${name} (${code} - Sesi ${session})?`;
        document.getElementById('cancelForm').action = `/admin/participants/${id}/cancel`;
        document.getElementById('cancelModal').classList.remove('hidden');
        document.getElementById('cancelModal').classList.add('flex');
    }
    function closeCancelModal() {
        document.getElementById('cancelModal').classList.add('hidden');
        document.getElementById('cancelModal').classList.remove('flex');
    }
</script>
@endsection
