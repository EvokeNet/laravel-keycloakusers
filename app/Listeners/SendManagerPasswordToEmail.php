<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Mail\ManagerCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendManagerPasswordToEmail
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
        if ($event->user->role != 'manager') {
            return;
        }

        Mail::to($event->user)->send(new ManagerCreated($event->user));
    }
}
