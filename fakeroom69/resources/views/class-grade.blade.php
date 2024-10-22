<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-semibold">{{ $task->title }}</h1>
                    <p class="mt-2 text-gray-700">{{ $task->description }}</p>
                    <div class="mt-6">
                        <h2 class="text-lg font-semibold">Submissions:</h2>
                        @if ($tasks_files->where('user_id', '!=', auth()->user()->id)->where('task_id', $task->id)->count() == 0)
                            <p class="text-gray-700 mt-2">There are no submissions yet.</p>
                        @else
                            <div class="space-y-6 mt-2">
                                <form method="POST" action="{{ route('grade.store', ['task' => $task->id]) }}">
                                    @csrf
                                    @foreach ($tasks_files->where('user_id', '!=', auth()->user()->id)->where('task_id', $task->id)->groupBy('user_id') as $user_id => $user_files)
                                        <div class="bg-gray-100 p-4 rounded-lg">
                                            <h3 class="text-lg font-semibold">{{ $users[ $user_id - 1 ]->username }}</h3>
                                            <div class="space-y-2 mt-2">
                                                @foreach ($user_files as $task_file)
                                                    <a href="{{ asset($task_file->path) }}" class="text-blue-500 hover:underline" target="_blank" rel="noopener noreferrer">{{ $task_file->file }} ({{ $task_file->created_at->format('d.m.Y H:i') }})</a>
                                                @endforeach
                                            </div>
                                            <div class="mt-2">
                                                <label for="rating-{{ $user_id }}" class="block text-sm font-medium text-gray-700">Rate this submission:</label>
                                                <select id="rating-{{ $user_id }}" name="rating[{{ $user_id }}]" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                                    @foreach (range(1, 10) as $rating_value)
                                                        <option value="{{ $rating_value }}" {{ $ratings->where('user_id', $user_id)->where('task_id', $task->id)->first()?->rating == $rating_value ? 'selected' : '' }}>{{ $rating_value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="mt-6">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                            Grade all
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

