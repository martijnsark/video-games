<x-app-layout>
<div>create game form</div>
    <form action="{{ route('games.store') }}" method="post">
        @csrf
        <label for="title">Title:</label>
        <input type="text" id="title" name="title">
        @error('title')
            {{ $message }}
        @enderror

        <label for="image">Image:</label>
        <input type="text" id="image" name="image">
        @error('image')
        {{ $message }}
        @enderror

        <label for="description">Description:</label>
        <input type="text" id="description" name="description">
        @error('description')
        {{ $message }}
        @enderror

        <label for="price">Price:</label>
        <input type="number" id="price" name="price">
        @error('price')
        {{ $message }}
        @enderror

        <label for="discount">Discount:</label>
        <input type="number" id="discount" name="discount">
        @error('discount')
        {{ $message }}
        @enderror

        <button type="submit">Submit</button>
    </form>

</x-app-layout>
