<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-slate-100">

    <div class="flex min-h-screen">

        @include('sidebar.admin')

        <main class="flex-1 p-6 md:p-10">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-blue-950">
                    Dashboard Admin
                </h1>

                <p class="text-slate-500">
                    Kelola sistem perpustakaan secara keseluruhan.
                </p>
            </div>

            <section class="grid md:grid-cols-4 gap-6 mb-8">

                <div class="bg-white p-6 rounded-2xl shadow">
                    <p class="text-slate-500">Total Buku</p>
                    <h2 class="text-3xl font-bold text-blue-950">{{ $totalBooks }}</h2>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow">
                    <p class="text-slate-500">Total Anggota</p>
                    <h2 class="text-3xl font-bold text-blue-950">{{ $totalMembers }}</h2>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow">
                    <p class="text-slate-500">Total Pustakawan</p>
                    <h2 class="text-3xl font-bold text-orange-500">{{ $totalLibrarians }}</h2>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow">
                    <p class="text-slate-500">Peminjaman Hari Ini</p>
                    <div class="bg-white p-6 rounded-2xl shadow">
                        <h2 class="text-3xl font-bold text-green-600">{{ $todayLoans }}</h2>
                    </div>
                </div>



            </section>

            <section class="grid lg:grid-cols-3 gap-8 mb-8">

                {{-- Statistik Sistem --}}
                <div class="bg-white p-6 rounded-3xl shadow">

                    <h2 class="text-xl font-bold text-blue-950 mb-6">
                        Statistik Sistem
                    </h2>

                    <div class="space-y-6">

                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="font-medium">Buku Dipinjam</span>
                                <span class="font-bold text-blue-900">
                                    {{ $borrowPercent }}%
                                </span>
                            </div>

                            <div class="w-full bg-slate-200 h-3 rounded-full">
                                <div class="bg-blue-900 h-3 rounded-full transition-all duration-500"
                                    style="width: {{ $borrowPercent }}%">
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between mb-2">
                                <span class="font-medium">Reservasi</span>
                                <span class="font-bold text-orange-500">
                                    {{ $reservationPercent }}%
                                </span>
                            </div>

                            <div class="w-full bg-slate-200 h-3 rounded-full">
                                <div class="bg-orange-500 h-3 rounded-full transition-all duration-500"
                                    style="width: {{ $reservationPercent }}%">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 pt-2">

                            <div class="bg-slate-50 rounded-xl p-4 text-center">
                                <p class="text-sm text-slate-500">
                                    User Aktif
                                </p>

                                <h3 class="text-2xl font-bold text-green-600">
                                    {{ $activeUsers }}
                                </h3>
                            </div>

                            <div class="bg-slate-50 rounded-xl p-4 text-center">
                                <p class="text-sm text-slate-500">
                                    Hari Ini
                                </p>

                                <h3 class="text-2xl font-bold text-blue-900">
                                    {{ $todayLoans }}
                                </h3>
                            </div>

                        </div>

                    </div>

                </div>

                <div class="lg:col-span-2">

                    {{-- Grafik Aktivitas Sistem --}}

                    <div class="bg-white p-6 rounded-3xl shadow">

                        <div class="flex justify-between items-center mb-6">

                            <h2 class="text-xl font-bold text-blue-950">
                                Grafik Aktivitas Sistem
                            </h2>

                            <span class="bg-blue-100 text-blue-700 text-xs px-3 py-1 rounded-full">

                                7 Hari Terakhir

                            </span>

                        </div>

                        <div class="relative h-[380px]">

                            <canvas id="activityChart"></canvas>

                        </div>

                    </div>
                </div>

            </section>

            {{-- Aktivitas Sistem --}}
            <section class="mt-8">
                <div class="bg-white p-6 rounded-3xl shadow">

                    <div class="flex justify-between items-center mb-6">

                        <h2 class="text-xl font-bold text-blue-950">
                            Aktivitas Sistem
                        </h2>

                        <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs">

                            {{ count($activities) }} Aktivitas

                        </span>

                    </div>

                    <div class="space-y-4">

                        @forelse($activities as $activity)
                            <div class="flex items-start gap-4 border-b border-slate-100 pb-4">

                                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">

                                    📚

                                </div>

                                <div class="flex-1">

                                    <p class="font-semibold text-slate-700">

                                        {{ $activity->member->name ?? 'Anggota' }}

                                        meminjam buku

                                        <span class="text-blue-900">

                                            "{{ $activity->book->title ?? '-' }}"

                                        </span>

                                    </p>

                                    <p class="text-sm text-slate-500 mt-1">

                                        {{ $activity->created_at->format('d M Y H:i') }}

                                    </p>

                                </div>

                            </div>

                        @empty

                            <div class="text-center py-10 text-slate-500">

                                Belum ada aktivitas sistem.

                            </div>
                        @endforelse

                    </div>

                </div>
            </section>

    </div>

    </section>

    </main>

    </div>

    <script>
        const ctx =
            document.getElementById('activityChart');

        new Chart(ctx, {

            type: 'line',

            data: {

                labels: @json($chartLabels),

                datasets: [{

                    label: 'Jumlah Peminjaman',

                    data: @json($chartData),

                    borderColor: '#172554',

                    backgroundColor: 'rgba(23,37,84,0.15)',

                    fill: true,

                    tension: 0.4

                }]
            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                scales: {

                    y: {

                        beginAtZero: true,

                        min: 0,

                        ticks: {

                            precision: 0,

                            stepSize: 1

                        }

                    }

                }

            }

        });
    </script>

</body>

</html>
