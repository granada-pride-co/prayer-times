<?php

namespace NumbersNebula\PrayerTimes\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use NumbersNebula\PluginHub\Facades\NebulaPlugin;

class PrayerTimesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'prayer_times');

        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'prayer_times');

        $this->publishes([
            __DIR__.'/../Config/system.php' => config_path('prayer_times_system.php'),
        ]);

        $this->app->register(ViewServiceProvider::class);

        Event::listen('bagisto.admin.dashboard.overall_details.before', function ($viewRenderEventManager) {
            if (class_exists(NebulaPlugin::class) && ! NebulaPlugin::isActive('prayer-times')) {
                return;
            }

            $viewRenderEventManager->addTemplate('prayer_times::admin.widget');
        });

        Event::listen('bagisto.shop.layout.body.after', function ($viewRenderEventManager) {
            if (class_exists(NebulaPlugin::class) && ! NebulaPlugin::isActive('prayer-times')) {
                return;
            }

            $viewRenderEventManager->addTemplate('prayer_times::shop.widget');
        });
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/system.php',
            'core'
        );
    }
}
