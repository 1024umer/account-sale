<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UsingProxyUser;
use Illuminate\Support\Facades\Auth;

class ProxyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
      // Check if the user is authenticated
      if (Auth::check()) {
          $user = Auth::user();

          // Check if the authenticated user is associated with a proxy
          $proxy_user = UsingProxyUser::where('user_id', $user->id)->first();

          if ($proxy_user) {
              abort(404);
          }
      }

      // Check if there is a proxy user based on the IP address
      $proxy_user_ip = UsingProxyUser::where('ip_address', $request->ip())->first();

      if ($proxy_user_ip) {
          abort(404);
      }

      return $next($request);
  }
}
