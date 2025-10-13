<x-app-layout>
    <div>hello world</div>

    <h1 class="text-xl font-bold">Hello, {{ auth()->user()->name }}!</h1>

    @foreach ($users as $user)
        <p>This is user {{ $user->id }}</p>
    @endforeach

</x-app-layout>


