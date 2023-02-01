<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyFirebaseToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->user('customer-api')->customerDetails->firebase_token !== $request->header('firebase-token') )
        {
           return sendError('Invalid Firebase Token',[],401);
            //abort(response()->json(['error' => 'Invalid Firebase Token.'], 401));
        }
        return $next($request);
    }
}
