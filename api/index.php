<?php

// 1. Paksa sistem untuk menampilkan error secara visual di browser jika terjadi crash
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Muat dependensi utama Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Daftarkan dan jalankan Kernel Konsol (Wajib untuk Artisan)
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// 4. Eksekusi perintah migrasi menggunakan Symfony Input/Output (Sangat Stabil di Vercel)
try {
    echo "<h2>Koneksi Serverless Vercel: Sukses!</h2>";
    echo "Menghubungkan ke database Clever Cloud...<br>";
    echo "Memulai proses migrasi tabel Laravel...<br><br>";

    // Membuat objek penampung log output
    $output = new \Symfony\Component\Console\Output\BufferedOutput;

    // Menjalankan perintah php artisan migrate --force
    \Illuminate\Support\Facades\Artisan::call('migrate --force', [], $output);

    echo "<span style='color:green; font-weight:bold;'>✔ MIGRASI SELESAI DAN BERHASIL!</span><br>";
    echo "<h3>Log Database:</h3>";
    echo "<pre style='background:#f4f4f4; padding:10px; border:1px solid #ddd;'>" . $output->fetch() . "</pre>";
} catch (\Exception $e) {
    echo "<span style='color:red; font-weight:bold;'>❌ MIGRASI GAGAL! Terjadi kendala konfigurasi:</span><br>";
    echo "<h3>Pesan Error:</h3>";
    echo "<pre style='background:#fff0f0; padding:10px; border:1px solid #ffa0a0; color:red;'>" . $e->getMessage() . "</pre>";
}
