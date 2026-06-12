<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Sistem Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

    <div class="flex min-h-screen">

        @include('sidebar.admin')

        <main class="flex-1 p-6 md:p-10">

            <div class="flex justify-between items-center mb-8">

                <div>
                    <h1 class="text-3xl font-bold text-blue-950">
                        Monitoring Sistem
                    </h1>

                    <p class="text-slate-500">
                        Monitoring aktivitas sistem, server, dan anggota.
                    </p>
                </div>

                <div class="flex gap-3">

                    @if (hasPermission('reports', 'print'))
                        <a href="{{ route('reports.export.pdf') }}"
                            class="bg-red-600 text-white px-5 py-3 rounded-lg hover:bg-red-700">
                            Export PDF
                        </a>
                    @endif

                    @if (hasPermission('reports', 'export'))
                        <a href="{{ route('reports.export.excel') }}"
                            class="bg-green-600 text-white px-5 py-3 rounded-lg hover:bg-green-700">

                            Export Excel

                        </a>
                    @endif

                </div>

            </div>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif


            {{-- CARD MONITORING --}}

            <div class="grid md:grid-cols-4 gap-6 mb-8">

                @foreach ($systemReports as $report)
                    <div class="bg-white rounded-2xl shadow p-6">

                        <p class="text-slate-500">
                            {{ $report['title'] }}
                        </p>

                        <h2 class="text-3xl font-bold text-blue-950 mt-2">
                            {{ $report['value'] }}
                        </h2>

                    </div>
                @endforeach

            </div>


            {{-- TABEL MONITORING --}}

            <div class="bg-white rounded-2xl shadow overflow-hidden">

                <table class="w-full text-left">

                    <thead class="bg-blue-950 text-white">

                        <tr>
                            <th class="p-4">Monitoring Sistem</th>
                            <th class="p-4">Nilai</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($systemReports as $report)
                            <tr class="border-b">

                                <td class="p-4 font-semibold">
                                    {{ $report['title'] }}
                                </td>

                                <td class="p-4">
                                    {{ $report['value'] }}
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- CATATAN --}}

            <div class="bg-white rounded-2xl shadow p-6 mt-8">

                <h2 class="text-xl font-bold text-blue-950 mb-3">
                    Catatan Monitoring
                </h2>

                <p class="text-slate-600">
                    Monitoring sistem digunakan untuk memantau performa aplikasi,
                    aktivitas login, anggotaan server, dan kestabilan sistem
                    perpustakaan digital.
                </p>

            </div>

        </main>

    </div>

</body>

</html>
