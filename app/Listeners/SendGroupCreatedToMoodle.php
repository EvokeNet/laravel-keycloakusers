<?php

namespace App\Listeners;

use App\Events\GroupCreated;
use App\Util\Moodle\Group;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendGroupCreatedToMoodle
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
        $group = new Group();

        $group->sendGroupToMoodle($event->group);
    }
}
