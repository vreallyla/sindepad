<?php

try {
    (new Dotenv\Dotenv(__DIR__ . '/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    realpath(__DIR__ . '/../')
);

$app->instance('path.config', app()->basePath() . DIRECTORY_SEPARATOR . 'config');
$app->instance('path.storage', app()->basePath() . DIRECTORY_SEPARATOR . 'storage');

$app->withFacades(true, [
    Tymon\JWTAuth\Facades\JWTAuth::class => 'JWTAuth',
    Tymon\JWTAuth\Facades\JWTFactory::class => 'JWTFactory',
    Intervention\Image\Facades\Image::class => 'Image'
]);
//

$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class);
$app->register(Intervention\Image\ImageServiceProvider::class);

$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Api::class
);

//storage
$app->singleton('filesystem', function ($app) {
    return $app->loadComponent('filesystems', 'Illuminate\Filesystem\FilesystemServiceProvider', 'filesystem');
});


/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// Load session config (otherwise it won't be loaded)
//$app->configure('session');

$app->middleware([
//    \Illuminate\Session\Middleware\StartSession::class,
]);

// Add `SessionServiceProvider`
//$app->register(Illuminate\Session\SessionServiceProvider::class);

// fix `BindingResolutionException` problem
//$app->bind(Illuminate\Session\SessionManager::class, function ($app) {
//    return $app->make('session');
//});

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
$app->register(App\Providers\EventServiceProvider::class);

// Add this line
$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class);

//mail set
$app->register(\Illuminate\Mail\MailServiceProvider::class);
$app->configure('mail');

//cache set
//$app->configure('cache');
//$app->singleton(Illuminate\Cache\Repository::class, Illuminate\Contracts\Cache\Repository::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

/*$app->instance('path.config', app()->basePath() . DIRECTORY_SEPARATOR . 'config');
$app->instance('path.storage', app()->basePath() . DIRECTORY_SEPARATOR . 'storage');*/


$app->router->group([
    'namespace' => 'App\Http\Controllers\Api',
], function ($router) {
    require __DIR__ . '/../routes/api.php';
});


$app->routeMiddleware([
    'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
//    'anu' => App\Http\Middleware\reMiddleware::class
    'jwttes' => App\Http\Middleware\jwtMiddleware::class,
    'api_user' => \App\Http\Middleware\Lumen\Role\userMiddleware::class,
    'api_admin' => \App\Http\Middleware\Lumen\Role\adminMiddleware::class,
    'confirm_payment_handdler'=>\App\Http\Middleware\Lumen\transConfirmHanddlerMiddleware::class,
    'confirm_confirm_handdler'=>\App\Http\Middleware\Lumen\transConfTransMiddleware::class
]);

return $app;
