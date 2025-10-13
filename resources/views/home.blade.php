<x-app-layout>
    <div>hello world</div>

    @if(auth()->check())
        <h1> Hello, {{ auth()->user()->name }}! </h1>

        @foreach ($users as $user)
            <p> This is user {{ $user->id }} </p>
        @endforeach
    @else
        <h1> Hello, Guest! </h1>
        <a href="{{ route('login') }}">Login </a>
    @endif

</x-app-layout>


