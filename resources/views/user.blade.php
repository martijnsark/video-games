<x-app-layout>
    <br>

    <a href="{{ route('games.create') }}" class="btn btn-primary text-gray-400">Create New Game</a>

    <form method="POST" action=" {{route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-primary text-gray-400">
            logout
        </button>
    </form>

</x-app-layout>
