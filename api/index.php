<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "<h2>Koneksi Serverless Vercel: Berhasil!</h2>";
    echo "Membaca file .env baru dan menghubungkan ke Clever Cloud...<br>";

    $output = new \Symfony\Component\Console\Output\BufferedOutput;

    // Menjalankan migrasi resmi Laravel
    \Illuminate\Support\Facades\Artisan::call('migrate --force', [], $output);

    echo "<span style='color:green; font-weight:bold;'>✔ MIGRASI SELESAI DAN BERHASIL!</span><br>";
    echo "<h3>Log Tabel Terbuat:</h3>";
    echo "<pre style='background:#f4f4f4; padding:10px; border:1px solid #ddd;'>" . $output->fetch() . "</pre>";
} catch (\Exception $e) {
    echo "<span style='color:red; font-weight:bold;'>❌ KONEKSI GAGAL! Periksa kembali data .env Anda:</span><br>";
    echo "<h3>Pesan Error Laravel:</h3>";
    echo "<pre style='background:#fff0f0; padding:10px; border:1px solid #ffa0a0; color:red;'>" . $e->getMessage() . "</pre>";
}
