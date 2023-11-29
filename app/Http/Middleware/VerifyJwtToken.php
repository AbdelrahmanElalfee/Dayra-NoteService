<?php

namespace App\Http\Middleware;

use App\Exceptions\GeneralException;
use App\Helpers\UserInternalApi;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Psr\Http\Message\RequestInterface;
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
        $id = UserInternalApi::getUserId($token);
        throw_if(!$id, GeneralException::class, 'Invalid token', 401);
        Auth::loginUsingId($id);
        return $next($request);
    }
}
