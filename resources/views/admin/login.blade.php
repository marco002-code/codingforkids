<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Panitia - Coding for Kids</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-slate-800 rounded-3xl p-8 border border-slate-700 shadow-2xl relative overflow-hidden">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="bg-white px-5 py-2.5 rounded-2xl shadow-lg inline-block mx-auto mb-4 border border-slate-600">
                <img src="{{ asset('images/logo-muhijunior-iss.png') }}" alt="Muhijunior ISS" class="h-10 w-auto object-contain">
            </div>
            <h1 class="text-2xl font-black text-white tracking-tight">Portal Panitia Event</h1>
            <p class="text-xs text-slate-400 mt-1">Coding for Kids and A.I. for Learning 2026</p>
        </div>

        @if($errors->any())
            <div class="mb-5 p-3.5 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs">
                {{ $errors->first() }}
            </div>
        @endif

        @if(session('success'))
            <div class="mb-5 p-3.5 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs">
                {{ session('success') }}
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-300 mb-1.5">Email Administrator</label>
                <input type="email" name="email" value="{{ old('email', 'admin@codingforkids.id') }}" required class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-300 mb-1.5">Kata Sandi</label>
                <input type="password" name="password" value="admin12345" required class="w-full px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
            </div>

            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center gap-2 cursor-pointer text-slate-400">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-700 bg-slate-900 text-indigo-600 focus:ring-indigo-500">
                    <span>Ingat saya</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-lg shadow-indigo-600/30 transition-colors mt-2">
                Masuk ke Dashboard &rarr;
            </button>
        </form>

        <!-- Credentials hint -->
        <div class="mt-6 pt-5 border-t border-slate-700/80 text-center">
            <span class="text-[11px] text-slate-500 block mb-1 font-mono">Akun Default Demo:</span>
            <code class="text-xs text-indigo-300 bg-slate-900 px-2 py-1 rounded-md">admin@muhijunior.id</code>
            <span class="text-slate-500 text-xs mx-1">/</span>
            <code class="text-xs text-indigo-300 bg-slate-900 px-2 py-1 rounded-md">admin12345</code>
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('home') }}" class="text-xs text-slate-400 hover:text-white transition-colors">
                &larr; Kembali ke Landing Page
            </a>
        </div>
    </div>

</body>
</html>

