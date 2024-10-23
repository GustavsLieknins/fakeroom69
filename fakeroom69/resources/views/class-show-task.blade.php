<x-app-layout>
    <style>
        .main-wrapper
        {
            position: relative;
        }
        .backsvg
        {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 45px;
            height: 45px;
        }
        @media only screen and (max-width: 600px) {
            .backsvg
            {
                top: 5px;
                width: 35px;
                height: 35px;
            }
        }
        .div-done {
            position: absolute;
            top: 10px;
            right: 10px;
            border: 2px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }
        
        .div-done:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        }

        .button-done {
            width: 100%;
            height: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button-done:hover {
            background-color: #45a049;
        }


        .backdrop {
                z-index: 20;
                display: none;
                z-index: 20;
                position: fixed;
                backdrop-filter: blur(0px);
                width: 100vw;
                top: 0;
                bottom: 0;
                height: 100vh;
                backdrop-filter: blur(3px);
                animation: backdrop 0.12s;
            }
            @keyframes backdrop {
                0% {
                    backdrop-filter: blur(0px);
                }
                100% {
                    backdrop-filter: blur(3px);
                }
            }
            .close-icon
            {
                position: absolute;
                top: 10px;
                right: 10px;
                height: 70px;
                width: 70px;
            }
            .joinclass-div {
                display: none;
                z-index: 10;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: white;
                padding: 20px;
                border-radius: 4px;
                box-shadow: 0 0 4px 0 gray;
                flex-direction: column;
                align-items: center;
            }
            .add-more
            {
                position: relative;
                z-index: 23;
            }
    </style>
    <div class="py-12 main-wrapper">
                    <div class="backdrop">
                        <img src="../../img/close.svg" alt="close.svg" class="close-icon">
                        <form method="POST" action="{{ route('files.store', ['task' => $task->id]) }}" enctype="multipart/form-data" class="joinclass-div flex flex-col items-center p-6 bg-white rounded-lg shadow-lg">
                            @csrf
                            <p class="text-lg font-semibold">Add files</p>
                            <div class="file-div flex flex-col space-y-2 mt-4">
                                <input type="file" name="file[]" class="bg-gray-100 border-2 border-gray-300 rounded-lg p-2 w-full">
                                <button class="add-more bg-gray-500 text-white rounded-lg px-4 py-2">Add more files</button>
                            </div>
                            <button class="mt-4 bg-blue-500 text-white rounded-lg px-4 py-2" type="submit">Submit</button>
                        </form>
                    </div>
        <a href="/class/{{ $previd }}">
            <img src="{{ asset('img/back.svg') }}" alt="back.svg" class="backsvg">
        </a>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 relative">
                    @if ($tasks_files_user->count() > 0 && auth()->user()->role !== 1)
                        <div style="position: absolute; right: 0;" class="bg-green-100 border border-green-400 p-4 rounded-lg">
                            <p class="font-semibold text-green-700">Marked as done</p>
                            <div class="mt-2 space-y-2">
                                @foreach ($tasks_files_user as $task_file_user)
                                    <div class="flex items-center">
                                        <a class="bg-gray-600 text-white rounded-lg px-1 py-0.5 truncate max-w-xs hover:bg-gray-700" href="{{ asset($task_file_user->path) }}" target="_blank">{{ Str::limit($task_file_user->file, 20) }}</a>
                                        <form method="POST" action="{{ route('files.destroy', ['task' => $task->id, 'file' => $task_file_user->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 ml-1">X</button>
                                        </form>
                                    </div>
                                @endforeach
                                    @if (isset($rating[0]))
                                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-2">
                                            <p class="font-bold">Your Rating: {{ $rating[0]->rating }}/10</p>
                                        </div>
                                    @endif
                            </div>
                        </div>
                    @elseif (auth()->user()->role == 0)
                        <div class="div-done">
                            <button class="button-done but-done">Mark as done</button>
                        </div>
                    @elseif (auth()->user()->role == 1)
                        <div class="flex justify-end">
                            <a href="{{ route('class.grade', ['class' => $task->id]) }}" class="text-blue-500 hover:text-blue-700 hover:underline">Grade submissions</a>
                        </div>
                    @endif
                    <h1 class="text-3xl font-bold">{{ $task->title }}</h1>
                    <p class="mt-4 text-gray-700">{{ $task->description }}</p>
                    <div class="mt-6">
                        <h2 class="text-lg font-semibold">Files:</h2>
                        <div class="mt-2 space-y-2">
                            @foreach ($tasks_files->where('task_id', $task->id) as $task_file)
                                <a class="block bg-gray-600 text-white rounded-lg px-4 py-2 truncate max-w-xs hover:bg-gray-700" href="{{ asset($task_file->path) }}" target="_blank" rel="noopener noreferrer">{{ $task_file->file }}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-12">
                        <h2 class="text-lg font-semibold">Comments:</h2>
                        <div class="mt-2 space-y-2">
                            @foreach ($comments->reverse()->take(5) as $comment)
                                <div class="bg-gray-100 p-4 rounded-lg">
                                    <p class="text-gray-700">{{ $comment->text }}</p>
                                    <p class="text-gray-500 text-sm">{{ $comment->created_at->format('d.m.Y H:i') }} by {{ $users[ $comment->user_id - 2 ]->username }}</p>
                                </div>
                            @endforeach
                            @if ($comments->count() > 5)
                                <div class="text-center">
                                    <a href="#" class="text-blue-500 hover:text-blue-700 hover:underline" id="show-more-comments">Show more comments</a>
                                </div>
                                <div id="more-comments" style="display: none;" class="space-y-2">
                                    @foreach ($comments->reverse()->skip(5) as $comment)
                                        <div class="bg-gray-100 p-4 rounded-lg">
                                            <p class="text-gray-700">{{ $comment->text }}</p>
                                            <p class="text-gray-500 text-sm">{{ $comment->created_at->format('d.m.Y H:i') }} by {{ $users[ $comment->user_id - 2]->username }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <form action="{{ route('comments.store', ['task' => $task->id]) }}" method="POST" class="mt-4">
                            @csrf
                            <textarea name="text" id="text" rows="3" class="block w-full bg-white border border-gray-300 rounded-lg p-2 resize-none"></textarea>
                            <input type="hidden" value="{{ $task->id }}" name="task_id">
                            <button type="submit" class="mt-2 bg-gray-500 text-white rounded-lg px-4 py-2">Add comment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    let joinclassDiv = document.querySelector('.joinclass-div');
        let backdrop = document.querySelector('.backdrop');
        let joinButton = document.querySelector('.but-done');

        document.addEventListener('click', function(event) {
            if (!event.target.closest('.joinclass-div') && !event.target.closest('.but-done')) {
                joinclassDiv.style.display = 'none';
                backdrop.style.display = 'none';
            }
        });

        joinButton.addEventListener('click', function() {
            joinclassDiv.style.display = 'flex';
            backdrop.style.display = 'flex';
        });


        let addMoreButton = document.querySelector('.add-more');
        let fileDiv = document.querySelector('.file-div');

        addMoreButton.addEventListener('click', function(event) {
            event.preventDefault();
            let input = document.createElement('input');
            input.type = 'file';
            input.name = 'file[]';
            input.classList.add('bg-gray-100', 'border-2', 'border-gray-300', 'rounded-lg', 'p-2', 'w-full');
            fileDiv.insertBefore(input, addMoreButton);
        });


    document.getElementById('show-more-comments').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('more-comments').style.display = 'block';
        this.style.display = 'none';
    });


    
</script>
