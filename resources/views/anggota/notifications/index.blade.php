<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Notifikasi</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

    <div class="flex min-h-screen">

        @include('sidebar.anggota')

        <div class="flex-1">

            <nav class="bg-white border-b border-slate-200 shadow-sm px-8 py-4">

                <div class="flex justify-between items-center">

                    {{-- Logo dan Info --}}
                    <div class="flex items-center gap-4">

                        <div
                            class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur flex items-center justify-center text-white text-2xl shadow">

                            📚

                        </div>

                        <div>

                            <h1 class="text-2xl font-bold text-blue-950">
                                SMPD
                            </h1>

                            <p class="text-sm text-slate-500">
                                Sistem Manajemen Perpustakaan Daerah
                            </p>

                        </div>

                    </div>

                    {{-- Menu kanan --}}
                    <div class="flex items-center gap-4">

                        {{-- Jam --}}
                        <div class="hidden lg:flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 text-slate-700">

                            🕒

                            <span id="clock"></span>

                        </div>

                        {{-- Profile --}}
                        <div class="relative">

                            <button id="profileButton" onclick="toggleProfileMenu()"
                                class="flex items-center gap-3 bg-slate-100 hover:bg-slate-200 px-4 py-2 rounded-2xl transition">

                                <div class="text-right">

                                    <p class="text-xs text-slate-500">
                                        Login sebagai
                                    </p>

                                    <p class="font-semibold text-blue-950">
                                        {{ session('username') }}
                                    </p>

                                    <span
                                        class="inline-block mt-1 px-2 py-0.5 text-xs font-medium rounded-full
                                        @if (session('role') == 'admin') bg-red-100 text-red-700
                                        @elseif(session('role') == 'pustakawan')
                                            bg-orange-100 text-orange-700
                                        @else
                                            bg-green-100 text-green-700 @endif">
                                        {{ ucfirst(session('role')) }}

                                    </span>

                                </div>

                                <div
                                    class="w-12 h-12 rounded-full bg-blue-950 text-white font-bold flex items-center justify-center shadow">

                                    {{ strtoupper(substr(session('username', 'A'), 0, 1)) }}

                                </div>

                            </button>

                            {{-- Dropdown --}}
                            <div id="profileMenu"
                                class="hidden absolute right-0 mt-3 w-72 bg-white rounded-2xl shadow-2xl border overflow-hidden z-50">

                                <div class="bg-blue-950 text-white p-5">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="w-12 h-12 rounded-full bg-white text-blue-950 flex items-center justify-center font-bold">

                                            {{ strtoupper(substr(session('username', 'A'), 0, 1)) }}

                                        </div>

                                        <div>

                                            <p class="font-bold">
                                                {{ session('username') }}
                                            </p>

                                            <p class="text-sm text-blue-200">
                                                {{ session('role') }}
                                            </p>

                                        </div>

                                    </div>

                                </div>

                                <a href="{{ route('profile.index') }}" class="block px-5 py-3 hover:bg-slate-100">

                                    👤 Profil Saya

                                </a>

                                <a href="{{ route('logout') }}" class="block px-5 py-3 text-red-600 hover:bg-red-50">

                                    🚪 Logout

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </nav>

            <main class="flex-1 p-6 md:p-10">

                <div class="mb-8">

                    <h1 class="text-3xl font-bold text-blue-950">
                        Riwayat Notifikasi
                    </h1>

                    <p class="text-slate-500">
                        Seluruh aktivitas dan informasi sistem.
                    </p>

                </div>

                @forelse($notifications as $notification)
                    <div
                        class="rounded-2xl shadow p-5 mb-4
                        @if ($notification->type == 'success') bg-green-50 border-l-4 border-green-500

                        @elseif($notification->type == 'warning')
                        bg-yellow-50 border-l-4 border-yellow-500

                        @elseif($notification->type == 'danger')
                        bg-red-50 border-l-4 border-red-500

                        @else
                        bg-blue-50 border-l-4 border-blue-500 @endif
                        ">

                        <div class="flex justify-between items-start">

                            <div>

                                <h2 class="font-bold text-lg">

                                    {{ $notification->title }}

                                </h2>

                                <p class="text-slate-600 mt-2">

                                    {{ $notification->message }}

                                </p>

                            </div>

                            <span class="text-xs text-slate-400">

                                {{ $notification->created_at }}

                            </span>

                        </div>

                    </div>

                @empty

                    <div class="bg-white rounded-2xl shadow p-6">

                        <p class="text-slate-500">

                            Belum ada notifikasi.

                        </p>

                    </div>
                @endforelse

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

            function toggleProfileMenu() {
                document
                    .getElementById('profileMenu')
                    .classList
                    .toggle('hidden');
            }

            document.addEventListener('click', function(event) {
                const menu =
                    document.getElementById('profileMenu');

                const button =
                    document.getElementById('profileButton');

                if (
                    !menu.contains(event.target) &&
                    !button.contains(event.target)
                ) {
                    menu.classList.add('hidden');
                }
            });
        </script>

</body>

</html>
