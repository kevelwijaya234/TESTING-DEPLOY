<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>SMPD</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            overflow-x: hidden;
        }

        @keyframes floatX1 {
            0% {
                transform: translateX(-200px) translateY(0px) rotate(-10deg);
            }

            50% {
                transform: translateX(50vw) translateY(-40px) rotate(10deg);
            }

            100% {
                transform: translateX(110vw) translateY(0px) rotate(-10deg);
            }
        }

        @keyframes floatX2 {
            0% {
                transform: translateX(100vw) translateY(0px) rotate(10deg);
            }

            50% {
                transform: translateX(40vw) translateY(40px) rotate(-10deg);
            }

            100% {
                transform: translateX(-200px) translateY(0px) rotate(10deg);
            }
        }

        @keyframes floatingCard {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-12px);
            }
        }

        .book-float-1 {
            animation: floatX1 18s linear infinite;
        }

        .book-float-2 {
            animation: floatX2 22s linear infinite;
        }

        .book-float-3 {
            animation: floatX1 25s linear infinite;
        }

        .book-float-4 {
            animation: floatX2 28s linear infinite;
        }

        .floating-card {
            animation: floatingCard 5s ease-in-out infinite;
        }
    </style>

</head>

<nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-xl border-b border-slate-200 shadow-lg">

    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        {{-- LOGO --}}
        <div class="flex items-center gap-4">

            <div
                class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-900 to-indigo-700 text-white flex items-center justify-center text-2xl shadow-xl">
                📚
            </div>

            <div>
                <h1 class="text-2xl font-black text-blue-950">
                    SMPD
                </h1>

                <p class="text-xs text-slate-500">
                    Sistem Manajemen Perpustakaan Daerah
                </p>
            </div>

        </div>

        {{-- MENU --}}
        <div class="hidden md:flex items-center gap-10">

            <a href="{{ route('landing') }}"
                class="font-medium text-slate-700 border-b-2 border-transparent pb-1 hover:text-blue-900 hover:border-blue-900 transition duration-300">
                Home
            </a>

            <a href="#fitur"
                class="font-medium text-slate-700 border-b-2 border-transparent pb-1 hover:text-blue-900 hover:border-blue-900 transition duration-300">
                Fitur
            </a>

            <a href="#tentang"
                class="font-medium text-slate-700 border-b-2 border-transparent pb-1 hover:text-blue-900 hover:border-blue-900 transition duration-300">
                Tentang
            </a>

            <a href="{{ route('opac.index') }}"
                class="font-medium text-slate-700 border-b-2 border-transparent pb-1 hover:text-blue-900 hover:border-blue-900 transition duration-300">
                OPAC
            </a>

        </div>

        {{-- BUTTON --}}
        <div class="flex gap-3">

            <a href="{{ route('login') }}"
                class="px-5 py-3 rounded-xl border border-blue-950 text-blue-950 font-semibold hover:bg-blue-50 transition duration-300">
                Login
            </a>

            <a href="{{ route('register') }}"
                class="px-5 py-3 rounded-xl bg-blue-950 text-white font-semibold hover:bg-blue-900 shadow-xl transition duration-300">
                Daftar
            </a>

        </div>

    </div>

