<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Coding for Kids & A.I. for Learning - Workshop SD Kelas 6')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            900: '#312e81',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            body { background: white !important; color: black !important; }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col selection:bg-indigo-500 selection:text-white">

    <!-- Top Notification Banner -->
    <div class="bg-gradient-to-r from-indigo-700 via-indigo-600 to-purple-600 text-white text-xs sm:text-sm py-2 px-4 text-center font-medium shadow-sm no-print">
        <span class="inline-block animate-pulse mr-1">🚀</span>
        Workshop Eksklusif Siswa SD Kelas 6 &bull; Senin, 21 Desember 2026 &bull; 
        <span class="bg-white/20 px-2 py-0.5 rounded-full font-semibold ml-1">100% Gratis</span>
    </div>

    <!-- Navigation Bar -->
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-200/80 shadow-xs no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-18 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center text-white font-extrabold text-xl shadow-md group-hover:scale-105 transition-transform">
                    CK
                </div>
                <div>
                    <span class="block font-extrabold text-lg text-slate-900 tracking-tight leading-none">Coding for Kids</span>
                    <span class="text-xs text-indigo-600 font-semibold tracking-wider uppercase">&amp; A.I. for Learning</span>
                </div>
            </a>

            <!-- Nav Links -->
            <nav class="hidden md:flex items-center gap-6 text-sm font-semibold text-slate-600">
                <a href="{{ route('home') }}#tentang" class="hover:text-indigo-600 transition-colors">Tentang</a>
                <a href="{{ route('home') }}#materi" class="hover:text-indigo-600 transition-colors">Materi</a>
                <a href="{{ route('home') }}#rundown" class="hover:text-indigo-600 transition-colors">Rundown</a>
                <a href="{{ route('home') }}#faq" class="hover:text-indigo-600 transition-colors">FAQ</a>
            </nav>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 sm:gap-3">
                <button type="button" onclick="openTicketSearchModal()" class="inline-flex items-center gap-1.5 px-3 py-2 text-xs sm:text-sm font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-lg border border-indigo-200 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <span>Cek Tiket / Status</span>
                </button>

                <a href="{{ route('home') }}#pendaftaran" class="inline-flex items-center justify-center px-4 py-2 text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 rounded-lg shadow-md shadow-indigo-500/20 hover:shadow-indigo-500/30 transition-all">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 text-sm border-t border-slate-800 no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold text-lg">
                            CK
                        </div>
                        <span class="font-bold text-white text-lg">Coding for Kids &amp; A.I. for Learning</span>
                    </div>
                    <p class="text-slate-400 text-xs sm:text-sm leading-relaxed max-w-md">
                        Inisiatif edukasi pengenalan logika komputasi dan pemanfaatan Artificial Intelligence secara cerdas, bijak, dan aman untuk siswa sekolah dasar.
                    </p>
                    <div class="mt-4 flex items-center gap-2 text-xs text-slate-500">
                        <span>📅 Senin, 21 Desember 2026</span> &bull; 
                        <span>⏰ 08.30 – 12.30 WIB</span>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold text-white mb-3">Tautan Penting</h4>
                    <ul class="space-y-2 text-xs sm:text-sm">
                        <li><a href="{{ route('home') }}#tentang" class="hover:text-white transition-colors">Tentang Acara</a></li>
                        <li><a href="{{ route('home') }}#materi" class="hover:text-white transition-colors">Kurikulum Singkat</a></li>
                        <li><a href="{{ route('home') }}#rundown" class="hover:text-white transition-colors">Jadwal / Rundown</a></li>
                        <li><a href="{{ route('home') }}#faq" class="hover:text-white transition-colors">Pertanyaan Umum (FAQ)</a></li>
                        <li><button type="button" onclick="openTicketSearchModal()" class="text-indigo-400 hover:text-indigo-300 transition-colors">Cek Status Registrasi</button></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold text-white mb-3">Kontak Panitia</h4>
                    <p class="text-xs text-slate-400 mb-2">Punya pertanyaan seputar acara atau pendaftaran?</p>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('contact_whatsapp', '081234567890')) }}" target="_blank" class="inline-flex items-center gap-2 text-emerald-400 hover:text-emerald-300 font-semibold text-xs sm:text-sm mb-3">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        Hotline WhatsApp Panitia
                    </a>
                    <div class="mt-4 pt-4 border-t border-slate-800 text-xs">
                        <a href="{{ route('admin.login') }}" class="text-slate-500 hover:text-slate-400 transition-colors">Portal Admin Panitia &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-800 text-center text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p>&copy; 2026 Coding for Kids &amp; A.I. for Learning. Hak cipta dilindungi.</p>
                <p class="text-slate-600">Sistem Pendaftaran Event Edukasi &bull; Laravel Ecosystem for HestiaCP</p>
            </div>
        </div>
    </footer>

    <!-- Ticket Search Modal -->
    <div id="ticketSearchModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl relative border border-slate-100 animate-in fade-in zoom-in duration-200">
            <button type="button" onclick="closeTicketSearchModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <div class="text-center mb-6">
                <div class="w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Cari E-Ticket / Cek Status</h3>
                <p class="text-xs text-slate-500 mt-1">Masukkan Kode Registrasi (misal: AI26-001) atau Nomor WhatsApp Orang Tua saat pendaftaran.</p>
            </div>

            <form action="{{ route('ticket.check') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kode Registrasi atau No. WhatsApp</label>
                    <input type="text" name="query" required placeholder="Contoh: AI26-001 atau 08123456789" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <button type="button" onclick="closeTicketSearchModal()" class="w-1/2 px-4 py-2.5 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="w-1/2 px-4 py-2.5 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md transition-colors">
                        Cari Tiket
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script for Modal & Search Results -->
    <script>
        function openTicketSearchModal() {
            document.getElementById('ticketSearchModal').classList.remove('hidden');
            document.getElementById('ticketSearchModal').classList.add('flex');
        }
        function closeTicketSearchModal() {
            document.getElementById('ticketSearchModal').classList.add('hidden');
            document.getElementById('ticketSearchModal').classList.remove('flex');
        }

        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeTicketSearchModal();
        });
    </script>
    @stack('scripts')
</body>
</html>
