<x-app-layout>

    <br>

    <div class="text-center mb-6">
        <h1 class="text-gray-400 text-2xl font-semibold">Games Overview</h1>
    </div>

    @if($games->isEmpty())
        <div class="text-center">
            <p class="text-gray-400">No games found.</p>
        </div>
    @else
        <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($games as $game)
                <li class="bg-gray-800 rounded-lg shadow-lg overflow-hidden p-4 flex flex-col space-y-3 hover:shadow-xl transition">
                    <h3 class="text-xl font-semibold text-gray-200">{{ $game->title }}</h3>

                    <!-- display active status -->
                    <p class="text-gray-400">
                        <strong>Status:</strong>
                        @if($game->is_active)
                            <span class="text-green-500 font-bold">Active</span>
                        @else
                            <span class="text-red-500 font-bold">Inactive</span>
                        @endif
                    </p>

                    <!-- submit button reflecting upcoming status change on click + handles status change -->
                    <form action="{{ route('games.toggle', $game->id) }}" method="POST" class="mt-2">
                        @csrf
                        <!-- uses PATCH to update function in GameController -->
                        @method('PATCH')
                        <button type="submit"
                                class="w-full px-4 py-2 rounded-md font-semibold text-white transition
                                {{ $game->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }}">
                            {{ $game->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif

</x-app-layout>
