<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Transaksi Peminjaman</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

    <main class="max-w-5xl mx-auto p-8">
        <a href="{{ route('loans.index') }}" class="text-blue-900 font-semibold">← Kembali</a>

        <div class="bg-white rounded-2xl shadow p-8 mt-6">
            <h1 class="text-3xl font-bold text-blue-950 mb-2">Transaksi Peminjaman</h1>
            <p class="text-slate-500 mb-8">
                Masukkan kode anggota dan kode buku untuk memproses peminjaman.
            </p>

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

            <form action="{{ route('loans.store') }}" method="POST" class="grid md:grid-cols-2 gap-6">
                @csrf

                <div class="md:col-span-2 bg-blue-50 border border-blue-100 rounded-2xl p-5">
                    <h2 class="font-bold text-blue-950 mb-2">Simulasi Scan</h2>
                    <p class="text-sm text-slate-600">
                        Scanner barcode biasanya langsung mengetikkan kode ke field aktif.
                        Klik field barcode/kode anggota, lalu scan atau input manual.
                    </p>
                </div>

                <div>
                    <label class="block mb-2 font-medium">Kode Anggota / QR Member</label>
                    <input type="text" name="member_code" value="{{ old('member_code') }}"
                        placeholder="Contoh: MBR0001"
                        class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-900 outline-none"
                        required>
                </div>

                <div>
                    <label class="block mb-2 font-medium">Kode Buku</label>
                    <input type="text" name="kode_buku" value="{{ old('kode_buku') }}" placeholder="Contoh: BK0001"
                        class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-900 outline-none"
                        required>
                </div>

                <div>
                    <label class="block mb-2 font-medium">
                        Tanggal Pinjam
                    </label>

                    <input type="date" name="loan_date" value="{{ old('loan_date', date('Y-m-d')) }}"
                        class="w-full border rounded-lg px-4 py-3" required>
                </div>

                <div class="md:col-span-2 bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                    <p class="font-semibold text-yellow-700">
                        Durasi peminjaman otomatis 5 hari.
                    </p>

                    <p class="text-sm text-slate-600 mt-1">
                        Tanggal jatuh tempo akan dihitung otomatis oleh sistem berdasarkan tanggal peminjaman.
                    </p>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 font-medium">Catatan</label>
                    <textarea name="notes" rows="3" placeholder="Opsional" class="w-full border rounded-lg px-4 py-3">{{ old('notes') }}</textarea>
                </div>

                <div class="md:col-span-2 flex gap-4">
                    <button class="bg-blue-950 text-white px-6 py-3 rounded-lg hover:bg-blue-900">
                        Simpan Peminjaman
                    </button>

                    <a href="{{ route('loans.index') }}" class="border px-6 py-3 rounded-lg hover:bg-slate-50">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>

</body>

</html>
