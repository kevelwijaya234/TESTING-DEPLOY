<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Reservasi Buku</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

    <div class="flex min-h-screen">

        @include('sidebar.anggota')

        <div class="flex-1">

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
                        <div class="hidden lg:flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 text-slate-700">

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

                                <a href="{{ route('logout') }}" class="block px-5 py-3 text-red-600 hover:bg-red-50">

                                    🚪 Logout

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </nav>

            <main class="flex-1 p-6 md:p-10">

                {{-- HEADER --}}
                <div class="mb-8">

                    <h1 class="text-3xl font-bold text-blue-950">
                        Reservasi Buku
                    </h1>

                    <p class="text-slate-500 mt-2">
                        Lakukan reservasi buku yang sedang dipinjam anggota lain.
                    </p>

                </div>

                {{-- ALERT SUCCESS --}}
                @if (session('success'))
                    <div id="successAlert"
                        class="mb-6 bg-green-100 border border-green-300 text-green-800 px-5 py-4 rounded-xl shadow-sm">

                        <div class="flex items-center gap-3">

                            <span class="text-xl">
                                ✅
                            </span>

                            <span class="font-medium">
                                {{ session('success') }}
                            </span>

                        </div>

                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', () => {

                            const alert = document.getElementById('successAlert');

                            if (alert) {

                                alert.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });

                                setTimeout(() => {

                                    alert.style.transition = "0.5s";
                                    alert.style.opacity = "0";

                                    setTimeout(() => {
                                        alert.remove();
                                    }, 500);

                                }, 3000);
                            }

                        });
                    </script>
                @endif

                {{-- ALERT ERROR --}}
                @if ($errors->any())

                    <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-xl">

                        <div class="font-semibold mb-2">
                            Terjadi Kesalahan:
                        </div>

                        <ul class="list-disc ml-5">

                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>

                @endif


                {{-- STATISTIK --}}
                <section class="grid md:grid-cols-3 gap-6 mb-8">

                    <div class="bg-white rounded-2xl shadow p-6">

                        <p class="text-slate-500">
                            Total Reservasi Saya
                        </p>

                        <h2 class="text-3xl font-bold text-blue-950">
                            {{ $totalReservations }}
                        </h2>

                    </div>

                    <div class="bg-white rounded-2xl shadow p-6">

                        <p class="text-slate-500">
                            Menunggu
                        </p>

                        <h2 class="text-3xl font-bold text-orange-500">
                            {{ $waitingReservations }}
                        </h2>

                    </div>

                    <div class="bg-white rounded-2xl shadow p-6">

                        <p class="text-slate-500">
                            Disetujui
                        </p>

                        <h2 class="text-3xl font-bold text-green-600">
                            {{ $approvedReservations }}
                        </h2>

                    </div>

                </section>


                {{-- FORM RESERVASI --}}
                <div class="bg-white rounded-2xl shadow p-6 mb-8">

                    <h2 class="text-xl font-bold text-blue-950 mb-5">
                        Form Reservasi
                    </h2>

                    <form action="{{ route('reservations.store') }}" method="POST" class="grid md:grid-cols-3 gap-5">

                        @csrf

                        <input type="hidden" name="from" value="anggota">

                        <div>
                            <label class="block mb-2 font-medium">
                                Kode Anggota
                            </label>

                            <input type="text" value="{{ $member->member_code }}" readonly
                                class="w-full border rounded-lg px-4 py-3 bg-slate-100 cursor-not-allowed">

                            <input type="hidden" name="member_code" value="{{ $member->member_code }}">
                        </div>

                        <div>

                            <label class="block mb-2 font-medium">
                                Kode Buku
                            </label>

                            <input type="text" name="kode_buku" value="{{ old('kode_buku') }}" placeholder="BK001"
                                class="w-full border rounded-lg px-4 py-3">

                        </div>

                        <div>

                            <label class="block mb-2 font-medium">
                                Tanggal Reservasi
                            </label>

                            <input type="date" name="reservation_date"
                                value="{{ old('reservation_date', date('Y-m-d')) }}"
                                class="w-full border rounded-lg px-4 py-3">

                        </div>

                        <input type="hidden" name="book_type" value="fisik">

                        <div class="md:col-span-3">

                            <button type="submit"
                                class="bg-blue-950 text-white px-5 py-3 rounded-lg hover:bg-blue-900">

                                Ajukan Reservasi

                            </button>

                        </div>

                    </form>

                </div>


                {{-- TABEL RESERVASI --}}
                <div class="bg-white rounded-2xl shadow overflow-hidden">

                    <div class="p-6 border-b">

                        <h2 class="text-xl font-bold text-blue-950">
                            Riwayat Reservasi
                        </h2>

                    </div>

                    <table class="w-full text-left">

                        <thead class="bg-blue-950 text-white">

                            <tr>
                                <th class="p-4">Kode</th>
                                <th class="p-4">Buku</th>
                                <th class="p-4">Tanggal</th>
                                <th class="p-4">Status</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($reservations as $reservation)
                                <tr class="border-b">

                                    <td class="p-4 font-semibold">
                                        {{ $reservation->reservation_code }}
                                    </td>

                                    <td class="p-4">
                                        @if ($reservation->book_type == 'digital')
                                            {{ $reservation->digitalBook->title ?? '-' }}
                                            <span class="text-xs text-blue-600">
                                                (E-Book)
                                            </span>
                                        @else
                                            {{ $reservation->book->title ?? '-' }}
                                        @endif
                                    </td>

                                    <td class="p-4">
                                        {{ $reservation->reservation_date }}
                                    </td>

                                    <td class="p-4">

                                        @if ($reservation->status == 'Menunggu')
                                            <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs">
                                                Menunggu
                                            </span>
                                        @elseif($reservation->status == 'Disetujui')
                                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                                Disetujui
                                            </span>
                                        @elseif($reservation->status == 'Dipinjam')
                                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">
                                                Dipinjam
                                            </span>
                                        @else
                                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                                                Dibatalkan
                                            </span>
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="4" class="p-6 text-center text-slate-500">

                                        Belum ada reservasi buku.

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- PAGINATION --}}
                <div class="mt-6">

                    {{ $reservations->links() }}

                </div>

            </main>

        </div>

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

            document.addEventListener('click', function(event) {
                const menu =
                    document.getElementById('profileMenu');

                const button =
                    document.getElementById('profileButton');

                if (
                    !menu.contains(event.target) &&
                    !button.contains(event.target)
                ) {
                    menu.classList.add('hidden');
                }
            });
        </script>

</body>

</html>
