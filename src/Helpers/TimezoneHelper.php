<?php

namespace NumbersNebula\PrayerTimes\Helpers;

/**
 * Class TimezoneHelper
 *
 * Provides standardized timezone options with reference cities.
 */
class TimezoneHelper
{
    /**
     * Get timezone offset options for system configuration dropdown.
     */
    public function getTimezoneOptions(): array
    {
        return [
            ['title' => 'prayer_times::app.admin.system.timezones.utc_m12', 'value' => '-12:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_m11', 'value' => '-11:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_m10', 'value' => '-10:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_m9', 'value' => '-09:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_m8', 'value' => '-08:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_m7', 'value' => '-07:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_m6', 'value' => '-06:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_m5', 'value' => '-05:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_m4', 'value' => '-04:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_m3_30', 'value' => '-03:30'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_m3', 'value' => '-03:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_m2', 'value' => '-02:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_m1', 'value' => '-01:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_0', 'value' => '+00:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_p1', 'value' => '+01:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_p2', 'value' => '+02:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_p3', 'value' => '+03:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_p3_30', 'value' => '+03:30'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_p4', 'value' => '+04:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_p4_30', 'value' => '+04:30'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_p5', 'value' => '+05:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_p5_30', 'value' => '+05:30'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_p5_45', 'value' => '+05:45'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_p6', 'value' => '+06:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_p6_30', 'value' => '+06:30'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_p7', 'value' => '+07:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_p8', 'value' => '+08:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_p8_45', 'value' => '+08:45'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_p9', 'value' => '+09:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_p9_30', 'value' => '+09:30'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_p10', 'value' => '+10:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_p10_30', 'value' => '+10:30'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_p11', 'value' => '+11:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_p12', 'value' => '+12:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_p13', 'value' => '+13:00'],
            ['title' => 'prayer_times::app.admin.system.timezones.utc_p14', 'value' => '+14:00'],
        ];
    }
}
