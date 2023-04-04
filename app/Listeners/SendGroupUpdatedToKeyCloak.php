<?php

namespace App\Listeners;

use App\Events\GroupUpdated;
use App\Util\Keycloak\Group;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendGroupUpdatedToKeyCloak
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
    public function handle(GroupUpdated $event): void
    {
        $keycloak = new Group();

        $keycloak->updateKeycloakGroup($event->group->campaign, $event->group);
    }
}
