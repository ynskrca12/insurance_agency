<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckDemoExpiry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Middleware\CheckAdmin;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => CheckAdmin::class,
            'check.demo.expiry' => CheckDemoExpiry::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //  404 Hatası
        $exceptions->render(function (NotFoundHttpException $e, $request) {
            return response()->view('errors.404', [], 404);
        });

        //  403 Hatası
        $exceptions->render(function (HttpException $e, $request) {
            if ($e->getStatusCode() === 403) {
                return response()->view('errors.403', [], 403);
            }
        });

        //  500 Hatası
        $exceptions->render(function (HttpException $e, $request) {
            if ($e->getStatusCode() === 500) {
                return response()->view('errors.500', [], 500);
            }
        });

        //  503 Hatası (Bakım Modu)
        $exceptions->render(function (HttpException $e, $request) {
            if ($e->getStatusCode() === 503) {
                return response()->view('errors.503', [], 503);
            }
        });
    })->create();
