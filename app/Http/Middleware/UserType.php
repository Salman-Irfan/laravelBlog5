<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $userType): Response
    {
        // catch the user
        $user = $request->user();

        // // check the user type
        if ($user->userType!= $userType) {
            return response()->json([
                'message' => 'You are not authorized to access this resource',
                'userType' => $userType,
                'inputUserFromDb' => $user->userType
            ]);
        }
        
        return $next($request);
    }
}
