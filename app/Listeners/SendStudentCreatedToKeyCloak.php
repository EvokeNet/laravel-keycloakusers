<?php

namespace App\Listeners;

use App\Events\StudentCreated;
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
    public function handle(StudentCreated $event): void
    {
        $keycloak = new KeyCloak();

        $keycloak->sendUserToKeycloak($event->student);
    }
}
