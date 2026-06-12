@php
    $role = session('role');
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Anggota - SMPD</title>

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
                        Manajemen Anggota
                    </h1>

                    <p class="text-slate-500 mt-1">
                        Kelola data anggota dan QR Member Card.
                    </p>
                </div>

                <div class="flex flex-col md:flex-row gap-3">

                    {{-- Search --}}
                    <form action="{{ route('members.index') }}" method="GET" class="flex gap-2">

                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari kode, nama, email, ..."
                            class="border border-slate-300 rounded-xl px-4 py-2 w-72 focus:outline-none focus:ring-2 focus:ring-blue-300">

                        <button type="submit" class="bg-slate-700 hover:bg-slate-800 text-white px-4 py-2 rounded-xl">
                            Cari
                        </button>
                    </form>

                    {{-- Tambah --}}
                    @if (hasPermission('users', 'create'))
                        <a href="{{ route('members.create') }}"
                            class="bg-blue-950 hover:bg-blue-900 text-white px-5 py-3 rounded-xl">
                            + Tambah Anggota
                        </a>
                    @endif
                </div>

            </div>

            {{-- Success Alert --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl mb-6">

                    {{ session('success') }}

                </div>
            @endif

            {{-- Card --}}
            <div class="bg-white rounded-2xl shadow overflow-hidden">

                <div class="px-6 py-4 border-b">

                    <h2 class="text-xl font-bold text-blue-950">

                        Daftar Anggota

                    </h2>

                </div>

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-blue-950 text-white">

                            <tr>

                                <th class="p-4 text-center">
                                    No
                                </th>

                                <th class="p-4">
                                    Kode Anggota
                                </th>

                                <th class="p-4">
                                    Nama
                                </th>

                                <th class="p-4">
                                    Email
                                </th>

                                <th class="p-4">
                                    No HP
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

                            @forelse($members as $member)
                                <tr class="border-b hover:bg-slate-50">

                                    <td class="p-4 text-center">

                                        {{ $loop->iteration + ($members->currentPage() - 1) * $members->perPage() }}

                                    </td>

                                    <td class="p-4 font-semibold">

                                        {{ $member->member_code }}

                                    </td>

                                    <td class="p-4">

                                        {{ $member->name }}

                                    </td>

                                    <td class="p-4">

                                        {{ $member->email }}

                                    </td>

                                    <td class="p-4">

                                        {{ $member->phone ?? '-' }}

                                    </td>

                                    <td class="p-4 text-center">

                                        @if ($member->status == 'Aktif')
                                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">

                                                Aktif

                                            </span>
                                        @else
                                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="p-4">
                                        <div class="flex justify-center flex-wrap gap-2">
                                            {{-- Kartu --}}
                                            <a href="{{ route('members.card', $member->id) }}"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm">
                                                Lihat Kartu
                                            </a>

                                            {{-- Hapus --}}
                                            <form action="{{ route('members.destroy', $member->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin hapus anggota ini?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-sm">

                                                    Hapus

                                                </button>

                                            </form>
                                        </div>
                                    </td>
                                </tr>

                            @empty

                                <tr>

                                    <td colspan="7" class="p-8 text-center text-slate-500">

                                        Data anggota belum tersedia.

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            {{-- Pagination --}}
            <div class="mt-6">

                {{ $members->links() }}

            </div>

        </main>

    </div>

</body>

</html>
