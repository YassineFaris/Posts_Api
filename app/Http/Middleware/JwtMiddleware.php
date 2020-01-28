<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Response;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{
    public function handle($request, Closure $next)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();
        }
        catch (Exception $e)
        {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException)
            {
                return Response::json(['Api_Error_message' => 'Token is Invalid'], 401);
            }
            else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException)
            {
                return Response::json(['Api_Error_message' => 'Token is Expired'], 401);
            }
            else
            {
                return Response::json(
                [
                    'Api_Error_message' => 'Authorization Token not found',
                    'Error' => $e
                ],401);
            }
        }
        return $next($request);
    }
}
