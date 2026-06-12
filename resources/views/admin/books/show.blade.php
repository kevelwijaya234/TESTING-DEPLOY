<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Buku - SMPD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

    <main class="max-w-4xl mx-auto p-8">
        <a href="{{ route('books.index') }}" class="text-blue-900 font-semibold">← Kembali</a>

        <div class="bg-white rounded-2xl shadow p-8 mt-6">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-blue-950">{{ $book->title }}</h1>
                    <p class="text-slate-500 mt-1">{{ $book->author }}</p>
                </div>

                <span class="bg-blue-100 text-blue-900 px-4 py-2 rounded-full">
                    {{ $book->category->name ?? '-' }}
                </span>
            </div>

            <div class="grid md:grid-cols-2 gap-5 mt-8">
                <div class="border rounded-xl p-5">
                    <p class="text-slate-500">Barcode Buku</p>
                    <h2 class="text-2xl font-bold">
                        {{ $book->kode_buku }}
                    </h2>

                    <div class="mt-4 bg-white p-4 rounded-lg text-center">
                        {!! DNS1D::getBarcodeHTML($book->kode_buku, 'C128', 2, 70) !!}
                        <p class="mt-3 font-bold">
                            {{ $book->kode_buku }}
                        </p>
                    </div>
                </div>

                <div class="border rounded-xl p-5">
                    <p class="text-slate-500">Status</p>
                    <h2 class="text-2xl font-bold">
                        {{ $book->stock > 0 ? 'Tersedia' : 'Habis' }}
                    </h2>
                </div>

                <div class="border rounded-xl p-5">
                    <p class="text-slate-500">Tahun Terbit</p>
                    <h2 class="text-2xl font-bold">{{ $book->year ?? '-' }}</h2>
                </div>

                <div class="border rounded-xl p-5">
                    <p class="text-slate-500">Stok Buku</p>
                    <h2 class="text-2xl font-bold">{{ $book->stock }}</h2>
                </div>

                <div class="border rounded-xl p-5">
                    <p class="text-slate-500">Penerbit</p>
                    <h2 class="text-xl font-bold">{{ $book->publisher ?? '-' }}</h2>
                </div>

                <div class="border rounded-xl p-5">
                    <p class="text-slate-500">ISBN</p>
                    <h2 class="text-xl font-bold">{{ $book->isbn ?? '-' }}</h2>
                </div>
            </div>

            <div class="mt-8">
                <h2 class="text-xl font-bold mb-2">Deskripsi</h2>
                <p class="text-slate-600">
                    {{ $book->description ?? 'Tidak ada deskripsi.' }}
                </p>
            </div>

            <div class="mt-8 flex gap-4">
                <a href="{{ route('books.edit', $book->id) }}" class="bg-yellow-500 text-white px-6 py-3 rounded-lg">
                    Edit Buku
                </a>

                <a href="{{ route('books.index') }}" class="border px-6 py-3 rounded-lg">
                    Kembali
                </a>
            </div>
        </div>
    </main>

</body>

</html>
