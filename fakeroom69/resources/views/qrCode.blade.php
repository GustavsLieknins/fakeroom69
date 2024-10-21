<x-app-layout>
    <style>
        .wrapper
        {
            display: flex;
            width: 100vw;
            height: 93vh;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        svg
        {
            width: 90vw;
            height: 90vh;
        }
        .back-icon
        {
            position: absolute;
            top: 20px;
            left: 10px;
            height: 45px;
            width: 45px;
        }
    </style>
    <div class="wrapper">
        <a href="{{ url()->previous() }}"><img src="{{ asset('img/back.svg') }}" alt="back.svg" class="back-icon"></a>
        {!! QrCode::size(300)->generate('http://127.0.0.1:8000/join-class?join_code='.$code) !!}
    </div>
</x-app-layout>

