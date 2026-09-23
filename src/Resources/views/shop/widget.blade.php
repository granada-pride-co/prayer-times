@if(!empty($prayerTimes) && ($appearance['enabled'] ?? true))
@php
    $currentLocale = core()->getCurrentLocale()?->code ?? app()->getLocale() ?? 'ar';
    $primary = $appearance['primary'] ?? '#171717';
    $secondary = $appearance['secondary'] ?? '#242424';
    $accent = $appearance['accent'] ?? '#c8a24d';
    $cardBg = $appearance['card_bg'] ?? '#1f1f1f';
    $cardBorder = $appearance['card_border'] ?? 'rgba(200, 162, 77, 0.25)';
    $textColor = $appearance['text'] ?? '#ffffff';
    $subtextColor = $appearance['subtext'] ?? '#c8a24d';
    $highlightBg = $appearance['highlight_bg'] ?? 'rgba(200, 162, 77, 0.15)';
    $highlightBorder = $appearance['highlight_border'] ?? '#c8a24d';
    $position = $appearance['position'] ?? 'center';

    $posClass = match($position) {
        'right' => 'bottom-4 right-4 sm:right-8',
        'left' => 'bottom-4 left-4 sm:left-8',
        default => 'bottom-4 left-1/2 -translate-x-1/2',
    };

    $to12h = function (?string $time24, string $locale = 'ar') {
        if (! $time24 || ! str_contains($time24, ':')) {
            return ['time' => '--', 'period' => '', 'full' => '--'];
        }

        $parts = explode(':', $time24);
        $h = (int) ($parts[0] ?? 0);
        $m = str_pad($parts[1] ?? '00', 2, '0', STR_PAD_LEFT);

        $isPm = $h >= 12;
        $h12 = $h % 12;
        if ($h12 === 0) {
            $h12 = 12;
        }
        $hStr = str_pad((string) $h12, 2, '0', STR_PAD_LEFT);

        $period = $isPm ? trans('prayer_times::app.pm', [], $locale) : trans('prayer_times::app.am', [], $locale);

        return [
            'time' => $hStr . ':' . $m,
            'period' => $period,
            'full' => $hStr . ':' . $m . ' ' . $period,
        ];
    };
@endphp

