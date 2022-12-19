<?php

namespace Database\Seeders;

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
        $settings = [
            ['key' => 'store-name', 'value' => 'VPOS Lite Store'],
            ['key' => 'store-address', 'value' => 'VPOS Lite street no.1'],
            ['key' => 'store-phone', 'value' => null],
            ['key' => 'tax', 'value' => '11'],
        ];

        foreach ($settings as $key => $setting) {
            $settings[$key]['default'] = $setting['value'];
            $settings[$key]['created_at'] = $datetime;
            $settings[$key]['updated_at'] = $datetime;
        }

        Setting::insert($settings);
    }
}
