<?php

// 1. Aktifkan laporan error secara detail
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Muat autoloader Composer dan aplikasi Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. TRIK PENYELAMAT: Alihkan folder storage Laravel ke folder temporary Vercel
$storagePath = '/tmp/storage/framework';
if (!is_dir($storagePath . '/views')) {
    mkdir($storagePath . '/views', 0755, true);
    mkdir($storagePath . '/cache', 0755, true);
    mkdir($storagePath . '/sessions', 0755, true);
}
$app->useStoragePath('/tmp/storage');

// 4. Daftarkan kernel konsol agar perintah Artisan bisa berjalan
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// 5. Eksekusi migrasi database
try {
    echo "<h2>Proses Inisialisasi Serverless Vercel Berhasil!</h2>";
    echo "Memulai migrasi database ke Clever Cloud...<br>";

    // Memicu perintah php artisan migrate --force
    $status = \Illuminate\Support\Facades\Artisan::call('migrate --force');

    echo "<br><b>Migrasi SELESAI!</b><br>";
    echo "Hasil Log:<br><pre>" . \Illuminate\Support\Facades\Artisan::output() . "</pre>";
} catch (\Exception $e) {
    echo "<br><b>Migrasi GAGAL! Terjadi kesalahan pada database:</b><br>";
    echo "<pre>" . $e->getMessage() . "</pre>";
}
