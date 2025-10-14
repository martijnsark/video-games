<h1>Games List</h1>

@if($games->isEmpty())
    <p>No games found.</p>
@else
    <ul>
        @foreach($games as $game)
            <li>
                <div> the game id is {{ $game->id }}</div>
                <div> user {{ $game->user_id }} made this</div>
                <div> the game is called {{ $game->title }}</div>
                <div> a image for the game is {{ $game->image }}</div>
                <div> about this game: {{ $game->description }}</div>
                <div> the game is categorized as {{ $game->category_id }}</div>
                <div> its usual retail price is {{ $game->price }}</div>
                <div> it's current discount is {{ $game->discount }}</div>
            </li>
        @endforeach
    </ul>
@endif
