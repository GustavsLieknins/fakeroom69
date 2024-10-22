<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Comment;
use App\Models\Task;

class CommentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'text' => 'required',
        ]);

        $comment = new Comment();
        $comment->text = $request->text;
        $comment->task_id = $request->task_id;
        $comment->user_id = auth()->user()->id;
        // $task->comments()->create([
        //     'text' => $request->text,
        //     'task_id' => $request->task_id,
        //     'user_id' => auth()->user()->id,
        // ]);

        // $task->title = $request->title;

        $comment->save();

        return redirect()->back()->with('message', 'Comment added successfully');
    }
}