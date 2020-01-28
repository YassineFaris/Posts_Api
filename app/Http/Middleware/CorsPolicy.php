<?php

namespace App\Http\Middleware;
use Closure;

class CorsPolicy
{
    public function handle($request, Closure $next)
    {
        // header("Access-Control-Allow-Origin: *");
        $headers = [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Max-Age' => '1000',
            'Access-Control-Allow-Credentials' => true,
            'Access-Control-Allow-Methods' => 'GET,POST',
            'Access-Control-Allow-Headers' => 'X-Requested-With, Content-Type, X-Token-Auth, Authorization, Accept, Origin',
        ];
        $response = $next($request);
        foreach ($headers as $key => $value)
        {
            if(get_class($response) !== "Symfony\Component\HttpFoundation\BinaryFileResponse" )
            {
                $response->header($key, $value);
            }
        }
        return $response;
    }
}
