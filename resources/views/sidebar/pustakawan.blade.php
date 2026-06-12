<aside class="w-72 bg-blue-950 text-white hidden md:flex flex-col min-h-screen shadow-2xl">

    {{-- HEADER --}}
    <div class="p-6 border-b border-blue-900">

        <h1 class="text-3xl font-bold tracking-wide">
            SMPD
        </h1>

        <p class="text-blue-300 text-sm mt-1">
            Sistem Manajemen Perpustakaan Daerah
        </p>

    </div>

    {{-- USER INFO --}}
    <div class="p-6">

        <div class="bg-blue-900 rounded-2xl p-4 shadow">

            <p class="text-xs uppercase tracking-widest text-blue-300">
                Login Sebagai
            </p>

            <h2 class="font-bold text-lg mt-2">
                {{ session('username') }}
            </h2>

            <span class="inline-flex items-center gap-1 mt-3 px-3 py-1 bg-blue-800 rounded-full text-xs">

                📚 Pustakawan

            </span>

        </div>

    </div>

    {{-- MENU --}}
    <nav class="px-4 space-y-2">

        <a href="{{ route('pustakawan.dashboard') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
            {{ request()->routeIs('pustakawan.dashboard') ? 'bg-blue-800 shadow text-white' : 'hover:bg-blue-900 text-blue-100' }}">

            📊 Dashboard

        </a>

        <a href="{{ route('books.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
            {{ request()->routeIs('books.*') ? 'bg-blue-800 shadow text-white' : 'hover:bg-blue-900 text-blue-100' }}">

            📚 Data Buku

        </a>

        <a href="{{ route('members.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
            {{ request()->routeIs('members.*') ? 'bg-blue-800 shadow text-white' : 'hover:bg-blue-900 text-blue-100' }}">

            👥 Data Anggota

        </a>

        <a href="{{ route('loans.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
            {{ request()->routeIs('loans.*') ? 'bg-blue-800 shadow text-white' : 'hover:bg-blue-900 text-blue-100' }}">

            📖 Peminjaman

        </a>

        <a href="{{ route('returns.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
            {{ request()->is('returns*') ? 'bg-blue-800 shadow text-white' : 'hover:bg-blue-900 text-blue-100' }}">

            🔄 Pengembalian

        </a>

        <a href="{{ route('reservations.pustakawan') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
            {{ request()->is('reservations*') ? 'bg-blue-800 shadow text-white' : 'hover:bg-blue-900 text-blue-100' }}">

            📌 Reservasi Buku

        </a>

        <a href="{{ route('reports.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200
            {{ request()->routeIs('reports.*') ? 'bg-blue-800 shadow text-white' : 'hover:bg-blue-900 text-blue-100' }}">

            📈 Laporan

        </a>

    </nav>

    {{-- FOOTER --}}
    <div class="p-4 mt-4">

        <a href="{{ route('logout') }}"
            class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-red-600 hover:bg-red-700 rounded-xl transition font-semibold">
            Logout
        </a>

    </div>

</aside>
