<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Bulanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

    <div class="flex min-h-screen">

        @include('sidebar.pustakawan')

        <main class="flex-1 p-6 md:p-10">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-blue-950">Laporan Bulanan</h1>
                    <p class="text-slate-500">Rekap peminjaman, pengembalian, keterlambatan, dan denda.</p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('reports.export.pdf') }}"
                        class="bg-red-600 text-white px-5 py-3 rounded-lg hover:bg-red-700">
                        Export PDF
                    </a>

                    <a href="{{ route('reports.export.excel') }}"
                        class="bg-green-600 text-white px-5 py-3 rounded-lg hover:bg-green-700">
                        Export Excel
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                <div class="bg-white rounded-2xl shadow p-6">
                    <p class="text-slate-500">
                        Total Peminjaman
                    </p>

                    <h2 class="text-4xl font-bold text-blue-950 mt-2">
                        {{ $totalLoans }}
                    </h2>
                </div>

                <div class="bg-white rounded-2xl shadow p-6">
                    <p class="text-slate-500">
                        Total Pengembalian
                    </p>

                    <h2 class="text-4xl font-bold text-green-600 mt-2">
                        {{ $totalReturns }}
                    </h2>
                </div>

                <div class="bg-white rounded-2xl shadow p-6">
                    <p class="text-slate-500">
                        Total Terlambat
                    </p>

                    <h2 class="text-4xl font-bold text-red-600 mt-2">
                        {{ $lateReturns }}
                    </h2>
                </div>

                <div class="bg-white rounded-2xl shadow p-6">
                    <p class="text-slate-500">
                        Total Denda
                    </p>

                    <h2 class="text-3xl font-bold text-amber-600 mt-2">
                        Rp{{ number_format($totalFines, 0, ',', '.') }}
                    </h2>
                </div>

            </div>
            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-blue-950 text-white">
                        <tr>
                            <th class="p-4">Bulan</th>
                            <th class="p-4">Total Peminjaman</th>
                            <th class="p-4">Total Pengembalian</th>
                            <th class="p-4">Terlambat</th>
                            <th class="p-4">Total Denda</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($reports as $report)
                            <tr class="border-b">
                                <td class="p-4 font-semibold">{{ $report['month'] }}</td>
                                <td class="p-4">{{ $report['total_loans'] }}</td>
                                <td class="p-4">{{ $report['total_returns'] }}</td>
                                <td class="p-4">{{ $report['late_returns'] }}</td>
                                <td class="p-4">Rp{{ number_format($report['total_fines'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white rounded-2xl shadow p-6 mt-8">
                <h2 class="text-xl font-bold text-blue-950 mb-3">Catatan Laporan</h2>
                <p class="text-slate-600">
                    Pada implementasi database asli, laporan ini akan mengambil data transaksi dari tabel loans,
                    returns, fines, members, dan books. Tombol export akan menghasilkan file PDF dan Excel.
                </p>
            </div>
        </main>
    </div>

</body>

</html>
