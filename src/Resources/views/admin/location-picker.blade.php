@php
    $locationData = \NumbersNebula\PrayerTimes\Helpers\LocationHelper::getCountriesWithCities();
    $currentLocale = core()->getCurrentLocale()?->code ?? app()->getLocale() ?? 'ar';
    $savedLocationName = core()->getConfigData('general.prayer_times.settings.location_name') ?: 'مسقط';
    $savedLat = core()->getConfigData('general.prayer_times.settings.latitude') ?: '23.5880';
    $savedLng = core()->getConfigData('general.prayer_times.settings.longitude') ?: '58.3829';

    $matchedCountryCode = null;
    $matchedCityIndex = -1;

    foreach ($locationData as $cCode => $cData) {
        foreach ($cData['cities'] as $idx => $city) {
            if ($savedLocationName && ($city['name_ar'] === $savedLocationName || $city['name_en'] === $savedLocationName)) {
                $matchedCountryCode = $cCode;
                $matchedCityIndex = $idx;
                break 2;
            }
            if (abs($city['lat'] - (float)$savedLat) < 0.05 && abs($city['lng'] - (float)$savedLng) < 0.05) {
                $matchedCountryCode = $cCode;
                $matchedCityIndex = $idx;
                break 2;
            }
        }
    }

    if (! $matchedCountryCode) {
        $matchedCountryCode = 'OM';
        $matchedCityIndex = 0;
    }
@endphp

<link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}" />
<style>
    .nn-leaflet-map {
        position: relative !important;
        overflow: hidden !important;
        z-index: 1 !important;
        width: 100% !important;
        height: 340px !important;
        min-height: 340px !important;
    }
    .nn-leaflet-map .leaflet-pane {
        z-index: 2 !important;
    }
    .nn-leaflet-map .leaflet-tile-pane {
        z-index: 2 !important;
    }
    .nn-leaflet-map .leaflet-control-zoom {
        border: none !important;
        border-radius: 0.75rem !important;
        overflow: hidden !important;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1) !important;
        margin: 12px !important;
    }
    .nn-leaflet-map .leaflet-control-zoom a {
        background-color: #ffffff !important;
        color: #1e293b !important;
        border: 1px solid #e2e8f0 !important;
        line-height: 28px !important;
        width: 32px !important;
        height: 32px !important;
    }
    .nn-leaflet-map .leaflet-control-zoom a:hover {
        background-color: #f8fafc !important;
    }
    .nn-leaflet-pin {
        background: transparent !important;
        border: none !important;
    }
</style>

