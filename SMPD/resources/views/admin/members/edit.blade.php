<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Anggota</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100">

<main class="max-w-4xl mx-auto p-8">
    <a href="{{ route('members.index') }}" class="text-blue-900 font-semibold">← Kembali</a>

    <div class="bg-white rounded-2xl shadow p-8 mt-6">
        <h1 class="text-3xl font-bold text-blue-950 mb-6">Edit Anggota</h1>

        <form action="{{ route('members.update', $member->id) }}" method="POST" class="grid md:grid-cols-2 gap-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-2 font-medium">Kode Anggota</label>
                <input type="text" name="member_code" value="{{ $member->member_code }}" class="w-full border rounded-lg px-4 py-3" required>
            </div>

            <div>
                <label class="block mb-2 font-medium">Nama Lengkap</label>
                <input type="text" name="name" value="{{ $member->name }}" class="w-full border rounded-lg px-4 py-3" required>
            </div>

            <div>
                <label class="block mb-2 font-medium">Email</label>
                <input type="email" name="email" value="{{ $member->email }}" class="w-full border rounded-lg px-4 py-3" required>
            </div>

            <div>
                <label class="block mb-2 font-medium">No HP</label>
                <input type="text" name="phone" value="{{ $member->phone }}" class="w-full border rounded-lg px-4 py-3">
            </div>

            <div class="md:col-span-2">
                <label class="block mb-2 font-medium">Alamat</label>
                <textarea name="address" rows="3" class="w-full border rounded-lg px-4 py-3">{{ $member->address }}</textarea>
            </div>

            <div>
                <label class="block mb-2 font-medium">Status</label>
                <select name="status" class="w-full border rounded-lg px-4 py-3">
                    <option value="Aktif" {{ $member->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Nonaktif" {{ $member->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <button class="bg-blue-950 text-white px-6 py-3 rounded-lg hover:bg-blue-900">
                    Update Anggota
                </button>
            </div>
        </form>
    </div>
</main>

</body>
</html>