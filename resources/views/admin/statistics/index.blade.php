@php
    $role = session('role');
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Statistik Peminjaman</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

    <div class="flex min-h-screen">

        @if ($role == 'admin')
            @include('sidebar.admin')
        @else
            @include('sidebar.pustakawan')
        @endif

        <main class="flex-1 p-6 md:p-10">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-blue-950">Statistik Peminjaman</h1>
                <p class="text-slate-500">Analisis buku terpopuler dan anggota paling aktif.</p>
            </div>

            <div class="grid md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow p-6">
                    <p class="text-slate-500">
                        Total Peminjaman
                    </p>
                    <h2 class="text-3xl font-bold text-blue-950 mt-2">
                        {{ $totalLoans }}
                    </h2>
                </div>
                <div class="bg-white rounded-2xl shadow p-6">

                    <p class="text-slate-500">
                        Buku Terpopuler
                    </p>

                    <h2 class="text-lg font-bold text-blue-950 mt-2 line-clamp-2">
                        {{ $topBook?->book?->title ?? '-' }}
                    </h2>

                </div>
                <div class="bg-white rounded-2xl shadow p-6">

                    <p class="text-slate-500">
                        Anggota Teraktif
                    </p>

                    <h2 class="text-lg font-bold text-blue-950 mt-2 line-clamp-2">
                        {{ $topMember?->member?->name ?? '-' }}
                    </h2>

                </div>

                <div class="bg-white rounded-2xl shadow p-6">

                    <p class="text-slate-500">
                        Bulan Ini
                    </p>

                    <h2 class="text-3xl font-bold text-blue-950 mt-2">
                        {{ $monthlyLoans }}
                    </h2>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-2xl shadow p-6">
                    <h2 class="text-xl font-bold text-blue-950 mb-6">Buku Terpopuler</h2>

                    <div class="space-y-5">
                        @foreach ($popularBooks as $book)
                            <div>
                                <div class="flex justify-between mb-2">
                                    <span class="font-semibold">{{ $book->book?->title ?? '-' }}</span>
                                    <span> {{ $book->total }} kali</span>
                                </div>

                                <div class="w-full bg-slate-200 rounded-full h-3">
                                    <div class="bg-blue-950 h-3 rounded-full"
                                        style="width: {{ min($book->total * 5, 100) }}%">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow p-6">
                    <h2 class="text-xl font-bold text-blue-950 mb-6">Anggota Teraktif</h2>

                    <div class="space-y-5">
                        @foreach ($activeMembers as $member)
                            <div>
                                <div class="flex justify-between mb-2">
                                    <span class="font-semibold">
                                        {{ $member->member?->name ?? '-' }}
                                    </span>
                                    <span>{{ $member->total }} pinjaman</span>
                                </div>

                                <div class="w-full bg-slate-200 rounded-full h-3">
                                    <div class="bg-green-600 h-3 rounded-full"
                                        style="width: {{ min($member->total * 5, 100) }}%">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow overflow-hidden mt-8">
                <table class="w-full text-left">
                    <thead class="bg-blue-950 text-white">
                        <tr>
                            <th class="p-4">Kategori</th>
                            <th class="p-4">Jumlah Peminjaman</th>
                            <th class="p-4">Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="p-4">Novel</td>
                            <td class="p-4">110</td>
                            <td class="p-4">34%</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-4">Teknologi</td>
                            <td class="p-4">90</td>
                            <td class="p-4">28%</td>
                        </tr>
                        <tr class="border-b">
                            <td class="p-4">Pendidikan</td>
                            <td class="p-4">70</td>
                            <td class="p-4">22%</td>
                        </tr>
                        <tr>
                            <td class="p-4">Sastra</td>
                            <td class="p-4">50</td>
                            <td class="p-4">16%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

</body>

</html>
