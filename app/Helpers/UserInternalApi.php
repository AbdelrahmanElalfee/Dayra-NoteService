<?php

namespace App\Helpers;

use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Http;
use Psr\Http\Message\RequestInterface;

class UserInternalApi {

    /**
     * @throws GeneralException
     */
    public static function getUserId($token) {
        // withoutVerifying() to disable ssl certificate verification (use it local)
        $response = Http::withoutVerifying()
            ->withRequestMiddleware(function (RequestInterface $request) use ($token) {
                return $request->withHeader('Authorization', 'Bearer ' . $token);
            })
            ->get(env('USER_MANAGEMENT_SERVICE_URI') . '/api/auth');

        if ($response->clientError()) {
            throw new GeneralException('Invalid token', 401);
        }

        return $response->json('data');
    }
}
