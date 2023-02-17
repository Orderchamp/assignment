<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class GuestCartMiddleware
{
    public function handle($request, Closure $next)
    {
        $guestCartId = $request->cookie('guest_cart_id');

        if (empty($guestCartId)) {
            $guestCartId = Str::uuid()->toString();
            $response = $next($request);
            $response->withCookie(cookie('guest_cart_id', $guestCartId, 60 * 24 * 365));
            $request->session()->put('guest_cart', [
                'cart_items' => [],
                'ttl' => now()->addDays(7),
            ]);
        } else {
            $guestCart = $request->session()->get('guest_cart');

            if ($guestCart === null) {
                $guestCart = [
                    'cart_items' => [],
                    'ttl' => now()->addDays(7),
                ];
                $request->session()->put('guest_cart', $guestCart);
            }
            $response = $next($request);
        }

        return $response;
    }
}
