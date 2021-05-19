<?php

namespace App\Http\Middleware;

use Closure;

class EconomyApiAuthentication
{
    const API_KEY_HEADER = 'api-key';

    private $tokens = [
        '1234',
        '12345',
        '123456',
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header(self::API_KEY_HEADER);

        if($token === null or $token == ''){
            return response()->json(['success'=> false, 'message'=>'Unauthorized'], 401);
        }

        if(!in_array($token, $this->tokens)){
            return response()->json(['success'=> false, 'message'=>'Unauthorized'], 401);
        }

        return $next($request);
    }
}
