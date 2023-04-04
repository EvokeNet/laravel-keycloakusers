<?php

namespace App\Listeners;

use App\Events\StudentCreated;
use App\Util\Keycloak\User;
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
        $keycloak = new User();

        $keycloak->sendUserToKeycloak($event->student);
    }
}
