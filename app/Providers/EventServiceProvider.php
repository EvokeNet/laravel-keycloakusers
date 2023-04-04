<?php

namespace App\Providers;

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
        \Illuminate\Auth\Events\Registered::class => [
            \Illuminate\Auth\Listeners\SendEmailVerificationNotification::class,
        ],
        \App\Events\UserCreated::class => [
            \App\Listeners\SendManagerPasswordToEmail::class,
        ],
        \App\Events\StudentCreated::class => [
            \App\Listeners\SendStudentCreatedToKeyCloak::class,
        ],
        \App\Events\GroupCreated::class => [
            \App\Listeners\SendGroupCreatedToKeyCloak::class
        ],
        \App\Events\GroupUpdated::class => [
            \App\Listeners\SendGroupUpdatedToKeyCloak::class
        ],
        \App\Events\SynchronizationSuccess::class => [
            \App\Listeners\SaveSynchronizationLog::class
        ],
        \App\Events\SynchronizationFailure::class => [
            \App\Listeners\SaveSynchronizationLog::class
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
