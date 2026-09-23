<?php

namespace NumbersNebula\PrayerTimes\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use IslamicNetwork\PrayerTimes\PrayerTimes;
use NumbersNebula\Azkar\Models\Azkar;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('prayer_times::admin.widget', function ($view) {
            $view->with('prayerTimes', $this->getPrayerTimes())
                ->with('locationName', $this->getLocationName())
                ->with('zekr', $this->getRandomZekr())
                ->with('appearance', $this->getAppearanceConfig());
        });

        View::composer('prayer_times::shop.widget', function ($view) {
            $view->with('prayerTimes', $this->getPrayerTimes())
                ->with('locationName', $this->getLocationName())
                ->with('zekr', $this->getRandomZekr())
                ->with('appearance', $this->getAppearanceConfig());
        });
    }

    /**
     * Calculate and return prayer times based on config.
     */
    private function getPrayerTimes(): array
    {
        try {
            $lat = core()->getConfigData('general.prayer_times.settings.latitude') ?: 25.2048;
            $lng = core()->getConfigData('general.prayer_times.settings.longitude') ?: 55.2708;
            $timezone = $this->resolveTimezone(core()->getConfigData('general.prayer_times.settings.timezone'));
            $method = (int) (core()->getConfigData('general.prayer_times.settings.method') ?: 3);

            $pt = new PrayerTimes($method);

            return $pt->getTimesForToday($lat, $lng, $timezone);
        } catch (\Throwable $e) {
            Log::error('PrayerTimes calculation failed: '.$e->getMessage());

            return [];
        }
    }

    /**
     * Get configured or default location name.
     */
    private function getLocationName(): string
    {
        return core()->getConfigData('general.prayer_times.settings.location_name') ?: trans('prayer_times::app.default_location');
    }

    /**
     * Get random dhikr if Azkar package is installed.
     *
     * @return mixed
     */
    private function getRandomZekr()
    {
        if (class_exists(Azkar::class)) {
            try {
                return Azkar::inRandomOrder()->first();
            } catch (\Throwable $e) {
                return null;
            }
        }

        return null;
    }

    /**
     * Resolve timezone into a valid string for DateTimeZone.
     *
     * @param  mixed  $timezone
     */
    private function resolveTimezone($timezone): string
    {
        if (empty($timezone)) {
            return config('app.timezone') ?: 'Asia/Muscat';
        }

        $timezone = trim((string) $timezone);

        if (is_numeric($timezone)) {
            $num = (float) $timezone;
            $sign = $num >= 0 ? '+' : '-';
            $abs = abs($num);
            $hours = floor($abs);
            $minutes = ($abs - $hours) * 60;

            return sprintf('%s%02d:%02d', $sign, $hours, $minutes);
        }

        if (preg_match('/^[+-]\d{1,2}$/', $timezone)) {
            $sign = $timezone[0];
            $hours = (int) substr($timezone, 1);

            return sprintf('%s%02d:00', $sign, $hours);
        }

        try {
            new \DateTimeZone($timezone);

            return $timezone;
        } catch (\Throwable $e) {
            return config('app.timezone') ?: 'Asia/Muscat';
        }
    }

    /**
     * Get appearance and color configuration.
     */
    private function getAppearanceConfig(): array
    {
        $preset = core()->getConfigData('general.prayer_times.appearance.theme_preset') ?: 'jz_luxury';

        $presets = [
            'jz_luxury' => [
                'primary' => '#171717',
                'secondary' => '#242424',
                'accent' => '#c8a24d',
                'card_bg' => '#1f1f1f',
                'card_border' => 'rgba(200, 162, 77, 0.25)',
                'text' => '#ffffff',
                'subtext' => '#c8a24d',
                'highlight_bg' => 'rgba(200, 162, 77, 0.15)',
                'highlight_border' => '#c8a24d',
            ],
            'emerald_gold' => [
                'primary' => '#064e3b',
                'secondary' => '#065f46',
                'accent' => '#d4af37',
                'card_bg' => '#064e3b',
                'card_border' => 'rgba(212, 175, 55, 0.3)',
                'text' => '#ffffff',
                'subtext' => '#a7f3d0',
                'highlight_bg' => 'rgba(212, 175, 55, 0.15)',
                'highlight_border' => '#d4af37',
            ],
            'classic_dark' => [
                'primary' => '#0f172a',
                'secondary' => '#1e293b',
                'accent' => '#38bdf8',
                'card_bg' => '#1e293b',
                'card_border' => 'rgba(56, 189, 248, 0.25)',
                'text' => '#ffffff',
                'subtext' => '#94a3b8',
                'highlight_bg' => 'rgba(56, 189, 248, 0.12)',
                'highlight_border' => '#38bdf8',
            ],
        ];

        $config = $presets[$preset] ?? $presets['jz_luxury'];

        $customPrimary = core()->getConfigData('general.prayer_times.appearance.primary_color');
        $customSecondary = core()->getConfigData('general.prayer_times.appearance.secondary_color');
        $customAccent = core()->getConfigData('general.prayer_times.appearance.accent_color');
        $customCardBg = core()->getConfigData('general.prayer_times.appearance.card_bg_color');
        $customText = core()->getConfigData('general.prayer_times.appearance.text_color');

        if ($preset === 'custom') {
            $config['primary'] = $customPrimary ?: '#171717';
            $config['secondary'] = $customSecondary ?: '#242424';
            $config['accent'] = $customAccent ?: '#c8a24d';
            $config['card_bg'] = $customCardBg ?: '#1f1f1f';
            $config['text'] = $customText ?: '#ffffff';
            $config['subtext'] = $config['accent'];
            $config['card_border'] = $config['accent'].'40';
            $config['highlight_border'] = $config['accent'];
            $config['highlight_bg'] = $config['accent'].'22';
        } else {
            if (! empty($customPrimary) && $customPrimary !== '#171717') {
                $config['primary'] = $customPrimary;
            }
            if (! empty($customSecondary) && $customSecondary !== '#242424') {
                $config['secondary'] = $customSecondary;
            }
            if (! empty($customAccent) && $customAccent !== '#c8a24d') {
                $config['accent'] = $customAccent;
                $config['subtext'] = $customAccent;
                $config['card_border'] = $customAccent.'40';
                $config['highlight_border'] = $customAccent;
                $config['highlight_bg'] = $customAccent.'22';
            }
            if (! empty($customCardBg) && $customCardBg !== '#1f1f1f') {
                $config['card_bg'] = $customCardBg;
            }
            if (! empty($customText) && $customText !== '#ffffff') {
                $config['text'] = $customText;
            }
        }

        $config['enabled'] = core()->getConfigData('general.prayer_times.appearance.enable_bottom_bar') ?? true;
        $config['position'] = core()->getConfigData('general.prayer_times.appearance.bottom_bar_position') ?: 'center';

        return $config;
    }
}
