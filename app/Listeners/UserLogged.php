<?php

namespace App\Listeners;

use Adldap\Laravel\Events\Authenticated;

class UserLogged
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
     * @param Authenticated $event
     */
    public function handle(Authenticated $event)
    {
        //dd($event->user);
    }
}
