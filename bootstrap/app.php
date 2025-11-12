<?php

use App\Http\Middleware\RequireCustomHeader;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(append: [
            RequireCustomHeader::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // ==========================================
        // MÉTODO NO PERMITIDO (405)
        // ==========================================
        $exceptions->render(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'HTTP method not allowed',
                    'error_code' => 'METHOD_NOT_ALLOWED',
                ], 405);
            }
        });

        // ==========================================
        // EXCEPCIONES HTTP (400, 401, 403, 404, etc)
        // ==========================================
        $exceptions->render(function (HttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage() ?: 'Request error',
                    'error_code' => 'HTTP_EXCEPTION',
                ], $e->getStatusCode());
            }
        });

        // ==========================================
        // ERRORES DE BASE DE DATOS
        // ==========================================
        $exceptions->render(function (QueryException $e, $request) {
            if ($request->is('api/*')) {
                Log::error('Database error', [
                    'message' => $e->getMessage(),
                    'sql' => $e->getSql(),
                    'bindings' => $e->getBindings(),
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                ]);

                $message = config('app.debug')
                    ? 'Database error: ' . $e->getMessage()
                    : 'Database error';

                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'error_code' => 'DATABASE_ERROR',
                ], 500);
            }
        });

        // ==========================================
        // ERRORES DE VALIDACIÓN (422)
        // ==========================================
        $exceptions->render(function (ValidationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'error_code' => 'VALIDATION_ERROR',
                    'errors' => $e->errors(),
                ], 422);
            }
        });

        // ==========================================
        // CATCH-ALL - CUALQUIER OTRA EXCEPCIÓN
        // ==========================================
        $exceptions->render(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                Log::error('Unhandled API error', [
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);

                // Don't show error details in production
                $message = config('app.debug')
                    ? $e->getMessage()
                    : 'Internal server error';

                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'error_code' => 'INTERNAL_SERVER_ERROR',
                ], 500);
            }
        });
    })->create();
