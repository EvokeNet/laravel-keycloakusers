<?php

namespace App\Listeners;

use App\Events\GroupCreated;
use App\Util\KeyCloak;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendGroupCreatedToKeyCloak
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
    public function handle(GroupCreated $event): void
    {
        $keycloak = new KeyCloak();

        $keycloak->sendGroupToKeycloak($event->group);
    }
}
