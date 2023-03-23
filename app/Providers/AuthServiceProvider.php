<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Campaign;
use App\Models\User;
use App\Policies\CampaignPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Campaign::class => CampaignPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('manage-campaign', [CampaignPolicy::class, 'manage']);
    }
}
