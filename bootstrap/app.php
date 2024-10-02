<?php

use App\Http\Middleware\CheckUserType;
use App\Http\Middleware\FacultyRedirect;
use App\Http\Middleware\Handle419Error;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsAuthenticated;
use App\Http\Middleware\IsGuest;
use App\Http\Middleware\IsOtherAccess;
use App\Http\Middleware\IsSuperadmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('auth_check', [
            IsAuthenticated::class,
        ]);

        $middleware->appendToGroup('guest', [
            IsGuest::class,
        ]);

        $middleware->appendToGroup('Superadmin', [
            IsSuperadmin::class,
            IsAdmin::class,
        ]);

        $middleware->appendToGroup('OtherAccess', [
            IsOtherAccess::class,
        ]);

        $middleware->appendToGroup('faculty', [
            FacultyRedirect::class,
        ]);

        $middleware->appendToGroup('419', [
            Handle419Error::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
