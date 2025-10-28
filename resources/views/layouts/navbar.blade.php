<nav class="flex space-x-6">
    <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-200 text-lg tracking-wide transition">
        home
    </a>
    <a href="{{ route('about') }}" class="text-gray-400 hover:text-gray-200 text-lg tracking-wide transition">
        about
    </a>
    <a href="{{ route('games.index') }}" class="text-gray-400 hover:text-gray-200 text-lg tracking-wide transition">
        games
    </a>

    <!-- only show user, wishlist, and overview page if logged in (overview = temp) -->
    @if (auth()->check())
        <a href="{{ route('wishlist', ['user' => auth()->user()->id]) }}" class="text-gray-400 hover:text-gray-200 text-lg tracking-wide transition">
            wishlist
        </a>
        @if (auth()->user()->isAdmin())
            <a href="{{ route('games.overview') }}" class="text-gray-400 hover:text-gray-200 text-lg tracking-wide transition">
                overview
            </a>
        @endif
    @endif



</nav>
