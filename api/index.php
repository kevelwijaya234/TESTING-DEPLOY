<?php

// 1. Aktifkan penanganan error PHP murni
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Alihkan folder penulisan log, views, dan cache secara paksa ke memori sementara Vercel
$storagePath = '/tmp/storage/framework';
if (!is_dir($storagePath . '/views')) {
    mkdir($storagePath . '/views', 0755, true);
    mkdir($storagePath . '/cache', 0755, true);
    mkdir($storagePath . '/sessions', 0755, true);
}

// 3. Paksa Laravel mengirim error ke sistem log Vercel (bukan menulis ke file laravel.log)
putenv("LOG_CHANNEL=stderr");
putenv("VIEW_COMPILED_PATH={$storagePath}/views");
putenv("CACHE_STORE=file");
putenv("SESSION_DRIVER=cookie"); // Hindari penulisan file session yang bikin crash

// 4. Muat Laravel Bootstrap secara aman
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->useStoragePath('/tmp/storage');

// 5. Jalankan Kernel Laravel menggunakan blok Try-Catch untuk menangkap error tersembunyi
try {
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    )->send();

    $kernel->terminate($request, $response);
} catch (\Exception $e) {
    // Jika Laravel crash, paksa errornya tercetak di layar browser Anda!
    echo "<h2>Laravel Core Crash Terdeteksi!</h2>";
    echo "<h3>Pesan Error Asli:</h3>";
    echo "<pre style='background:#fff0f0; padding:15px; border:1px solid #ffa0a0; color:red; font-size:14px;'>" . $e->getMessage() . "</pre>";
    echo "<h3>File Penyebab:</h3>";
    echo "<pre>" . $e->getFile() . " (Line: " . $e->getLine() . ")</pre>";
    echo "<h3>Trace:</h3>";
    echo "<pre style='font-size:11px;'>" . $e->getTraceAsString() . "</pre>";
}
