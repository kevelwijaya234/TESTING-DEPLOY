{{-- HAPUS JIKA CUMA AKSES PUSTAKAWAN --}}
@php
    $role = session('role');
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Reservasi Buku</title>
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
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-blue-950">Reservasi Buku</h1>
                <p class="text-slate-500">Kelola reservasi buku yang sedang dipinjam anggota lain.</p>
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

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid lg:grid-cols-3 gap-8 mb-8">
                <div class="bg-white rounded-2xl shadow p-6">

                    <h2 class="text-xl font-bold text-blue-950 mb-4">
                        Tambah Reservasi
                    </h2>

                    @if (hasPermission('reservations', 'create'))
                        <form action="{{ route('reservations.store') }}" method="POST" class="space-y-5">

                            @csrf

                            <div>
                                <label class="block mb-2 font-medium">
                                    Kode Anggota
                                </label>

                                <input type="text" name="member_code" placeholder="MBR001"
                                    class="w-full border rounded-lg px-4 py-3">
                            </div>

                            <div>
                                <label class="block mb-2 font-medium">
                                    Barcode Buku
                                </label>

                                <input type="text" name="kode_buku" placeholder="BK002"
                                    class="w-full border rounded-lg px-4 py-3">
                            </div>

                            <div>
                                <label class="block mb-2 font-medium">
                                    Tanggal Reservasi
                                </label>

                                <input type="date" name="reservation_date" value="{{ date('Y-m-d') }}"
                                    class="w-full border rounded-lg px-4 py-3">
                            </div>

                            <button type="submit"
                                class="w-full bg-blue-950 text-white py-3 rounded-lg hover:bg-blue-900">

                                Simpan Reservasi

                            </button>

                        </form>
                    @else
                        <div class="bg-yellow-100 text-yellow-700 p-4 rounded-lg">

                            Anda tidak memiliki hak membuat reservasi.

                        </div>
                    @endif

                </div>
                <div class="lg:col-span-2 grid md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-2xl shadow p-6">
                        <p class="text-slate-500">Total Reservasi</p>
                        <h2 class="text-3xl font-bold text-blue-950">{{ $totalReservations }}</h2>
                    </div>

                    <div class="bg-white rounded-2xl shadow p-6">
                        <p class="text-slate-500">Menunggu</p>
                        <h2 class="text-3xl font-bold text-orange-500">{{ $waitingReservations }}</h2>
                    </div>
                    <div class="md:col-span-3 bg-white rounded-2xl shadow p-6">
                        <h2 class="text-xl font-bold text-blue-950 mb-3">Alur Reservasi</h2>
                        <p class="text-slate-600">
                            Jika stok buku habis atau sedang dipinjam, anggota dapat melakukan reservasi.
                            Setelah buku dikembalikan, pustakawan dapat menghubungi anggota sesuai antrean
                            reservasi.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow overflow-hidden">

                <div class="px-6 py-4 border-b">
                    <h2 class="text-xl font-bold text-blue-950">
                        Daftar Reservasi
                    </h2>
                </div>

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-blue-950 text-white">

                            <tr>

                                <th class="px-6 py-4 text-left">
                                    Kode Reservasi
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Anggota
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Buku
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Tanggal
                                </th>

                                <th class="px-6 py-4 text-center">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-center">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($reservations as $reservation)
                                <tr class="border-b hover:bg-slate-50">

                                    <td class="px-6 py-4 font-medium">
                                        {{ $reservation->reservation_code }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $reservation->member?->name ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $reservation->book?->title ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d M Y') }}
                                    </td>

                                    <td class="px-6 py-4 text-center">

                                        @if ($reservation->status == 'Menunggu')
                                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                                                Menunggu
                                            </span>
                                        @elseif($reservation->status == 'Disetujui')
                                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                                Disetujui
                                            </span>
                                        @elseif($reservation->status == 'Dipinjam')
                                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
                                                Dipinjam
                                            </span>
                                        @else
                                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                                                Dibatalkan
                                            </span>
                                        @endif

                                    </td>

                                    <td class="px-6 py-4">

                                        @if ($reservation->status == 'Menunggu')
                                            <div class="flex justify-center gap-2">

                                                @if (hasPermission('reservations', 'edit'))
                                                    <form
                                                        action="{{ route('reservations.approve', $reservation->id) }}"
                                                        method="POST">

                                                        @csrf
                                                        @method('PUT')

                                                        <button
                                                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">

                                                            Setujui

                                                        </button>

                                                    </form>
                                                @endif

                                                @if (hasPermission('reservations', 'edit'))
                                                    <form action="{{ route('reservations.cancel', $reservation->id) }}"
                                                        method="POST">

                                                        @csrf
                                                        @method('PUT')

                                                        <button
                                                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm">

                                                            Tolak

                                                        </button>

                                                    </form>
                                                @endif

                                            </div>
                                        @else
                                            <span class="text-slate-400 text-sm">

                                                Tidak ada aksi

                                            </span>
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6" class="text-center py-10 text-slate-500">

                                        Belum ada data reservasi.

                                    </td>

                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>

            </div>
            <div class="mt-6">
                {{ $reservations->links() }}
            </div>
    </div>

    </main>
    </div>

</body>

</html>
