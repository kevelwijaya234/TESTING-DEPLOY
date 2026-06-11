<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SMPD</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden">

        <div class="grid md:grid-cols-2">

            {{-- KIRI --}}
            <div class="bg-blue-950 text-white p-12 flex flex-col justify-center">

                <h1 class="text-5xl font-bold mb-4">
                    SMPD
                </h1>

                <h2 class="text-2xl font-semibold mb-4">
                    Sistem Manajemen Perpustakaan Daerah
                </h2>

                <p class="text-blue-100 leading-relaxed">
                    Daftarkan akun anggota perpustakaan untuk mengakses katalog buku,
                    melakukan reservasi, melihat riwayat peminjaman,
                    dan mengakses E-Library.
                </p>

                <div class="mt-8">
                    <div class="bg-white/10 rounded-2xl p-4">
                        📚 Akses ribuan koleksi buku
                    </div>

                    <div class="bg-white/10 rounded-2xl p-4 mt-3">
                        📖 E-Library Digital
                    </div>

                    <div class="bg-white/10 rounded-2xl p-4 mt-3">
                        🔔 Notifikasi Reservasi
                    </div>
                </div>

            </div>

            {{-- KANAN --}}
            <div class="p-10">

                <div class="mb-8">

                    <h2 class="text-3xl font-bold text-blue-950">
                        Daftar Anggota
                    </h2>

                    <p class="text-slate-500 mt-2">
                        Lengkapi data berikut untuk membuat akun baru.
                    </p>

                </div>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-300 text-red-700 rounded-xl p-4 mb-6">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register.store') }}" method="POST" class="space-y-5">

                    @csrf

                    <div>
                        <label class="block mb-2 font-medium text-slate-700">
                            Nama Lengkap
                        </label>

                        <input type="text" name="name" value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap"
                            class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-900 outline-none">
                    </div>

                    <div>
                        <label class="block mb-2 font-medium text-slate-700">
                            Email
                        </label>

                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email"
                            class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-900 outline-none">
                    </div>

                    <div>

                        <label class="block mb-2 font-medium text-slate-700">
                            Password
                        </label>

                        <div class="relative">

                            <input type="password" id="password" name="password" placeholder="Minimal 6 karakter"
                                class="w-full border rounded-xl px-4 py-3 pr-12 focus:ring-2 focus:ring-blue-900 outline-none">

                            <button type="button" onclick="togglePassword('password','eyeOpen1','eyeClosed1')"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-blue-950">

                                <svg id="eyeOpen1" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5
                                    c4.478 0 8.268 2.943 9.542 7
                                    -1.274 4.057-5.064 7-9.542 7
                                    -4.477 0-8.268-2.943-9.542-7z" />

                                </svg>

                                <svg id="eyeClosed1" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3l18 18" />

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.58 10.58a2 2 0 102.83 2.83" />

                                </svg>

                            </button>

                        </div>

                    </div>
                    <div>

                        <label class="block mb-2 font-medium text-slate-700">
                            Konfirmasi Password
                        </label>

                        <div class="relative">

                            <input type="password" id="password_confirmation" name="password_confirmation"
                                placeholder="Ulangi password"
                                class="w-full border rounded-xl px-4 py-3 pr-12 focus:ring-2 focus:ring-blue-900 outline-none">

                            <button type="button"
                                onclick="togglePassword('password_confirmation','eyeOpen2','eyeClosed2')"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-blue-950">

                                <svg id="eyeOpen2" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5
                                    c4.478 0 8.268 2.943 9.542 7
                                    -1.274 4.057-5.064 7-9.542 7
                                    -4.477 0-8.268-2.943-9.542-7z" />

                                </svg>

                                <svg id="eyeClosed2" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3l18 18" />

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.58 10.58a2 2 0 102.83 2.83" />

                                </svg>

                            </button>

                        </div>

            </div>

            <button type="submit"
                class="w-full bg-blue-950 hover:bg-blue-900 text-white py-3 rounded-xl font-semibold transition">

                Daftar Sekarang

            </button>

            </form>

            <div class="mt-6 text-center">

                <span class="text-slate-500">
                    Sudah punya akun?
                </span>

                <a href="{{ route('login') }}" class="text-blue-950 font-semibold hover:underline">

                    Login

                </a>

            </div>

        </div>

    </div>

    </div>

    <script>
        function togglePassword(inputId, eyeOpenId, eyeClosedId) {
            const input =
                document.getElementById(inputId);

            const eyeOpen =
                document.getElementById(eyeOpenId);

            const eyeClosed =
                document.getElementById(eyeClosedId);

            if (input.type === 'password') {
                input.type = 'text';

                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                input.type = 'password';

                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>

</body>

</html>
