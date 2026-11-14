@extends('layouts.admin')

@section('title', 'Manajemen Akun Panitia & Password - Panel Admin')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black bg-indigo-50 text-indigo-700 border border-indigo-200 uppercase tracking-wider">
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    AKSES SISTEM PANITIA
                </span>
                <span class="text-xs text-slate-500 font-bold">&bull; {{ $users->count() }} Pengguna Terdaftar</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Manajemen Akun Panitia</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola hak akses panitia, tambahkan admin baru, perbarui profil, dan ubah / reset kata sandi semua akun pengguna.</p>
        </div>

        <div>
            <button type="button" onclick="openCreateUserModal()" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black uppercase tracking-wider rounded-xl shadow-xs transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                <span>Tambah Akun Panitia</span>
            </button>
        </div>
    </div>

    <!-- Error Validation Alert -->
    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-xs shadow-xs space-y-1">
            <div class="font-bold flex items-center gap-1.5 text-sm">
                <span>⚠️</span>
                <span>Terdapat kesalahan pada isian form:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5 pl-4 text-rose-800">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Users Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200/90 overflow-hidden shadow-xs">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-extrabold text-slate-900 text-base">Daftar Akun Pengguna</h3>
            <span class="text-xs text-slate-400">Total: <strong>{{ $users->count() }} Akun</strong></span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-black text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 text-center w-12">No</th>
                        <th class="py-3.5 px-4">Pengguna</th>
                        <th class="py-3.5 px-4">Alamat Email</th>
                        <th class="py-3.5 px-4 text-center">Status Akun</th>
                        <th class="py-3.5 px-4">Terdaftar Sejak</th>
                        <th class="py-3.5 px-4 text-right">Aksi &amp; Ganti Password</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium">
                    @foreach($users as $index => $u)
                        @php
                            $isCurrentUser = ($u->id === Auth::id());
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition-colors {{ $isCurrentUser ? 'bg-indigo-50/20' : '' }}">
                            <td class="py-4 px-4 text-center text-slate-400 font-bold">
                                {{ $index + 1 }}
                            </td>

                            <td class="py-4 px-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-slate-900 text-white font-extrabold text-xs flex items-center justify-center shrink-0 shadow-xs">
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-slate-900 text-sm">{{ $u->name }}</span>
                                            @if($isCurrentUser)
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-indigo-100 text-indigo-800 border border-indigo-200">
                                                    Akun Anda Saat Ini
                                                </span>
                                            @endif
                                        </div>
                                        <span class="text-[11px] text-slate-400 block">ID Akun: #{{ $u->id }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="py-4 px-4 whitespace-nowrap">
                                <span class="font-mono text-slate-700 bg-slate-100 px-2 py-1 rounded-md text-xs">
                                    {{ $u->email }}
                                </span>
                            </td>

                            <td class="py-4 px-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Panitia Aktif
                                </span>
                            </td>

                            <td class="py-4 px-4 whitespace-nowrap text-slate-500 text-[11px]">
                                {{ $u->created_at ? $u->created_at->format('d M Y, H:i') : '-' }} WIB
                            </td>

                            <td class="py-4 px-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    
                                    <!-- Change Password Button -->
                                    <button type="button" 
                                            onclick="openChangePasswordModal({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ $u->email }}')" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-800 rounded-lg text-xs font-bold transition-colors border border-amber-200" 
                                            title="Ubah kata sandi akun ini">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                        <span>Ganti Password</span>
                                    </button>

                                    <!-- Edit Profile Button -->
                                    <button type="button" 
                                            onclick="openEditUserModal({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ $u->email }}')" 
                                            class="p-1.5 text-slate-500 hover:text-indigo-600 rounded-lg hover:bg-indigo-50 transition-colors" 
                                            title="Ubah nama & email">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>

                                    <!-- Delete Button (Only for other accounts) -->
                                    @if(!$isCurrentUser)
                                        <button type="button" 
                                                onclick="openDeleteUserModal({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ $u->email }}')" 
                                                class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition-colors" 
                                                title="Hapus akun panitia ini">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ===================================================================== -->
<!-- MODAL 1: TAMBAH AKUN PANITIA BARU -->
<!-- ===================================================================== -->
<div id="createUserModal" class="fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl relative border border-slate-100 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
                <h3 class="text-base font-extrabold text-slate-900">Tambah Akun Panitia</h3>
            </div>
            <button type="button" onclick="closeCreateUserModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                &times;
            </button>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-3.5">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Panitia <span class="text-rose-500">*</span></label>
                <input type="text" name="name" required placeholder="Contoh: Muhammad Raihan" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Email Login <span class="text-rose-500">*</span></label>
                <input type="email" name="email" required placeholder="Contoh: panitia@muhijunior.id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Kata Sandi (Password) <span class="text-rose-500">*</span></label>
                <input type="password" name="password" required minlength="6" placeholder="Minimal 6 karakter" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Ulangi Kata Sandi (Konfirmasi) <span class="text-rose-500">*</span></label>
                <input type="password" name="password_confirmation" required minlength="6" placeholder="Ketik ulang kata sandi di atas" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                <button type="button" onclick="closeCreateUserModal()" class="px-4 py-2.5 text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-xs transition-colors">
                    Simpan Akun Baru
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ===================================================================== -->
<!-- MODAL 2: EDIT NAMA & EMAIL AKUN -->
<!-- ===================================================================== -->
<div id="editUserModal" class="fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl relative border border-slate-100 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </div>
                <h3 class="text-base font-extrabold text-slate-900">Ubah Profil Panitia</h3>
            </div>
            <button type="button" onclick="closeEditUserModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                &times;
            </button>
        </div>

        <form id="editUserForm" method="POST" action="" class="space-y-3.5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Panitia <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="editUserName" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Email Login <span class="text-rose-500">*</span></label>
                <input type="email" name="email" id="editUserEmail" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                <button type="button" onclick="closeEditUserModal()" class="px-4 py-2.5 text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-xs transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ===================================================================== -->
