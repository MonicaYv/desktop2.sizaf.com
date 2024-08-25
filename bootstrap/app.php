<?php

use App\Http\Middleware\CspMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(CspMiddleware::class);
        $middleware->validateCsrfTokens(except: [
            'registerfacedata',
        ]);
        $middleware->alias([
            'blockIP' => \App\Http\Middleware\BlockIpMiddleware::class,
            'checkPermis.fileManager' => \App\Http\Middleware\CheckPermission::class,
            'checkPermis.backendManagement' => \App\Http\Middleware\CheckPermission::class,
            'checkPermis.userManagement' => \App\Http\Middleware\CheckPermission::class,
            'checkPermis.roleManagement' => \App\Http\Middleware\CheckPermission::class,
            'checkPermis.groupsManagement' => \App\Http\Middleware\CheckPermission::class,
        ]);        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
?>