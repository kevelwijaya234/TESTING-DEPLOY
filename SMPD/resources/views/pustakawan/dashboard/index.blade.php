@php$role = session('role');@endphp

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="flex min-h-screen">

    @include('sidebar.pustakawan')

    <main class="flex-1 p-6 md:p-8">

        <!-- Header -->
        <div class="mb-8">

            <h1 class="text-3xl font-bold text-blue-950">
                Dashboard
            </h1>

            <p class="text-slate-500 mt-2">
                Pantau aktivitas peminjaman dan pengembalian buku.
            </p>

        </div>

        <!-- Statistik -->
        <section class="grid md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

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
                    Reservasi Menunggu
                </p>

                <h2 class="text-4xl font-bold text-orange-500 mt-2">
                    {{ $pendingReservations }}
                </h2>

            </div>

            <div class="bg-white rounded-2xl shadow p-6">

                <p class="text-slate-500">
                    Keterlambatan
                </p>

                <h2 class="text-4xl font-bold text-red-600 mt-2">
                    {{ $lateLoans }}
                </h2>

            </div>

        </section>

        <!-- Grafik Peminjaman -->
        <div class="bg-white rounded-2xl shadow p-8 mb-8">

            <div class="flex justify-between items-center mb-5">

                <h2 class="text-xl font-bold text-blue-950">
                    📈 Tren Peminjaman
                </h2>

                <form method="GET">

                    <form method="GET">

                        <input type="month" name="periode" value="{{ request('periode') }}"
                            onchange="this.form.submit()" class="border rounded-lg px-3 py-2">

                    </form>
                </form>

            </div>

            <canvas id="loanChart"></canvas>
        </div>

        <!-- Top Buku + Aktivitas -->
        <section class="grid lg:grid-cols-2 gap-8 mb-8">

            <!-- Buku Populer -->
            <div class="bg-white rounded-2xl shadow p-6">

                <h2 class="text-xl font-bold text-blue-950 mb-5">
                    Buku Terpopuler
                </h2>

                <div class="space-y-4">

                    @forelse($popularBooks ?? [] as $book)
                        <div class="border-b pb-3 flex justify-between">

                            <span>
                                {{ $book['title'] }}
                            </span>

                            <span class="font-semibold">
                                {{ $book['total'] }}
                            </span>

                        </div>

                    @empty

                        <div class="space-y-4">

                            <div class="bg-slate-50 rounded-xl p-4 border">

                                <div class="flex justify-between items-center mb-2">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                            🥇
                                        </div>

                                        <div>
                                            <p class="text-sm text-slate-500">
                                                Buku paling banyak dipinjam
                                            </p>
                                        </div>

                                    </div>

                                    <span class="font-bold text-blue-950">
                                        45%
                                    </span>

                                </div>

                                <div class="w-full bg-slate-200 rounded-full h-2">
                                    <div class="bg-yellow-500 h-2 rounded-full w-[90%]"></div>
                                </div>

                            </div>

                            <div class="bg-slate-50 rounded-xl p-4 border">

                                <div class="flex justify-between items-center mb-2">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center">
                                            🥈
                                        </div>

                                        <div>
                                            <h3 class="font-semibold text-slate-800">
                                                Bumi
                                            </h3>

                                            <p class="text-sm text-slate-500">
                                                Favorit pembaca remaja
                                            </p>
                                        </div>

                                    </div>

                                    <span class="font-bold text-blue-950">
                                        38%
                                    </span>

                                </div>

                                <div class="w-full bg-slate-200 rounded-full h-2">
                                    <div class="bg-slate-500 h-2 rounded-full w-[76%]"></div>
                                </div>

                            </div>

                            <div class="bg-slate-50 rounded-xl p-4 border">

                                <div class="flex justify-between items-center mb-2">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                            🥉
                                        </div>

                                        <div>
                                            <h3 class="font-semibold text-slate-800">
                                                Atomic Habits
                                            </h3>

                                            <p class="text-sm text-slate-500">
                                                Buku pengembangan diri
                                            </p>
                                        </div>

                                    </div>

                                    <span class="font-bold text-blue-950">
                                        32%
                                    </span>

                                </div>

                                <div class="w-full bg-slate-200 rounded-full h-2">
                                    <div class="bg-orange-500 h-2 rounded-full w-[64%]"></div>
                                </div>

                            </div>

                        </div>
                    @endforelse

                </div>

            </div>

            <!-- Aktivitas -->
            <div class="bg-white rounded-2xl shadow p-6">

                <h2 class="text-xl font-bold text-blue-950 mb-5">
                    Aktivitas Terbaru
                </h2>

                <div class="space-y-5">

                    <div class="flex items-start gap-4">

                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-lg">
                            📚
                        </div>

                        <div class="flex-1">

                            <div class="flex justify-between items-center">

                                <h3 class="font-semibold text-slate-800">
                                    Peminjaman Buku
                                </h3>

                                <span class="text-sm text-slate-400">
                                    5 menit lalu
                                </span>

                            </div>

                            <p class="text-slate-500 text-sm">
                                Ahmad meminjam buku
                                <span class="font-medium">Laskar Pelangi</span>.
                            </p>

                        </div>

                    </div>

                    <div class="flex items-start gap-4">

                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-lg">
                            🔄
                        </div>

                        <div class="flex-1">

                            <div class="flex justify-between items-center">

                                <h3 class="font-semibold text-slate-800">
                                    Pengembalian Buku
                                </h3>

                                <span class="text-sm text-slate-400">
                                    12 menit lalu
                                </span>

                            </div>

                            <p class="text-slate-500 text-sm">
                                Sinta mengembalikan buku
                                <span class="font-medium">Bumi</span>.
                            </p>

                        </div>

                    </div>

                    <div class="flex items-start gap-4">

                        <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-lg">
                            📌
                        </div>

                        <div class="flex-1">

                            <div class="flex justify-between items-center">

                                <h3 class="font-semibold text-slate-800">
                                    Reservasi Baru
                                </h3>

                                <span class="text-sm text-slate-400">
                                    20 menit lalu
                                </span>

                            </div>

                            <p class="text-slate-500 text-sm">
                                Reservasi buku
                                <span class="font-medium">Atomic Habits</span>
                                menunggu persetujuan.
                            </p>

                        </div>

                    </div>

                    <div class="flex items-start gap-4">

                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-lg">
                            👤
                        </div>

                        <div class="flex-1">

                            <div class="flex justify-between items-center">

                                <h3 class="font-semibold text-slate-800">
                                    Anggota Baru
                                </h3>

                                <span class="text-sm text-slate-400">
                                    35 menit lalu
                                </span>

                            </div>

                            <p class="text-slate-500 text-sm">
                                Diana Putri berhasil terdaftar sebagai anggota perpustakaan.
                            </p>

                        </div>

                    </div>

                </div>

        </section>

        <!-- Reservasi -->
        <section class="bg-white rounded-2xl shadow p-6">

            <div class="flex justify-between items-center mb-5">

                <h2 class="text-xl font-bold text-blue-950">
                    Reservasi Menunggu Persetujuan
                </h2>

                <a href="{{ route('reservations.pustakawan') }}" class="text-blue-950 font-semibold hover:underline">
                    Lihat Semua
                </a>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead>

                        <tr class="border-b">

                            <th class="text-left py-3">
                                Nama
                            </th>

                            <th class="text-left py-3">
                                Buku
                            </th>

                            <th class="text-left py-3">
                                Tanggal
                            </th>

                            <th class="text-left py-3">
                                Status
                            </th>
                            <th class="text-left py-3">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($reservations ?? [] as $reservation)
                            <tr class="border-b hover:bg-slate-50">

                                <td class="py-3">
                                    {{ $reservation->member->name }}
                                </td>

                                <td>
                                    @if ($reservation->book_type == 'digital')
                                        {{ $reservation->digitalBook?->title ?? 'E-Book Tidak Ditemukan' }}
                                    @else
                                        {{ $reservation->book?->title ?? 'Buku Tidak Ditemukan' }}
                                    @endif
                                </td>

                                <td>
                                    {{ date('d M Y', strtotime($reservation->reservation_date)) }}
                                </td>

                                <td>

                                    @if ($reservation->status == 'Menunggu')
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                                            Menunggu
                                        </span>
                                    @elseif($reservation->status == 'Disetujui')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                            Disetujui
                                        </span>
                                    @elseif($reservation->status == 'Dibatalkan')
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                                            Dibatalkan
                                        </span>
                                    @else
                                        <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-sm">
                                            {{ $reservation->status }}
                                        </span>
                                    @endif

                                </td>

                                <td class="py-3">
                                    <div class="flex space-x-2">

                                        @if ($reservation->status == 'Menunggu')
                                            <div class="flex justify-center gap-2">

                                                <form action="{{ route('reservations.approve', $reservation->id) }}"
                                                    method="POST">

                                                    @csrf
                                                    @method('PUT')

                                                    <button
                                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">

                                                        Setujui

                                                    </button>

                                                </form>

                                                <form action="{{ route('reservations.cancel', $reservation->id) }}"
                                                    method="POST">

                                                    @csrf
                                                    @method('PUT')

                                                    <button
                                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm">

                                                        Tolak

                                                    </button>

                                                </form>

                                            </div>
                                        @else
                                            <span class="text-slate-400 text-sm">
                                                Tidak ada aksi
                                            </span>
                                        @endif

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="text-center py-6 text-slate-500">
                                    Belum ada data reservasi.
                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>

    </main>

</div>

<!-- Chart -->
<script>
    const ctx = document.getElementById('loanChart');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: @json($data),
                borderWidth: 3,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    min: 0,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>
