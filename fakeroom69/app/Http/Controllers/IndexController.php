<?php

namespace App\Http\Controllers;

use App\Models\Class_users;
use App\Models\Classes;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $classes = Classes::all();
        $classes_ids = Class_users::where('user_id', auth()->user()->id)->get();
        return view('dashboard', compact('classes_ids', 'classes'));
    }

    
    public function joinClass(Request $request)
    {
        $join_code = $request->input('join_code');
        $class = Classes::where('join_code', $join_code)->first();

        if ($class) {
            $alreadyJoined = Class_users::where('class_id', $class->id)
                ->where('user_id', auth()->user()->id)
                ->exists();

            if (!$alreadyJoined) {
                Class_users::create([
                    'class_id' => $class->id,
                    'user_id' => auth()->user()->id
                ]);
                return redirect()->back()->with('message', 'You have joined the class');
            } else {
                return redirect()->back()->with('error-2', 'You are already a member of this class');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid join code');
        }
    }
}
