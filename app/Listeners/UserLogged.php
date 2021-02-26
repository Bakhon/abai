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
        $base64 = null;

        if (!empty($event->user->thumbnailphoto)) {
            $base64 = 'data:image/jpeg;base64,' . base64_encode($event->user->thumbnailphoto[0]);
        }

        /** @var \App\User $user */
        $user = $event->model;

        $user->profile->update(
            [
                'thumb' => $base64,
                'department' => $event->user->department ? $event->user->department[0] : null,
                'org' => $event->user->company ? $event->user->company[0] : null,
                'phone' => $event->user->telephonenumber ? $event->user->telephonenumber[0] : null,
                'mobile' => $event->user->mobile ? $event->user->mobile[0] : null,
                'email' => $event->user->mail ? $event->user->mail[0] : null
            ]
        );
        $user->profile->save();


        $user->last_authorized_at = \Carbon\Carbon::now();
        $user->save();
    }
}
