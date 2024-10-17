<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class adminController extends Controller
{
    public function index() {
        $users = User::all();
        
        return view("admin", ["users" => $users]);
    }

    public function findUser(Request $request) {

        $user = User::find($request->user_id);


        return view("admin", ["user" => $user]);
    }

    public function roleChange(Request $request) {

        $user = User::find($request->user_id);
        if($request->has("user_role"))
        {
            $user->role = $request->user_role;
            $user->save();
                return back()->withInput($request->input());
        }

        return view("admin", ["user" => $user]);
    }

    public function userDelete(Request $request) {

        $user = User::find($request->user_id);
        $user->delete();

        $users = User::all();
        return view("admin", ["users" => $users]);
    }
    
    public function userCreate(Request $request) {
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'user_role' => 'required',
        ]);

        $user = new User();
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->role = $request->user_role;
        $user->save();

        $users = User::all();
        
        return view("admin", ["users" => $users]);
    }
}