<x-app-layout>

    <br>

    <!-- category filter buttons -->
    <div class="text-center">
        <h1 class="text-gray-400">Games List</h1>

        @foreach($categories as $category)
            <!-- inline php to see if the current category id matches the requested category in the https request  -->
            @php
                $isActive = request('category') == $category->id;
            @endphp

            @if($isActive)
                <!-- if filter is already active remove URL filter on category -->
                <!-- button for the active category -->
                <a href="{{ route('games.index') }}"
                   class="px-3 py-1 rounded-md bg-blue-500 text-white hover:bg-blue-600 transition">
                    {{ $category->name }}
                </a>
            @else
                <!-- if filter is not already active activate URL filter on category  -->
                <!-- buttons for an inactive categories -->
                <a href="{{ route('games.index', ['category' => $category->id]) }}"
                   class="px-3 py-1 rounded-md bg-gray-700 text-gray-200 hover:bg-blue-600 transition">
                    {{ $category->name }}
                </a>
            @endif
        @endforeach
    </div>


    <!-- search bar -->
    <div class="flex flex-col items-center space-y-4">
        <form action="{{ route('games.index') }}" method="GET" class="mb-6">
            @csrf
            <input
                type="text"
                name="search"
                placeholder="Search games..."
                value="{{ request('search') }}"
                class="px-4 py-2 rounded-md bg-gray-700 text-gray-200">
            <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                Search
            </button>
        </form>
    </div>

    <br>

    @if($games->isEmpty())
        <div class="text-center">
            <p class="text-gray-400">No games found.</p>
        </div>
    @else
        <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($games as $game)
                <li class="bg-gray-800 rounded-lg shadow-lg overflow-hidden p-4 flex flex-col space-y-3 hover:shadow-xl transition">
                    <!-- game details  -->
                    <h3 class="text-xl font-semibold text-gray-200">{{ $game->title }}</h3>
                    <!-- image doesen't work  -->
                    <img src="{{ $game->image }}" alt="{{ $game->title }}" class="w-full h-48 object-cover rounded-md text-gray-400">

                    <p class="text-gray-400"><strong>ID:</strong> {{ $game->id }}</p>
                    <p class="text-gray-400"><strong>Posted by:</strong> {{ $game->user->name }}</p>
                    <p class="text-gray-400"><strong>Description:</strong> {{ $game->description }}</p>
                    <!-- if category exists get category name otherwise enter No Category -->
                    <p class="text-gray-400"><strong>Category:</strong> {{ $game->category ? $game->category->name : 'No Category' }}</p>
                    <p class="text-gray-400"><strong>Price:</strong> ${{ $game->price }}</p>
                    <p class="text-gray-400"><strong>Discount:</strong> {{ $game->discount }}%</p>

                    <!-- Ensure that the only user that can edit the game is the creator -->
                    @if (Auth::id() === $game->user_id)
                        <!-- edit game link based on game id -->
                        <a href="{{ route('games.edit', $game->id) }}" class="btn btn-primary text-gray-400">Edit Game</a>
                    @endif

                    <!-- user has to be logged in to add a game to their wishlist -->
                    @if (auth()->check())
                        <!-- add/remove game from wishlist -->
                        <!-- get user id and game id of game -->
                        <form action="{{ route('wishlist.add', ['user' => auth()->user()->id, 'game'=> $game->id]) }}" method="POST">
                            @csrf

                            <!-- inline php to see if current game is in current users wishlist  -->
                            @php
                                $wishlistStatus = auth()->user()
                                    ->game_wishlist()
                                    ->where('game_id', $game->id)
                                    ->exists();
                            @endphp

                                <!-- update text status based on previous inline php + submit button  -->
                            <button type="submit"  class="btn btn-primary text-gray-400">
                                {{ $wishlistStatus ? 'Remove from wishlist' : 'Add to wishlist' }}
                            </button>
                        </form>
                    @endif

                    <!-- Ensure that the only user that can delete the game is the creator -->
                    @if (Auth::id() === $game->user_id)
                        <!-- Delete form -->
                        <form action="{{ route('games.destroy', $game->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger text-gray-400">Delete Game</button>
                        </form>
                    @endif

                </li>
            @endforeach
        </ul>
    @endif
</x-app-layout>
