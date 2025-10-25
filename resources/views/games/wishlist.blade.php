<x-app-layout>
    <br>
    <div class="text-center">
        <!-- show user name for feedback -->
        <h1 class="text-gray-400">{{ $user->name }}'s Wishlist</h1>
    </div>

    <!-- if no games wishlisted by user show feedback -->
    @if($games->isEmpty())
        <div class="text-center">
            <p class="text-gray-400">No wishlisted games found.</p>
        </div>
        <!-- if games are found in wishlist of user display them -->
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-9 gap-11 justify-items-center">
            @foreach($games as $game)
                <div class="bg-gray-800 text-gray-400 p-4 rounded-lg w-64 text-center shadow-lg">
                    <H2 class="text-gray-400"> Game: {{ $game->title }}</H2>
                    <p class="text-gray-400"> Price: ${{ $game->price }}</p>
                    <p class="text-gray-400"> Discount: {{ $game->discount }}%</p>
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
