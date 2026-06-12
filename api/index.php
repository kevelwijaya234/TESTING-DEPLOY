<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1. Alihkan folder penyimpan sementara ke memori Vercel (/tmp)
$storagePath = '/tmp/storage/framework';
if (!is_dir($storagePath . '/views')) {
    mkdir($storagePath . '/views', 0755, true);
    mkdir($storagePath . '/cache', 0755, true);
    mkdir($storagePath . '/sessions', 0755, true);
}

putenv("LOG_CHANNEL=stderr");
putenv("VIEW_COMPILED_PATH={$storagePath}/views");
putenv("CACHE_STORE=file");
putenv("SESSION_DRIVER=cookie");

// 2. Muat Laravel Bootstrap
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->useStoragePath('/tmp/storage');

// 3. JEMBATAN PENYELAMAT: Daftarkan View Service Provider secara paksa agar class [view] tidak hilang!
$app->register(\Illuminate\View\ViewServiceProvider::class);

// 4. Jalankan Kernel HTTP Laravel
try {
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    )->send();

    $kernel->terminate($request, $response);
} catch (\Exception $e) {
    echo "<h2>Laravel Core Crash Terdeteksi!</h2>";
    echo "<h3>Pesan Error Asli:</h3>";
    echo "<pre style='background:#fff0f0; padding:15px; border:1px solid #ffa0a0; color:red; font-size:14px;'>" . $e->getMessage() . "</pre>";
    echo "<h3>File Penyebab:</h3>";
    echo "<pre>" . $e->getFile() . " (Line: " . $e->getLine() . ")</pre>";
}
