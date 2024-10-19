<x-guest-layout>
    <div class="max-w-md w-full space-y-8">
      <div>
        <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">Log in to your account</h2>
      </div>
      @if (session('status'))
        <div class="mb-4 text-green-600 text-center">
          {{ session('status') }}
        </div>
      @endif
      <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="rounded-md shadow-sm -space-y-px">
          <div>
            <label for="username" class="sr-only">Username</label>
            <input id="username" name="username" type="text" autocomplete="username" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Username" value="{{ old('username') }}"/>
            @error('username')
              <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label for="password" class="sr-only">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password" value="{{ old('password') }}"/>
            @error('password')
              <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>
        <div class="flex items-center justify-between">
          <div class="text-sm">
            @if (Route::has('register'))
              <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Dont have an account?</a>
            @endif
          </div>
          <button type="submit" class="group relative flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Log in
          </button>
        </div>
      </form>
    </div>
</x-guest-layout>

