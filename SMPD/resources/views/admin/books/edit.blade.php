<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Buku - SMPD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

    <main class="max-w-4xl mx-auto p-8">
        <a href="{{ route('books.index') }}" class="text-blue-900 font-semibold">← Kembali</a>

        <div class="bg-white rounded-2xl shadow p-8 mt-6">
            <h1 class="text-3xl font-bold text-blue-950 mb-6">Edit Buku</h1>

            <form action="{{ route('books.update', $book->id) }}" method="POST" class="grid md:grid-cols-2 gap-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block mb-2 font-medium">Judul Buku</label>
                    <input type="text" name="title" value="{{ $book->title }}"
                        class="w-full border rounded-lg px-4 py-3" required>
                </div>

                <div>
                    <label class="block mb-2 font-medium">Penulis</label>
                    <input type="text" name="author" value="{{ $book->author }}"
                        class="w-full border rounded-lg px-4 py-3" required>
                </div>

                <div>
                    <label class="block mb-2 font-medium">Kategori</label>
                    <select name="category_id" class="w-full border rounded-lg px-4 py-3" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $book->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-medium">Penerbit</label>
                    <input type="text" name="publisher" value="{{ $book->publisher }}"
                        class="w-full border rounded-lg px-4 py-3">
                </div>

                <div>
                    <label class="block mb-2 font-medium">Tahun Terbit</label>
                    <input type="number" name="year" value="{{ $book->year }}"
                        class="w-full border rounded-lg px-4 py-3">
                </div>

                <div>
                    <label class="block mb-2 font-medium">ISBN</label>
                    <input type="text" name="isbn" value="{{ $book->isbn }}"
                        class="w-full border rounded-lg px-4 py-3">
                </div>

                <div>
                    <label class="block mb-2 font-medium">Stok</label>
                    <input type="number" name="stock" value="{{ $book->stock }}"
                        class="w-full border rounded-lg px-4 py-3" required>
                </div>

                <div>
                    <label class="block mb-2 font-medium">Kode Buku</label>
                    <input type="text" name="kode_buku" value="{{ $book->kode_buku }}"
                        class="w-full border rounded-lg px-4 py-3" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 font-medium">Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full border rounded-lg px-4 py-3">{{ $book->description }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <button class="bg-blue-950 text-white px-6 py-3 rounded-lg hover:bg-blue-900">
                        Update Buku
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>

</html>
