<?php

namespace App\Listeners;

use App\Events\CampaignCreated;
use App\Util\Moodle\Course;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCampaignCreatedToMoodle
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
    public function handle(CampaignCreated $event): void
    {
        $course = new Course();

        $course->sendCourseToMoodle($event->campaign);
    }
}
