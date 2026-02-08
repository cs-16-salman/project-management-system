<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use App\Http\Middleware\IdentifyTenant;
use Illuminate\Routing\Middleware\ThrottleRequests;
use App\Models\User;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
// use Throwable;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // API rate limiting
        $middleware->appendToGroup('api', \Illuminate\Routing\Middleware\ThrottleRequests::class . ':60,1');

        // Tenant identification
        $middleware->appendToGroup('api', \App\Http\Middleware\IdentifyTenant::class);

        // Permission middleware alias
        $middleware->alias([
            'permission' => \App\Http\Middleware\CheckPermission::class,
        ]);

        $middleware->api(prepend: [
            EnsureFrontendRequestsAreStateful::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {


                if ($e instanceof ValidationException) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validation Failed',
                        'errors' => $e->errors(),
                    ], 422);
                }

                if ($e instanceof HttpExceptionInterface) {
                    return response()->json([
                        'success' => false,
                        'message' => $e->getMessage() ?: 'HTTP Error',
                    ], $e->getStatusCode());
                }

                return response()->json([
                    'success' => false,
                    'message' => config('app.debug') ? $e->getMessage() : 'Server Error',
                ], 500);
            }
        });
    })->create();
