<?php

namespace NumbersNebula\PrayerTimes\Helpers;

/**
 * Class LocationHelper
 *
 * Provides structured country and city coordinates, timezones, and recommended calculation methods.
 */
class LocationHelper
{
    /**
     * Get all structured countries with their major cities.
     */
    public static function getCountriesWithCities(): array
    {
        return [
            'OM' => [
                'name_ar' => 'سلطنة عُمان',
                'name_en' => 'Oman',
                'cities' => [
                    ['name_ar' => 'مسقط', 'name_en' => 'Muscat', 'lat' => 23.5880, 'lng' => 58.3829, 'timezone' => '+04:00', 'method' => 3],
                    ['name_ar' => 'صلالة', 'name_en' => 'Salalah', 'lat' => 17.0151, 'lng' => 54.0924, 'timezone' => '+04:00', 'method' => 3],
                    ['name_ar' => 'صحار', 'name_en' => 'Sohar', 'lat' => 24.3461, 'lng' => 56.7075, 'timezone' => '+04:00', 'method' => 3],
                    ['name_ar' => 'نزوى', 'name_en' => 'Nizwa', 'lat' => 22.9333, 'lng' => 57.5333, 'timezone' => '+04:00', 'method' => 3],
                    ['name_ar' => 'صور', 'name_en' => 'Sur', 'lat' => 22.5667, 'lng' => 59.5289, 'timezone' => '+04:00', 'method' => 3],
                    ['name_ar' => 'السيب', 'name_en' => 'Seeb', 'lat' => 23.6703, 'lng' => 58.1891, 'timezone' => '+04:00', 'method' => 3],
                    ['name_ar' => 'الرستاق', 'name_en' => 'Rustaq', 'lat' => 23.3908, 'lng' => 57.4244, 'timezone' => '+04:00', 'method' => 3],
                    ['name_ar' => 'البريمي', 'name_en' => 'Al Buraimi', 'lat' => 24.2509, 'lng' => 55.7931, 'timezone' => '+04:00', 'method' => 3],
                    ['name_ar' => 'عبري', 'name_en' => 'Ibri', 'lat' => 23.2257, 'lng' => 56.5157, 'timezone' => '+04:00', 'method' => 3],
                    ['name_ar' => 'خصب', 'name_en' => 'Khasab', 'lat' => 26.1799, 'lng' => 56.2477, 'timezone' => '+04:00', 'method' => 3],
                ],
            ],
            'SA' => [
                'name_ar' => 'المملكة العربية السعودية',
                'name_en' => 'Saudi Arabia',
                'cities' => [
                    ['name_ar' => 'مكة المكرمة', 'name_en' => 'Makkah', 'lat' => 21.4225, 'lng' => 39.8262, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'المدينة المنورة', 'name_en' => 'Madinah', 'lat' => 24.4672, 'lng' => 39.6111, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'الرياض', 'name_en' => 'Riyadh', 'lat' => 24.7136, 'lng' => 46.6753, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'جدة', 'name_en' => 'Jeddah', 'lat' => 21.5433, 'lng' => 39.1728, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'الدمام', 'name_en' => 'Dammam', 'lat' => 26.4207, 'lng' => 50.0888, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'الخبر', 'name_en' => 'Khobar', 'lat' => 26.2172, 'lng' => 50.1971, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'الطائف', 'name_en' => 'Taif', 'lat' => 21.2854, 'lng' => 40.4222, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'تبوك', 'name_en' => 'Tabuk', 'lat' => 28.3835, 'lng' => 36.5662, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'بريدة', 'name_en' => 'Buraidah', 'lat' => 26.3260, 'lng' => 43.9750, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'أبها', 'name_en' => 'Abha', 'lat' => 18.2164, 'lng' => 42.5053, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'نجران', 'name_en' => 'Najran', 'lat' => 17.4924, 'lng' => 44.1277, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'جازان', 'name_en' => 'Jazan', 'lat' => 16.8892, 'lng' => 42.5511, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'حائل', 'name_en' => 'Hail', 'lat' => 27.5219, 'lng' => 41.6959, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'ينبع', 'name_en' => 'Yanbu', 'lat' => 24.0891, 'lng' => 38.0637, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'الأحساء', 'name_en' => 'Al Ahsa', 'lat' => 25.3835, 'lng' => 49.5864, 'timezone' => '+03:00', 'method' => 4],
                ],
            ],
            'AE' => [
                'name_ar' => 'الإمارات العربية المتحدة',
                'name_en' => 'United Arab Emirates',
                'cities' => [
                    ['name_ar' => 'أبوظبي', 'name_en' => 'Abu Dhabi', 'lat' => 24.4539, 'lng' => 54.3773, 'timezone' => '+04:00', 'method' => 3],
                    ['name_ar' => 'دبي', 'name_en' => 'Dubai', 'lat' => 25.2048, 'lng' => 55.2708, 'timezone' => '+04:00', 'method' => 3],
                    ['name_ar' => 'الشارقة', 'name_en' => 'Sharjah', 'lat' => 25.3463, 'lng' => 55.4209, 'timezone' => '+04:00', 'method' => 3],
                    ['name_ar' => 'عجمان', 'name_en' => 'Ajman', 'lat' => 25.4052, 'lng' => 55.5136, 'timezone' => '+04:00', 'method' => 3],
                    ['name_ar' => 'رأس الخيمة', 'name_en' => 'Ras Al Khaimah', 'lat' => 25.7895, 'lng' => 55.9432, 'timezone' => '+04:00', 'method' => 3],
                    ['name_ar' => 'الفجيرة', 'name_en' => 'Fujairah', 'lat' => 25.1288, 'lng' => 56.3265, 'timezone' => '+04:00', 'method' => 3],
                    ['name_ar' => 'أم القيوين', 'name_en' => 'Umm Al Quwain', 'lat' => 25.5647, 'lng' => 55.5552, 'timezone' => '+04:00', 'method' => 3],
                    ['name_ar' => 'العين', 'name_en' => 'Al Ain', 'lat' => 24.2075, 'lng' => 55.7447, 'timezone' => '+04:00', 'method' => 3],
                ],
            ],
            'KW' => [
                'name_ar' => 'دولة الكويت',
                'name_en' => 'Kuwait',
                'cities' => [
                    ['name_ar' => 'مدينة الكويت', 'name_en' => 'Kuwait City', 'lat' => 29.3759, 'lng' => 47.9774, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'حولي', 'name_en' => 'Hawalli', 'lat' => 29.3328, 'lng' => 48.0289, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'السالمية', 'name_en' => 'Salmiya', 'lat' => 29.3344, 'lng' => 48.0772, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'الأحمدي', 'name_en' => 'Al Ahmadi', 'lat' => 29.0769, 'lng' => 48.0839, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'الجهراء', 'name_en' => 'Al Jahra', 'lat' => 29.3375, 'lng' => 47.6581, 'timezone' => '+03:00', 'method' => 4],
                ],
            ],
            'QA' => [
                'name_ar' => 'دولة قطر',
                'name_en' => 'Qatar',
                'cities' => [
                    ['name_ar' => 'الدوحة', 'name_en' => 'Doha', 'lat' => 25.2854, 'lng' => 51.5310, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'الريان', 'name_en' => 'Al Rayyan', 'lat' => 25.2919, 'lng' => 51.4244, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'الوكرة', 'name_en' => 'Al Wakrah', 'lat' => 25.1768, 'lng' => 51.6048, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'الخور', 'name_en' => 'Al Khor', 'lat' => 25.6839, 'lng' => 51.5058, 'timezone' => '+03:00', 'method' => 4],
                ],
            ],
            'BH' => [
                'name_ar' => 'مملكة البحرين',
                'name_en' => 'Bahrain',
                'cities' => [
                    ['name_ar' => 'المنامة', 'name_en' => 'Manama', 'lat' => 26.2285, 'lng' => 50.5860, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'المحرق', 'name_en' => 'Muharraq', 'lat' => 26.2572, 'lng' => 50.6119, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'الرفاع', 'name_en' => 'Riffa', 'lat' => 26.1300, 'lng' => 50.5550, 'timezone' => '+03:00', 'method' => 4],
                ],
            ],
            'EG' => [
                'name_ar' => 'جمهورية مصر العربية',
                'name_en' => 'Egypt',
                'cities' => [
                    ['name_ar' => 'القاهرة', 'name_en' => 'Cairo', 'lat' => 30.0444, 'lng' => 31.2357, 'timezone' => '+02:00', 'method' => 5],
                    ['name_ar' => 'الإسكندرية', 'name_en' => 'Alexandria', 'lat' => 31.2001, 'lng' => 29.9187, 'timezone' => '+02:00', 'method' => 5],
                    ['name_ar' => 'الجيزة', 'name_en' => 'Giza', 'lat' => 30.0131, 'lng' => 31.2089, 'timezone' => '+02:00', 'method' => 5],
                    ['name_ar' => 'بورسعيد', 'name_en' => 'Port Said', 'lat' => 31.2653, 'lng' => 32.3019, 'timezone' => '+02:00', 'method' => 5],
                    ['name_ar' => 'السويس', 'name_en' => 'Suez', 'lat' => 29.9668, 'lng' => 32.5498, 'timezone' => '+02:00', 'method' => 5],
                    ['name_ar' => 'المنصورة', 'name_en' => 'Mansoura', 'lat' => 31.0409, 'lng' => 31.3785, 'timezone' => '+02:00', 'method' => 5],
                    ['name_ar' => 'طنطا', 'name_en' => 'Tanta', 'lat' => 30.7865, 'lng' => 31.0004, 'timezone' => '+02:00', 'method' => 5],
                    ['name_ar' => 'أسوان', 'name_en' => 'Aswan', 'lat' => 24.0889, 'lng' => 32.8998, 'timezone' => '+02:00', 'method' => 5],
                    ['name_ar' => 'الأقصر', 'name_en' => 'Luxor', 'lat' => 25.6872, 'lng' => 32.6396, 'timezone' => '+02:00', 'method' => 5],
                ],
            ],
            'JO' => [
                'name_ar' => 'المملكة الأردنية الهاشمية',
                'name_en' => 'Jordan',
                'cities' => [
                    ['name_ar' => 'عمّان', 'name_en' => 'Amman', 'lat' => 31.9454, 'lng' => 35.9284, 'timezone' => '+03:00', 'method' => 3],
                    ['name_ar' => 'الزرقاء', 'name_en' => 'Zarqa', 'lat' => 32.0728, 'lng' => 36.0880, 'timezone' => '+03:00', 'method' => 3],
                    ['name_ar' => 'إربد', 'name_en' => 'Irbid', 'lat' => 32.5568, 'lng' => 35.8469, 'timezone' => '+03:00', 'method' => 3],
                    ['name_ar' => 'العقبة', 'name_en' => 'Aqaba', 'lat' => 29.5321, 'lng' => 35.0063, 'timezone' => '+03:00', 'method' => 3],
                ],
            ],
            'PS' => [
                'name_ar' => 'فلسطين',
                'name_en' => 'Palestine',
                'cities' => [
                    ['name_ar' => 'القدس الشريف', 'name_en' => 'Jerusalem', 'lat' => 31.7683, 'lng' => 35.2137, 'timezone' => '+03:00', 'method' => 3],
                    ['name_ar' => 'غزة', 'name_en' => 'Gaza', 'lat' => 31.5017, 'lng' => 34.4668, 'timezone' => '+03:00', 'method' => 3],
                    ['name_ar' => 'رام الله', 'name_en' => 'Ramallah', 'lat' => 31.9038, 'lng' => 35.2034, 'timezone' => '+03:00', 'method' => 3],
                    ['name_ar' => 'الخليل', 'name_en' => 'Hebron', 'lat' => 31.5326, 'lng' => 35.0998, 'timezone' => '+03:00', 'method' => 3],
                    ['name_ar' => 'نابلس', 'name_en' => 'Nablus', 'lat' => 32.2211, 'lng' => 35.2544, 'timezone' => '+03:00', 'method' => 3],
                ],
            ],
            'IQ' => [
                'name_ar' => 'جمهورية العراق',
                'name_en' => 'Iraq',
                'cities' => [
                    ['name_ar' => 'بغداد', 'name_en' => 'Baghdad', 'lat' => 33.3152, 'lng' => 44.3661, 'timezone' => '+03:00', 'method' => 3],
                    ['name_ar' => 'البصرة', 'name_en' => 'Basra', 'lat' => 30.5085, 'lng' => 47.7804, 'timezone' => '+03:00', 'method' => 3],
                    ['name_ar' => 'أربيل', 'name_en' => 'Erbil', 'lat' => 36.1901, 'lng' => 44.0091, 'timezone' => '+03:00', 'method' => 3],
                    ['name_ar' => 'الموصل', 'name_en' => 'Mosul', 'lat' => 36.3400, 'lng' => 43.1300, 'timezone' => '+03:00', 'method' => 3],
                    ['name_ar' => 'النجف الأشرف', 'name_en' => 'Najaf', 'lat' => 32.0000, 'lng' => 44.3333, 'timezone' => '+03:00', 'method' => 0],
                    ['name_ar' => 'كربلاء', 'name_en' => 'Karbala', 'lat' => 32.6160, 'lng' => 44.0249, 'timezone' => '+03:00', 'method' => 0],
                ],
            ],
            'YE' => [
                'name_ar' => 'الجمهورية اليمنية',
                'name_en' => 'Yemen',
                'cities' => [
                    ['name_ar' => 'صنعاء', 'name_en' => 'Sanaa', 'lat' => 15.3694, 'lng' => 44.1910, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'عدن', 'name_en' => 'Aden', 'lat' => 12.7855, 'lng' => 45.0187, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'تعز', 'name_en' => 'Taiz', 'lat' => 13.5795, 'lng' => 44.0209, 'timezone' => '+03:00', 'method' => 4],
                    ['name_ar' => 'المكلا', 'name_en' => 'Mukalla', 'lat' => 14.5425, 'lng' => 49.1242, 'timezone' => '+03:00', 'method' => 4],
                ],
            ],
            'LB' => [
                'name_ar' => 'الجمهورية اللبنانية',
                'name_en' => 'Lebanon',
                'cities' => [
                    ['name_ar' => 'بيروت', 'name_en' => 'Beirut', 'lat' => 33.8938, 'lng' => 35.5018, 'timezone' => '+03:00', 'method' => 3],
                    ['name_ar' => 'طرابلس', 'name_en' => 'Tripoli', 'lat' => 34.4367, 'lng' => 35.8497, 'timezone' => '+03:00', 'method' => 3],
                    ['name_ar' => 'صيدا', 'name_en' => 'Sidon', 'lat' => 33.5631, 'lng' => 35.3689, 'timezone' => '+03:00', 'method' => 3],
                ],
            ],
            'SY' => [
                'name_ar' => 'الجمهورية العربية السورية',
                'name_en' => 'Syria',
                'cities' => [
                    ['name_ar' => 'دمشق', 'name_en' => 'Damascus', 'lat' => 33.5138, 'lng' => 36.2765, 'timezone' => '+03:00', 'method' => 3],
                    ['name_ar' => 'حلب', 'name_en' => 'Aleppo', 'lat' => 36.2021, 'lng' => 37.1343, 'timezone' => '+03:00', 'method' => 3],
                    ['name_ar' => 'حمص', 'name_en' => 'Homs', 'lat' => 34.7324, 'lng' => 36.7137, 'timezone' => '+03:00', 'method' => 3],
                    ['name_ar' => 'اللاذقية', 'name_en' => 'Latakia', 'lat' => 35.5317, 'lng' => 35.7901, 'timezone' => '+03:00', 'method' => 3],
                ],
            ],
            'MA' => [
                'name_ar' => 'المملكة المغربية',
                'name_en' => 'Morocco',
                'cities' => [
                    ['name_ar' => 'الرباط', 'name_en' => 'Rabat', 'lat' => 34.0209, 'lng' => -6.8416, 'timezone' => '+01:00', 'method' => 3],
                    ['name_ar' => 'الدار البيضاء', 'name_en' => 'Casablanca', 'lat' => 33.5731, 'lng' => -7.5898, 'timezone' => '+01:00', 'method' => 3],
                    ['name_ar' => 'فاس', 'name_en' => 'Fes', 'lat' => 34.0181, 'lng' => -5.0078, 'timezone' => '+01:00', 'method' => 3],
                    ['name_ar' => 'مراكش', 'name_en' => 'Marrakesh', 'lat' => 31.6295, 'lng' => -7.9811, 'timezone' => '+01:00', 'method' => 3],
                    ['name_ar' => 'طنجة', 'name_en' => 'Tangier', 'lat' => 35.7595, 'lng' => -5.8340, 'timezone' => '+01:00', 'method' => 3],
                    ['name_ar' => 'أكادير', 'name_en' => 'Agadir', 'lat' => 30.4278, 'lng' => -9.5981, 'timezone' => '+01:00', 'method' => 3],
                ],
            ],
            'DZ' => [
                'name_ar' => 'الجمهورية الجزائرية',
                'name_en' => 'Algeria',
                'cities' => [
                    ['name_ar' => 'الجزائر العاصمة', 'name_en' => 'Algiers', 'lat' => 36.7538, 'lng' => 3.0588, 'timezone' => '+01:00', 'method' => 3],
                    ['name_ar' => 'وهران', 'name_en' => 'Oran', 'lat' => 35.6987, 'lng' => -0.6349, 'timezone' => '+01:00', 'method' => 3],
                    ['name_ar' => 'قسنطينة', 'name_en' => 'Constantine', 'lat' => 36.3650, 'lng' => 6.6147, 'timezone' => '+01:00', 'method' => 3],
                    ['name_ar' => 'عنابة', 'name_en' => 'Annaba', 'lat' => 36.9000, 'lng' => 7.7667, 'timezone' => '+01:00', 'method' => 3],
                ],
            ],
            'TN' => [
                'name_ar' => 'الجمهورية التونسية',
                'name_en' => 'Tunisia',
                'cities' => [
                    ['name_ar' => 'تونس', 'name_en' => 'Tunis', 'lat' => 36.8065, 'lng' => 10.1815, 'timezone' => '+01:00', 'method' => 3],
                    ['name_ar' => 'صفاقس', 'name_en' => 'Sfax', 'lat' => 34.7406, 'lng' => 10.7603, 'timezone' => '+01:00', 'method' => 3],
                    ['name_ar' => 'سوسة', 'name_en' => 'Sousse', 'lat' => 35.8256, 'lng' => 10.6369, 'timezone' => '+01:00', 'method' => 3],
                    ['name_ar' => 'القيروان', 'name_en' => 'Kairouan', 'lat' => 35.6781, 'lng' => 10.0963, 'timezone' => '+01:00', 'method' => 3],
                ],
            ],
            'LY' => [
                'name_ar' => 'دولة ليبيا',
                'name_en' => 'Libya',
                'cities' => [
                    ['name_ar' => 'طرابلس', 'name_en' => 'Tripoli', 'lat' => 32.8872, 'lng' => 13.1913, 'timezone' => '+02:00', 'method' => 5],
                    ['name_ar' => 'بنغازي', 'name_en' => 'Benghazi', 'lat' => 32.1167, 'lng' => 20.0667, 'timezone' => '+02:00', 'method' => 5],
                    ['name_ar' => 'مصراتة', 'name_en' => 'Misrata', 'lat' => 32.3754, 'lng' => 15.0925, 'timezone' => '+02:00', 'method' => 5],
                ],
            ],
            'SD' => [
                'name_ar' => 'جمهورية السودان',
                'name_en' => 'Sudan',
                'cities' => [
                    ['name_ar' => 'الخرطوم', 'name_en' => 'Khartoum', 'lat' => 15.5007, 'lng' => 32.5599, 'timezone' => '+02:00', 'method' => 5],
                    ['name_ar' => 'أم درمان', 'name_en' => 'Omdurman', 'lat' => 15.6500, 'lng' => 32.4833, 'timezone' => '+02:00', 'method' => 5],
                    ['name_ar' => 'بورتسودان', 'name_en' => 'Port Sudan', 'lat' => 19.6175, 'lng' => 37.2164, 'timezone' => '+02:00', 'method' => 5],
                ],
            ],
            'TR' => [
                'name_ar' => 'الجمهورية التركية',
                'name_en' => 'Turkey',
                'cities' => [
                    ['name_ar' => 'إسطنبول', 'name_en' => 'Istanbul', 'lat' => 41.0082, 'lng' => 28.9784, 'timezone' => '+03:00', 'method' => 3],
                    ['name_ar' => 'أنقرة', 'name_en' => 'Ankara', 'lat' => 39.9334, 'lng' => 32.8597, 'timezone' => '+03:00', 'method' => 3],
                    ['name_ar' => 'إزمير', 'name_en' => 'Izmir', 'lat' => 38.4237, 'lng' => 27.1428, 'timezone' => '+03:00', 'method' => 3],
                    ['name_ar' => 'بورصة', 'name_en' => 'Bursa', 'lat' => 40.1885, 'lng' => 29.0610, 'timezone' => '+03:00', 'method' => 3],
                    ['name_ar' => 'قونية', 'name_en' => 'Konya', 'lat' => 37.8746, 'lng' => 32.4932, 'timezone' => '+03:00', 'method' => 3],
                    ['name_ar' => 'غازي عنتاب', 'name_en' => 'Gaziantep', 'lat' => 37.0662, 'lng' => 37.3833, 'timezone' => '+03:00', 'method' => 3],
                ],
            ],
            'MY' => [
                'name_ar' => 'ماليزيا',
                'name_en' => 'Malaysia',
                'cities' => [
                    ['name_ar' => 'كوالالمبور', 'name_en' => 'Kuala Lumpur', 'lat' => 3.1390, 'lng' => 101.6869, 'timezone' => '+08:00', 'method' => 3],
                    ['name_ar' => 'جورج تاون', 'name_en' => 'George Town', 'lat' => 5.4141, 'lng' => 100.3288, 'timezone' => '+08:00', 'method' => 3],
                    ['name_ar' => 'جوهور باهرو', 'name_en' => 'Johor Bahru', 'lat' => 1.4927, 'lng' => 103.7414, 'timezone' => '+08:00', 'method' => 3],
                ],
            ],
            'ID' => [
                'name_ar' => 'إندونيسيا',
                'name_en' => 'Indonesia',
                'cities' => [
                    ['name_ar' => 'جاكرتا', 'name_en' => 'Jakarta', 'lat' => -6.2088, 'lng' => 106.8456, 'timezone' => '+07:00', 'method' => 3],
                    ['name_ar' => 'سورابايا', 'name_en' => 'Surabaya', 'lat' => -7.2575, 'lng' => 112.7521, 'timezone' => '+07:00', 'method' => 3],
                    ['name_ar' => 'باندونغ', 'name_en' => 'Bandung', 'lat' => -6.9175, 'lng' => 107.6191, 'timezone' => '+07:00', 'method' => 3],
                ],
            ],
            'PK' => [
                'name_ar' => 'جمهورية باكستان الإسلامية',
                'name_en' => 'Pakistan',
                'cities' => [
                    ['name_ar' => 'كراتشي', 'name_en' => 'Karachi', 'lat' => 24.8607, 'lng' => 67.0011, 'timezone' => '+05:00', 'method' => 1],
                    ['name_ar' => 'لاهور', 'name_en' => 'Lahore', 'lat' => 31.5204, 'lng' => 74.3587, 'timezone' => '+05:00', 'method' => 1],
                    ['name_ar' => 'إسلام أباد', 'name_en' => 'Islamabad', 'lat' => 33.6844, 'lng' => 73.0479, 'timezone' => '+05:00', 'method' => 1],
                    ['name_ar' => 'راولبندي', 'name_en' => 'Rawalpindi', 'lat' => 33.5651, 'lng' => 73.0169, 'timezone' => '+05:00', 'method' => 1],
                ],
            ],
            'IN' => [
                'name_ar' => 'الهند',
                'name_en' => 'India',
                'cities' => [
                    ['name_ar' => 'نيودلهي', 'name_en' => 'New Delhi', 'lat' => 28.6139, 'lng' => 77.2090, 'timezone' => '+05:30', 'method' => 1],
                    ['name_ar' => 'مومباي', 'name_en' => 'Mumbai', 'lat' => 19.0760, 'lng' => 72.8777, 'timezone' => '+05:30', 'method' => 1],
                    ['name_ar' => 'حيدر أباد', 'name_en' => 'Hyderabad', 'lat' => 17.3850, 'lng' => 78.4867, 'timezone' => '+05:30', 'method' => 1],
                ],
            ],
            'BD' => [
                'name_ar' => 'بنغلاديش',
                'name_en' => 'Bangladesh',
                'cities' => [
                    ['name_ar' => 'دكا', 'name_en' => 'Dhaka', 'lat' => 23.8103, 'lng' => 90.4125, 'timezone' => '+06:00', 'method' => 1],
                    ['name_ar' => 'شيتاغونغ', 'name_en' => 'Chittagong', 'lat' => 22.3569, 'lng' => 91.7832, 'timezone' => '+06:00', 'method' => 1],
                ],
            ],
            'GB' => [
                'name_ar' => 'المملكة المتحدة',
                'name_en' => 'United Kingdom',
                'cities' => [
                    ['name_ar' => 'لندن', 'name_en' => 'London', 'lat' => 51.5074, 'lng' => -0.1278, 'timezone' => '+00:00', 'method' => 3],
                    ['name_ar' => 'برمنغهام', 'name_en' => 'Birmingham', 'lat' => 52.4862, 'lng' => -1.8904, 'timezone' => '+00:00', 'method' => 3],
                    ['name_ar' => 'مانشستر', 'name_en' => 'Manchester', 'lat' => 53.4808, 'lng' => -2.2426, 'timezone' => '+00:00', 'method' => 3],
                ],
            ],
            'US' => [
                'name_ar' => 'الولايات المتحدة الأمريكية',
                'name_en' => 'United States',
                'cities' => [
                    ['name_ar' => 'نيويورك', 'name_en' => 'New York', 'lat' => 40.7128, 'lng' => -74.0060, 'timezone' => '-05:00', 'method' => 2],
                    ['name_ar' => 'شيكاغو', 'name_en' => 'Chicago', 'lat' => 41.8781, 'lng' => -87.6298, 'timezone' => '-06:00', 'method' => 2],
                    ['name_ar' => 'لوس أنجلوس', 'name_en' => 'Los Angeles', 'lat' => 34.0522, 'lng' => -118.2437, 'timezone' => '-08:00', 'method' => 2],
                    ['name_ar' => 'هيوستن', 'name_en' => 'Houston', 'lat' => 29.7604, 'lng' => -95.3698, 'timezone' => '-06:00', 'method' => 2],
                    ['name_ar' => 'واشنطن العاصمة', 'name_en' => 'Washington DC', 'lat' => 38.9072, 'lng' => -77.0369, 'timezone' => '-05:00', 'method' => 2],
                ],
            ],
            'CA' => [
                'name_ar' => 'كندا',
                'name_en' => 'Canada',
                'cities' => [
                    ['name_ar' => 'تورونتو', 'name_en' => 'Toronto', 'lat' => 43.6532, 'lng' => -79.3832, 'timezone' => '-05:00', 'method' => 2],
                    ['name_ar' => 'مونتريال', 'name_en' => 'Montreal', 'lat' => 45.5017, 'lng' => -73.5673, 'timezone' => '-05:00', 'method' => 2],
                    ['name_ar' => 'فانكوفر', 'name_en' => 'Vancouver', 'lat' => 49.2827, 'lng' => -123.1207, 'timezone' => '-08:00', 'method' => 2],
                ],
            ],
            'FR' => [
                'name_ar' => 'فرنسا',
                'name_en' => 'France',
                'cities' => [
                    ['name_ar' => 'باريس', 'name_en' => 'Paris', 'lat' => 48.8566, 'lng' => 2.3522, 'timezone' => '+01:00', 'method' => 3],
                    ['name_ar' => 'مارسيليا', 'name_en' => 'Marseille', 'lat' => 43.2965, 'lng' => 5.3698, 'timezone' => '+01:00', 'method' => 3],
                    ['name_ar' => 'ليون', 'name_en' => 'Lyon', 'lat' => 45.7640, 'lng' => 4.8357, 'timezone' => '+01:00', 'method' => 3],
                ],
            ],
            'DE' => [
                'name_ar' => 'ألمانيا',
                'name_en' => 'Germany',
                'cities' => [
                    ['name_ar' => 'برلين', 'name_en' => 'Berlin', 'lat' => 52.5200, 'lng' => 13.4050, 'timezone' => '+01:00', 'method' => 3],
                    ['name_ar' => 'فرانكفورت', 'name_en' => 'Frankfurt', 'lat' => 50.1109, 'lng' => 8.6821, 'timezone' => '+01:00', 'method' => 3],
                    ['name_ar' => 'ميونخ', 'name_en' => 'Munich', 'lat' => 48.1351, 'lng' => 11.5820, 'timezone' => '+01:00', 'method' => 3],
                ],
            ],
            'AU' => [
                'name_ar' => 'أستراليا',
                'name_en' => 'Australia',
                'cities' => [
                    ['name_ar' => 'سيدني', 'name_en' => 'Sydney', 'lat' => -33.8688, 'lng' => 151.2093, 'timezone' => '+10:00', 'method' => 3],
                    ['name_ar' => 'ملبورن', 'name_en' => 'Melbourne', 'lat' => -37.8136, 'lng' => 144.9631, 'timezone' => '+10:00', 'method' => 3],
                ],
            ],
        ];
    }
}
