<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Task;
use App\Models\TaskFile;

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
        $class->join_code = strtoupper($join_code);
        $class->creator_id = auth()->user()->id;
        $class->save();

        return redirect()->back()->with('message', 'Class created successfully');
    }

    public function store(Request $request, $class)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'file.*' => 'required|file|mimes:pdf,doc,docx,svg,jpg,png|max:2048',
        ]);

        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->class_id = $class;
        $task->save();

        $directory = '';
        $fullPath = public_path($directory);

        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0777, true);
        }

        if ($request->hasfile('file')) {
            foreach ($request->file('file') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move($fullPath, $fileName);

                $taskFile = new TaskFile();
                $taskFile->task_id = $task->id;
                $taskFile->file = $directory . '/' . $fileName;
                $taskFile->path = $directory . '/' . $fileName;
                $taskFile->save();
            }
        }

        return redirect()->back()->with('message', 'Task created successfully');
    }
}
