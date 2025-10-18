<x-app-layout>
    <h1 class="text-gray-400">Games List</h1>

    @if($games->isEmpty())
        <p class="text-gray-400">No games found.</p>
        <a href="{{ route('games.create') }}" class="btn btn-primary text-gray-400">Create New Game</a>
    @else
        <a href="{{ route('games.create') }}" class="btn btn-primary text-gray-400">Create New Game</a>
        <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($games as $game)
                <li class="bg-gray-800 rounded-lg shadow-lg overflow-hidden p-4 flex flex-col space-y-3 hover:shadow-xl transition">
                    <h3 class="text-xl font-semibold text-gray-200">{{ $game->title }}</h3>
                    <img src="{{ $game->image }}"
                         alt="{{ $game->title }}"
                         class="w-full h-48 object-cover rounded-md text-gray-400">

                    <p class="text-gray-400"><strong>ID:</strong> {{ $game->id }}</p>
                    <p class="text-gray-400"><strong>Posted by:</strong> {{ $game->user->name }}</p>
                    <p class="text-gray-400"><strong>Description:</strong> {{ $game->description }}</p>
                    <p class="text-gray-400"><strong>Category:</strong> {{ $game->category ? $game->category->name : 'No Category' }}</p>
                    <p class="text-gray-400"><strong>Price:</strong> ${{ $game->price }}</p>
                    <p class="text-gray-400"><strong>Discount:</strong> {{ $game->discount }}%</p>
                </li>
            @endforeach
        </ul>
    @endif
</x-app-layout>
