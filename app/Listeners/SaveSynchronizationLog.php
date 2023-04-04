<?php

namespace App\Listeners;

use App\Events\SynchronizationFailure;
use App\Events\SynchronizationSuccess;
use App\Models\Group;
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
        if ($event->action == 'update') {
            $log = SyncLog::where('model', Group::class)
                ->where('model_id', $event->model->id)
                ->where('status', '<>', 201)
                ->where('status', '<>', 204)
                ->first();

            if ($log) {
                $log->status = $event->status;
                $log->message = $event->message;

                $log->save();

                return;
            }
        }

        $log = new SyncLog();
        $log->model = get_class($event->model);
        $log->model_id = $event->model->id;
        $log->action = $event->action;
        $log->status = $event->status;
        $log->message = $event->message;
        $log->timesent = Carbon::now();

        $log->save();
    }
}
