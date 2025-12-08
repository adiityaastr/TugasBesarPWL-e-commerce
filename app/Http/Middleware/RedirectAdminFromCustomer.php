<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectAdminFromCustomer
{
    /**
     * Prevent admin users from accessing customer-facing pages.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Admin hanya dapat mengakses area penjual.');
        }

        return $next($request);
    }
}

