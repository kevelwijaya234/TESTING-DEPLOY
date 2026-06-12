<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Verifikasi Email</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

    <div class="min-h-screen flex items-center justify-center">

        <div class="bg-white shadow rounded-2xl p-8 w-full max-w-md">

            <h1 class="text-2xl font-bold mb-2">
                Verifikasi Email
            </h1>

            <p class="text-slate-500 mb-6">
                Masukkan kode OTP yang telah dikirim ke email Anda.
            </p>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('verify.email.submit') }}" method="POST">

                @csrf

                <input type="text" name="otp" placeholder="Masukkan OTP"
                    class="w-full border rounded-lg px-4 py-3 mb-4" required>

                <button class="w-full bg-blue-950 text-white py-3 rounded-lg">
                    Verifikasi
                </button>

            </form>

            <form action="{{ route('resend.otp') }}" method="POST">
                @csrf

                <button type="submit" class="bg-blue-950 text-white px-4 py-2 rounded-lg mt-3 w-full">

                    Kirim Ulang OTP

                </button>

            </form>
        </div>

    </div>

</body>

</html>
