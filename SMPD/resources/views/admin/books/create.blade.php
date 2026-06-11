<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Buku - SMPD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

    <main class="max-w-4xl mx-auto p-8">
        <a href="{{ route('books.index') }}" class="text-blue-900 font-semibold">← Kembali</a>

        <div class="bg-white rounded-2xl shadow p-8 mt-6">
            <h1 class="text-3xl font-bold text-blue-950 mb-6">Tambah Buku</h1>

            <form action="{{ route('books.store') }}" method="POST" class="grid md:grid-cols-2 gap-5">
                @csrf

                <div>
                    <label class="block mb-2 font-medium">Judul Buku</label>
                    <input type="text" name="title" class="w-full border rounded-lg px-4 py-3" required>
                </div>

                <div>
                    <label class="block mb-2 font-medium">Penulis</label>
                    <input type="text" name="author" class="w-full border rounded-lg px-4 py-3" required>
                </div>

                <div>
                    <label class="block mb-2 font-medium">Kategori</label>
                    <select name="category_id" class="w-full border rounded-lg px-4 py-3" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-medium">Penerbit</label>
                    <input type="text" name="publisher" class="w-full border rounded-lg px-4 py-3">
                </div>

                <div>
                    <label class="block mb-2 font-medium">Tahun Terbit</label>
                    <input type="number" name="year" class="w-full border rounded-lg px-4 py-3">
                </div>

                <div>
                    <label class="block mb-2 font-medium">ISBN</label>
                    <input type="text" name="isbn" class="w-full border rounded-lg px-4 py-3">
                </div>

                <div>
                    <label class="block mb-2 font-medium">Stok</label>
                    <input type="number" name="stock" class="w-full border rounded-lg px-4 py-3" required>
                </div>

                <div>
                    <label class="block mb-2 font-medium">kode_buku</label>
                    <input type="text" name="kode_buku" placeholder="Contoh: BK0201"
                        class="w-full border rounded-lg px-4 py-3" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 font-medium">Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full border rounded-lg px-4 py-3"></textarea>
                </div>

                <div class="md:col-span-2">
                    <button class="bg-blue-950 text-white px-6 py-3 rounded-lg hover:bg-blue-900">
                        Simpan Buku
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>

</html>
