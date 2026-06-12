<?php

// Mengaktifkan laporan error agar kita tahu jika ada masalah database
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Memanggil bootstrap Laravel
require __DIR__ . '/../public/index.php';

// Trik memicu php artisan migrate secara otomatis via kode PHP
try {
    echo "Memulai migrasi database...<br>";
    \Illuminate\Support\Facades\Artisan::call('migrate --force');
    echo "Migrasi SELESAI dan BERHASIL!<br>";
    echo "<hr>Hasil Log:<br><pre>" . \Illuminate\Support\Facades\Artisan::output() . "</pre>";
} catch (\Exception $e) {
    echo "Migrasi GAGAL! Terjadi kesalahan:<br>";
    echo "<pre>" . $e->getMessage() . "</pre>";
}