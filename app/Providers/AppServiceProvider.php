<?php

namespace App\Providers;

use App\Models\Entity;
use App\Models\Relationship;
use App\Models\World;
use App\Policies\EntityPolicy;
use App\Policies\RelationshipPolicy;
use App\Policies\WorldPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        URL::forceScheme('https');
        Gate::policy(Entity::class, EntityPolicy::class);
        Gate::policy(World::class, WorldPolicy::class);
        Gate::policy(Relationship::class, RelationshipPolicy::class);
    }
}
