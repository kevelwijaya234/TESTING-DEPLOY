<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>OPAC - SMPD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-slate-100 text-slate-800">

    @if (session('role'))

        <div class="flex min-h-screen">

            {{-- SIDEBAR --}}
            @include('sidebar.anggota')

            <div class="flex-1 min-w-0">

                {{-- HEADER --}}
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
                            <div
                                class="hidden lg:flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 text-slate-700">

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

                                    <a href="{{ route('logout') }}"
                                        class="block px-5 py-3 text-red-600 hover:bg-red-50">

                                        🚪 Logout

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                </nav>

                <main class="p-6 md:p-10">

                    <div class="p-8">

                        <div class="mb-8">
                            <h1 class="text-3xl font-bold text-blue-950">
                                Katalog Buku
                            </h1>

                            <p class="text-slate-500">
                                Cari dan jelajahi koleksi buku perpustakaan.
                            </p>
                        </div>

                        {{-- FORM PENCARIAN --}}
                        <form action="{{ route('opac.index') }}" method="GET"
                            class="bg-white p-6 rounded-2xl shadow mb-8">

                            <label class="block mb-2 font-semibold">
                                Pencarian Buku
                            </label>

                            <div class="flex flex-col md:flex-row gap-4">

                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari judul, penulis, atau kategori..."
                                    class="flex-1 border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-900 outline-none">

                                <button type="submit"
                                    class="bg-blue-950 text-white px-6 py-3 rounded-lg hover:bg-blue-900">

                                    Cari

                                </button>

                                <a href="{{ route('opac.index') }}"
                                    class="border border-slate-300 px-6 py-3 rounded-lg text-center hover:bg-slate-50">

                                    Reset

                                </a>

                            </div>

                        </form>

                        {{-- LIST BUKU --}}
                        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">

                            @forelse($books as $book)
                                <div class="bg-white rounded-2xl shadow overflow-hidden">

                                    <div class="h-44 bg-blue-100 flex items-center justify-center">
                                        <span class="text-5xl">📘</span>
                                    </div>

                                    <div class="p-5">

                                        <span class="text-xs bg-blue-100 text-blue-900 px-3 py-1 rounded-full">
                                            {{ $book->category->name ?? '-' }}
                                        </span>

                                        <h3 class="font-bold text-lg mt-3 text-blue-950">
                                            {{ $book->title }}
                                        </h3>

                                        <p class="text-sm text-slate-500 mt-1">
                                            {{ $book->kode_buku ?? '-' }}
                                        </p>

                                        <p class="text-sm text-slate-500 mt-1">
                                            {{ $book->author }}
                                        </p>

                                        <p class="text-sm text-slate-500">
                                            Tahun: {{ $book->year ?? '-' }}
                                        </p>

                                        <div class="mt-3 flex justify-between items-center">

                                            <span class="text-sm">
                                                Stok: {{ $book->stock }}
                                            </span>

                                            @if ($book->stock > 0)
                                                <span
                                                    class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full">
                                                    Tersedia
                                                </span>
                                            @else
                                                <span class="text-xs bg-red-100 text-red-700 px-3 py-1 rounded-full">
                                                    Habis
                                                </span>
                                            @endif

                                        </div>

                                        <a href="{{ route('opac.show', $book->id) }}"
                                            class="block mt-5 text-center bg-blue-950 text-white py-2 rounded-lg hover:bg-blue-900">

                                            Detail Buku

                                        </a>

                                    </div>

                                </div>

                            @empty

                                <div class="col-span-full bg-white p-8 rounded-2xl shadow text-center">

                                    <h3 class="text-xl font-bold text-blue-950">
                                        Buku tidak ditemukan
                                    </h3>

                                    <p class="text-slate-500 mt-2">
                                        Coba gunakan kata kunci lain.
                                    </p>

                                </div>
                            @endforelse

                        </div>

                        <div class="mt-8">
                            {{ $books->links() }}
                        </div>

                </main>

            </div>
        @else
            {{-- PUBLIC OPAC --}}

            <nav class="bg-white shadow-sm">

                <div class="w-full px-8 py-4 flex justify-between items-center">

                    <h1 class="text-2xl font-bold text-blue-950">
                        SMPD
                    </h1>

                    <div class="space-x-4">

                        <a href="{{ route('landing') }}" class="text-slate-700 hover:text-blue-900">
                            Home
                        </a>

                        <a href="{{ route('opac.index') }}" class="text-blue-900 font-semibold">
                            OPAC
                        </a>

                        <a href="{{ route('login') }}"
                            class="bg-blue-950 text-white px-4 py-2 rounded-lg hover:bg-blue-900">

                            Login

                        </a>

                    </div>

                </div>

            </nav>

            <section class="bg-blue-950 text-white py-14">

                <div class="max-w-7xl mx-auto px-6">

                    <h2 class="text-4xl font-bold mb-3">
                        Public OPAC
                    </h2>

                    <p class="text-blue-100">
                        Cari koleksi buku berdasarkan judul, penulis, atau kategori.
                    </p>

                </div>

            </section>

            <main class="max-w-7xl mx-auto px-6 py-10">

                <form action="{{ route('opac.index') }}" method="GET" class="bg-white p-6 rounded-2xl shadow mb-8">

                    <label class="block mb-2 font-semibold">
                        Pencarian Buku
                    </label>

                    <div class="flex flex-col md:flex-row gap-4">

                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari judul, penulis, atau kategori..."
                            class="flex-1 border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-900 outline-none">

                        <button type="submit" class="bg-blue-950 text-white px-6 py-3 rounded-lg hover:bg-blue-900">

                            Cari

                        </button>

                    </div>

                </form>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">

                    @forelse($books as $book)
                        <div class="bg-white rounded-2xl shadow overflow-hidden">

                            <div class="h-44 bg-blue-100 flex items-center justify-center">
                                <span class="text-5xl">📘</span>
                            </div>

                            <div class="p-5">

                                <span class="text-xs bg-blue-100 text-blue-900 px-3 py-1 rounded-full">
                                    {{ $book->category->name ?? '-' }}
                                </span>

                                <h3 class="font-bold text-lg mt-3 text-blue-950">
                                    {{ $book->title }}
                                </h3>

                                <p class="text-sm text-slate-500 mt-1">
                                    {{ $book->author }}
                                </p>

                                <a href="{{ route('opac.show', $book->id) }}"
                                    class="block mt-5 text-center bg-blue-950 text-white py-2 rounded-lg hover:bg-blue-900">

                                    Detail Buku

                                </a>

                            </div>

                        </div>

                    @empty

                        <div class="col-span-full bg-white p-8 rounded-2xl shadow text-center">

                            <h3 class="text-xl font-bold text-blue-950">
                                Buku tidak ditemukan
                            </h3>

                        </div>
                    @endforelse

                </div>

            </main>

    @endif

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
    </script>
</body>

</html>
