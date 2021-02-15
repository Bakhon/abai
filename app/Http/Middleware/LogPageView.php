<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LogPageView
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $excludedUrls = [
            '(.*)/js/lang.js',
            '/'
        ];

        foreach($excludedUrls as $url) {
            if(preg_match("#^{$url}$#", $request->path())) {
                return $next($request);
            }
        }

        if(auth()->check() && !$request->ajax()) {
            \App\Models\LogPageView::create([
                'user_id' => auth()->id(),
                'url' => $request->path()
            ]);
        }

        return $next($request);
    }
}
