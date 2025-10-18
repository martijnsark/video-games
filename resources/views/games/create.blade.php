<x-app-layout>
    <div class="flex items-center justify-center min-h-screen">
        <form action="{{ route('games.store') }}" method="post" class="flex flex-col space-y-4 w-full max-w-xl p-4">
            @csrf

            <p class="text-gray-400">create game form</p>

            <label for="title" class="text-gray-400">Title:</label>
            <input type="text" id="title" name="title">
            @error('title')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror

            <select name="category_id" id="category_id" class="form-control">
                <option value=""> select a category </option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror

            <label for="image" class="text-gray-400">Image:</label>
            <input type="text" id="image" name="image">
            @error('image')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror

            <label for="description" class="text-gray-400">Description:</label>
            <input type="text" id="description" name="description">
            @error('description')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror

            <label for="price" class="text-gray-400">Price:</label>
            <input type="number" id="price" name="price">
            @error('price')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror

            <label for="discount" class="text-gray-400">Discount:</label>
            <input type="number" id="discount" name="discount">
            @error('discount')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror

            <button type="submit" class="text-gray-400">Submit</button>
        </form>
    </div>

</x-app-layout>
