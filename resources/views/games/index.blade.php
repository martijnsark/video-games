<x-app-layout>
    <h1>Games List</h1>

    @if($games->isEmpty())
        <p>No games found.</p>
        <a href="{{ route('games.create') }}" class="btn btn-primary">Create New Game</a>
    @else
        <ul class="game-list">
            <a href="{{ route('games.create') }}" class="btn btn-primary">Create New Game</a>
        @foreach($games as $game)
                <li class="game-item">
                    <h3 class="game-title">{{ $game->title }}</h3>
                    <img src="{{ $game->image }}" alt="{{ $game->title }}" class="game-image">
                    <p><strong>Game ID:</strong> {{ $game->id }}</p>
                    <p><strong>Created by User:</strong> {{ $game->user_id }}</p>
                    <p><strong>Description:</strong> {{ $game->description }}</p>
                    <p><strong>Category:</strong> {{ $game->category ? $game->category->name : 'No Category' }}</p>
                    <p><strong>Price:</strong> ${{ $game->price }}</p>
                    <p><strong>Discount:</strong> {{ $game->discount }}%</p>
                </li>
            @endforeach
        </ul>
    @endif
</x-app-layout>
