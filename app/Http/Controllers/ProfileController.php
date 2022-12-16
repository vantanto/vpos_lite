<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'avatar' => 'nullable|mimes:jpeg,jpg,png|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'msg' => $validator->messages()], 400);
        }

        $user = Auth::user();
        $user->name = $request->name;

        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::delete($user->avatar);
            $file = $request->avatar;
            $filename = time() . $user->id . '.' . $file->extension();
            $user->avatar = 'avatar/' . $filename;

            Storage::disk('public')->put($user->avatar, file_get_contents($file));
        }

        $user->save();
        return response()->json(['status' => 'success', 'msg' => 'User Successfully Updated'], 200);
    }
}
