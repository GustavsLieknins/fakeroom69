<x-app-layout>
    <style>
        .pop-up
        {
            width: 100vw;
            text-align: center;
            background-color: rgba(128, 128, 128, 0.2);

            animation: popup 8s forwards;
        }
        .pop-up > p
        {
            font-weight: bold;
        }


        @keyframes popup {
            0% {
                opacity: 0;
                /* transform: scale(0.5); */
            }
            3% {
                opacity: 1;
                /* transform: scale(1); */
            }
            95% { 
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }
    </style>
    @if (session('message'))
        <div class="pop-up">
            <p>Class added</p>
        </div>
    @endif
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-3xl font-bold leading-tight mt-0 mb-2">
                    Hi {{ auth()->user()->username }}, create class here
                </h1>

                <form method="POST" action="{{ route('create') }}" class="mt-6 space-y-6">
                    @csrf
                    <div class="space-y-2">
                        <label for="class" class="block text-sm font-medium text-gray-700">
                            Class Name
                        </label>
                        <input type="text" id="class" name="class" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter the class name">
                    </div>

                    <div class="space-y-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            Class Description
                        </label>
                        <input type="text" id="description" name="description" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter the description">
                    </div>

                    <div class="space-y-2">
                        <label for="join_code" class="block text-sm font-medium text-gray-700">
                            Custom Join Code (leave empty for non-custom)
                        </label>
                        <input type="text" id="join_code" name="join_code"
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter the custom join code">
                    </div>

                    <input type="hidden" id="creator_id" name="creator_id" value="{{ auth()->user()->id }}">

                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-black bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

