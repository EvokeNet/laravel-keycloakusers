<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Util\KeyCloak;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendStudentCreatedToKeyCloak implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserCreated $event): void
    {
        if ($event->user->role != 'student') {
            return;
        }

        $keycloak = new KeyCloak();

        $keycloak->sendUserToKeycloak($event->user);
    }
}
