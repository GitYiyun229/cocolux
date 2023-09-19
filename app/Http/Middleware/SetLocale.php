<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
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
        $locale = $request->input('locale');
        if (!in_array($locale, ['en', 'vi'])) {
            $locale = 'vi'; // Nếu không tồn tại, sử dụng ngôn ngữ mặc định
        }
        session(['locale' => $locale]);
        config(['app.locale' => session('locale')]);
        // hoặc
        // $response->cookie('locale', $locale);
//dd(session('locale'));
        return $next($request);
    }
}
