<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EmailActivation
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
        // if ($request->user() &&  && !in_array($request->route()->getName(), ['front.home', 'front.resend-own-email-virefication', 'verification.verify', 'logout'])) {
        if(!$request->user()->hasVerifiedEmail()){
            return redirect()->route('front.home');
        }
        return $next($request);
    }
}
