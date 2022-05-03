<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class IsAdmin
{
    /**
     * @param  Request  $request
     */
    public function handle($request, Closure $next): mixed
    {
        if (Auth::user() and Auth::user()->isAdministrator() == 1) {
            return $next($request);
        }
        abort(403);
    }
}