<div id="nn-prayer-widget-root" class="relative z-50">
    <div
        id="nn-prayer-backdrop"
        class="fixed inset-0 bg-black/70 backdrop-blur-sm transition-opacity duration-300 opacity-0 pointer-events-none z-[9998]"
        onclick="nnTogglePrayerDrawer(false)"
    ></div>

    <div
        id="nn-prayer-drawer"
        class="fixed inset-x-0 bottom-0 max-h-[92vh] overflow-y-auto shadow-2xl rounded-t-3xl transition-transform duration-300 ease-out translate-y-full z-[9999] px-4 py-5 sm:px-8 sm:py-6"
        style="background: {{ $primary }}; color: {{ $textColor }}; border-top: 1px solid {{ $accent }}40;"
        onclick="nnOnDrawerClick(event)"
    >
        <div id="nn-prayer-drawer-content" class="max-w-5xl mx-auto" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between pb-4 mb-5" style="border-bottom: 1px solid {{ $accent }}25;">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background: {{ $accent }}20; color: {{ $accent }}; border: 1px solid {{ $accent }}40;">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2m0 0a4 4 0 0 1 4 4v1h-8V9a4 4 0 0 1 4-4zm-7 8v8h14v-8M3 21h18M9 21v-4a3 3 0 0 1 6 0v4M4 11l8-4 8 4" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold leading-tight font-serif" style="color: {{ $textColor }};">
                            {{ trans('prayer_times::app.daily_prayer_times', [], $currentLocale) }}
                        </h2>
                        <span class="text-xs" style="color: {{ $subtextColor }};">
                            {{ $locationName }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <div class="flex items-center p-0.5 rounded-xl" style="background: {{ $secondary }}; border: 1px solid {{ $accent }}35;">
                        <button
                            type="button"
                            id="nn-btn-fmt-12"
                            onclick="nnSetTimeFormat('12')"
                            class="px-2.5 py-1 rounded-lg text-xs font-bold transition cursor-pointer select-none"
                            style="background: {{ $accent }}; color: #171717;"
                            title="{{ trans('prayer_times::app.format_12h', [], $currentLocale) }}"
                        >
                            {{ trans('prayer_times::app.format_12h', [], $currentLocale) }}
                        </button>
                        <button
                            type="button"
                            id="nn-btn-fmt-24"
                            onclick="nnSetTimeFormat('24')"
                            class="px-2.5 py-1 rounded-lg text-xs font-bold transition cursor-pointer select-none opacity-60 hover:opacity-100"
                            style="color: {{ $textColor }};"
                            title="{{ trans('prayer_times::app.format_24h', [], $currentLocale) }}"
                        >
                            {{ trans('prayer_times::app.format_24h', [], $currentLocale) }}
                        </button>
                    </div>

                    <button
                        type="button"
                        onclick="nnTogglePrayerDrawer(false)"
                        class="p-2 rounded-xl transition cursor-pointer"
                        style="color: {{ $subtextColor }}; background: {{ $secondary }}; border: 1px solid {{ $accent }}30;"
                        title="{{ trans('prayer_times::app.close', [], $currentLocale) }}"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-2xl p-5 sm:p-6 mb-6 shadow-xl" style="background: linear-gradient(135deg, {{ $secondary }} 0%, {{ $primary }} 100%); border: 1px solid {{ $accent }}40; color: #ffffff;">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-4 w-full lg:w-auto">
                        <div class="w-13 h-13 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center shrink-0 shadow-inner" style="background: {{ $accent }}22; border: 1px solid {{ $accent }}55; color: {{ $accent }};">
                            <svg class="w-7 h-7 sm:w-8 sm:h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs sm:text-sm font-semibold uppercase tracking-wider block" style="color: {{ $subtextColor }};">
                                {{ trans('prayer_times::app.time_remaining_until', [], $currentLocale) }}
                            </span>
                            <div class="flex items-baseline gap-2 mt-0.5">
                                <span id="nn-hero-prayer-name" class="text-2xl sm:text-3xl font-extrabold font-serif" style="color: {{ $textColor }};">
                                    --
                                </span>
                                <span id="nn-hero-prayer-time" class="text-xs sm:text-sm font-mono font-bold px-2 py-0.5 rounded-md" style="background: {{ $accent }}25; color: {{ $accent }}; border: 1px solid {{ $accent }}40;" dir="ltr">
                                    --:--
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-center gap-3 sm:gap-4 direction-ltr" dir="ltr">
                        <div class="text-center px-3 py-2 rounded-xl" style="background: rgba(0,0,0,0.3); border: 1px solid {{ $accent }}30; min-width: 68px;">
                            <span id="nn-countdown-hours" class="block text-3xl sm:text-4xl font-extrabold tracking-tight font-mono" style="color: {{ $textColor }};">00</span>
                            <span class="text-[11px] uppercase tracking-wider font-semibold" style="color: {{ $subtextColor }};">{{ trans('prayer_times::app.hours', [], $currentLocale) }}</span>
                        </div>
                        <span class="text-2xl sm:text-3xl font-bold opacity-60 mb-2" style="color: {{ $accent }};">:</span>
                        <div class="text-center px-3 py-2 rounded-xl" style="background: rgba(0,0,0,0.3); border: 1px solid {{ $accent }}30; min-width: 68px;">
                            <span id="nn-countdown-minutes" class="block text-3xl sm:text-4xl font-extrabold tracking-tight font-mono" style="color: {{ $textColor }};">00</span>
                            <span class="text-[11px] uppercase tracking-wider font-semibold" style="color: {{ $subtextColor }};">{{ trans('prayer_times::app.minutes', [], $currentLocale) }}</span>
                        </div>
                        <span class="text-2xl sm:text-3xl font-bold opacity-60 mb-2" style="color: {{ $accent }};">:</span>
                        <div class="text-center px-3 py-2 rounded-xl" style="background: rgba(0,0,0,0.3); border: 1px solid {{ $accent }}30; min-width: 68px;">
                            <span id="nn-countdown-seconds" class="block text-3xl sm:text-4xl font-extrabold tracking-tight font-mono" style="color: {{ $textColor }};">00</span>
                            <span class="text-[11px] uppercase tracking-wider font-semibold" style="color: {{ $subtextColor }};">{{ trans('prayer_times::app.seconds', [], $currentLocale) }}</span>
                        </div>
                    </div>

                    <div class="w-full lg:w-auto flex justify-end">
                        <button
                            type="button"
                            onclick="nnToggleCardsList()"
                            class="w-full lg:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl font-bold text-xs sm:text-sm shadow-md transition cursor-pointer"
                            style="background: linear-gradient(135deg, {{ $accent }}, #d4af37); color: #171717;"
                        >
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span id="nn-toggle-list-text">{{ trans('prayer_times::app.view_prayer_schedule', [], $currentLocale) }}</span>
                            <svg id="nn-toggle-chevron" class="w-4 h-4 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div id="nn-prayer-cards-container" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-4">
                    @php
                        $prayerCardItems = [
                            [
                                'key' => 'Fajr',
                                'id' => 'nn-card-fajr',
                                'label' => trans('prayer_times::app.prayers.fajr', [], $currentLocale),
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3v4m0 10v4m9-9h-4M7 12H3m15.364-6.364l-2.828 2.828M8.464 15.536L5.636 18.364m0-12.728l2.828 2.828m8.9 8.9l2.828 2.828" />',
                            ],
                            [
                                'key' => 'Sunrise',
                                'id' => 'nn-card-sunrise',
                                'label' => trans('prayer_times::app.prayers.sunrise', [], $currentLocale),
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3v6m0 0l-3-3m3 3l3-3M4 17h16M2 21h20" />',
                            ],
                            [
                                'key' => 'Dhuhr',
                                'id' => 'nn-card-dhuhr',
                                'label' => trans('prayer_times::app.prayers.dhuhr', [], $currentLocale),
                                'icon' => '<circle cx="12" cy="12" r="4" /><path stroke-linecap="round" d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32l1.41 1.41M2 12h2m16 0h2M6.34 17.66l-1.41 1.41m14.14-14.14l-1.41 1.41" />',
                            ],
                            [
                                'key' => 'Asr',
                                'id' => 'nn-card-asr',
                                'label' => trans('prayer_times::app.prayers.asr', [], $currentLocale),
                                'icon' => '<circle cx="12" cy="12" r="5" /><path stroke-linecap="round" d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2m18 0h2" />',
                            ],
                            [
                                'key' => 'Maghrib',
                                'id' => 'nn-card-maghrib',
                                'label' => trans('prayer_times::app.prayers.maghrib', [], $currentLocale),
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9z" />',
                            ],
                            [
                                'key' => 'Isha',
                                'id' => 'nn-card-isha',
                                'label' => trans('prayer_times::app.prayers.isha', [], $currentLocale),
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />',
                            ],
                            [
                                'key' => 'Midnight',
                                'id' => 'nn-card-midnight',
                                'label' => trans('prayer_times::app.prayers.midnight', [], $currentLocale),
                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3a9 9 0 1 0 9 9c0-.46-.04-.92-.1-1.36a5.389 5.389 0 0 1-4.4 2.26 5.403 5.403 0 0 1-3.14-9.8c-.44-.06-.9-.1-1.36-.1z" />',
                            ],
                        ];
                    @endphp
                    @foreach($prayerCardItems as $card)
                        @php
                            $t24 = $prayerTimes[$card['key']] ?? '--';
                            $t12 = $to12h($t24, $currentLocale);
                        @endphp
                        <div id="{{ $card['id'] }}" class="flex items-center justify-between p-4 rounded-xl shadow-sm transition-all duration-200" style="background: {{ $cardBg }}; border: 1px solid {{ $cardBorder }};">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0" style="background: {{ $accent }}20; color: {{ $accent }}; border: 1px solid {{ $accent }}30;">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        {!! $card['icon'] !!}
                                    </svg>
                                </div>
                                <span class="font-bold text-sm sm:text-base" style="color: {{ $textColor }};">
                                    {{ $card['label'] }}
                                </span>
                            </div>
                            <div class="flex flex-col items-end">
                                <div class="flex items-baseline gap-1" dir="ltr">
                                    <span id="nn-time-main-{{ strtolower($card['key']) }}" class="font-mono font-bold text-base sm:text-lg" style="color: {{ $textColor }};">
                                        {{ $t12['time'] }}
                                    </span>
                                    <span id="nn-period-{{ strtolower($card['key']) }}" class="text-xs font-bold" style="color: {{ $accent }};">
                                        {{ $t12['period'] }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-1 text-[11px] font-mono opacity-65" dir="ltr" style="color: {{ $textColor }};">
                                    <span id="nn-time-sub-{{ strtolower($card['key']) }}">{{ $t24 }}</span>
                                    <span id="nn-label-sub-{{ strtolower($card['key']) }}" class="text-[10px] font-sans opacity-75">({{ trans('prayer_times::app.format_24h', [], $currentLocale) }})</span>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="flex items-center justify-between p-4 rounded-xl shadow-sm transition-all duration-200" style="background: {{ $cardBg }}; border: 1px solid {{ $cardBorder }};">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: {{ $accent }}20; color: {{ $accent }}; border: 1px solid {{ $accent }}30;">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <span class="font-bold text-sm sm:text-base" style="color: {{ $textColor }};">
                                {{ trans('prayer_times::app.timezone_label', [], $currentLocale) }}
                            </span>
                        </div>
                        <span class="font-semibold text-xs sm:text-sm font-mono" style="color: {{ $subtextColor }};">
                            {{ $locationName }}
                        </span>
                    </div>
                </div>

                @if($zekr)
                @php
                    $zekrTranslation = $zekr->translate($currentLocale) ?? $zekr->translate('ar') ?? $zekr->translate('en');
                @endphp
                <div class="mt-8 pt-6" style="border-top: 1px solid {{ $accent }}25;">
                    <div class="flex items-center justify-center gap-3 mb-4">
                        <div class="h-px w-16" style="background: {{ $accent }}40;"></div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold shadow-sm" style="background: {{ $secondary }}; border: 1px solid {{ $accent }}40; color: {{ $accent }};">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>{{ trans('prayer_times::app.remembrance', [], $currentLocale) }}</span>
                            @if(($zekr->count ?? 1) > 1)
                                <span class="px-1.5 py-0.5 rounded font-mono text-[10px] font-extrabold" style="background: {{ $accent }}30; color: {{ $accent }};">
                                    {{ $zekr->count }}x
                                </span>
                            @endif
                        </div>
                        <div class="h-px w-16" style="background: {{ $accent }}40;"></div>
                    </div>
                    <div class="rounded-2xl p-4 sm:p-5 text-center shadow-inner" style="background: {{ $secondary }}; border: 1px solid {{ $accent }}30;">
                        <p class="text-sm sm:text-base font-medium italic leading-relaxed" style="color: {{ $textColor }};">
                            "{{ $zekrTranslation?->content }}"
                        </p>
                        @if($zekrTranslation?->description)
                            <p class="mt-2 text-xs leading-normal opacity-85" style="color: {{ $subtextColor }};">
                                {{ $zekrTranslation->description }}
                            </p>
                        @endif
                        @if($zekrTranslation?->reference)
                        <span class="inline-block mt-2.5 text-xs font-bold" style="color: {{ $subtextColor }};">
                            - {{ $zekrTranslation->reference }}
                        </span>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div
        id="nn-prayer-bottom-bar"
        class="fixed {{ $posClass }} z-[9990] w-[92%] sm:w-auto max-w-xl transition-all duration-300"
    >
        <div
            onclick="nnTogglePrayerDrawer(true)"
            class="flex items-center justify-between gap-3 sm:gap-5 px-4 py-2.5 sm:px-6 sm:py-3 rounded-full text-white backdrop-blur-md shadow-2xl transition-all duration-200 cursor-pointer select-none group"
            style="background: {{ $primary }}; border: 1px solid {{ $accent }}55; box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.5), 0 0 15px -3px {{ $accent }}30;"
        >
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full flex items-center justify-center shrink-0 shadow-md group-hover:scale-105 transition-transform" style="background: linear-gradient(135deg, {{ $accent }}, #d4af37); color: #171717;">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2m0 0a4 4 0 0 1 4 4v1h-8V9a4 4 0 0 1 4-4zm-7 8v8h14v-8M3 21h18M9 21v-4a3 3 0 0 1 6 0v4M4 11l8-4 8 4" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] sm:text-[11px] font-semibold leading-none" style="color: {{ $subtextColor }};">
                        {{ trans('prayer_times::app.next_prayer', [], $currentLocale) }}
                    </span>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span id="nn-bar-prayer-name" class="text-xs sm:text-sm font-bold leading-tight" style="color: {{ $textColor }};">
                            --
                        </span>
                        <span id="nn-bar-prayer-time" class="text-[10px] font-mono font-semibold opacity-75" style="color: {{ $subtextColor }};" dir="ltr">
                            --
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-1.5 px-3 py-1 rounded-full font-mono font-bold tracking-wider text-xs sm:text-sm" style="background: {{ $secondary }}; border: 1px solid {{ $accent }}40; color: {{ $accent }};" dir="ltr">
                <span id="nn-bar-countdown">--:--:--</span>
            </div>

            <div class="flex items-center transition" style="color: {{ $accent }};">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 transform -rotate-90 group-hover:translate-y-[-2px] transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    var rawPrayerTimes = @json($prayerTimes);
    var prayerLabels = {
        'Fajr': @json(trans('prayer_times::app.prayers.fajr', [], $currentLocale)),
        'Sunrise': @json(trans('prayer_times::app.prayers.sunrise', [], $currentLocale)),
        'Dhuhr': @json(trans('prayer_times::app.prayers.dhuhr', [], $currentLocale)),
        'Asr': @json(trans('prayer_times::app.prayers.asr', [], $currentLocale)),
        'Maghrib': @json(trans('prayer_times::app.prayers.maghrib', [], $currentLocale)),
        'Isha': @json(trans('prayer_times::app.prayers.isha', [], $currentLocale)),
        'Midnight': @json(trans('prayer_times::app.prayers.midnight', [], $currentLocale))
    };

    var prayerKeys = ['Fajr', 'Sunrise', 'Dhuhr', 'Asr', 'Maghrib', 'Isha', 'Midnight'];
    var currentFormat = '12';
    try {
        currentFormat = localStorage.getItem('nn_prayer_time_fmt') || '12';
    } catch (e) {}

    var highlightBorder = @json($highlightBorder);
    var highlightBg = @json($highlightBg);
    var cardBorder = @json($cardBorder);
    var cardBg = @json($cardBg);
    var accentColor = @json($accent);
    var textColor = @json($textColor);
    var label12h = @json(trans('prayer_times::app.format_12h', [], $currentLocale));
    var label24h = @json(trans('prayer_times::app.format_24h', [], $currentLocale));
    var amLabel = @json(trans('prayer_times::app.am', [], $currentLocale));
    var pmLabel = @json(trans('prayer_times::app.pm', [], $currentLocale));

    window.nnTogglePrayerDrawer = function(open) {
        var drawer = document.getElementById('nn-prayer-drawer');
        var backdrop = document.getElementById('nn-prayer-backdrop');
        var bottomBar = document.getElementById('nn-prayer-bottom-bar');
        if (!drawer || !backdrop) return;

        if (open) {
            drawer.classList.remove('translate-y-full');
            backdrop.classList.remove('opacity-0', 'pointer-events-none');
            backdrop.classList.add('opacity-100');
            if (bottomBar) bottomBar.classList.add('opacity-0', 'pointer-events-none');
        } else {
            drawer.classList.add('translate-y-full');
            backdrop.classList.remove('opacity-100');
            backdrop.classList.add('opacity-0', 'pointer-events-none');
            if (bottomBar) bottomBar.classList.remove('opacity-0', 'pointer-events-none');
        }
    };

    window.nnOnDrawerClick = function(event) {
        var content = document.getElementById('nn-prayer-drawer-content');
        if (content && !content.contains(event.target)) {
            window.nnTogglePrayerDrawer(false);
        }
    };

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' || e.key === 'Esc' || e.keyCode === 27) {
            var drawer = document.getElementById('nn-prayer-drawer');
            if (drawer && !drawer.classList.contains('translate-y-full')) {
                window.nnTogglePrayerDrawer(false);
            }
        }
    });

    document.addEventListener('click', function(e) {
        var drawer = document.getElementById('nn-prayer-drawer');
        var bottomBar = document.getElementById('nn-prayer-bottom-bar');
        var content = document.getElementById('nn-prayer-drawer-content');
        if (!drawer || drawer.classList.contains('translate-y-full')) return;

        if (content && content.contains(e.target)) return;
        if (bottomBar && bottomBar.contains(e.target)) return;
        if (e.target === drawer || (drawer.contains(e.target) && !content.contains(e.target))) {
            window.nnTogglePrayerDrawer(false);
        }
    });

    window.nnToggleCardsList = function() {
        var container = document.getElementById('nn-prayer-cards-container');
        var chevron = document.getElementById('nn-toggle-chevron');
        var textSpan = document.getElementById('nn-toggle-list-text');
        if (!container) return;

        var isHidden = container.classList.contains('hidden');
        if (isHidden) {
            container.classList.remove('hidden');
            if (chevron) chevron.classList.remove('rotate-180');
            if (textSpan) textSpan.innerText = @json(trans('prayer_times::app.hide_prayer_schedule', [], $currentLocale));
        } else {
            container.classList.add('hidden');
            if (chevron) chevron.classList.add('rotate-180');
            if (textSpan) textSpan.innerText = @json(trans('prayer_times::app.view_prayer_schedule', [], $currentLocale));
        }
    };

    function format12(time24) {
        if (!time24 || time24.indexOf(':') === -1) {
            return { time: '--', period: '', full: '--' };
        }
        var parts = time24.split(':');
        var h = parseInt(parts[0], 10);
        var m = parts[1];
        var isPm = h >= 12;
        var h12 = h % 12;
        if (h12 === 0) h12 = 12;
        var hStr = h12 < 10 ? '0' + h12 : '' + h12;
        var period = isPm ? pmLabel : amLabel;
        return {
            time: hStr + ':' + m,
            period: period,
            full: hStr + ':' + m + ' ' + period
        };
    }

    function updateFormatUI() {
        var btn12 = document.getElementById('nn-btn-fmt-12');
        var btn24 = document.getElementById('nn-btn-fmt-24');

        if (btn12 && btn24) {
            if (currentFormat === '24') {
                btn24.style.background = accentColor;
                btn24.style.color = '#171717';
                btn24.classList.remove('opacity-60');
                btn12.style.background = 'transparent';
                btn12.style.color = textColor;
                btn12.classList.add('opacity-60');
            } else {
                btn12.style.background = accentColor;
                btn12.style.color = '#171717';
                btn12.classList.remove('opacity-60');
                btn24.style.background = 'transparent';
                btn24.style.color = textColor;
                btn24.classList.add('opacity-60');
            }
        }

        for (var i = 0; i < prayerKeys.length; i++) {
            var key = prayerKeys[i];
            var lower = key.toLowerCase();
            var mainEl = document.getElementById('nn-time-main-' + lower);
            var periodEl = document.getElementById('nn-period-' + lower);
            var subEl = document.getElementById('nn-time-sub-' + lower);
            var subLabelEl = document.getElementById('nn-label-sub-' + lower);
            var rawTime = rawPrayerTimes[key];

            if (!rawTime || !mainEl) continue;

            var f12 = format12(rawTime);
            if (currentFormat === '24') {
                mainEl.innerText = rawTime;
                if (periodEl) periodEl.innerText = '';
                if (subEl) subEl.innerText = f12.full;
                if (subLabelEl) subLabelEl.innerText = '(' + label12h + ')';
            } else {
                mainEl.innerText = f12.time;
                if (periodEl) periodEl.innerText = f12.period;
                if (subEl) subEl.innerText = rawTime;
                if (subLabelEl) subLabelEl.innerText = '(' + label24h + ')';
            }
        }

        updateCountdowns();
    }

    window.nnSetTimeFormat = function(fmt) {
        currentFormat = fmt;
        try {
            localStorage.setItem('nn_prayer_time_fmt', fmt);
        } catch (e) {}
        updateFormatUI();
    };

    function parseTime(timeStr, baseDate) {
        var parts = timeStr.split(':');
        var d = new Date(baseDate.getTime());
        d.setHours(parseInt(parts[0], 10), parseInt(parts[1], 10), 0, 0);
        return d;
    }

    function updateCountdowns() {
        var now = new Date();
        var mainPrayers = ['Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
        var nextPrayerKey = null;
        var nextPrayerDate = null;

        for (var i = 0; i < mainPrayers.length; i++) {
            var key = mainPrayers[i];
            if (rawPrayerTimes[key]) {
                var pDate = parseTime(rawPrayerTimes[key], now);
                if (pDate > now) {
                    nextPrayerKey = key;
                    nextPrayerDate = pDate;
                    break;
                }
            }
        }

        if (!nextPrayerKey && rawPrayerTimes['Fajr']) {
            nextPrayerKey = 'Fajr';
            var tomorrow = new Date(now.getTime() + 24 * 60 * 60 * 1000);
            nextPrayerDate = parseTime(rawPrayerTimes['Fajr'], tomorrow);
        }

        if (!nextPrayerKey || !nextPrayerDate) return;

        var diff = Math.max(0, Math.floor((nextPrayerDate.getTime() - now.getTime()) / 1000));
        var hours = Math.floor(diff / 3600);
        var minutes = Math.floor((diff % 3600) / 60);
        var seconds = diff % 60;

        var sHours = hours < 10 ? '0' + hours : '' + hours;
        var sMinutes = minutes < 10 ? '0' + minutes : '' + minutes;
        var sSeconds = seconds < 10 ? '0' + seconds : '' + seconds;
        var sTimer = sHours + ':' + sMinutes + ':' + sSeconds;

        var pLabel = prayerLabels[nextPrayerKey] || nextPrayerKey;
        var nextRawTime = rawPrayerTimes[nextPrayerKey] || '';
        var f12Next = format12(nextRawTime);
        var formattedNextTime = currentFormat === '24' ? nextRawTime : f12Next.full;

        var heroName = document.getElementById('nn-hero-prayer-name');
        if (heroName) heroName.innerText = pLabel;

        var heroTime = document.getElementById('nn-hero-prayer-time');
        if (heroTime) heroTime.innerText = formattedNextTime;

        var barName = document.getElementById('nn-bar-prayer-name');
        if (barName) barName.innerText = pLabel;

        var barTime = document.getElementById('nn-bar-prayer-time');
        if (barTime) barTime.innerText = '(' + formattedNextTime + ')';

        var elH = document.getElementById('nn-countdown-hours');
        var elM = document.getElementById('nn-countdown-minutes');
        var elS = document.getElementById('nn-countdown-seconds');
        if (elH) elH.innerText = sHours;
        if (elM) elM.innerText = sMinutes;
        if (elS) elS.innerText = sSeconds;

        var barCountdown = document.getElementById('nn-bar-countdown');
        if (barCountdown) barCountdown.innerText = sTimer;

        var cards = document.querySelectorAll('[id^="nn-card-"]');
        for (var c = 0; c < cards.length; c++) {
            cards[c].style.borderColor = cardBorder;
            cards[c].style.background = cardBg;
            cards[c].style.boxShadow = '';
        }
        var nextCard = document.getElementById('nn-card-' + nextPrayerKey.toLowerCase());
        if (nextCard) {
            nextCard.style.borderColor = highlightBorder;
            nextCard.style.background = highlightBg;
            nextCard.style.boxShadow = '0 0 20px -3px rgba(200, 162, 77, 0.3)';
        }
    }

    if (currentFormat === '24') {
        updateFormatUI();
    } else {
        updateCountdowns();
    }

    setInterval(updateCountdowns, 1000);
})();
</script>
@endif
