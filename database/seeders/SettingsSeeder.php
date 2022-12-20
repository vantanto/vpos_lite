<?php

namespace Database\Seeders;

use App\Helpers\Helper;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datetime = now();
        $settings = Setting::all()->keyBy('key');
        $setting_defaults = collect(Setting::$Default)->keyBy('key');

        $setting_diffs = $setting_defaults->diffKeys($settings)->all();
        if ($setting_diffs) {
            foreach ($setting_diffs as $key => $setting_diff) {
                $setting_diffs[$key]['value'] = $setting_diff['default'];
                $setting_diffs[$key]['created_at'] = $datetime;
                $setting_diffs[$key]['updated_at'] = $datetime;
            }
            Setting::insert($setting_diffs);

            Helper::settingsUpdate();
        }
    }
}
