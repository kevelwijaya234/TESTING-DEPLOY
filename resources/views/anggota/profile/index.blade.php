<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Profil Saya</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-slate-100">

    <div class="flex min-h-screen">

        @include('sidebar.anggota')
        <div class="flex-1">

            <nav class="bg-white border-b shadow-sm px-8 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-blue-950">
                            SMPD
                        </h1>
                        <p class="text-sm text-slate-500">
                            Sistem Manajemen Perpustakaan Daerah
                        </p>
                    </div>

                    <div class="flex items-center gap-4">

                        {{-- Jam --}}
                        <div class="hidden lg:flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 text-slate-700">

                            🕒

                            <span id="clock"></span>

                        </div>

                    </div>
            </nav>

            <main class="flex-1 p-6 md:p-10">


                <div class="mb-8">

                    <h1 class="text-3xl font-bold text-blue-950">

                        Profil Saya

                    </h1>

                    <p class="text-slate-500">

                        Informasi akun anggota perpustakaan.

                    </p>

                </div>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-300 text-green-700 p-4 rounded-xl mb-6">

                        {{ session('success') }}

                    </div>
                @endif

                <div class="bg-white rounded-2xl shadow p-8">

                    <div class="flex items-center gap-5 mb-8">

                        <div
                            class="w-20 h-20 rounded-full bg-blue-950 text-white flex items-center justify-center text-3xl font-bold">

                            {{ strtoupper(substr($member->name, 0, 1)) }}

                        </div>

                        <div>

                            <h2 class="text-2xl font-bold text-blue-950">

                                {{ $member->name }}

                            </h2>

                            <p class="text-slate-500">

                                {{ ucfirst($member->role->name) }}

                            </p>

                        </div>

                    </div>

                    <div class="grid md:grid-cols-2 gap-6">

                        <div>

                            <label class="text-slate-500 text-sm">
                                Kode Anggota
                            </label>

                            <p class="font-semibold">
                                {{ $member->member_code }}
                            </p>

                        </div>

                        <div>

                            <label class="text-slate-500 text-sm">
                                Email
                            </label>

                            <p class="font-semibold">
                                {{ $member->email }}
                            </p>

                        </div>

                        <div>

                            <label class="text-slate-500 text-sm">
                                Nomor HP
                            </label>

                            <p class="font-semibold">
                                {{ $member->phone ?? '-' }}
                            </p>

                        </div>

                        <div>

                            <label class="text-slate-500 text-sm">
                                Status
                            </label>

                            <p class="font-semibold text-green-600">
                                {{ $member->status }}
                            </p>

                        </div>

                        <div class="md:col-span-2">

                            <label class="text-slate-500 text-sm">
                                Alamat
                            </label>

                            <p class="font-semibold">
                                {{ $member->address ?? '-' }}
                            </p>

                        </div>

                    </div>

                    <div class="mt-8">

                        <a href="{{ route('profile.edit') }}"
                            class="bg-blue-950 hover:bg-blue-900 text-white px-6 py-3 rounded-xl">

                            Edit Profil

                        </a>

                    </div>

                </div>

            </main>

        </div>

        <script>
            function updateClock() {
                const now = new Date();
                document.getElementById('clock').innerHTML =
                    now.toLocaleTimeString('id-ID');
            }

            setInterval(updateClock, 1000);
            updateClock();
        </script>

</body>

</html>
