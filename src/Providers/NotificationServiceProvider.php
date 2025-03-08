<?php

namespace Modulus\Notification\Providers;

use Illuminate\Support\ServiceProvider;
use Modulus\Notification\Contracts\NotificationServiceInterface;
use Modulus\Notification\Services\NotificationService;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/notification.php', 'notification'
        );

        $this->app->bind(NotificationServiceInterface::class, NotificationService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish configuration
        $this->publishes([
            __DIR__.'/../../config/notification.php' => config_path('notification.php'),
        ], 'notification-config');

        // Publish views
        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/notification'),
        ], 'notification-views');

        // Load views
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'notification');
    }
}