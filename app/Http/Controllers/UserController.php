<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query();
        if ($request->search) {
            $users->where(function($query) use($request) {
                $query->where('name', 'like', "%{$request->search}%")
                    ->orWhere('username', 'like', "%{$request->search}%");
            });
        }
        $users = $users->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('user.index', compact('users'));
    }

    public function create(Request $request)
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'nullable|email|unique:users,email',
            'password' => ['required', Rules\Password::defaults()],
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'msg' => $validator->messages()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json(['status' => 'success', 'msg' => 'User Successfully Created'], 200);
    }

    public function edit(Request $request, $id)
    {
        $user = User::find($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users,username,'.$id,
            'email' => 'nullable|email|unique:users,email,'.$id,
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'msg' => $validator->messages()], 400);
        }

        $user = User::find($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->save();
        return response()->json(['status' => 'success', 'msg' => 'User Successfully Updated'], 200);        
    }

    public function destroy(Request $request, $id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')->with('success', 'User Successfully Deleted');
    }
}
