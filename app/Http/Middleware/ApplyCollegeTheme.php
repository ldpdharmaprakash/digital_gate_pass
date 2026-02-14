<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ApplyCollegeTheme
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $college = auth()->user()->college;
            
            if ($college) {
                Session::put('theme_primary', $college->primary_color);
                Session::put('theme_secondary', $college->secondary_color);
                Session::put('college_name', $college->name);
                Session::put('college_code', $college->code);
            }
        }

        return $next($request);
    }
}
