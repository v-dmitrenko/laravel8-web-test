<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class CORS
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (! $response instanceof SymfonyResponse) {
            $response = new Response($response);
        }

        $response->headers->set('Access-Control-Allow-Origin', '*');

        // ALLOW OPTIONS METHOD
        $headers = [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin, Authorization'
        ];

        if ($request->getMethod() == "OPTIONS") {
            // The client-side application can set only headers allowed in Access-Control-Allow-Headers
            //return \Response::make('OK', 200, $headers);
            return response('OK', 200)->withHeaders($headers);
        }

        foreach ($headers as $key => $value) {
            //$response->header($key, $value);
            $response->headers->set($key, $value);
        }

        return $response;
    }
}
