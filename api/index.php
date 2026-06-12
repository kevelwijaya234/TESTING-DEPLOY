<?php

// 1. Paksa tampilkan error murni jika ada masalah internal
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Muat autoloader vendor
require __DIR__ . '/../vendor/autoload.php';

// 3. Alihkan folder penyimpan cache & views secara paksa ke folder temporer Vercel
$storagePath = '/tmp/storage/framework';
if (!is_dir($storagePath . '/views')) {
    mkdir($storagePath . '/views', 0755, true);
    mkdir($storagePath . '/cache', 0755, true);
    mkdir($storagePath . '/sessions', 0755, true);
}

// Set variabel lingkungan agar Laravel tahu folder penulisan log & view-nya aman
putenv("VIEW_COMPILED_PATH={$storagePath}/views");
putenv("LOG_CHANNEL=stderr"); // Paksa log dikirim ke sistem Vercel, bukan nulis file log

// 4. Muat bootstrap aplikasi
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->useStoragePath('/tmp/storage');

// 5. Jalankan Kernel Laravel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);
