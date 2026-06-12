@php
    $role = session('role');
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengembalian Buku - SMPD</title>

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

        <main class="flex-1 p-6 md:p-8">

            {{-- Header --}}
            <div class="mb-8">

                <h1 class="text-3xl font-bold text-blue-950">
                    Pengembalian Buku
                </h1>

                <p class="text-slate-500 mt-2">
                    Kelola pengembalian buku dan perhitungan denda secara otomatis.
                </p>

            </div>

            {{-- Alert --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl mb-6">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Statistik --}}
            <section class="grid md:grid-cols-3 gap-6 mb-8">

                <div class="bg-white rounded-2xl shadow p-6">

                    <p class="text-slate-500">
                        Total Pengembalian
                    </p>

                    <h2 class="text-4xl font-bold text-blue-950 mt-2">
                        {{ $todayReturns ?? 0 }}
                    </h2>

                </div>

                <div class="bg-white rounded-2xl shadow p-6">

                    <p class="text-slate-500">
                        Total Terlambat
                    </p>

                    <h2 class="text-4xl font-bold text-red-600 mt-2">
                        {{ $lateReturns ?? 0 }}
                    </h2>

                </div>

                <div class="bg-white rounded-2xl shadow p-6">

                    <p class="text-slate-500">
                        Denda Terkumpul
                    </p>

                    <h2 class="text-3xl font-bold text-green-600 mt-2">
                        Rp{{ number_format($totalFine ?? 0, 0, ',', '.') }}
                    </h2>

                </div>

            </section>

            {{-- Form + Info --}}
            <section class="grid lg:grid-cols-3 gap-8 mb-8">

                {{-- Form --}}
                <div class="bg-white rounded-2xl shadow p-6">

                    <h2 class="text-xl font-bold text-blue-950 mb-5">
                        Form Pengembalian
                    </h2>

                    <form action="{{ route('returns.process') }}" method="POST">

                        @csrf

                        <div class="space-y-5">

                            <div>
                                <label class="block mb-2 font-medium">
                                    Kode Peminjaman
                                </label>

                                <input type="text" name="loan_code" placeholder="LN001"
                                    class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-900">
                            </div>

                            <div>
                                <label class="block mb-2 font-medium">
                                    Kode Buku
                                </label>

                                <input type="text" name="kode_buku" placeholder="BK001"
                                    class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-900">
                            </div>

                            <div>
                                <label class="block mb-2 font-medium">
                                    Tanggal Pengembalian
                                </label>

                                <input type="date" name="return_date" value="{{ date('Y-m-d') }}"
                                    class="w-full border rounded-xl px-4 py-3">
                            </div>

                            <div class="bg-orange-50 border border-orange-100 rounded-xl p-4">

                                <p class="text-orange-700 text-sm">
                                    Denda otomatis:
                                </p>

                                <p class="text-xl font-bold text-red-600">
                                    Rp 5.000 / Hari
                                </p>

                            </div>

                            <button type="submit"
                                class="w-full bg-blue-950 hover:bg-blue-900 text-white py-3 rounded-xl font-semibold">

                                Konfirmasi Pengembalian

                            </button>

                        </div>

                    </form>

                </div>

                {{-- Informasi --}}
                <div class="lg:col-span-2 bg-white rounded-2xl shadow p-6">

                    <h2 class="text-xl font-bold text-blue-950 mb-4">
                        Cara Kerja Pengembalian
                    </h2>

                    <div class="space-y-4">

                        <div class="border rounded-xl p-4">
                            <h3 class="font-semibold text-blue-950">
                                1. Masukkan Kode Peminjaman
                            </h3>
                            <p class="text-slate-500 text-sm">
                                Sistem akan mencari data peminjaman yang aktif.
                            </p>
                        </div>

                        <div class="border rounded-xl p-4">
                            <h3 class="font-semibold text-blue-950">
                                2. Verifikasi Barcode Buku
                            </h3>
                            <p class="text-slate-500 text-sm">
                                Pastikan buku yang dikembalikan sesuai data peminjaman.
                            </p>
                        </div>

                        <div class="border rounded-xl p-4">
                            <h3 class="font-semibold text-blue-950">
                                3. Denda Otomatis
                            </h3>
                            <p class="text-slate-500 text-sm">
                                Sistem menghitung keterlambatan dan denda secara otomatis.
                            </p>
                        </div>

                    </div>

                </div>

            </section>

            {{-- Tabel Riwayat --}}
            <section class="bg-white rounded-2xl shadow overflow-hidden">

                <div class="p-6 border-b">

                    <h2 class="text-xl font-bold text-blue-950">
                        Riwayat Pengembalian Buku
                    </h2>

                </div>

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-blue-950 text-white">

                            <tr>

                                <th class="p-4 text-left">Kode Return</th>
                                <th class="p-4 text-left">Kode Pinjam</th>
                                <th class="p-4 text-left">Anggota</th>
                                <th class="p-4 text-left">Buku</th>
                                <th class="p-4 text-left">Jatuh Tempo</th>
                                <th class="p-4 text-left">Tanggal Kembali</th>
                                <th class="p-4 text-left">Telat</th>
                                <th class="p-4 text-left">Denda</th>
                                <th class="p-4 text-left">Status</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($returns as $return)
                                <tr class="border-b hover:bg-slate-50">

                                    <td class="p-4 font-semibold">
                                        {{ $return->return_code }}
                                    </td>

                                    <td class="p-4">
                                        {{ $return->loan->loan_code ?? '-' }}
                                    </td>

                                    <td class="p-4">
                                        {{ $return->loan->member->name ?? '-' }}
                                    </td>

                                    <td class="p-4">
                                        {{ $return->loan->book->title ?? '-' }}
                                    </td>

                                    <td class="p-4">
                                        {{ $return->loan->due_date ?? '-' }}
                                    </td>

                                    <td class="p-4">
                                        {{ $return->return_date }}
                                    </td>

                                    <td class="p-4">
                                        {{ $return->late_days }} Hari
                                    </td>

                                    <td class="p-4">
                                        Rp{{ number_format($return->fine_amount, 0, ',', '.') }}
                                    </td>

                                    <td class="p-4">

                                        @if ($return->late_days > 0)
                                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                                                Terlambat
                                            </span>
                                        @else
                                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                                Tepat Waktu
                                            </span>
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="9" class="text-center py-10 text-slate-500">
                                        Belum ada data pengembalian.
                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="p-6">
                    {{ $returns->links() }}
                </div>

            </section>

        </main>

    </div>

</body>

</html>
