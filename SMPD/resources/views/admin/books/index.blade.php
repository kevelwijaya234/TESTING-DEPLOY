@php
    $role = session('role');
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manajemen Buku - SMPD</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-slate-100">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        @if ($role == 'admin')
            @include('sidebar.admin')
        @else
            @include('sidebar.pustakawan')
        @endif

        {{-- Content --}}
        <main class="flex-1 p-6 md:p-10">
            {{-- Header --}}
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4 mb-8">

                <div>
                    <h1 class="text-3xl font-bold text-blue-950">
                        Manajemen Buku
                    </h1>

                    <p class="text-slate-500 mt-1">
                        Kelola data buku dan QR Member Card.
                    </p>
                </div>

                <div class="flex flex-col md:flex-row gap-3">

                    {{-- Search --}}
                    <form action="{{ route('books.index') }}" method="GET" class="flex gap-2">

                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari kode, judul, nama, ..."
                            class="border border-slate-300 rounded-xl px-4 py-2 w-72 focus:outline-none focus:ring-2 focus:ring-blue-300">

                        <button type="submit" class="bg-slate-700 hover:bg-slate-800 text-white px-4 py-2 rounded-xl">
                            Cari
                        </button>

                    </form>

                    {{-- Tambah --}}
                    @if (hasPermission('books', 'create'))
                        <a href="{{ route('books.create') }}"
                            class="bg-blue-950 hover:bg-blue-900 text-white px-5 py-3 rounded-xl">
                            + Tambah Buku
                        </a>
                    @endif

                </div>

            </div>
            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl mb-6">

                    {{ session('success') }}

                </div>
            @endif

            <div class="bg-white rounded-2xl shadow overflow-hidden">

                {{-- Header Table --}}
                <div class="p-5 border-b flex flex-col md:flex-row md:justify-between md:items-center gap-4">

                    <h2 class="text-xl font-bold text-blue-950">
                        Daftar Buku
                    </h2>

                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-blue-950 text-white">

                            <tr>

                                <th class="p-4 text-center">
                                    No
                                </th>

                                <th class="p-4">
                                    Kode Buku
                                </th>

                                <th class="p-4">
                                    Judul Buku
                                </th>

                                <th class="p-4">
                                    Penulis
                                </th>

                                <th class="p-4">
                                    Kategori
                                </th>

                                <th class="p-4 text-center">
                                    Stok
                                </th>

                                <th class="p-4 text-center">
                                    Status
                                </th>

                                <th class="p-4 text-center">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($books as $book)
                                <tr class="border-b hover:bg-slate-50 transition">

                                    <td class="p-4 text-center">

                                        {{ $loop->iteration + ($books->currentPage() - 1) * $books->perPage() }}

                                    </td>

                                    <td class="p-4">

                                        <span class="font-mono text-sm bg-slate-100 px-2 py-1 rounded">

                                            {{ $book->kode_buku }}

                                        </span>

                                    </td>

                                    <td class="p-4 font-semibold text-blue-950">

                                        {{ $book->title }}

                                    </td>

                                    <td class="p-4">

                                        {{ $book->author }}

                                    </td>

                                    <td class="p-4">

                                        {{ $book->category->name ?? '-' }}

                                    </td>

                                    <td class="p-4 text-center">

                                        @if ($book->stock > 5)
                                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">

                                                {{ $book->stock }}

                                            </span>
                                        @elseif($book->stock > 0)
                                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">

                                                {{ $book->stock }}

                                            </span>
                                        @else
                                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">

                                                Habis

                                            </span>
                                        @endif

                                    </td>

                                    <td class="p-4 text-center">

                                        @if ($book->stock > 0)
                                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">

                                                Tersedia

                                            </span>
                                        @else
                                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">

                                                Tidak Tersedia

                                            </span>
                                        @endif

                                    </td>

                                    <td class="p-4">

                                        <div class="flex justify-center flex-wrap gap-2">

                                            {{-- Detail --}}
                                            @if (hasPermission('books', 'view'))
                                                <a href="{{ route('books.show', $book->id) }}"
                                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm">
                                                    Detail
                                                </a>
                                            @endif

                                            {{-- Edit --}}
                                            {{-- @if (hasPermission('books', 'edit'))
                                                    <a href="{{ route('books.edit', $book->id) }}"
                                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg text-sm">
                                                        Edit
                                                    </a>
                                                @endif --}}

                                            {{-- Hapus --}}
                                            @if (hasPermission('books', 'delete'))
                                                <form action="{{ route('books.destroy', $book->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Yakin ingin menghapus buku ini?')"
                                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-sm">
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="8" class="p-8 text-center text-slate-500">

                                        Belum ada data buku.

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- Pagination --}}
            <div class="mt-6">

                {{ $books->links() }}

            </div>

        </main>

    </div>

</body>

</html>
