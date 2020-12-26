<?php

namespace App\Listeners;

use Adldap\Laravel\Events\AuthenticationSuccessful;

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
     * @param AuthenticationSuccessful $event
     */
    public function handle(AuthenticationSuccessful $event)
    {
        $base64 = 'data:image/jpeg;base64,' . base64_encode($event->user->thumbnailphoto[0]);

        $event->model->thumb = $base64;
        $event->model->last_authorized_at = \Carbon\Carbon::now();
        $event->model->save();

    }
}
