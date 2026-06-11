<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Hak Akses</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

    <div class="flex min-h-screen">

        @include('sidebar.admin')

        <main class="flex-1 p-6 md:p-10">

            <div class="mb-8">

                <h1 class="text-3xl font-bold text-blue-950">
                    Hak Akses
                </h1>

                <p class="text-slate-500">
                    Kelola hak akses untuk setiap role dalam sistem perpustakaan.
                </p>

            </div>

            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-700 p-4 rounded-xl mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid lg:grid-cols-3 gap-6">

                {{-- DAFTAR ROLE --}}
                <div class="bg-white rounded-2xl shadow">

                    <div class="p-5 border-b">
                        <h2 class="font-bold text-lg">
                            Daftar Peran
                        </h2>
                    </div>

                    <div class="p-4">

                        @foreach ($roles as $role)
                            <a href="{{ route('permissions.index', ['role' => $role->id]) }}"
                                class="block border rounded-xl p-4 mb-4 transition
                               {{ $selectedRole == $role->id ? 'bg-blue-100 border-blue-500' : 'hover:bg-slate-50' }}">

                                <h3 class="font-semibold">
                                    {{ ucfirst($role->name) }}
                                </h3>

                                <p class="text-sm text-slate-500">
                                    Role sistem perpustakaan
                                </p>

                            </a>
                        @endforeach

                    </div>

                </div>

                {{-- TABEL PERMISSION --}}
                <div class="lg:col-span-2">

                    <form action="{{ route('permissions.update') }}" method="POST">

                        @csrf

                        <input type="hidden" name="role_id" value="{{ $selectedRole }}">

                        <div class="bg-white rounded-2xl shadow overflow-hidden">

                            <div class="p-5 border-b flex flex-wrap gap-3 justify-between items-center">

                                <h2 class="font-bold text-xl">

                                    Pengaturan Hak Akses -
                                    {{ ucfirst($roles->find($selectedRole)?->name) }}

                                </h2>

                                <div class="flex gap-2">

                                    <button type="button" onclick="checkAllPermissions()"
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">

                                        ✓ Centang Semua

                                    </button>

                                    <button type="button" onclick="uncheckAllPermissions()"
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">

                                        ✕ Hapus Semua

                                    </button>

                                </div>

                            </div>

                            <div class="overflow-x-auto">

                                <table class="w-full">

                                    <thead class="bg-blue-950 text-white">

                                        <tr>

                                            <th class="p-4 text-left">
                                                Modul
                                            </th>

                                            <th class="p-4 text-center">
                                                View
                                            </th>

                                            <th class="p-4 text-center">
                                                Create
                                            </th>

                                            <th class="p-4 text-center">
                                                Edit
                                            </th>

                                            <th class="p-4 text-center">
                                                Delete
                                            </th>

                                            <th class="p-4 text-center">
                                                Print
                                            </th>

                                            <th class="p-4 text-center">
                                                Export
                                            </th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @foreach ($permissions as $permission)
                                            @php
                                                $rp = $rolePermissions
                                                    ->where('permission_id', $permission->id)
                                                    ->first();
                                            @endphp

                                            <tr class="border-b hover:bg-slate-50">

                                                <td class="p-4 font-medium">
                                                    {{ ucfirst($permission->name) }}
                                                </td>

                                                <td class="text-center">
                                                    <input type="checkbox"
                                                        class="permission-checkbox w-5 h-5 accent-blue-600"
                                                        name="permissions[{{ $permission->id }}][can_view]"
                                                        {{ $rp && $rp->can_view ? 'checked' : '' }}>
                                                </td>

                                                <td class="text-center">
                                                    <input type="checkbox"
                                                        class="permission-checkbox w-5 h-5 accent-green-600"
                                                        name="permissions[{{ $permission->id }}][can_create]"
                                                        {{ $rp && $rp->can_create ? 'checked' : '' }}>
                                                </td>

                                                <td class="text-center">
                                                    <input type="checkbox"
                                                        class="permission-checkbox w-5 h-5 accent-yellow-500"
                                                        name="permissions[{{ $permission->id }}][can_edit]"
                                                        {{ $rp && $rp->can_edit ? 'checked' : '' }}>
                                                </td>

                                                <td class="text-center">
                                                    <input type="checkbox"
                                                        class="permission-checkbox w-5 h-5 accent-red-600"
                                                        name="permissions[{{ $permission->id }}][can_delete]"
                                                        {{ $rp && $rp->can_delete ? 'checked' : '' }}>
                                                </td>

                                                <td class="text-center">
                                                    <input type="checkbox"
                                                        class="permission-checkbox w-5 h-5 accent-purple-600"
                                                        name="permissions[{{ $permission->id }}][can_print]"
                                                        {{ $rp && $rp->can_print ? 'checked' : '' }}>
                                                </td>

                                                <td class="text-center">
                                                    <input type="checkbox"
                                                        class="permission-checkbox w-5 h-5 accent-indigo-600"
                                                        name="permissions[{{ $permission->id }}][can_export]"
                                                        {{ $rp && $rp->can_export ? 'checked' : '' }}>
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                        </div>

                        <div class="flex justify-end mt-6">

                            <button type="submit"
                                class="bg-blue-950 hover:bg-blue-900 text-white px-6 py-3 rounded-lg">

                                Simpan Perubahan

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </main>

    </div>

    <script>
        function checkAllPermissions() {

            document.querySelectorAll('.permission-checkbox')
                .forEach(cb => cb.checked = true);

        }

        function uncheckAllPermissions() {

            document.querySelectorAll('.permission-checkbox')
                .forEach(cb => cb.checked = false);

        }
    </script>

</body>

</html>
