<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}

                    <br>

                    <!-- errors for create if wishlist does not have 3 games  -->
                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    <!-- send user to create on click -->
                    <a href="{{ route('games.create') }}" class="btn btn-primary text-gray-400">Create New Game</a>

                    <form method="POST" action=" {{route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary text-gray-400">
                            logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
