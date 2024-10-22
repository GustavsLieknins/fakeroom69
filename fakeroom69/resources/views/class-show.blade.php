<x-app-layout>
    <style>
        .main-wrapper
        {
            display: flex;
            flex-direction: column;
            /* justify-content: center; */
            position: relative;
            align-items: center;
            min-height: 61vh;
        }
        .card-background {
            -webkit-mask-image: -webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0)));
            mask-image: linear-gradient(to bottom, rgba(0,0,0,1), rgba(0,0,0,0));
            object-fit: fit;
            border-radius: 4px;
            border: 2px solid gray;
            width: 60vw;
            height: 30vh
        }
        .first, .last, .last-hover {
            left: 50%;
            transform: translateX(-50%);
            position: absolute;
            font-weight: 900;
            color: black;
        }
        .first {
            bottom: 140px;
            font-size: xxx-large;
        }
        .last {
            bottom: 120px;
            font-size: medium;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 45ch;
        }
        .last-hover {
            visibility: hidden;
            opacity: 0;
            bottom: 70px;
            font-size: medium;
            white-space: nowrap;
            overflow: hidden;
            background-color: rgba(128, 128, 128, 0.1);
            padding: 10px 20px;
            border-radius: 4px;
            transition: opacity 0.15s ease, visibility 0.15s ease;
        }

        .last:hover + .last-hover {
            visibility: visible;
            opacity: 1;
        }

        .big-thing
        {
            position: relative;
            display: flex;
            justify-content: center;
            padding: 20px;
            padding-bottom: 0px;
        }
        .info-div
        {
            padding: 10px 10px;
            width: 60vw;
            border-right: 3px solid black;
            border-left: 3px solid black;
            min-height: 61vh;
            padding-bottom: 30px;
        }
        .info-div > div
        {
            min-height: 100%;
        }
        .bg-code
        {
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
        .code-div {
            display: none;
            font-size: xxx-large;
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
        }.close-icon
            {
                position: absolute;
                top: 10px;
                right: 10px;
                height: 70px;
                width: 70px;
            }

        /* Mobile view */
        @media only screen and (max-width: 600px) {
            .main-wrapper {
                flex-direction: column;
                align-items: center;
            }
            .card-background {
                width: 100vw;
                height: 25vh;
            }
            .big-thing {
                padding: 20px 20px;
            }
            .info-div {
                width: 100vw;
                border-right: none;
                border-left: none;
            }
            .code-div {
                width: 100vw;
                left: 0;
                top: 50%;
                transform: translateY(-50%);
            }

            .first 
            {
                bottom: 120px;
                font-size: xx-large;
            }
            .last 
            {
                bottom: 100px;
                font-size: small;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 45ch;
            }
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
    </style>
    <div class="main-wrapper">
        <a href="/">
            <img src="{{ asset('img/back.svg') }}" alt="back.svg" class="backsvg">
        </a>
        <div class="bg-code">
            <img src="../img/close.svg" alt="close.svg" class="close-icon">
            <div class="code-div">
                <p>{{ $class->join_code }}</p>
            </div>
        </div>
        <div class="big-thing">
            <img class="card-background" src="../img/whiteboard.jpg" alt="fakeroom-background">
            <p class="first">{{ $class->class }}</p>
            <p class="last">
                {{ $class->description }}
            </p>
            <p class="last-hover">
                {{ $class->description }}
            </p>
        </div>
        <div class="info-div">
            <div class="p-4 space-y-4">
                <!-- <h1 class="text-4xl font-bold">{{ $class->class }}</h1>
                <p class="text-xl">{{ $class->description }}</p> -->
                @if (auth()->user()->role == 1 || auth()->user()->role == 2)
                    <button class="px-4 py-2 bg-gray-500 text-white rounded-lg">Reveal join code</button>
                    <a class="px-4 py-2 bg-gray-500 text-white rounded-lg" href="/showqr/{{ $class->join_code }}">Show qr code</a>

                    <form action="{{ route('tasks.store', ['class' => $class->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-4 rounded-lg shadow-lg">
                        <h2 class="text-2xl font-bold">Create task</h2>
                        @csrf
                        <div class="my-4">
                            <label for="title" class="block text-lg font-semibold">Title</label>
                            <input type="text" name="title" id="title" class="bg-gray-100 border-2 border-gray-300 rounded-lg p-2 w-full">
                        </div>
                        <div class="my-4">
                            <label for="description" class="block text-lg font-semibold">Description</label>
                            <input type="text" name="description" id="description" class="bg-gray-100 border-2 border-gray-300 rounded-lg p-2 w-full">
                        </div>
                        <div class="my-4">
                            <h3 class="text-lg font-semibold">Add files</h3>
                            <div class="flex flex-row space-x-4">
                                <input type="file" name="file[]" class="bg-gray-100 border-2 border-gray-300 rounded-lg p-2 w-full">
                                <button type="button" id="add-file" class="bg-gray-500 text-white rounded-lg px-4 py-2">Add more</button>
                            </div>
                            <div id="file-inputs" class="flex flex-col space-y-2 mt-4">
                            </div>
                        </div>
                        <button type="submit" class="bg-gray-500 text-white rounded-lg px-4 py-2">Create</button>
                    </form>
                @endif
                <p class="text-lg">Creator: {{ $creator->username }}</p>
                <h2 class="text-2xl font-bold">Tasks</h2>
                @foreach ($tasks->where('class_id', $class->id) as $task)
                    <a href="{{ route('show.task', ['task' => $task->id, 'class_id' => $class->id]) }}">
                        <div class="bg-white p-4 rounded-lg shadow-lg my-4">
                            <h3 class="text-lg font-semibold">{{ $task->title }}</h3>
                            <p>{{ $task->description }}</p>
                            <div class="flex flex-row space-x-4">
                                @foreach ($tasks_files->where('task_id', $task->id) as $task_file)
                                    <a href="{{ asset($task_file->path) }}" class="bg-gray-500 text-white rounded-lg px-4 py-2 truncate max-w-xs" target="_blank" rel="noopener noreferrer">{{ $task_file->file }}</a>
                                @endforeach
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            @if (auth()->user()->role == 1)
                <h2 class="text-2xl font-bold">Users:</h2>
                    <ul class="list-disc pl-4 space-y-2">
                        @foreach ($users as $user)
                            <li class="text-lg flex items-center">
                                {{ $user->username }}
                                @if (auth()->user()->role == 1)
                                    <form action="{{ route('class.remove.user', ['class' => $class->id, 'user' => $user->id]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-red-500 hover:text-red-700 ml-2">X</button>
                                    </form>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
        </div>
    </div>

    <script>
        let addFileButton = document.querySelector('#add-file');
        let fileInputs = document.querySelector('#file-inputs');

        addFileButton.addEventListener('click', function(event) {
            event.preventDefault();
            let input = document.createElement('input');
            input.type = 'file';
            input.name = 'file[]';
            input.classList.add('bg-gray-100', 'border-2', 'border-gray-300', 'rounded-lg', 'p-2', 'w-full');
            fileInputs.appendChild(input);
        });


        let codeDiv = document.querySelector('.code-div');
        let bgCode = document.querySelector('.bg-code');
        let joinCodeButton = document.querySelector('.info-div > div > button');

        document.addEventListener('click', function(event) {
            if (!event.target.closest('.code-div') && !event.target.closest('.info-div > div > button')) {
                codeDiv.style.display = 'none';
                bgCode.style.display = 'none';
            }
        });

        joinCodeButton.addEventListener('click', function() {
            codeDiv.style.display = 'flex';
            bgCode.style.display = 'flex';
        });
        
        </script>
    </x-app-layout>
