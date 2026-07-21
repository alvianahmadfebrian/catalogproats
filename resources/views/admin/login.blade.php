<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Proats Music CMS</title>
    <!-- Google Fonts: Outfit & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        h1, h2, h3 { font-family: 'Outfit', sans-serif; letter-spacing: -0.02em; }
    </style>
</head>
<body class="bg-white min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-sm">

        <!-- Logo -->
        <div class="text-center mb-8">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Proats Logo" class="h-16 w-auto mx-auto mb-3 object-contain">
            <h1 class="text-xl font-extrabold text-gray-900">Proats Admin CMS</h1>
            <p class="text-xs text-gray-400 mt-1">Masuk untuk mengelola katalog alat musik</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl border border-orange-100 shadow-sm p-6">

            @if(session('success'))
                <div class="mb-4 bg-green-50 text-green-700 p-3 rounded-xl text-xs font-semibold flex items-center gap-2 border border-green-200">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div class="mb-4 bg-red-50 text-red-700 p-3 rounded-xl text-xs font-semibold flex items-center gap-2 border border-red-200">
                    <i class="fas fa-circle-exclamation"></i> {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Username / Email</label>
                    <input type="text" 
                           name="username" 
                           value="{{ old('username') }}" 
                           required 
                           placeholder="Masukkan username admin" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 mb-1.5">Password</label>
                    <input type="password" 
                           name="password" 
                           required 
                           placeholder="••••••••" 
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-100">
                </div>

                <label class="flex items-center gap-2 cursor-pointer text-xs text-gray-500">
                    <input type="checkbox" name="remember" checked class="rounded text-orange-500 focus:ring-orange-400">
                    <span>Ingat saya</span>
                </label>

                <button type="submit" class="w-full py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl transition text-sm">
                    Masuk
                </button>
            </form>
        </div>

        <p class="text-center text-[11px] text-gray-300 mt-6">&copy; {{ date('Y') }} Proats Music E-Catalog</p>
    </div>

</body>
</html>
