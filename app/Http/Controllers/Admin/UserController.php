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
     * Display a listing of all admin users.
     */
    public function index()
    {
        $users = User::orderBy('id', 'asc')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Store a newly created admin user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Alamat email ini sudah terdaftar untuk pengguna lain.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal harus terdiri dari 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = User::create([
            'name' => trim($request->name),
            'email' => strtolower(trim($request->email)),
            'password' => $request->password,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "Akun panitia '{$user->name}' ({$user->email}) berhasil dibuat.");
    }

    /**
     * Update the specified admin user's name and email.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => "required|email|max:150|unique:users,email,{$user->id}",
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Alamat email ini sudah digunakan oleh akun lain.',
        ]);

        $user->update([
            'name' => trim($request->name),
            'email' => strtolower(trim($request->email)),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "Data profil akun panitia '{$user->name}' berhasil diperbarui.");
    }

    /**
     * Change or reset password for any admin user.
     */
    public function changePassword(Request $request, User $user)
    {
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
     * Remove the specified admin user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif digunakan.');
        }

        // Prevent deleting the last remaining admin account
        if (User::count() <= 1) {
            return back()->with('error', 'Tidak dapat menghapus satu-satunya akun administrator yang tersisa.');
        }

        $name = $user->name;
        $email = $user->email;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "Akun panitia '{$name}' ({$email}) berhasil dihapus dari sistem.");
    }
}

