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
            $setting_defaults = Setting::$Default;
            foreach ($setting_defaults as $key => $setting_default) {
                $setting_defaults[$key]['value'] = $request->input($setting_default['key']);
            }
            Setting::upsert($setting_defaults, ['key'], ['value']);

            DB::commit();

            Helper::settingsUpdate();

            return response()->json(['status' => 'success', 'msg' => 'Setting Successfully updated'], 200);
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['status' => 'error', 'msg' => config('app.debug') ? $ex->getMessage() : 'Setting Failed Updated'], 500);
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
            return response()->json(['status' => 'error', 'msg' => config('app.debug') ? $ex->getMessage() : 'Setting Failed Restored'], 500);
        }
    }
}
