<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $method = "index";
        $settings = Setting::all()->keyBy('key');
        return view('setting.index', compact('method', 'settings'));
    }

    public function edit(Request $request)
    {
        $method = "edit";
        $settings = Setting::all()->keyBy('key');
        return view('setting.index', compact('method', 'settings'));
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = [
                'store-name',
                'store-address',
                'store-phone',
            ];

            foreach ($validated as $settingKey) {
                $inputValue = $request->input($settingKey);
                if ($inputValue) {
                    Setting::where('key', $settingKey)->update(['value' => $inputValue]);
                }
            }

            DB::commit();

            Helper::settingsUpdate();

            return response()->json(['status' => 'success', 'msg' => 'Setting Successfully updated'], 200);
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['status' => 'error', 'msg' => 'Setting Failed updated'], 500);
        }
    }

    public function restore()
    {
        DB::beginTransaction();
        try {
            DB::statement('UPDATE settings SET `value` = `default`');
            DB::commit();

            Helper::settingsUpdate();

            return redirect()->route('settings.index')->with('success', 'Settting Success Restored');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('settings.index')->with('error', 'Settting Failed Restored');
        }
    }
}
