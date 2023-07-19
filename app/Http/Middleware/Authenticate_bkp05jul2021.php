<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Auth\Middleware\Authenticate as Middleware;
// use Illuminate\Support\Arr;

// class Authenticate extends Middleware
// {
//     /**
//      * Get the path the user should be redirected to when they are not authenticated.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  \Closure  $next
//      * @param  string|null  $guard
//      * @return mixed
//      * @return string|null
//      */
//     protected function redirectTo($request)
//     {
//         if (! $request->expectsJson()) {
//             return route('login');
//         }
//     }
//     public function handle($request, Closure $next, $guard = null)
//     {
//       switch($guard){
//         case 'admin':
//             if (Auth::guard($guard)->check()) {
//                 return redirect('/admin');
//             }
//             break;
//         default:
//             if (Auth::guard($guard)->check()) {
//                 return redirect('/');
//             }
//             break;
//     }
//       return $next($request);
//     }
// }

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Arr;

class Authenticate extends Middleware
{
    protected $guards = [];
     /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string[] ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this->guards = $guards;

        return parent::handle($request, $next, ...$guards);
    }
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if (Arr::first($this->guards) === 'admin') {
                return route('admin.login');
            }
            return '/';
        }

    }

}