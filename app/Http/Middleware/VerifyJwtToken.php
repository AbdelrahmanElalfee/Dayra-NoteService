<?php

namespace App\Http\Middleware;

use App\Exceptions\GeneralException;
use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class VerifyJwtToken
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     *
     * @throws Throwable
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$token = $request->bearerToken()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        try {
            // withoutVerifying() to disable ssl certificate verification (use it in local)
            Http::withoutVerifying()->withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get(env('USER_MANAGEMENT_SERVICE_URI') . '/api/auth');
        } catch (\Exception $e) {
            throw new GeneralException($e->getMessage(), 401);
        }

        return $next($request);
    }
}
