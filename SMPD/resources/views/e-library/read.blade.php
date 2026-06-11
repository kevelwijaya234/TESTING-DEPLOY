<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Baca PDF</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

    <main class="max-w-6xl mx-auto p-8">
        <a href="{{ route('elibrary.index') }}" class="text-blue-900 font-semibold">← Kembali ke E-Library</a>

        <div class="bg-white rounded-2xl shadow p-8 mt-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-blue-950">
                        {{ $digitalBook->title }}
                    </h1>
                    <p class="text-slate-500">
                        {{ $digitalBook->author }} — {{ $digitalBook->category->name ?? '-' }}
                    </p>
                </div>

                @if ($reservation && $reservation->access_until >= now())
                    <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full">
                        Akses Full PDF
                    </span>
                @else
                    <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full">
                        Preview Only
                    </span>
                @endif
            </div>

            <div class="bg-slate-200 rounded-2xl p-8 min-h-[650px]">

                @if (!$reservation || !$reservation->access_until || $reservation->access_until < now())
                    {{-- PREVIEW --}}
                    <div class="h-full flex items-center justify-center">

                        <div class="text-center max-w-2xl">

                            <div class="text-8xl mb-6">
                                📄
                            </div>

                            <h2 class="text-3xl font-bold text-blue-950 mb-4">
                                Preview PDF
                            </h2>

                            <p class="text-slate-600 mb-6">
                                Anda hanya dapat melihat preview buku.
                                Untuk membaca versi lengkap PDF,
                                silakan lakukan reservasi terlebih dahulu.
                            </p>

                            <div class="bg-white rounded-xl p-6 shadow mb-6">

                                <h3 class="font-bold text-lg mb-2">
                                    Preview Buku
                                </h3>

                                <p class="text-slate-500">
                                    Halaman 1 - 3 tersedia untuk preview.
                                </p>

                            </div>

                            <a href="{{ route('reservations.anggota') }}"
                                class="inline-block bg-blue-950 text-white px-6 py-3 rounded-lg">

                                Reservasi Ebook Ini

                            </a>

                            <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">

                                <div class="font-semibold text-yellow-700">
                                    ⚠ Informasi Akses
                                </div>

                                <p class="mt-2 text-sm text-slate-600">
                                    Reservasi harus disetujui pustakawan
                                    sebelum PDF dapat dibuka penuh.
                                </p>
                            </div>
                        </div>
                    </div>
                @elseif($reservation && $reservation->access_until && $reservation->access_until >= now())
                    {{-- FULL PDF --}}
                    <div>
                        <div class="mb-4">
                            <h2 class="text-xl font-bold text-green-700">
                                ✓ Akses Full PDF Aktif
                            </h2>
                            <p class="text-slate-500">
                                Anda telah mendapatkan akses untuk membaca buku digital ini.
                            </p>
                        </div>

                        <iframe src="{{ asset('storage/' . $digitalBook->file) }}" width="100%" height="700"
                            class="rounded-xl border">
                        </iframe>
                    </div>
                @endif
            </div>
    </main>
</body>

</html>
