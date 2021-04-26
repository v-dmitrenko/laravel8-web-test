<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return response()->json(['error' => 'Token is Invalid'], HttpResponse::HTTP_UNAUTHORIZED); //401
            } elseif ($e instanceof TokenExpiredException) {
                return response()->json(['error' => 'Token is Expired'], HttpResponse::HTTP_UNAUTHORIZED); //401
            } else {
                return response()->json(['error' => 'Authorization Token not found'], HttpResponse::HTTP_UNAUTHORIZED);
            }
        }
        return $next($request);
    }
}
