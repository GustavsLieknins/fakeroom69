<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class teacherController extends Controller
{
    public function index()
    {
        return view('teacher-create');
    }

    
    public function create(Request $request)
    {
        $request->validate([
            'class' => 'required',
            'description' => 'required',
            'join_code' => 'nullable|unique:classes,join_code|size:8',
        ]);

        $class = new \App\Models\Classes();
        $class->class = $request->class;
        $class->description = $request->description;
        $join_code = $request->join_code;
        if (!$join_code) {
            do {
                $join_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);
            } while (\App\Models\Classes::where('join_code', $join_code)->exists());
        }
        $class->join_code = $join_code;
        $class->creator_id = auth()->user()->id;
        $class->save();

        return redirect()->back()->with('message', 'Class created successfully');
    }
}
