<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Profil</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-slate-100">
    <div class="flex min-h-screen">

        @include('sidebar.anggota')

        <main class="flex-1 p-6 md:p-10">

            {{-- Header --}}
            <div class="mb-8">

                <h1 class="text-3xl font-bold text-blue-950">
                    Edit Profil
                </h1>

                <p class="text-slate-500">
                    Perbarui data pribadi dan password akun Anda.
                </p>

            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-700 p-4 rounded-xl mb-6">

                    {{ session('success') }}

                </div>
            @endif

            {{-- Error Message --}}
            @if ($errors->any())

                <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-xl mb-6">

                    <ul class="list-disc ml-5">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            @endif

            <div class="bg-white rounded-2xl shadow p-8">

                <form action="{{ route('profile.update') }}" method="POST">

                    @csrf
                    @method('PUT')

                    {{-- DATA PROFIL --}}
                    <div class="grid md:grid-cols-2 gap-6">

                        <div>

                            <label class="block mb-2 font-medium">

                                Nama Lengkap

                            </label>

                            <input type="text" name="name" value="{{ old('name', $member->name) }}"
                                class="w-full border rounded-xl px-4 py-3">

                        </div>

                        <div>

                            <label class="block mb-2 font-medium">

                                Email

                            </label>

                            <input type="email" value="{{ $member->email }}" disabled
                                class="w-full border rounded-xl px-4 py-3 bg-slate-100">

                        </div>

                        <div>

                            <label class="block mb-2 font-medium">

                                Nomor HP

                            </label>

                            <input type="text" name="phone" value="{{ old('phone', $member->phone) }}"
                                class="w-full border rounded-xl px-4 py-3">

                        </div>

                        <div>

                            <label class="block mb-2 font-medium">

                                Kode Anggota

                            </label>

                            <input type="text" value="{{ $member->member_code }}" disabled
                                class="w-full border rounded-xl px-4 py-3 bg-slate-100">

                        </div>

                        <div class="md:col-span-2">

                            <label class="block mb-2 font-medium">

                                Alamat

                            </label>

                            <textarea name="address" rows="4" class="w-full border rounded-xl px-4 py-3">{{ old('address', $member->address) }}</textarea>

                        </div>

                    </div>

                    {{-- GARIS PEMBATAS --}}
                    <hr class="my-8">

                    {{-- PASSWORD --}}
                    <div>

                        <h2 class="text-xl font-bold text-blue-950 mb-6">

                            Ganti Password

                        </h2>

                        <div class="grid md:grid-cols-2 gap-6">

                            <div class="md:col-span-2">

                                <label class="block mb-2 font-medium">

                                    Password Lama

                                </label>

                                <input type="password" name="current_password"
                                    class="w-full border rounded-xl px-4 py-3">

                            </div>

                            <div>

                                <label class="block mb-2 font-medium">

                                    Password Baru

                                </label>

                                <input type="password" name="password" class="w-full border rounded-xl px-4 py-3">

                            </div>

                            <div>

                                <label class="block mb-2 font-medium">

                                    Konfirmasi Password Baru

                                </label>

                                <input type="password" name="password_confirmation"
                                    class="w-full border rounded-xl px-4 py-3">

                            </div>

                        </div>

                    </div>

                    {{-- BUTTON --}}
                    <div class="mt-8 flex flex-wrap gap-4">

                        <button type="submit"
                            class="bg-blue-950 hover:bg-blue-900 text-white px-6 py-3 rounded-xl transition">

                            Simpan Perubahan

                        </button>

                        <a href="{{ route('profile.index') }}"
                            class="bg-slate-200 hover:bg-slate-300 px-6 py-3 rounded-xl transition">

                            Batal

                        </a>

                    </div>

                </form>

            </div>

        </main>

    </div>

</body>

</html>
