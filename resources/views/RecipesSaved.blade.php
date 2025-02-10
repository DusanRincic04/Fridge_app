<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        </h2>
        <a class="text-white" href="{{route("ingredients.index")}}">Go back to ingredients</a>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($recipes as $recipe)
                    <div class="bg-white shadow-xl rounded-lg p-6">
                        <h3 class="text-2xl font-bold mb-4">{{ $recipe['name'] }}</h3>
                        <p class="text-lg"><strong>Ingredients:</strong> {{ implode(', ', json_decode($recipe['ingredients'], true)) }}</p>
                        {{--                        <ul>--}}
                        {{--                            @foreach($recipe['ingredients'] as $ingredient)--}}
                        {{--                                <li>{{ $ingredient }}</li>--}}
                        {{--                            @endforeach--}}
                        {{--                        </ul>--}}
                        <p class="mt-4"><strong>Instructions:</strong> {{ $recipe['instructions'] }}</p>
                        <button onclick="readRecipe('{{ $recipe['name'] }}', '{{ implode(', ', json_decode($recipe['ingredients'], true)) }}', '{{ $recipe['instructions'] }}')"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">
                            Read Recipe
                        </button>

                        <form method="POST" action="{{route("recipes.destroy", $recipe->id)}}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"  class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function readRecipe(name, ingredients, instructions) {
        const text = `Recipe name: ${name}. Ingredients: ${ingredients}. Instructions: ${instructions}`;

        const speech = new SpeechSynthesisUtterance(text);
        speech.lang = "en-US"; // Set language (adjust if needed)
        speech.rate = 1; // Adjust speech speed (1 is normal)

        window.speechSynthesis.speak(speech);
    }
</script>
