<aside class="w-72 bg-blue-950 text-white hidden md:flex flex-col min-h-screen shadow-xl">

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

        <div class="bg-blue-900 rounded-xl p-4">

            <p class="text-xs uppercase tracking-wider text-blue-300">
                Login Sebagai
            </p>

            <h2 class="font-bold text-lg mt-1">
                {{ session('username') }}
            </h2>

            <span class="inline-block mt-2 px-3 py-1 text-xs bg-blue-800 rounded-full">
                Administrator
            </span>

        </div>

    </div>

    {{-- MENU --}}
    <nav class="px-4 space-y-2">

        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
            {{ request()->routeIs('admin.dashboard') ? 'bg-blue-800 text-white' : 'hover:bg-blue-900 text-blue-100' }}">
            📊 Dashboard
        </a>

        <a href="{{ route('users.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
            {{ request()->routeIs('users.*') ? 'bg-blue-800 text-white' : 'hover:bg-blue-900 text-blue-100' }}">
            👤 Manajemen User
        </a>

        <a href="{{ route('books.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
            {{ request()->routeIs('books.*') ? 'bg-blue-800 text-white' : 'hover:bg-blue-900 text-blue-100' }}">
            📚 Manajemen Buku
        </a>

        <a href="{{ route('members.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
            {{ request()->routeIs('members.*') ? 'bg-blue-800 text-white' : 'hover:bg-blue-900 text-blue-100' }}">
            👥 Manajemen Anggota
        </a>

        <a href="{{ route('reports.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
            {{ request()->routeIs('reports.*') ? 'bg-blue-800 text-white' : 'hover:bg-blue-900 text-blue-100' }}">
            📈 Laporan Sistem
        </a>

        <a href="{{ route('permissions.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
            {{ request()->routeIs('permissions.*') ? 'bg-blue-800 text-white' : 'hover:bg-blue-900 text-blue-100' }}">
            🔐 Hak Akses
        </a>

    </nav>

    {{-- LOGOUT --}}
    <div class="px-4 mt-4">

        <a href="{{ route('logout') }}"
            class="block w-full text-center px-4 py-3 bg-red-600 hover:bg-red-700 rounded-xl transition font-semibold">

            Logout

        </a>

    </div>

</aside>
