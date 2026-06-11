@php
    $role = session('role');
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kartu Anggota</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

    <div class="flex min-h-screen">

        {{-- SIDEBAR DINAMIS --}}
        @if ($role == 'admin')
            @include('sidebar.admin')
        @elseif ($role == 'pustakawan')
            @include('sidebar.pustakawan')
        @else
            @include('sidebar.anggota')
        @endif


        <main class="flex-1 p-8">

            {{-- BUTTON KEMBALI --}}
            <div class="mb-6">

                @if ($role == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-900 font-semibold">
                        ← Kembali
                    </a>
                @elseif ($role == 'pustakawan')
                    <a href="{{ route('pustakawan.dashboard') }}" class="text-blue-900 font-semibold">
                        ← Kembali
                    </a>
                @else
                    <a href="{{ route('anggota.dashboard') }}" class="text-blue-900 font-semibold">
                        ← Kembali
                    </a>
                @endif

            </div>


            <div class="bg-white rounded-2xl shadow p-8">

                <h1 class="text-3xl font-bold text-blue-950 mb-6">
                    QR Member Card
                </h1>

                <div class="border-2 border-blue-950 rounded-2xl overflow-hidden max-w-xl mx-auto">

                    <div class="bg-blue-950 text-white p-5">

                        <h2 class="text-2xl font-bold">
                            SMPD
                        </h2>

                        <p>
                            Kartu Anggota Perpustakaan
                        </p>

                    </div>

                    <div class="p-6 grid md:grid-cols-2 gap-6 items-center">

                        <div>

                            <p class="text-slate-500">
                                Kode Anggota
                            </p>

                            <h3 class="text-2xl font-bold text-blue-950">
                                {{ $member->member_code }}
                            </h3>

                            <p class="text-slate-500 mt-4">
                                Nama
                            </p>

                            <h3 class="font-bold">
                                {{ $member->name }}
                            </h3>

                            <p class="text-slate-500 mt-4">
                                Email
                            </p>

                            <h3 class="font-semibold">
                                {{ $member->email }}
                            </h3>

                            <p class="text-slate-500 mt-4">
                                Status
                            </p>

                            @if ($member->status == 'Aktif')
                                <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                    Aktif
                                </span>
                            @else
                                <span class="inline-block bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                                    Nonaktif
                                </span>
                            @endif

                        </div>

                        <div class="bg-slate-100 h-56 rounded-xl flex items-center justify-center text-center">

                            <div>

                                <div class="bg-white p-3 rounded-lg inline-block">

                                    {!! QrCode::size(150)->generate($member->member_code) !!}

                                </div>

                                <p class="font-bold mt-3">
                                    {{ $member->member_code }}
                                </p>

                                <p class="text-xs text-slate-500">
                                    QR Member
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- BUTTON --}}
                <div class="text-center mt-6 flex justify-center gap-4">

                    {{-- CETAK --}}
                    <button onclick="window.print()" class="bg-blue-950 text-white px-6 py-3 rounded-lg">

                        Cetak Kartu

                    </button>


                    {{-- EDIT KHUSUS ADMIN & PUSTAKAWAN --}}
                    @if ($role == 'admin' || $role == 'pustakawan')
                        <a href="{{ route('members.edit', $member->id) }}"
                            class="bg-yellow-500 text-white px-6 py-3 rounded-lg">

                            Edit Data

                        </a>
                    @endif

                </div>

            </div>

        </main>

    </div>

</body>

</html>
