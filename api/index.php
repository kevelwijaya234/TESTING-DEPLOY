<?php

// 1. Paksa Vercel menampilkan error di layar jika ada typo kode
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Muat dependensi bawaan Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. JALUR AMAN: Paksa Laravel menulis cache & session ke folder temporary Vercel
$storagePath = '/tmp/storage/framework';
if (!is_dir($storagePath . '/views')) {
    mkdir($storagePath . '/views', 0755, true);
    mkdir($storagePath . '/cache', 0755, true);
    mkdir($storagePath . '/sessions', 0755, true);
}
$app->useStoragePath('/tmp/storage');

// 4. Jalankan aplikasi Laravel lewat Kernel HTTP secara aman
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);
