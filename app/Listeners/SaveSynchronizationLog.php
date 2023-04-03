<?php

namespace App\Listeners;

use App\Events\SynchronizationFailure;
use App\Events\SynchronizationSuccess;
use App\Models\SyncLog;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveSynchronizationLog
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
    public function handle(SynchronizationSuccess|SynchronizationFailure $event): void
    {
        $log = new SyncLog();
        $log->fill($event->logObject);
        $log->timesent = Carbon::now();

        $log->save();
    }
}
