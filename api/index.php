<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Muat autoloader vendor
require __DIR__ . '/../vendor/autoload.php';

// Muat aplikasi utama
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Jalankan Kernel HTTP Laravel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);
