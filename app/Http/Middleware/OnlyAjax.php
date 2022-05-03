<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

final class OnlyAjax
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (!$request->ajax()) {
            abort(404);
        }

        return $next($request);
    }
}
