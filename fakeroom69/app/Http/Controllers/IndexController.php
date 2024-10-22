<?php

namespace App\Http\Controllers;

use App\Models\Class_users;
use App\Models\Classes;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskFile;

use SimpleSoftwareIO\QrCode\Facades\QrCode;


class IndexController extends Controller
{
    public function index()
    {
        $classes = Classes::all();
        $classes_ids = Class_users::where('user_id', auth()->user()->id)->get();

        if(auth()->user()->role == 1)
        {
            $classes = Classes::where('creator_id', auth()->user()->id)->get();
            $classes_ids = Class_users::where('creator_id', auth()->user()->id)->get();
        }
        return view('dashboard', compact('classes_ids', 'classes'));
    }

    
    public function joinClass(Request $request)
    {
        $join_code = $request->join_code;
        $class = Classes::where('join_code', $join_code)->first();

        if ($class) {
            $alreadyJoined = Class_users::where('class_id', $class->id)->where('user_id', auth()->user()->id)->exists();

            if (!$alreadyJoined) {
                Class_users::create([
                    'class_id' => $class->id,
                    'user_id' => auth()->user()->id,
                    'creator_id' => $class->creator_id
                ]);
                return redirect()->back()->with('message', 'You have joined the class');
            } else {
                return redirect()->back()->with('error-2', 'You are already a member of this class');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid join code');
        }
    }

    public function show($id) {

        
        $class = Classes::where('id', $id)->first();
        $available = Class_users::where('class_id', $id)->where('user_id', auth()->user()->id)->exists();
        $available2 = Classes::where('id', $id)->where('creator_id', auth()->user()->id)->exists();
        $tasks = Task::all();
        $tasks_files = TaskFile::all();
        
        if (isset($class) && ($available || $available2)) {
            $creator = User::where('id', $class->creator_id)->first();
            return view("class-show", ["class" => $class, "creator" => $creator, "tasks" => $tasks, "tasks_files" => $tasks_files]);
        }

        return redirect("/");
        // Uztaisīt skatu View vienam produktam un
        // izsaukt to no kontroliera
        
    }
    
    public function showqr($code)
    {
        // $image = QrCode::size(300)->generate('http://127.0.0.1:8000/join-class?join_code='.$code)->merge('/img/fakeroom69.png', .3) ;
        // $image = QrCode::format('png')
        // ->size(300)
        // ->color(255, 0, 0)
        // ->backgroundColor(255, 255, 255)
        // ->margin(1)
        // ->merge('/public/img/fakeroom69.png', .3);
        // ->generate('http://127.0.0.1:8000/join-class?join_code='.$code);
        return view('qrCode', ['code' => $code]);
    }
}
