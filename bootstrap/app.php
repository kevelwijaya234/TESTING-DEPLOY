<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Trik memaksa folder storage pindah ke /tmp jika berjalan di Vercel
if (env('VERCEL_ENV') || isset($_SERVER['VERCEL_URL'])) {
    $storagePath = '/tmp/storage/framework';
    if (!is_dir($storagePath . '/views')) {
        @mkdir($storagePath . '/views', 0755, true);
        @mkdir($storagePath . '/cache', 0755, true);
        @mkdir($storagePath . '/sessions', 0755, true);
    }
    putenv("VIEW_COMPILED_PATH={$storagePath}/views");
    putenv("LOG_CHANNEL=stderr");
    putenv("SESSION_DRIVER=cookie");
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
