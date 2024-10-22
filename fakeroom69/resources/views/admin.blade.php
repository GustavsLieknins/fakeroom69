<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
      <div class="p-6 bg-white border-b border-gray-200">
        <div class="mb-4 text-center">
          <h1 class="text-2xl font-bold text-gray-900">Hi Admin!</h1>
        </div>
        <div class="mt-4">
          <form action="/admin/findUser" method="GET" class="space-y-6">
            @method('GET')
            @csrf
            <div>
              <label class="block text-sm font-medium text-gray-700">
                Find user by id
              </label>
              <input type="number" name="user_id" value="{{ $user->id ?? '' }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <button type="submit" class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Search
            </button>
          </form>
        </div>

        @if (isset($user))
          <div class="mt-8">
            <form action="/admin/roleChange" method="GET" class="space-y-4">
              @method('GET')
              @csrf
              <div class="border-t border-gray-200 pt-4">
                <h2 class="text-lg font-medium text-gray-900">User: {{ $user->username }}</h2>
                <select name="user_role" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" onchange="this.form.submit()">
                  <option value="">Select user role</option>
                  <option value="0" {{ old('user_role', $user->role) == 0 ? 'selected' : '' }}>User</option>
                  <option value="1" {{ old('user_role', $user->role) == 1 ? 'selected' : '' }}>Teacher</option>
                  <option value="2" {{ old('user_role', $user->role) == 2 ? 'selected' : '' }}>Admin</option>
                </select>
                <input type="hidden" value="{{ $user->id }}" name="user_id">
              </div>
            </form>
            <form action="/admin/userDelete" method="POST" class="mt-4">
              @csrf
              @method("DELETE")
              <input type="hidden" name="user_id" value="{{ $user->id }}">
              <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Delete user
              </button>
            </form>
          </div>
        @endif
        <form action="/admin/userCreate" method="POST" class="space-y-4">
          @csrf
          <div class="border-t border-gray-200 pt-4">
            <h2 class="text-lg font-medium text-gray-900">Create user</h2>
            <div class="mt-4">
              <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
              <div class="mt-1">
                <input type="text" name="username" id="username" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
              </div>
            </div>
            <div class="mt-4">
              <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
              <div class="mt-1">
                <input type="password" name="password" id="password" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
              </div>
            </div>
            <div class="mt-4">
              <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm password</label>
              <div class="mt-1">
                <input type="password" name="password_confirmation" id="password_confirmation" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
              </div>
            </div>
            <div class="mt-4">
              <label for="user_role" class="block text-sm font-medium text-gray-700">Role</label>
              <div class="mt-1">
                <select name="user_role" id="user_role" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                  <option value="0">User</option>
                  <option value="1">Teacher</option>
                  <option value="2">Admin</option>
                </select>
              </div>
            </div>
          </div>
          <button type="submit" class="mt-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Create user
          </button>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>

@if (session('message'))
  <script>
    window.addEventListener("DOMContentLoaded", function() {
      alert("{{ session('message') }}");
    });
  </script>
@endif

