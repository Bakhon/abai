<?php

namespace App\Http\Middleware;

use Closure;
use Request;
use App;

class LocaleMiddleware
{
    public static $mainLanguage = 'ru';
    public static $languages = ['en', 'ru', 'kz'];

    public static function getLocale()
    {
        $uri = Request::path();

        $segmentsURI = explode('/',$uri);

        if (!empty($segmentsURI[0]) && in_array($segmentsURI[0], self::$languages)) {
            return $segmentsURI[0];
        } else {
            return  self::$mainLanguage;
        }
    }

    public function handle($request, Closure $next)
    {
        $locale = self::getLocale();
        if($locale) App::setLocale($locale);

        return $next($request);
    }
}
