<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="text-center py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{route("ingredients.update", $ingredient->id)}}">
                    @csrf
                    @method('PUT')

                    <div class="p-6">
                        <label for="name" class="text-xl text-green-100 font-semibold mb-4">Ingredient name</label>
                        <input
                            name="name"
                            type="text"
                            id="name"
                            required
                            placeholder="New Ingredient Name"
                            value="{{$ingredient->name}}"
                            class="border p-2 rounded w-full"
                        />
                    </div>
                    <div class="p-3">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Ingredient</button>
                    </div>
                </form>
                <div class="mt-3 pt-3 px-3 mb-6">
                    <a class="bg-blue-500 text-white px-4 py-2 rounded" href="{{ route('ingredients.index') }}">Go back</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
