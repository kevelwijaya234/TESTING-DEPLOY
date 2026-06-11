{{-- HAPUS JIKA CUMA AKSES PUSTAKAWAN --}}
@php
    $role = session('role');
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Peminjaman Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

    <div class="flex min-h-screen">

        {{-- @include('sidebar.admin') --}}
        {{-- HAPUS JIKA CUMA AKSES PUSTAKAWAN --}}
        @if ($role == 'admin')
            @include('sidebar.admin')
        @else
            @include('sidebar.pustakawan')
        @endif

        <main class="flex-1 p-6 md:p-10">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-blue-950">Peminjaman Buku</h1>
                    <p class="text-slate-500">Kelola transaksi peminjaman dengan kode anggota dan kode_buku buku.</p>
                </div>

                <a href="{{ route('loans.create') }}"
                    class="bg-blue-950 text-white px-5 py-3 rounded-lg hover:bg-blue-900">
                    + Transaksi Pinjam
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow p-6">
                    <p class="text-slate-500">Peminjaman Aktif</p>
                    <h2 class="text-3xl font-bold text-blue-950">{{ $loans->where('status', 'Dipinjam')->count() }}
                    </h2>
                </div>

                <div class="bg-white rounded-2xl shadow p-6">
                    <p class="text-slate-500">Terlambat</p>
                    <h2 class="text-3xl font-bold text-red-600">{{ $loans->where('status', 'Terlambat')->count() }}
                    </h2>
                </div>

                <div class="bg-white rounded-2xl shadow p-6">
                    <p class="text-slate-500">Total Data Halaman Ini</p>
                    <h2 class="text-3xl font-bold text-blue-950">{{ $loans->count() }}</h2>
                </div>

                <div class="bg-white rounded-2xl shadow p-6">
                    <p class="text-slate-500">Total Semua Data</p>
                    <h2 class="text-3xl font-bold text-blue-950">{{ $loans->total() }}</h2>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-blue-950 text-white">
                        <tr>
                            <th class="p-4">Kode Pinjam</th>
                            <th class="p-4">Anggota</th>
                            <th class="p-4">Buku</th>
                            <th class="p-4">Tanggal Pinjam</th>
                            <th class="p-4">Jatuh Tempo</th>
                            <th class="p-4">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($loans as $loan)
                            <tr class="border-b">
                                <td class="p-4 font-semibold">{{ $loan->loan_code }}</td>
                                <td class="p-4">
                                    <p class="font-semibold">{{ $loan->member->name ?? '-' }}</p>
                                    <p class="text-sm text-slate-500">{{ $loan->member->member_code ?? '-' }}</p>
                                </td>
                                <td class="p-4">
                                    <p class="font-semibold">{{ $loan->book->title ?? '-' }}</p>
                                    <p class="text-sm text-slate-500">{{ $loan->book->kode_buku ?? '-' }}</p>
                                </td>
                                <td class="p-4">{{ $loan->loan_date }}</td>
                                <td class="p-4">{{ $loan->due_date }}</td>
                                <td class="p-4">
                                    @if ($loan->status == 'Dipinjam')
                                        <span
                                            class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">Dipinjam</span>
                                    @elseif($loan->status == 'Dikembalikan')
                                        <span
                                            class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">Dikembalikan</span>
                                    @else
                                        <span
                                            class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">Terlambat</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-6 text-center text-slate-500">
                                    Belum ada data peminjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $loans->links() }}
            </div>
        </main>
    </div>

</body>

</html>
