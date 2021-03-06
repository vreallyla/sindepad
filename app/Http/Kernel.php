<?php

namespace App\Http;

use App\Http\Middleware\accessMiddleware;
use App\Http\Middleware\justShadowMiddleware;
use App\Http\Middleware\jwtMiddleware;
use App\Http\Middleware\order\handdleTfMiddleware;
use App\Http\Middleware\orderMiddleware;
use App\Http\Middleware\redirectMiddleware;
use App\Http\Middleware\reMiddleware;
use App\Http\Middleware\Role\justAdminMiddleware;
use App\Http\Middleware\Role\justInController;
use App\Http\Middleware\Role\UserMiddleware;
use App\Http\Middleware\validUserMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'anu' => reMiddleware::class,
        'order' => justInController::class,
        'redirectLogin' => redirectMiddleware::class,
        'adminRole' => justAdminMiddleware::class,
        'shadowRole' => justShadowMiddleware::class,
        'jwttes' => jwtMiddleware::class,
        'access' => accessMiddleware::class,
        'user_role'=>UserMiddleware::class,
        'user_permissions'=>validUserMiddleware::class,
        'method_permissions'=>handdleTfMiddleware::class
    ];
}
