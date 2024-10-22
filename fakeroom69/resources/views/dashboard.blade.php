<x-app-layout>
    <style>
        .card-background {
            -webkit-mask-image: -webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0)));
            mask-image: linear-gradient(to bottom, rgba(0,0,0,1), rgba(0,0,0,0.0));
            object-fit: cover;
            border-radius: 4px;
            border: 2px solid gray;
        }
        .main-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            width: 80vw;
            position: relative;
            padding: 10px;
            align-content: flex-start
        }
        .side-bar {
            width: 20vw;
            /* border-left: 1px solid gray; */
            box-shadow: -1px 0 3px -1px gray;
        }
        .side-bar > div {
            padding: 10px;
            display: flex;
            justify-content: center;
        }
        .side-bar > div > button {
            padding: 10px 20px;
            background-color: gray;
            color: white;
            border-radius: 4px;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }
        .side-bar > div > a > button {
            padding: 10px 20px;
            background-color: gray;
            color: white;
            border-radius: 4px;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }
        .side-bar > div > button:hover {
            background-color: #444;
        }
        .main-wrapper > a {
            margin: 10px;
            height: max-content;
        }
        .main-wrapper > a > div {
            position: relative;
            transition: all ease-in-out 0.1s;
        }
        .main-wrapper > a:hover > div 
        {
            transform: scale(1.06);
        }
        .main-wrapper > a > div > p {
            position: absolute;
            font-weight: 900;
            color: black;
        }
        .first, .last {
            left: 50%;
            transform: translateX(-50%);
        }
        .first {
            bottom: 70px;
            font-size: x-large;
        }
        .last {
            bottom: 50px;
            font-size: small;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 45ch;
        }
        .mainmain-wrapper {
            width: 100vw;
            min-height: 100vh;
            display: flex;
            flex-direction: row;
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
        .joinclass-div > p {
            margin-bottom: 20px;
        }
        .joinclass-div > form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .joinclass-div > form > input {
            padding: 10px;
            margin-bottom: 20px;
        }
        .joinclass-div > form > button {
            background-color: gray;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }
        .joinclass-div > form > button:hover {
            background-color: #444;
        }
        @media only screen and (max-width: 600px) {
            .main-wrapper {
                display: block;
            }
            .main-wrapper > a {
                margin: 5px;
            }
            .first {
                bottom: 60px;
            }
            .last {
                bottom: 40px;
                max-width: 35ch;
            }
        }


        .pop-up-wrapper
        {
            /* display: flex; */
            position: relative;
            width: 100vw;
            /* justify-content: end; */
        }
        .pop-up
        {
            z-index: 10;
            color: green;
            border-radius: 4px;
            font-size: large;
            position: absolute;
            min-width: max-content;
            /* width: 10vw; */
            text-align: center;
            background-color: #111;
            padding: 30px 10px;
            animation: popup 6s forwards;
            right: 23vw;
            top: -55px;

        }
        .pop-up > p
        {
            font-weight: bold;
        }
        .red-error
        {
            color: red !important;
        }
        .blue-error
        {
            color: blue !important;
        }
        @keyframes popup {
            0% {
                right: -200px;
                opacity: 0;
            }
            3% {
                right: 10px;
                opacity: 1;
            }
            95% { 
                right: 10px;
                opacity: 1;
            }
            100% {
                right: -200px;
                opacity: 0;
            }
        }
     
            .backdrop {
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
    </style>
    @if (session('message') || session('error') || session('error-2'))
        <div class="pop-up-wrapper">
            <div class="@if(session('error')) red-error @endif @if(session('error-2')) blue-error @endif pop-up">
                <p>@if(session('message')) Class added @elseif(session('error'))  Invalid code @else Already joined @endif</p>
            </div>
        </div>
    @endif
    <div class="mainmain-wrapper">
        <div class="backdrop">
            <img src="img/close.svg" alt="close.svg" class="close-icon">
            <div class="joinclass-div">
                <p>Enter your code</p>
                <form action="{{ route('joinClass') }}" method="GET">
                    @csrf
                    <input type="text" name="join_code">
                    <button>Enter</button>
                </form>
            </div>
        </div>
        <div class="main-wrapper">
            @if (auth()->user()->role == 1)
                <span class="text-3xl font-bold text-center">Hi teacher! Ur classes: </span>
            @foreach ($classes_ids as $class_id)
                <a href="/class/{{ $class_id->class_id }}">
                    <div>
                        <img class="card-background" src="img/fakeroom-background.png" alt="fakeroom-background">
                        <p class="first">{{ $classes->find($class_id->class_id)->class }}</p>
                        <p class="last">
                            {{ Str::limit($classes->find($class_id->class_id)->description, 45) }}
                        </p>
                    </div>
                </a>
            @endforeach
            @elseif (auth()->user()->role == 2 )
                <p class="text-3xl font-bold text-center">Hi admin!</p>
            @elseif ($classes_ids->isEmpty())
                <p class="text-3xl font-bold text-center">Join classes!</p>
            @else
            @foreach ($classes_ids as $class_id)
                <a href="/class/{{ $class_id->class_id }}">
                    <div>
                        <img class="card-background" src="img/fakeroom-background.png" alt="fakeroom-background">
                        <p class="first">{{ $classes->find($class_id->class_id)->class }}</p>
                        <p class="last">
                            {{ Str::limit($classes->find($class_id->class_id)->description, 45) }}
                        </p>
                    </div>
                </a>
            @endforeach
            @endif
        </div>
        <div class="side-bar">
            @if (auth()->user()->role == 0)
            <div>
                <button>Join class</button>
            </div>
            @else
            <div>
            <a href="/teacher"><button>Create class</button></a>
            </div>
            @endif
        </div>
    </div>
    <script>
        let joinclassDiv = document.querySelector('.joinclass-div');
        let backdrop = document.querySelector('.backdrop');
        let joinButton = document.querySelector('.side-bar > div > button');

        document.addEventListener('click', function(event) {
            if (!event.target.closest('.joinclass-div') && !event.target.closest('.side-bar > div > button')) {
                joinclassDiv.style.display = 'none';
                backdrop.style.display = 'none';
            }
        });

        joinButton.addEventListener('click', function() {
            joinclassDiv.style.display = 'flex';
            backdrop.style.display = 'flex';
        });
    </script>
</x-app-layout>
