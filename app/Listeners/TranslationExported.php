<?php

namespace App\Listeners;

class TranslationExported
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     */
    public function handle()
    {
        foreach(\App\Http\Middleware\LocaleMiddleware::$languages as $lang) {
            \Illuminate\Support\Facades\Cache::forget('lang_' . $lang . '.js');
        }
    }
}
