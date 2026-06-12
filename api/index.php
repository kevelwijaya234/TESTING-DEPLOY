<?php

// 1. Tampilkan error mentah jika ada kendala fatal
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

// 3. Suntikkan Environment Variables secara aman untuk lingkungan serverless
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
try {
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    // TRICK PAMUNGKAS: Paksa sistem untuk mengosongkan cache view lama yang merusak render
    if (is_dir($storagePath . '/views')) {
        array_map('unlink', glob("$storagePath/views/*"));
    }

    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    )->send();

    $kernel->terminate($request, $response);
} catch (\Exception $e) {
    echo "<h2>Laravel Core Bridge Error Terdeteksi!</h2>";
    echo "<h3>Pesan Masalah:</h3>";
    echo "<pre style='background:#fff0f0; padding:15px; border:1px solid #ffa0a0; color:red; font-size:14px;'>" . $e->getMessage() . "</pre>";
}
