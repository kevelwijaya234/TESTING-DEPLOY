@php
    $notificationCount = \App\Models\Notification::where('member_id', session('member_id'))
        ->where('is_read', false)
        ->count();
@endphp

<aside class="w-72 bg-blue-950 text-white p-6 hidden md:flex flex-col min-h-screen">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-8">

        <h1 class="text-2xl font-bold">
            SMPD
        </h1>

        <a href="{{ route('notifications.index') }}" class="relative">

            <div
                class="w-10 h-10 rounded-full bg-blue-900 hover:bg-blue-800 flex items-center justify-center transition duration-300">

                🔔

            </div>

            @if ($notificationCount > 0)
                <span
                    class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center animate-pulse">

                    {{ $notificationCount }}

                </span>
            @endif

        </a>

    </div>

    {{-- USER PROFILE --}}
    <div class="mb-6 bg-blue-900 rounded-xl p-4">

        <div class="flex items-center gap-3">

            <div
                class="w-12 h-12 rounded-full bg-cyan-400 text-blue-950 font-bold text-lg flex items-center justify-center">

                {{ strtoupper(substr(session('username', 'A'), 0, 1)) }}

            </div>

            <div>

                <p class="text-xs text-blue-200">
                    Halo,
                </p>

                <h2 class="font-bold text-white">
                    {{ session('username', 'Anggota') }}
                </h2>

            </div>

        </div>

    </div>

    {{-- MENU --}}
    <nav class="space-y-2 flex-1">

        <a href="{{ route('anggota.dashboard') }}"
            class="block px-4 py-3 rounded-lg hover:bg-blue-900 transition
            {{ request()->routeIs('anggota.dashboard') ? 'bg-blue-900' : '' }}">

            🏠 Dashboard

        </a>

        <a href="{{ route('opac.index') }}"
            class="block px-4 py-3 rounded-lg hover:bg-blue-900 transition
            {{ request()->routeIs('opac.index') ? 'bg-blue-900' : '' }}">

            📚 Katalog Buku

        </a>

        <a href="{{ route('loan-history.index') }}"
            class="block px-4 py-3 rounded-lg hover:bg-blue-900 transition
            {{ request()->routeIs('loan-history.*') ? 'bg-blue-900' : '' }}">

            📖 Riwayat Peminjaman

        </a>

        <a href="{{ route('reservations.anggota') }}"
            class="block px-4 py-3 rounded-lg hover:bg-blue-900 transition
            {{ request()->routeIs('reservations.anggota') ? 'bg-blue-900' : '' }}">

            📌 Reservasi Buku

        </a>

        <a href="{{ route('elibrary.index') }}"
            class="block px-4 py-3 rounded-lg hover:bg-blue-900 transition
            {{ request()->routeIs('elibrary.*') ? 'bg-blue-900' : '' }}">

            💻 E-Library

        </a>

        <a href="{{ route('members.card', session('member_id')) }}"
            class="block px-4 py-3 rounded-lg hover:bg-blue-900 transition
            {{ request()->routeIs('members.card') ? 'bg-blue-900' : '' }}">

            🪪 Kartu Member

        </a>

        <a href="{{ route('notifications.index') }}"
            class="block px-4 py-3 rounded-lg hover:bg-blue-900 transition
            {{ request()->routeIs('notifications.*') ? 'bg-blue-900' : '' }}">

            🔔 Riwayat Notifikasi

        </a>

        {{-- FOOTER --}}
        <div class="mt-6">

            <a href="{{ route('logout') }}"
                class="block px-4 py-3 bg-red-600 hover:bg-red-700 rounded-lg text-center transition duration-300">

                Logout

            </a>

        </div>

    </nav>

</aside>
