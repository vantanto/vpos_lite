<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class Helper
{
    public static function trimTrailingZeroes($nbr) 
    {
        return strpos($nbr,'.')!==false ? rtrim(rtrim($nbr,'0'),'.') : $nbr;
    }

    public static function numberFormatNoZeroes($num, $decimal = 2)
    {
        return $num ? self::trimTrailingZeroes(number_format($num, $decimal)) : $num;
    }

    /**
     * Cache Setting
     */
    public static function settings($key)
    {
        if (! Cache::get('settings')) self::settingsUpdate();
        return Cache::get('settings')[$key] ?? '';
    }

    public static function settingsUpdate()
    {
        if (Schema::hasTable('settings')) {
            $settings = Setting::all()->mapWithKeys(function($setting, $key) {
                return [$setting->key => $setting->value];
            });
            Cache::forever('settings', $settings);   
        }
    }
}