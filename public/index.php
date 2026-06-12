<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Cek apakah aplikasi sedang dalam mode perbaikan (maintenance)...
if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Daftarkan Auto Loader Composer
require __DIR__ . '/../vendor/autoload.php';

// Jalankan Bootstrap Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Meminta Kernel untuk menangani Request secara benar sesuai arsitektur Laravel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
