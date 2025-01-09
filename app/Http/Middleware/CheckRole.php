<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!$request->user() || !$request->user()->hasRole($role)) {
            return response()->json([
                'message' => 'Bu işlem için yetkiniz bulunmamaktadır.',
                'error' => 'Unauthorized'
            ], 403);
        }

        return $next($request);
    }
} 