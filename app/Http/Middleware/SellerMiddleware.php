<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SellerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role !== 'seller') {
            abort(403, 'Unauthorized access');
        }

        // Check if seller profile is approved
        if (auth()->user()->seller && auth()->user()->seller->status !== 'approved') {
            return redirect()->route('seller.pending')->with('error', 'Your seller account is pending approval');
        }

        return $next($request);
    }
}
