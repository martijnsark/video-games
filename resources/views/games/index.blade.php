<x-app-layout>
    <h1 class="text-gray-400">Games List</h1>

    @if($games->isEmpty())
        <p class="text-gray-400">No games found.</p>
        <a href="{{ route('games.create') }}" class="btn btn-primary text-gray-400">Create New Game</a>
    @else
        <ul class="game-list">
            <a href="{{ route('games.create') }}" class="btn btn-primary text-gray-400">Create New Game</a>
        @foreach($games as $game)
                <li class="game-item">
                    <h3 class="game-title text-gray-400">{{ $game->title }}</h3>
                    <img src="{{ $game->image }}" alt="{{ $game->title }}" class="game-image text-gray-400">
                    <p class="text-gray-400"><strong>Game ID:</strong> {{ $game->id }}</p>
                    <p class="text-gray-400">Posted by: {{ $game->user->name }}</p>
                    <p class="text-gray-400"><strong>Description:</strong> {{ $game->description }}</p>
                    <p class="text-gray-400"><strong>Category:</strong> {{ $game->category ? $game->category->name : 'No Category' }}</p>
                    <p class="text-gray-400"><strong>Price:</strong> ${{ $game->price }}</p>
                    <p class="text-gray-400"><strong>Discount:</strong> {{ $game->discount }}%</p>
                </li>
            @endforeach
        </ul>
    @endif
</x-app-layout>
