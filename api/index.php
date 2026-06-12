<?php

// 1. Tampilkan error mentah PHP jika bootstrap gagal
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Siapkan folder memori sementara Vercel (/tmp)
$storagePath = '/tmp/storage/framework';
if (!is_dir($storagePath . '/views')) {
    @mkdir($storagePath . '/views', 0755, true);
    @mkdir($storagePath . '/cache', 0755, true);
    @mkdir($storagePath . '/sessions', 0755, true);
}

// 3. PAKSA MODE DEBUG: Matikan caching dan nyalakan deteksi error Laravel secara agresif
putenv("APP_DEBUG=true");
putenv("APP_ENV=local");
putenv("LOG_CHANNEL=stderr");
putenv("VIEW_COMPILED_PATH={$storagePath}/views");
putenv("CACHE_STORE=file");
putenv("SESSION_DRIVER=cookie");

// 4. Muat Autoloader dan Aplikasi Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->useStoragePath('/tmp/storage');

// 5. Daftarkan Service Provider inti secara manual
$app->register(\Illuminate\Events\EventServiceProvider::class);
$app->register(\Illuminate\Filesystem\FilesystemServiceProvider::class);
$app->register(\Illuminate\View\ViewServiceProvider::class);

// 6. Jalankan Kernel HTTP Laravel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);
