<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

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
            $agent = new Agent();
            $oslogo = '';
            if($agent->is('Windows')){
                $oslogo = 'windows';
            }elseif($agent->is('Ubuntu')){
                $oslogo = 'linux';
            }elseif($agent->is('OS X')){
                $oslogo = 'ios';
            }elseif($agent->is('iPhone')){
                $oslogo = 'ios';
            }elseif($agent->isAndroidOS()){
                $oslogo = 'android';
            }else{}
            \App\Models\LogPageView::create([
                'user_id' => auth()->id(),
                'url' => $request->path(),
                'ip_address' => \Request::ip(),
                'user_os' => $agent->platform(),
                'os_logo' => $oslogo,
                ]);
        }

        return $next($request);
    }
}
