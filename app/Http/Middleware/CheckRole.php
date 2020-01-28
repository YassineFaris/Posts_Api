<?php

namespace App\Http\Middleware;

use Response;
use Closure;
use JWTAuth;
use Exception;
use Illuminate\Support\Facades\Crypt;

class CheckRole
{
    public function handle($request, Closure $next)
    {
        try
        {
            // route api roles valide
            $actions = $request->route()->getAction('roles');
            //front end user id_role in token
            $role = Crypt::decryptString(JWTAuth::parseToken()->getPayload()->get('id_role'));

            if (in_array($role, $actions))
            {
                return $next($request);
            }
            else
            {
                return Response::json(
                [
                    'Api Error message' => 'Access Denied'
                ],401);
            }
        }
        catch (Exception $e)
        {
            return Response::json(
            [
                'Api Error message' => 'Access Denied',
                'Error' => $e
            ],401);
        }
    }
}
