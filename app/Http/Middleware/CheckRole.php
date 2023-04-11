<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    //protected $parameter1;
    // public function __construct(string $parameter1)
    // {
    //     dump( $parameter1);

    // }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $route_role)
    {
        $user_role = $request->route('role');

        //dump($request->route);
       //dump($route_role==$user_role);
        if ($route_role!==$user_role) {
            return response()->json(['error'=> 'You do not have the required permissions to access this resource.']);
        }
        return $next($request);

    }
}
