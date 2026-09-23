@if(!empty($prayerTimes))
@php
    $currentLocale = core()->getCurrentLocale()?->code ?? app()->getLocale() ?? 'ar';
    $primary = $appearance['primary'] ?? '#171717';
    $secondary = $appearance['secondary'] ?? '#242424';
    $accent = $appearance['accent'] ?? '#c8a24d';
    $cardBg = $appearance['card_bg'] ?? '#1f1f1f';
    $textColor = $appearance['text'] ?? '#ffffff';
    $subtextColor = $appearance['subtext'] ?? '#c8a24d';
    $highlightBg = $appearance['highlight_bg'] ?? 'rgba(200, 162, 77, 0.15)';
    $highlightBorder = $appearance['highlight_border'] ?? '#c8a24d';
@endphp
<div class="mb-6 rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
    <div class="flex items-center justify-between pb-3 mb-4 border-b border-slate-100 dark:border-slate-800">
        <div class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: {{ $accent }}20; color: {{ $accent }}; border: 1px solid {{ $accent }}40;">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2m0 0a4 4 0 0 1 4 4v1h-8V9a4 4 0 0 1 4-4zm-7 8v8h14v-8M3 21h18M9 21v-4a3 3 0 0 1 6 0v4M4 11l8-4 8 4" />
                </svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-800 dark:text-white leading-none">
                    {{ trans('prayer_times::app.daily_prayer_times', [], $currentLocale) }}
                </h3>
                <span class="text-xs text-slate-400 mt-1 inline-block">
                    {{ $locationName }}
                </span>
            </div>
        </div>

        <a
            href="{{ route('admin.configuration.index', ['general', 'prayer_times']) }}"
            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-semibold transition"
        >
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <circle cx="12" cy="12" r="3" />
            </svg>
            <span>{{ trans('prayer_times::app.admin.system.settings', [], $currentLocale) }}</span>
        </a>
    </div>

    <div class="rounded-2xl p-5 mb-5 shadow-sm text-white" style="background: linear-gradient(135deg, {{ $secondary }} 0%, {{ $primary }} 100%); border: 1px solid {{ $accent }}40; color: #ffffff;">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0" style="background: {{ $accent }}20; border: 1px solid {{ $accent }}40; color: {{ $accent }};">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                </div>
                <div>
                    <span class="text-xs uppercase tracking-wider block font-medium" style="color: {{ $subtextColor }};">
                        {{ trans('prayer_times::app.time_remaining_until', [], $currentLocale) }}
                    </span>
                    <span id="nn-admin-hero-prayer" class="text-xl sm:text-2xl font-black text-white">--</span>
                </div>
            </div>
            <div class="flex items-center px-4 py-2 rounded-xl" style="background: rgba(0, 0, 0, 0.3); backdrop-filter: blur(8px); border: 1px solid {{ $accent }}30;">
                <div class="font-mono text-2xl sm:text-3xl font-extrabold tracking-wider" style="color: {{ $textColor }}; text-shadow: 0 1px 3px rgba(0,0,0,0.3);" dir="ltr">
                    <span id="nn-admin-hero-timer">--:--:--</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3 text-center">
        @php
            $displayKeys = ['Fajr', 'Sunrise', 'Dhuhr', 'Asr', 'Maghrib', 'Isha', 'Midnight'];
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
        @foreach($displayKeys as $key)
            @if(isset($prayerTimes[$key]))
                @php
                    $t24 = $prayerTimes[$key];
                    $t12 = $to12h($t24, $currentLocale);
                @endphp
                <div class="p-3 rounded-xl border border-slate-200/80 bg-slate-50/70 dark:bg-slate-800/60 dark:border-slate-700/80 transition" id="nn-prayer-card-{{ strtolower($key) }}">
                    <span class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1">
                        {{ trans('prayer_times::app.prayers.' . strtolower($key), [], $currentLocale) }}
                    </span>
                    <span class="block font-mono font-bold text-sm text-slate-800 dark:text-white" dir="ltr">
                        {{ $t12['full'] }}
                    </span>
                    <span class="block font-mono text-[11px] text-slate-400 dark:text-slate-500 mt-0.5" dir="ltr">
                        {{ $t24 }}
                    </span>
                </div>
            @endif
        @endforeach
    </div>
</div>

<script>
(function() {
    var rawTimes = @json($prayerTimes);
    var labels = {
        'Fajr': @json(trans('prayer_times::app.prayers.fajr', [], $currentLocale)),
        'Sunrise': @json(trans('prayer_times::app.prayers.sunrise', [], $currentLocale)),
        'Dhuhr': @json(trans('prayer_times::app.prayers.dhuhr', [], $currentLocale)),
        'Asr': @json(trans('prayer_times::app.prayers.asr', [], $currentLocale)),
        'Maghrib': @json(trans('prayer_times::app.prayers.maghrib', [], $currentLocale)),
        'Isha': @json(trans('prayer_times::app.prayers.isha', [], $currentLocale)),
        'Midnight': @json(trans('prayer_times::app.prayers.midnight', [], $currentLocale))
    };

    var highlightBorder = @json($highlightBorder);
    var highlightBg = @json($highlightBg);

    function parseTime(timeStr, baseDate) {
        var parts = timeStr.split(':');
        var d = new Date(baseDate.getTime());
        d.setHours(parseInt(parts[0], 10), parseInt(parts[1], 10), 0, 0);
        return d;
    }

    function updateAdminTimer() {
        var now = new Date();
        var main = ['Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];
        var nextKey = null;
        var nextDate = null;

        for (var i = 0; i < main.length; i++) {
            var k = main[i];
            if (rawTimes[k]) {
                var pd = parseTime(rawTimes[k], now);
                if (pd > now) {
                    nextKey = k;
                    nextDate = pd;
                    break;
                }
            }
        }

        if (!nextKey && rawTimes['Fajr']) {
            nextKey = 'Fajr';
            var tomorrow = new Date(now.getTime() + 24 * 60 * 60 * 1000);
            nextDate = parseTime(rawTimes['Fajr'], tomorrow);
        }

        if (!nextKey || !nextDate) return;

        var diff = Math.max(0, Math.floor((nextDate.getTime() - now.getTime()) / 1000));
        var h = Math.floor(diff / 3600);
        var m = Math.floor((diff % 3600) / 60);
        var s = diff % 60;

        var sh = h < 10 ? '0' + h : '' + h;
        var sm = m < 10 ? '0' + m : '' + m;
        var ss = s < 10 ? '0' + s : '' + s;

        var heroName = document.getElementById('nn-admin-hero-prayer');
        var heroTimer = document.getElementById('nn-admin-hero-timer');
        if (heroName) heroName.innerText = labels[nextKey] || nextKey;
        if (heroTimer) heroTimer.innerText = sh + ':' + sm + ':' + ss;

        var cards = document.querySelectorAll('[id^="nn-prayer-card-"]');
        for (var c = 0; c < cards.length; c++) {
            cards[c].style.borderColor = '';
            cards[c].style.backgroundColor = '';
            cards[c].style.boxShadow = '';
        }
        var nextCard = document.getElementById('nn-prayer-card-' + nextKey.toLowerCase());
        if (nextCard) {
            nextCard.style.borderColor = highlightBorder;
            nextCard.style.backgroundColor = highlightBg;
            nextCard.style.boxShadow = '0 0 12px -2px rgba(200, 162, 77, 0.25)';
        }
    }

    updateAdminTimer();
    setInterval(updateAdminTimer, 1000);
})();
</script>
@endif
