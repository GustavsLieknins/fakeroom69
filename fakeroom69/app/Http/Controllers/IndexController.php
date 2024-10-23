<?php

namespace App\Http\Controllers;

use App\Models\Class_users;
use App\Models\Classes;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskFile;
use App\Models\Comment;
use App\Models\Rating;

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
        $tasks_files = TaskFile::where('user_id', $class->creator_id)->get();
        $users = User::all();
        $rating = Rating::where('user_id', auth()->user()->id)->get();
        
        if (isset($class) && ($available || $available2)) {
            $creator = User::where('id', $class->creator_id)->first();
            $users = User::whereIn('id', Class_users::where('class_id', $id)->pluck('user_id'))->get();

            return view("class-show", ["class" => $class, "creator" => $creator, "tasks" => $tasks, "tasks_files" => $tasks_files, "users" => $users, "rating" => $rating]);
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

    
    public function showTask($id, $class_id)
    {
        $class = Classes::where('id', $class_id)->first();
        $task = Task::find($id);
        $users = User::all();
        $tasks_files = TaskFile::where('user_id', $class->creator_id)->get();
        $tasks_files_user = TaskFile::where('user_id', auth()->user()->id)->where('task_id', $id)->get();
        $comments = Comment::where('task_id', $id)->get();
        $rating = Rating::where('user_id', auth()->user()->id)->where('task_id', $id)->get();
        $previd = $class_id;
        return view('class-show-task', compact('task', 'tasks_files', 'comments', 'users', 'previd', 'tasks_files_user', 'rating'));
    }

    
    public function removeUser(Request $request, $class, $user)
    {
        Class_users::where('class_id', $class)->where('user_id', $user)->delete();
        return redirect()->back()->with('message', 'User has been removed from the class');
    }
    public function storeFiles(Request $request, $task)
    {
        $request->validate([
            'file.*' => 'required|file|mimes:pdf,doc,docx,svg,jpg,png|max:2048',
        ]);

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
                $taskFile->task_id = $task;
                $taskFile->file = $directory . $fileName;
                $taskFile->path = $directory . '/' . $fileName;
                $taskFile->user_id = auth()->user()->id;
                $taskFile->save();
                // return "here";
            }
        }

        return redirect()->back()->with('message', 'Files uploaded successfully');
        // return "done";
    }

    public function destroyFile($task, $file)
    {
        $taskFile = TaskFile::where('task_id', $task)->where('id', $file)->first();

        if ($taskFile && $taskFile->user_id == auth()->user()->id) {
            $filePath = public_path($taskFile->path);

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $taskFile->delete();
            $ratings = Rating::where('user_id', $taskFile->user_id)->where('task_id', $task)->delete();
            return redirect()->back()->with('message', 'File deleted successfully');
        }

        return redirect()->back()->with('error', 'You do not have permission to delete this file');
    }
    
    public function grade($class)
    {
        $task = Task::where('id', $class)->first();
        // $tasks = Task::where('class_id', $class->class_id)->get();
        $users = User::all();
        $tasks_files = TaskFile::all();
        $ratings = Rating::all();

        return view('class-grade', compact('task', 'users', 'tasks_files', 'ratings'));
    }
 
    
    public function gradeStore(Request $request, $task)
    {
        $task = Task::find($task);

        $request->validate([
            'rating.*' => 'required|integer|between:1,10',
        ]);

        foreach ($request->rating as $user_id => $rating) {
            Rating::updateOrCreate(
                [
                    'user_id' => $user_id,
                    'class_id' => $task->class_id,
                    'task_id' => $task->id,
                ],
                [
                    'rating' => $rating,
                ]
            );
        }

        return redirect()->back()->with('message', 'Submissions graded successfully');
    }

    // Route::post('/tasks/{task}/files', [IndexController::class, 'storeFiles'])->name('files.store');
    // <form method="POST" action="{{ route('files.store', ['task' => $task->id]) }}" enctype="multipart/form-data" class="joinclass-div flex flex-col items-center p-6 bg-white rounded-lg shadow-lg">
    //                         @csrf
    //                         <p class="text-lg font-semibold">Add files</p>
    //                         <div class="file-div flex flex-col space-y-2 mt-4">
    //                             <input type="file" name="file[]" class="bg-gray-100 border-2 border-gray-300 rounded-lg p-2 w-full">
    //                             <button class="add-more bg-gray-500 text-white rounded-lg px-4 py-2">Add more files</button>
    //                         </div>
    //                         <button class="mt-4 bg-blue-500 text-white rounded-lg px-4 py-2" type="submit">Submit</button>
    //                     </form>
    

}