<!-- MODAL 3: GANTI PASSWORD (CHANGE PASSWORD) -->
<!-- ===================================================================== -->
<div id="changePasswordModal" class="fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl relative border border-slate-100 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">Ganti Kata Sandi</h3>
                    <p class="text-[11px] text-slate-500" id="changePasswordUserLabel">Pengguna</p>
                </div>
            </div>
            <button type="button" onclick="closeChangePasswordModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                &times;
            </button>
        </div>

        <form id="changePasswordForm" method="POST" action="" class="space-y-3.5">
            @csrf

            <div class="p-3 bg-amber-50 rounded-xl border border-amber-200 text-[11px] text-amber-900">
                💡 <strong>Catatan:</strong> Kata sandi akun ini akan langsung diperbarui ke kata sandi baru yang Anda masukkan di bawah.
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Kata Sandi Baru <span class="text-rose-500">*</span></label>
                <input type="password" name="password" required minlength="6" placeholder="Minimal 6 karakter" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium focus:ring-2 focus:ring-amber-500 outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Ulangi Kata Sandi Baru <span class="text-rose-500">*</span></label>
                <input type="password" name="password_confirmation" required minlength="6" placeholder="Ketik ulang kata sandi baru" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium focus:ring-2 focus:ring-amber-500 outline-none">
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                <button type="button" onclick="closeChangePasswordModal()" class="px-4 py-2.5 text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 text-xs font-bold text-white bg-amber-600 hover:bg-amber-700 rounded-xl shadow-xs transition-colors">
                    Perbarui Kata Sandi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ===================================================================== -->
<!-- MODAL 4: HAPUS AKUN PANITIA -->
<!-- ===================================================================== -->
<div id="deleteUserModal" class="fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-xs hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl relative border border-rose-100 space-y-4">
        <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
        </div>

        <div>
            <h3 class="text-base font-extrabold text-slate-900 mb-1">Hapus Akun Panitia?</h3>
            <p class="text-xs text-slate-600 leading-relaxed" id="deleteUserText">
                Akun ini tidak akan dapat login lagi ke panel sistem pendaftaran.
            </p>
        </div>

        <form id="deleteUserForm" method="POST" action="">
            @csrf
            @method('DELETE')

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-100">
                <button type="button" onclick="closeDeleteUserModal()" class="px-4 py-2.5 text-xs font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-xs transition-colors">
                    Ya, Hapus Akun
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Create User Modal
    function openCreateUserModal() {
        document.getElementById('createUserModal').classList.remove('hidden');
        document.getElementById('createUserModal').classList.add('flex');
    }
    function closeCreateUserModal() {
        document.getElementById('createUserModal').classList.add('hidden');
        document.getElementById('createUserModal').classList.remove('flex');
    }

    // Edit User Modal
    function openEditUserModal(id, name, email) {
        document.getElementById('editUserName').value = name;
        document.getElementById('editUserEmail').value = email;
        document.getElementById('editUserForm').action = `/admin/users/${id}`;
        document.getElementById('editUserModal').classList.remove('hidden');
        document.getElementById('editUserModal').classList.add('flex');
    }
    function closeEditUserModal() {
        document.getElementById('editUserModal').classList.add('hidden');
        document.getElementById('editUserModal').classList.remove('flex');
    }

    // Change Password Modal
    function openChangePasswordModal(id, name, email) {
        document.getElementById('changePasswordUserLabel').innerText = `${name} (${email})`;
        document.getElementById('changePasswordForm').action = `/admin/users/${id}/change-password`;
        document.getElementById('changePasswordModal').classList.remove('hidden');
        document.getElementById('changePasswordModal').classList.add('flex');
    }
    function closeChangePasswordModal() {
        document.getElementById('changePasswordModal').classList.add('hidden');
        document.getElementById('changePasswordModal').classList.remove('flex');
    }

    // Delete User Modal
    function openDeleteUserModal(id, name, email) {
        document.getElementById('deleteUserText').innerHTML = `Apakah Anda yakin ingin menghapus akun panitia <strong>${name}</strong> (<code>${email}</code>)? Tindakan ini tidak dapat dibatalkan.`;
        document.getElementById('deleteUserForm').action = `/admin/users/${id}`;
        document.getElementById('deleteUserModal').classList.remove('hidden');
        document.getElementById('deleteUserModal').classList.add('flex');
    }
    function closeDeleteUserModal() {
        document.getElementById('deleteUserModal').classList.add('hidden');
        document.getElementById('deleteUserModal').classList.remove('flex');
    }
</script>
@endpush
@endsection
