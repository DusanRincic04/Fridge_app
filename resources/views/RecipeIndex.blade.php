<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <a href="{{route("ingredients.index")}}">Go back to ingredients</a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($recipes as $recipe)
                    <div class="bg-white shadow-xl rounded-lg p-6">
                        <h3 class="text-2xl font-bold mb-4">{{ $recipe['name'] }}</h3>
                        <p class="text-lg"><strong>Ingredients:</strong> {{ $recipe['ingredients'] }}</p>
                        <p class="mt-4"><strong>Instructions:</strong> {{ $recipe['instructions'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
