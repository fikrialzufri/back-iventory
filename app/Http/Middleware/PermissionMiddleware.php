<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Traits\HasPermissionsTrait;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $permission)
    {
        if ($request->user()->hasRole('superadmin')) {
            return $next($request);
        }
        if (!$request->user()->can($permission)) {
            $response = [
                'success' => false,
                'data' => '',
                'message' => 'url ada akses',
            ];

            return response()->json($response, 404);
        }

        return $next($request);
    }
}