<div class="mb-6 rounded-2xl border border-slate-200/90 bg-slate-50/70 p-5 dark:border-slate-800 dark:bg-slate-900/60 shadow-xs">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 mb-4 border-b border-slate-200/70 dark:border-slate-800">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 dark:bg-emerald-950/70 dark:text-emerald-400 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                    <circle cx="12" cy="9" r="3" />
                </svg>
            </div>
            <div>
                <h4 class="text-sm sm:text-base font-bold text-slate-800 dark:text-white leading-tight">
                    {{ trans('prayer_times::app.admin.system.location_picker') }}
                </h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                    {{ trans('prayer_times::app.admin.system.map_picker_hint') }}
                </p>
            </div>
        </div>

        <button
            type="button"
            id="nn-btn-device-location"
            onclick="window.nnLocationPicker && window.nnLocationPicker.useDeviceGps()"
            class="inline-flex items-center justify-center gap-2 px-3.5 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:border-emerald-500 hover:text-emerald-600 dark:hover:border-emerald-500 dark:hover:text-emerald-400 text-xs font-semibold shadow-xs transition cursor-pointer select-none"
        >
            <svg id="nn-gps-icon" class="w-4 h-4 text-emerald-600 dark:text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="3" />
                <path stroke-linecap="round" d="M12 2v3m0 14v3M2 12h3m14 0h3" />
                <circle cx="12" cy="12" r="7" />
            </svg>
            <span id="nn-gps-text">{{ trans('prayer_times::app.admin.system.use_device_location') }}</span>
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
        <div>
            <label for="nn-country-selector" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                {{ trans('prayer_times::app.admin.system.country') }}
            </label>
            <select
                id="nn-country-selector"
                onchange="window.nnLocationPicker && window.nnLocationPicker.onCountryChange(this.value)"
                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-xs sm:text-sm font-normal text-slate-700 shadow-sm transition hover:border-slate-300 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200"
            >
                <option value="">{{ trans('prayer_times::app.admin.system.select_country') }}</option>
                @foreach($locationData as $code => $country)
                    <option value="{{ $code }}" {{ $matchedCountryCode === $code ? 'selected' : '' }}>
                        {{ $currentLocale === 'ar' ? $country['name_ar'] : $country['name_en'] }} ({{ $code }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="nn-city-selector" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                {{ trans('prayer_times::app.admin.system.city') }}
            </label>
            <select
                id="nn-city-selector"
                onchange="window.nnLocationPicker && window.nnLocationPicker.onCityChange(this.value)"
                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-xs sm:text-sm font-normal text-slate-700 shadow-sm transition hover:border-slate-300 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200"
            >
                <option value="">{{ trans('prayer_times::app.admin.system.select_city') }}</option>
                @if(isset($locationData[$matchedCountryCode]['cities']))
                    @foreach($locationData[$matchedCountryCode]['cities'] as $idx => $city)
                        <option value="{{ $idx }}" {{ $matchedCityIndex === $idx ? 'selected' : '' }}>
                            {{ $currentLocale === 'ar' ? ($city['name_ar'] . ' (' . $city['name_en'] . ')') : ($city['name_en'] . ' (' . $city['name_ar'] . ')') }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>

    <div class="relative rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700 shadow-sm" style="min-height: 340px;">
        <div id="nn-prayer-leaflet-map" class="nn-leaflet-map w-full bg-slate-100 dark:bg-slate-800" style="height: 340px; min-height: 340px; width: 100%; position: relative;"></div>

        <div class="absolute bottom-2.5 left-2.5 rtl:left-auto rtl:right-2.5 z-20 pointer-events-none">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-900/80 text-white backdrop-blur-md text-[11px] font-mono shadow-md border border-white/10" dir="ltr">
                <span class="text-emerald-400 font-bold">GPS:</span>
                <span id="nn-map-coords-badge">{{ number_format((float)$savedLat, 4, '.', '') }} , {{ number_format((float)$savedLng, 4, '.', '') }}</span>
            </div>
        </div>
    </div>

    <div id="nn-gps-alert" class="hidden mt-3 p-3 rounded-xl text-xs font-medium bg-emerald-50 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800/80 transition-all"></div>
</div>

<script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
<script>
    (function() {
        var rawData = @json($locationData);
        var currentLocale = @json($currentLocale);
        var selectCityLabel = @json(trans('prayer_times::app.admin.system.select_city'));
        var mapInstance = null;
        var markerInstance = null;

        var initialLat = {{ (float)$savedLat }};
        var initialLng = {{ (float)$savedLng }};

        function findFieldInputs(suffix) {
            var selectors = [
                'input[name*="[' + suffix + ']"]',
                'select[name*="[' + suffix + ']"]',
                'input[name$="' + suffix + '"]',
                'select[name$="' + suffix + '"]',
                'input#' + suffix,
                'select#' + suffix
            ];
            return document.querySelectorAll(selectors.join(', '));
        }

        function setInputValue(suffix, val) {
            var inputs = findFieldInputs(suffix);
            inputs.forEach(function(input) {
                input.value = val;
                input.dispatchEvent(new Event('input', { bubbles: true }));
                input.dispatchEvent(new Event('change', { bubbles: true }));
            });
        }

        function updateCoordsBadge(lat, lng) {
            var badge = document.getElementById('nn-map-coords-badge');
            if (badge) {
                badge.innerText = Number(lat).toFixed(4) + ' , ' + Number(lng).toFixed(4);
            }
        }

        function showAlert(msg, isError) {
            var box = document.getElementById('nn-gps-alert');
            if (!box) return;
            box.innerText = msg;
            box.classList.remove('hidden', 'bg-emerald-50', 'text-emerald-800', 'border-emerald-200', 'bg-rose-50', 'text-rose-800', 'border-rose-200');
            if (isError) {
                box.classList.add('bg-rose-50', 'text-rose-800', 'border-rose-200', 'dark:bg-rose-950/60', 'dark:text-rose-300');
            } else {
                box.classList.add('bg-emerald-50', 'text-emerald-800', 'border-emerald-200', 'dark:bg-emerald-950/60', 'dark:text-emerald-300');
            }
            setTimeout(function() {
                box.classList.add('hidden');
            }, 6000);
        }

        function createSvgIcon() {
            return L.divIcon({
                className: 'nn-leaflet-pin',
                html: '<div style="position:relative; width:34px; height:46px; transform:translate(-17px, -46px); filter: drop-shadow(0 4px 6px rgba(0,0,0,0.35));">' +
                      '<svg width="34" height="46" viewBox="0 0 30 42" fill="none" xmlns="http://www.w3.org/2000/svg">' +
                      '<path d="M15 0C6.716 0 0 6.716 0 15C0 26.25 15 42 15 42C15 42 30 26.25 30 15C30 6.716 23.284 0 15 0Z" fill="#059669"/>' +
                      '<circle cx="15" cy="15" r="6" fill="#ffffff"/>' +
                      '</svg>' +
                      '</div>',
                iconSize: [34, 46],
                iconAnchor: [17, 46]
            });
        }

        function triggerMapInvalidate() {
            if (mapInstance) {
                mapInstance.invalidateSize({ pan: false });
            }
        }

        function initLeafletMap(lat, lng) {
            var container = document.getElementById('nn-prayer-leaflet-map');
            if (!container || typeof L === 'undefined') return;

            if (mapInstance) {
                try {
                    mapInstance.remove();
                } catch (e) {}
                mapInstance = null;
            }

            if (container._leaflet_id) {
                try {
                    container._leaflet_id = null;
                } catch (e) {}
            }

            mapInstance = L.map(container, {
                center: [lat, lng],
                zoom: 10,
                zoomControl: true,
                attributionControl: false,
                trackResize: true
            });

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: 'OpenStreetMap'
            }).addTo(mapInstance);

            markerInstance = L.marker([lat, lng], {
                draggable: true,
                icon: createSvgIcon()
            }).addTo(mapInstance);

            updateCoordsBadge(lat, lng);

            setTimeout(triggerMapInvalidate, 60);
            setTimeout(triggerMapInvalidate, 200);
            setTimeout(triggerMapInvalidate, 500);
            setTimeout(triggerMapInvalidate, 1000);
            setTimeout(triggerMapInvalidate, 2000);

            if (window.ResizeObserver) {
                var ro = new ResizeObserver(function() {
                    triggerMapInvalidate();
                });
                ro.observe(container);
            }

            window.addEventListener('resize', triggerMapInvalidate);

            markerInstance.on('dragend', function(e) {
                var pos = e.target.getLatLng();
                handleNewCoords(pos.lat, pos.lng);
            });

            mapInstance.on('click', function(e) {
                var pos = e.latlng;
                markerInstance.setLatLng(pos);
                handleNewCoords(pos.lat, pos.lng);
            });
        }

        function handleNewCoords(lat, lng) {
            var latFixed = Number(lat).toFixed(4);
            var lngFixed = Number(lng).toFixed(4);

            setInputValue('latitude', latFixed);
            setInputValue('longitude', lngFixed);
            updateCoordsBadge(latFixed, lngFixed);

            var countrySelect = document.getElementById('nn-country-selector');
            var countryCode = countrySelect ? countrySelect.value : null;
            if (countryCode && rawData[countryCode] && rawData[countryCode].cities) {
                var cities = rawData[countryCode].cities;
                var closestIdx = -1;
                var minDistance = 0.35;
                for (var i = 0; i < cities.length; i++) {
                    var dist = Math.sqrt(Math.pow(cities[i].lat - lat, 2) + Math.pow(cities[i].lng - lng, 2));
                    if (dist < minDistance) {
                        minDistance = dist;
                        closestIdx = i;
                    }
                }
                var citySelect = document.getElementById('nn-city-selector');
                if (citySelect) {
                    if (closestIdx !== -1) {
                        citySelect.value = closestIdx;
                        var c = cities[closestIdx];
                        var cityName = currentLocale === 'ar' ? c.name_ar : c.name_en;
                        setInputValue('location_name', cityName);
                        setInputValue('timezone', c.timezone);
                        if (c.method !== undefined) {
                            setInputValue('method', c.method);
                        }
                    }
                }
            }
        }

        window.nnLocationPicker = {
            onCountryChange: function(countryCode) {
                if (!countryCode) return;
                var country = rawData[countryCode];
                if (!country || !country.cities || !country.cities.length) return;

                var citySelect = document.getElementById('nn-city-selector');
                if (citySelect) {
                    citySelect.innerHTML = '<option value="">' + selectCityLabel + '</option>';
                    country.cities.forEach(function(city, idx) {
                        var opt = document.createElement('option');
                        opt.value = idx;
                        var label = currentLocale === 'ar' ? (city.name_ar + ' (' + city.name_en + ')') : (city.name_en + ' (' + city.name_ar + ')');
                        opt.textContent = label;
                        citySelect.appendChild(opt);
                    });
                    citySelect.value = 0;
                }

                this.onCityChange(0, countryCode);
            },

            onCityChange: function(cityIndex, explicitCountryCode) {
                var countrySelect = document.getElementById('nn-country-selector');
                var countryCode = explicitCountryCode || (countrySelect ? countrySelect.value : null);
                if (!countryCode) return;

                var country = rawData[countryCode];
                if (!country || !country.cities) return;

                var idx = parseInt(cityIndex, 10);
                if (isNaN(idx) || idx < 0 || !country.cities[idx]) return;

                var city = country.cities[idx];
                var cityName = currentLocale === 'ar' ? city.name_ar : city.name_en;

                setInputValue('location_name', cityName);
                setInputValue('latitude', city.lat);
                setInputValue('longitude', city.lng);
                setInputValue('timezone', city.timezone);

                if (city.method !== undefined) {
                    setInputValue('method', city.method);
                }

                if (mapInstance && markerInstance) {
                    var newPos = [city.lat, city.lng];
                    markerInstance.setLatLng(newPos);
                    mapInstance.setView(newPos, 10, { animate: true });
                    updateCoordsBadge(city.lat, city.lng);
                    triggerMapInvalidate();
                }
            },

            useDeviceGps: function() {
                var textSpan = document.getElementById('nn-gps-text');

                if (!navigator.geolocation) {
                    showAlert(@json(trans('prayer_times::app.admin.system.location_error')), true);
                    return;
                }

                if (textSpan) textSpan.innerText = @json(trans('prayer_times::app.admin.system.detecting_location'));

                navigator.geolocation.getCurrentPosition(function(pos) {
                    if (textSpan) textSpan.innerText = @json(trans('prayer_times::app.admin.system.use_device_location'));
                    var lat = pos.coords.latitude;
                    var lng = pos.coords.longitude;

                    handleNewCoords(lat, lng);

                    if (mapInstance && markerInstance) {
                        markerInstance.setLatLng([lat, lng]);
                        mapInstance.setView([lat, lng], 12, { animate: true });
                        triggerMapInvalidate();
                    }

                    var offsetMin = -new Date().getTimezoneOffset();
                    var sign = offsetMin >= 0 ? '+' : '-';
                    var absH = String(Math.floor(Math.abs(offsetMin) / 60)).padStart(2, '0');
                    var absM = String(Math.abs(offsetMin) % 60).padStart(2, '0');
                    var tzVal = sign + absH + ':' + absM;

                    setInputValue('timezone', tzVal);

                    showAlert(@json(trans('prayer_times::app.admin.system.location_detected')), false);
                }, function(err) {
                    if (textSpan) textSpan.innerText = @json(trans('prayer_times::app.admin.system.use_device_location'));
                    showAlert(@json(trans('prayer_times::app.admin.system.location_error')), true);
                }, {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                });
            }
        };

        function setupLocationComponent() {
            var latInput = document.querySelector('input[name*="[latitude]"]');
            var lngInput = document.querySelector('input[name*="[longitude]"]');

            var mapLat = latInput ? (parseFloat(latInput.value) || initialLat) : initialLat;
            var mapLng = lngInput ? (parseFloat(lngInput.value) || initialLng) : initialLng;

            if (typeof L === 'undefined') {
                var script = document.querySelector('script[src*="leaflet.js"]');
                if (script) {
                    script.addEventListener('load', function() {
                        initLeafletMap(mapLat, mapLng);
                    });
                } else {
                    var s = document.createElement('script');
                    s.src = '{{ asset("vendor/leaflet/leaflet.js") }}';
                    s.onload = function() {
                        initLeafletMap(mapLat, mapLng);
                    };
                    document.head.appendChild(s);
                }
            } else {
                initLeafletMap(mapLat, mapLng);
            }
        }

        document.addEventListener('change', function(e) {
            if (!e.target || !e.target.name) return;
            if (e.target.name.indexOf('[latitude]') !== -1 || e.target.name.indexOf('[longitude]') !== -1) {
                var latInput = document.querySelector('input[name*="[latitude]"]');
                var lngInput = document.querySelector('input[name*="[longitude]"]');
                if (latInput && lngInput) {
                    var latVal = parseFloat(latInput.value);
                    var lngVal = parseFloat(lngInput.value);
                    if (!isNaN(latVal) && !isNaN(lngVal) && mapInstance && markerInstance) {
                        markerInstance.setLatLng([latVal, lngVal]);
                        mapInstance.panTo([latVal, lngVal]);
                        updateCoordsBadge(latVal, lngVal);
                        triggerMapInvalidate();
                    }
                }
            }
        });

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', setupLocationComponent);
        } else {
            setTimeout(setupLocationComponent, 100);
        }
    })();
</script>
