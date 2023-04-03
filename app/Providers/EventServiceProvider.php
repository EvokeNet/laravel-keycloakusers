<?php

namespace App\Providers;

use App\Events\GroupCreated;
use App\Events\StudentCreated;
use App\Events\SynchronizationFailure;
use App\Events\SynchronizationSuccess;
use App\Events\UserCreated;
use App\Listeners\SaveSynchronizationLog;
use App\Listeners\SendGroupCreatedToKeyCloak;
use App\Listeners\SendManagerPasswordToEmail;
use App\Listeners\SendStudentCreatedToKeyCloak;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserCreated::class => [
            SendManagerPasswordToEmail::class,
        ],
        StudentCreated::class => [
            SendStudentCreatedToKeyCloak::class,
        ],
        GroupCreated::class => [
            SendGroupCreatedToKeyCloak::class
        ],
        SynchronizationSuccess::class => [
            SaveSynchronizationLog::class
        ],
        SynchronizationFailure::class => [
            SaveSynchronizationLog::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
