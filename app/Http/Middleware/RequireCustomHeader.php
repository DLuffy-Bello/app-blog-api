<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireCustomHeader
{

    /**
     * The required headers to check for.
     */
    private array $requiredHeaders = [
        'X-User-ID' => 'User ID is required',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        foreach ($this->requiredHeaders as $header => $message) {
            if (!$request->hasHeader($header)) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 400);
            }
        }

        return $next($request);
    }
}
