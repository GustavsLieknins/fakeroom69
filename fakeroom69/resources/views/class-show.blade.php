<x-app-layout>
    <style>
        .main-wrapper
        {
            display: flex;
            flex-direction: column;
            /* justify-content: center; */
            position: relative;
            align-items: center;
            height: 61vh;
        }
        .card-background {
            -webkit-mask-image: -webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,1)), to(rgba(0,0,0,0)));
            mask-image: linear-gradient(to bottom, rgba(0,0,0,1), rgba(0,0,0,0.0));
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
            min-height: 100%;
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
    </style>
    <div class="main-wrapper">
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
            <div>
                <h1>{{ $class->class }}</h1>
                <p>{{ $class->description }}</p>
                <button>Show join code</button>
                <a href="/showqr/{{ $class->join_code }}">Show qr code</a>
                <p>Creator: {{ $creator->username }}</p>
            </div>
        </div>
    </div>

    <script>

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

