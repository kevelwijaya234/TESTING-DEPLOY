<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $digitalBook->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

    <div class="flex min-h-screen">

        @include('sidebar.anggota')

        <div class="flex-1">

            <main class="p-8">

                <a href="{{ route('elibrary.index') }}" class="text-blue-950 font-semibold">

                    ← Kembali ke E-Library

                </a>

                <div class="bg-white rounded-2xl shadow mt-6 p-8">

                    <div class="flex flex-col lg:flex-row gap-8">

                        <div class="lg:w-1/3">

                            <div class="bg-red-100 rounded-2xl h-80 flex items-center justify-center">

                                <span class="text-8xl">
                                    📄
                                </span>

                            </div>

                        </div>

                        <div class="lg:w-2/3">

                            <span class="bg-blue-100 text-blue-900 px-3 py-1 rounded-full">

                                {{ $digitalBook->category->name }}

                            </span>

                            <h1 class="text-4xl font-bold text-blue-950 mt-4">

                                {{ $digitalBook->title }}

                            </h1>

                            <p class="text-slate-500 mt-2 text-lg">

                                Oleh {{ $digitalBook->author }}

                            </p>

                            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 mt-8">

                                <div class="border rounded-xl p-4">
                                    <p class="text-sm text-slate-500 mt-2">
                                        Kode: {{ $digitalBook->kode_buku }}
                                    </p>


                                    <h3 class="font-semibold">

                                        {{ $digitalBook->kode_buku }}

                                    </h3>
                                </div>

                                <div class="border rounded-xl p-4">
                                    <p class="text-sm text-slate-500">

                                        Penerbit

                                    </p>

                                    <h3 class="font-semibold">

                                        {{ $digitalBook->publisher }}

                                    </h3>
                                </div>

                                <div class="border rounded-xl p-4">
                                    <p class="text-sm text-slate-500">
                                        Tahun: {{ $digitalBook->year }}
                                    </p>

                                    <h3 class="font-semibold">

                                        {{ $digitalBook->year }}

                                    </h3>
                                </div>

                                <div class="border rounded-xl p-4">
                                    <p class="text-sm text-slate-500">

                                        ISBN

                                    </p>

                                    <h3 class="font-semibold">

                                        {{ $digitalBook->isbn }}

                                    </h3>
                                </div>

                            </div>

                            <div class="mt-8">

                                <h2 class="font-bold text-xl">

                                    Deskripsi

                                </h2>

                                <p class="text-slate-600">

                                    {{ $digitalBook->description }}

                                </p>

                            </div>

                            <div class="mt-8 flex gap-4">
                                <form action="{{ route('reservations.store') }}" method="POST">

                                    @csrf

                                    <input type="hidden" name="book_type" value="digital">

                                    <input type="hidden" name="digital_book_id" value="{{ $digitalBook->id }}">

                                    <input type="hidden" name="reservation_date" value="{{ now()->toDateString() }}">

                                    <input type="hidden" name="from" value="anggota">

                                    <button type="submit" class="bg-blue-950 text-white px-6 py-3 rounded-lg">

                                        Reservasi Ebook

                                    </button>

                                </form>
                                <a href="{{ route('elibrary.read', $digitalBook->id) }}"
                                    class="border px-6 py-3 rounded-lg">

                                    Preview Ebook

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </main>

        </div>

    </div>

</body>

</html>
