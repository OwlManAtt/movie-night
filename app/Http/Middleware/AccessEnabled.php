<?php

namespace App\Http\Middleware;

use Closure;

class AccessEnabled
{
    public function handle($request, Closure $next)
    {
        if (optional($request->user())->app_access_enabled === true) {
            return $next($request);
        }

        return redirect(route('login'));
    }
}
