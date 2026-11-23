<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of admin users.
     * Panitia can only view their own account.
     * Administrator can view all accounts.
     */
    public function index()
    {
        $currentUser = Auth::user();
        $users = ($currentUser && $currentUser->isPanitia())
            ? User::where('id', $currentUser->id)->get()
            : User::orderBy('id', 'asc')->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Store a newly created admin or panitia user in storage.
     * Only accessible by Administrator.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email',
            'role' => 'nullable|in:admin,panitia',
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Alamat email ini sudah terdaftar untuk pengguna lain.',
            'role.in' => 'Peran akun yang dipilih tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal harus terdiri dari 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $role = $request->input('role', 'panitia');
        $roleLabel = ($role === 'admin') ? 'Administrator' : 'Panitia';

        $user = User::create([
            'name' => trim($request->name),
            'email' => strtolower(trim($request->email)),
            'role' => $role,
            'password' => $request->password,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "Akun {$roleLabel} '{$user->name}' ({$user->email}) berhasil dibuat.");
    }

    /**
     * Update the specified user's profile and role.
     * Only accessible by Administrator.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => "required|email|max:150|unique:users,email,{$user->id}",
            'role' => 'nullable|in:admin,panitia',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Alamat email ini sudah digunakan oleh akun lain.',
            'role.in' => 'Peran akun yang dipilih tidak valid.',
        ]);

        $updateData = [
            'name' => trim($request->name),
            'email' => strtolower(trim($request->email)),
        ];

        if ($request->filled('role')) {
            // Prevent demoting the only remaining administrator
            if ($user->isAdmin() && $request->role !== 'admin' && User::where('role', 'admin')->count() <= 1) {
                return back()->with('error', 'Tidak dapat mengubah peran satu-satunya Administrator yang tersisa.');
            }
            $updateData['role'] = $request->role;
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')
            ->with('success', "Data profil akun '{$user->name}' berhasil diperbarui.");
    }

    /**
     * Change or reset password for a user.
     * Panitia can ONLY change their own password.
     * Administrator can change any user's password.
     */
    public function changePassword(Request $request, User $user)
    {
        // Enforce self-only password change for Panitia
        if ($request->user()->isPanitia() && $user->id !== $request->user()->id) {
            abort(403, 'Akses ditolak. Sebagai Panitia, Anda hanya diizinkan mengubah kata sandi akun Anda sendiri.');
        }

        $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal harus terdiri dari 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $user->update([
            'password' => $request->password,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "Kata sandi untuk akun '{$user->name}' ({$user->email}) berhasil diperbarui.");
    }

    /**
     * Remove the specified user from storage.
     * Only accessible by Administrator.
     */
    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif digunakan.');
        }

        // Prevent deleting the last remaining admin account
        if ($user->isAdmin() && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'Tidak dapat menghapus satu-satunya akun Administrator yang tersisa.');
        }

        $name = $user->name;
        $email = $user->email;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "Akun '{$name}' ({$email}) berhasil dihapus dari sistem.");
    }
}

