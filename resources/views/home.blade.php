<x-app-layout>
    <div>hello world</div>

    @if(auth()->check())
        <h1> Hello, {{ auth()->user()->name }}! </h1>

        @foreach ($users as $user)
            <p> id {{ $user->id }} has been taken </p>
        @endforeach
    @else
        <h1> Hello, Guest! </h1>
        <a href="{{ route('login') }}">Login </a>
    @endif

</x-app-layout>


