<?php

declare(strict_types=1);

namespace Rinvex\Subscriptions\Providers;

use Illuminate\Support\Str;
use Rinvex\Subscriptions\Models\Plan;
use Illuminate\Support\ServiceProvider;
use Rinvex\Subscriptions\Models\PlanFeature;
use Rinvex\Subscriptions\Models\PlanSubscription;
use Rinvex\Subscriptions\Models\PlanSubscriptionUsage;

class SubscriptionsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(realpath(__DIR__.'/../../config/config.php'), 'rinvex.subscriptions');

        // Bind eloquent models to IoC container
        $models = [
            'rinvex.subscriptions.plan' => Plan::class,
            'rinvex.subscriptions.plan_feature' => PlanFeature::class,
            'rinvex.subscriptions.plan_subscription' => PlanSubscription::class,
            'rinvex.subscriptions.plan_subscription_usage' => PlanSubscriptionUsage::class,
        ];

        foreach ($models as $service => $class) {
            $this->app->singleton($service, $model = $this->app['config'][Str::replaceLast('.', '.models.', $service)]);
            $model === $class || $this->app->alias($service, $class);
        }
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Publish Resources
    }
}
