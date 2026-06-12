<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

    <div class="flex min-h-screen">

        @include('sidebar.admin')

        <main class="flex-1 p-6 md:p-10">

            {{-- HEADER --}}
            <div class="mb-8">

                <h1 class="text-3xl font-bold text-blue-950">
                    Manajemen User
                </h1>

                <p class="text-slate-500">
                    Daftar akun Administrator dan Pustakawan yang terdaftar dalam sistem.
                </p>

            </div>

            {{-- KARTU STATISTIK --}}
            <div class="grid md:grid-cols-3 gap-6 mb-8">

                <div class="bg-white rounded-2xl shadow p-6">

                    <p class="text-slate-500">
                        Total User
                    </p>

                    <h2 class="text-4xl font-bold text-blue-950 mt-2">
                        {{ $users->count() }}
                    </h2>

                </div>

                <div class="bg-white rounded-2xl shadow p-6">

                    <p class="text-slate-500">
                        Administrator
                    </p>

                    <h2 class="text-4xl font-bold text-green-600 mt-2">
                        {{ $users->filter(fn($u) => strtolower($u->role->name) == 'admin')->count() }}
                    </h2>

                </div>

                <div class="bg-white rounded-2xl shadow p-6">

                    <p class="text-slate-500">
                        Pustakawan
                    </p>

                    <h2 class="text-4xl font-bold text-purple-600 mt-2">
                        {{ $users->filter(fn($u) => strtolower($u->role->name) == 'pustakawan')->count() }}
                    </h2>

                </div>

            </div>

            {{-- TABEL USER --}}
            <div class="bg-white rounded-2xl shadow overflow-hidden">

                <div class="p-6 border-b">

                    <h2 class="text-xl font-bold text-blue-950">
                        Daftar Admin & Pustakawan Terdaftar
                    </h2>

                </div>

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-blue-950 text-white">

                            <tr>

                                <th class="p-4 text-left">
                                    User
                                </th>

                                <th class="p-4 text-left">
                                    Email
                                </th>

                                <th class="p-4 text-center">
                                    Role
                                </th>

                                <th class="p-4 text-center">
                                    Telepon
                                </th>

                                <th class="p-4 text-center">
                                    Status
                                </th>

                                <th class="p-4 text-center">
                                    Bergabung
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($users as $user)
                                <tr class="border-b hover:bg-slate-50">

                                    {{-- USER --}}
                                    <td class="p-4">

                                        <div class="flex items-center gap-3">

                                            <div
                                                class="w-12 h-12 rounded-full bg-blue-950 text-white flex items-center justify-center font-bold">

                                                {{ strtoupper(substr($user->name, 0, 1)) }}

                                            </div>

                                            <div>

                                                <div class="font-semibold text-slate-800">

                                                    {{ $user->name }}

                                                </div>

                                                <div class="text-xs text-slate-500">

                                                    {{ $user->member_code }}

                                                </div>

                                            </div>

                                        </div>

                                    </td>

                                    {{-- EMAIL --}}
                                    <td class="p-4 text-slate-700">

                                        {{ $user->email }}

                                    </td>

                                    {{-- ROLE --}}
                                    <td class="p-4 text-center">

                                        @if (strtolower($user->role->name) == 'admin')
                                            <span
                                                class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">

                                                Administrator

                                            </span>
                                        @else
                                            <span
                                                class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-medium">

                                                Pustakawan

                                            </span>
                                        @endif

                                    </td>

                                    {{-- TELEPON --}}
                                    <td class="p-4 text-center text-slate-700">

                                        {{ $user->phone ?? '-' }}

                                    </td>

                                    {{-- STATUS --}}
                                    <td class="p-4 text-center">

                                        @if ($user->status == 'Aktif')
                                            <span class="text-green-600 font-semibold">

                                                ● Aktif

                                            </span>
                                        @else
                                            <span class="text-red-600 font-semibold">

                                                ● Nonaktif

                                            </span>
                                        @endif

                                    </td>

                                    {{-- TANGGAL --}}
                                    <td class="p-4 text-center text-slate-600">

                                        {{ $user->created_at->format('d M Y') }}

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6" class="text-center py-10 text-slate-500">

                                        Belum ada akun Admin atau Pustakawan yang terdaftar.

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </main>

    </div>

</body>

</html>