</nav>



    {{-- HERO --}}
    <section
        class="relative overflow-hidden bg-gradient-to-br from-blue-950 via-indigo-900 to-slate-950 text-white min-h-screen flex items-center pt-24">

        {{-- BACKGROUND EFFECT --}}
        <div class="absolute inset-0 overflow-hidden">

            {{-- blur --}}
            <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-blue-500/20 rounded-full blur-3xl">
            </div>

            <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-indigo-500/20 rounded-full blur-3xl">
            </div>


            {{-- floating books --}}
            <div class="absolute top-20 text-7xl opacity-10 book-float-1">
                📘
            </div>

            <div class="absolute top-40 text-6xl opacity-10 book-float-2">
                📚
            </div>

            <div class="absolute bottom-32 text-8xl opacity-10 book-float-3">
                📖
            </div>

            <div class="absolute top-1/2 text-6xl opacity-10 book-float-4">
                📕
            </div>

        </div>


        <div class="max-w-7xl mx-auto px-6 py-24 relative z-10">

            <div class="grid lg:grid-cols-2 gap-16 items-center">

                {{-- LEFT --}}
                <div>

                    {{-- BADGE --}}
                    <div
                        class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-xl border border-white/10 px-6 py-3 rounded-full shadow-xl">

                        <span class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></span>

                        <span class="text-sm tracking-wide">
                            Sistem Informasi Perpustakaan Modern
                        </span>

                    </div>


                    {{-- TITLE --}}
                    <h1 class="text-6xl md:text-7xl font-black leading-tight mt-8">

                        Masa Depan

                        <span class="text-blue-300">
                            Perpustakaan
                        </span>

                        Dimulai Hari Ini

                    </h1>


                    {{-- DESC --}}
                    <p class="mt-8 text-blue-100 text-xl leading-relaxed max-w-2xl">

                        Platform perpustakaan digital modern
                        dengan sistem peminjaman,
                        e-library, reservasi buku,
                        kode_buku scanner, dan laporan otomatis.

                    </p>


                    {{-- BUTTON --}}
                    <div class="flex flex-wrap gap-6 mt-12">

                        <a href="{{ route('opac.index') }}"
                            class="group bg-white text-blue-950 px-10 py-5 rounded-2xl font-bold shadow-2xl hover:scale-105 transition duration-300">

                            <span class="flex items-center gap-3">

                                <span class="text-2xl">
                                    📚
                                </span>

                                Jelajahi Katalog

                            </span>

                        </a>


                        <a href="{{ route('register') }}"
                            class="group bg-gradient-to-r from-cyan-400 to-blue-500 px-10 py-5 rounded-2xl font-bold shadow-2xl hover:scale-105 transition duration-300">

                            <span class="flex items-center gap-3 text-white">

                                <span class="text-2xl">
                                    🚀
                                </span>

                                Mulai Sekarang

                            </span>

                        </a>

                    </div>


                    {{-- STATS --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-5 mt-16 max-w-3xl">

                        {{-- Koleksi --}}
                        <div
                            class="bg-white/10 backdrop-blur-xl border border-white/10 rounded-3xl p-5 text-center hover:bg-white/20 transition duration-300 hover:-translate-y-2">

                            <div class="text-3xl mb-4">
                                📚
                            </div>

                            <h3 class="text-4xl font-black text-white">
                                200+
                            </h3>

                            <p class="text-sm text-blue-100 mt-2">
                                Koleksi Buku
                            </p>

                        </div>


                        {{-- Anggota --}}
                        <div
                            class="bg-white/10 backdrop-blur-xl border border-white/10 rounded-3xl p-5 text-center hover:bg-white/20 transition duration-300 hover:-translate-y-2">

                            <div class="text-3xl mb-4">
                                👥
                            </div>

                            <h3 class="text-4xl font-black text-white">
                                50+
                            </h3>

                            <p class="text-sm text-blue-100 mt-2">
                                Anggota
                            </p>

                        </div>


                        {{-- Online --}}
                        <div
                            class="bg-white/10 backdrop-blur-xl border border-white/10 rounded-3xl p-5 text-center hover:bg-white/20 transition duration-300 hover:-translate-y-2">

                            <div class="text-3xl mb-4">
                                ⚡
                            </div>

                            <h3 class="text-4xl font-black text-white">
                                24/7
                            </h3>

                            <p class="text-sm text-blue-100 mt-2">
                                Akses Online
                            </p>

                        </div>


                        {{-- E-Library --}}
                        <div
                            class="bg-white/10 backdrop-blur-xl border border-white/10 rounded-3xl p-5 text-center hover:bg-white/20 transition duration-300 hover:-translate-y-2">

                            <div
                                class="w-14 h-14 mx-auto rounded-2xl bg-red-400/20 border border-white/10 flex items-center justify-center text-3xl mb-4">

                                📄

                            </div>

                            <h3 class="text-2xl font-black text-white">
                                E-Library
                            </h3>

                            <p class="text-sm text-blue-100 mt-2">
                                Buku PDF Digital
                            </p>

                        </div>

                    </div>
                </div>
                {{-- RIGHT --}}
                <div class="hidden lg:flex justify-center relative">

                    {{-- glow --}}
                    <div class="absolute w-[450px] h-[450px] bg-cyan-400/20 rounded-full blur-3xl animate-pulse">
                    </div>


                    {{-- MAIN CARD --}}
                    <div
                        class="relative w-[500px] h-[500px] rounded-[40px] bg-white/10 backdrop-blur-2xl border border-white/10 shadow-2xl flex items-center justify-center overflow-hidden floating-card">

                        {{-- top floating --}}
                        <div
                            class="absolute top-10 left-10 bg-white/10 backdrop-blur-xl rounded-2xl px-6 py-4 shadow-xl floating-card">

                            <div class="text-4xl">
                                📘
                            </div>

                        </div>


                        {{-- bottom floating --}}
                        <div
                            class="absolute bottom-10 right-10 bg-white/10 backdrop-blur-xl rounded-2xl px-6 py-4 shadow-xl floating-card">

                            <div class="text-4xl">
                                📚
                            </div>

                        </div>

                        {{-- badge online --}}
                        <div
                            class="absolute top-8 left-1/2 -translate-x-1/2 z-30 bg-cyan-400 text-blue-950 font-extrabold px-8 py-4 rounded-2xl shadow-[0_20px_60px_rgba(34,211,238,0.45)] border border-cyan-200 whitespace-nowrap">

                            ⚡ Online 24/7

                        </div>


                        {{-- center --}}
                        <div
                            class="w-64 h-64 rounded-full bg-gradient-to-br from-cyan-400/30 to-blue-500/30 flex items-center justify-center border border-white/10 shadow-2xl backdrop-blur-xl">

                            <div class="text-[120px] animate-pulse">
                                🌐
                            </div>

                        </div>


                        {{-- mini icon --}}
                        <div class="absolute top-24 right-20 text-5xl floating-card">
                            📖
                        </div>

                        <div class="absolute bottom-24 left-20 text-5xl floating-card">
                            💻
                        </div>

                        <div class="absolute top-40 left-16 text-4xl floating-card">
                            ☁️
                        </div>

                        <div class="absolute bottom-40 right-28 text-4xl floating-card">
                            🔍
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- FITUR --}}
    <section id="fitur" class="max-w-7xl mx-auto px-6 py-24">

        <div class="text-center mb-16">

            <h2 class="text-5xl font-black text-blue-950">
                Fitur Unggulan
            </h2>

            <p class="text-slate-500 mt-4 text-lg">
                Semua kebutuhan perpustakaan dalam satu platform modern
            </p>

        </div>


        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">

            <div
                class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl hover:-translate-y-3 transition duration-500 border border-slate-100">

                <div class="w-16 h-16 rounded-2xl bg-blue-100 text-3xl flex items-center justify-center mb-6">
                    📖
                </div>

                <h3 class="text-2xl font-bold text-blue-950 mb-3">
                    OPAC
                </h3>

                <p class="text-slate-500 leading-relaxed">
                    Cari buku dengan cepat berdasarkan kategori,
                    penulis, atau judul.
                </p>

            </div>


            <div
                class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl hover:-translate-y-3 transition duration-500 border border-slate-100">

                <div class="w-16 h-16 rounded-2xl bg-green-100 text-3xl flex items-center justify-center mb-6">
                    🔄
                </div>

                <h3 class="text-2xl font-bold text-blue-950 mb-3">
                    Peminjaman
                </h3>

                <p class="text-slate-500 leading-relaxed">
                    Kelola peminjaman dan pengembalian buku
                    secara digital.
                </p>

            </div>


            <div
                class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl hover:-translate-y-3 transition duration-500 border border-slate-100">

                <div class="w-16 h-16 rounded-2xl bg-orange-100 text-3xl flex items-center justify-center mb-6">
                    ☁️
                </div>

                <h3 class="text-2xl font-bold text-blue-950 mb-3">
                    E-Library
                </h3>

                <p class="text-slate-500 leading-relaxed">
                    Baca buku digital kapan saja
                    langsung dari sistem.
                </p>

            </div>


            <div
                class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl hover:-translate-y-3 transition duration-500 border border-slate-100">

                <div class="w-16 h-16 rounded-2xl bg-purple-100 text-3xl flex items-center justify-center mb-6">
                    📊
                </div>

                <h3 class="text-2xl font-bold text-blue-950 mb-3">
                    Laporan
                </h3>

                <p class="text-slate-500 leading-relaxed">
                    Statistik dan laporan otomatis
                    berbasis realtime.
                </p>

            </div>

        </div>

    </section>



    {{-- FOOTER --}}
    <footer id="tentang"
        class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-blue-950 to-indigo-950 text-white">

        {{-- background glow --}}
        <div class="absolute inset-0 overflow-hidden">

            <div class="absolute top-0 left-0 w-[350px] h-[350px] bg-cyan-400/10 rounded-full blur-3xl">
            </div>

            <div class="absolute bottom-0 right-0 w-[300px] h-[300px] bg-blue-500/10 rounded-full blur-3xl">
            </div>

        </div>


        <div class="relative z-10 max-w-7xl mx-auto px-6 py-20">

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-12">

                {{-- BRAND --}}
                <div>

                    <div class="flex items-center gap-4 mb-6">

                        <div
                            class="w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-400 to-blue-500 flex items-center justify-center text-2xl shadow-2xl">

                            📚

                        </div>

                        <div>

                            <h2 class="text-3xl font-black">
                                SMPD
                            </h2>

                            <p class="text-blue-200 text-sm">
                                Sistem Manajemen Perpustakaan Daerah
                            </p>

                        </div>

                    </div>

                    <p class="text-blue-100 leading-relaxed">

                        Sistem perpustakaan digital modern
                        untuk pengelolaan buku, anggota,
                        peminjaman, e-library, dan laporan otomatis.

                    </p>

                </div>


                {{-- MENU --}}
                <div>

                    <h3 class="text-xl font-bold mb-6">
                        Navigasi
                    </h3>

                    <div class="space-y-4">

                        <a href="{{ route('landing') }}"
                            class="block text-blue-100 hover:text-white hover:translate-x-2 transition duration-300">

                            Home

                        </a>

                        <a href="#fitur"
                            class="block text-blue-100 hover:text-white hover:translate-x-2 transition duration-300">

                            Fitur Sistem

                        </a>

                        <a href="{{ route('opac.index') }}"
                            class="block text-blue-100 hover:text-white hover:translate-x-2 transition duration-300">

                            Public OPAC

                        </a>

                        <a href="{{ route('login') }}"
                            class="block text-blue-100 hover:text-white hover:translate-x-2 transition duration-300">

                            Login

                        </a>

                    </div>

                </div>


                {{-- FITUR --}}
                <div>

                    <h3 class="text-xl font-bold mb-6">
                        Fitur
                    </h3>

                    <div class="space-y-4 text-blue-100">

                        <div class="flex items-center gap-3">
                            <span>📖</span>
                            <span>Digital OPAC</span>
                        </div>

                        <div class="flex items-center gap-3">
                            <span>☁️</span>
                            <span>E-Library PDF</span>
                        </div>

                        <div class="flex items-center gap-3">
                            <span>📊</span>
                            <span>Laporan Realtime</span>
                        </div>

                        <div class="flex items-center gap-3">
                            <span>🔍</span>
                            <span>kode_buku Scanner</span>
                        </div>

                    </div>

                </div>


                {{-- CONTACT --}}
                <div>

                    <h3 class="text-xl font-bold mb-6">
                        Kontak
                    </h3>

                    <div class="space-y-5 text-blue-100">

                        <div class="flex items-start gap-4">

                            <div
                                class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center backdrop-blur-xl">

                                📍

                            </div>

                            <div>

                                <p class="font-semibold text-white">
                                    Lokasi
                                </p>

                                <p class="text-sm">
                                    Palembang, Indonesia
                                </p>

                            </div>

                        </div>


                        <div class="flex items-start gap-4">

                            <div
                                class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center backdrop-blur-xl">

                                📧

                            </div>

                            <div>

                                <p class="font-semibold text-white">
                                    Email
                                </p>

                                <p class="text-sm">
                                    SMPDtem@gmail.com
                                </p>

                            </div>

                        </div>


                        <div class="flex items-start gap-4">

                            <div
                                class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center backdrop-blur-xl">

                                ☎️

                            </div>

                            <div>

                                <p class="font-semibold text-white">
                                    Telepon
                                </p>

                                <p class="text-sm">
                                    +62 812 3456 7890
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- BOTTOM --}}
            <div
                class="border-t border-white/10 mt-16 pt-8 flex flex-col md:flex-row justify-between items-center gap-5">

                <p class="text-blue-200 text-sm">
                    © 2026 SMPD — All Rights Reserved
                </p>

                <div class="flex items-center gap-5 text-blue-200 text-sm">

                    <span class="hover:text-white transition cursor-pointer">
                        Privacy Policy
                    </span>

                    <span class="hover:text-white transition cursor-pointer">
                        Terms
                    </span>

                    <span class="hover:text-white transition cursor-pointer">
                        Support
                    </span>

                </div>

            </div>

        </div>

    </footer>

</body>

</html>
