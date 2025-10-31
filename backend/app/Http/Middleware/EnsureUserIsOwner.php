<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsOwner
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->role !== 'owner') {
            return response()->json(['error' => 'Access denied: owners only'], 403);
        }

        return $next($request);
    }
}

