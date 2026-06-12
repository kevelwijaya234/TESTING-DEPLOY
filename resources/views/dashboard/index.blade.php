<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

    <div class="flex min-h-screen">

        @include('sidebar.pustakawan')

        <main class="flex-1 p-6 md:p-10">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-blue-950">
                    Dashboard Pustakawan
                </h1>

                <p class="text-slate-500">
                    Kelola operasional perpustakaan harian.
                </p>
            </div>

            <section class="grid md:grid-cols-4 gap-6 mb-8">

                <div class="bg-white p-6 rounded-2xl shadow">
                    <p class="text-slate-500">Peminjaman</p>
                    <h2 class="text-3xl font-bold text-blue-950">320</h2>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow">
                    <p class="text-slate-500">Pengembalian</p>
                    <h2 class="text-3xl font-bold text-green-600">290</h2>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow">
                    <p class="text-slate-500">Reservasi</p>
                    <h2 class="text-3xl font-bold text-orange-500">18</h2>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow">
                    <p class="text-slate-500">Denda</p>
                    <h2 class="text-3xl font-bold text-red-600">Rp85.000</h2>
                </div>

            </section>

            <section class="grid lg:grid-cols-2 gap-8">

                <div class="bg-white p-6 rounded-2xl shadow">

                    <h2 class="text-xl font-bold text-blue-950 mb-5">
                        Buku Trending
                    </h2>

                    <div class="space-y-5">

                        <div>
                            <div class="flex justify-between mb-2">
                                <span>Laskar Pelangi</span>
                                <span>45x</span>
                            </div>

                            <div class="w-full bg-slate-200 h-4 rounded-full">
                                <div class="bg-blue-950 h-4 rounded-full" style="width:90%">
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between mb-2">
                                <span>Atomic Habits</span>
                                <span>38x</span>
                            </div>

                            <div class="w-full bg-slate-200 h-4 rounded-full">
                                <div class="bg-blue-950 h-4 rounded-full" style="width:76%">
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="bg-white p-6 rounded-2xl shadow">

                    <h2 class="text-xl font-bold text-blue-950 mb-5">
                        Aktivitas Hari Ini
                    </h2>

                    <div class="space-y-4">

                        <div class="border-b pb-3">
                            8 buku dipinjam hari ini.
                        </div>

                        <div class="border-b pb-3">
                            5 buku dikembalikan.
                        </div>

                        <div class="border-b pb-3">
                            2 reservasi disetujui.
                        </div>

                    </div>

                </div>

            </section>

        </main>

    </div>

</body>

</html>
