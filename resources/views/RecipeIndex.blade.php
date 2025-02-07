<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        </h2>
        <a class="text-white" href="{{route("ingredients.index")}}">Go back to ingredients</a>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($recipes['recipes'] as $recipe)
                    <div class="bg-white shadow-xl rounded-lg p-6">
                        <h3 class="text-2xl font-bold mb-4">{{ $recipe['name'] }}</h3>
                        <p class="text-lg"><strong>Ingredients:</strong> {{implode(', ',  $recipe['ingredients']) }}</p>
                        {{--                        <ul>--}}
                        {{--                            @foreach($recipe['ingredients'] as $ingredient)--}}
                        {{--                                <li>{{ $ingredient }}</li>--}}
                        {{--                            @endforeach--}}
                        {{--                        </ul>--}}
                        <p class="mt-4"><strong>Instructions:</strong> {{ $recipe['instructions'] }}</p>

                        <form action="{{ route('recipes.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="name" value="{{ $recipe['name'] }}">
                            <input type="hidden" name="instructions" value="{{ $recipe['instructions'] }}">
                            @foreach ($recipe['ingredients'] as $ingredient)
                                <input type="hidden" name="ingredients[]" value="{{ $ingredient }}">
                            @endforeach
                            <button
                                type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded mr-3"
                            >
                                Save Recipe
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
