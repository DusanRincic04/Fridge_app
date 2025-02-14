<!DOCTYPE html>
<x-app-layout>
    <x-slot name="header">
        <a href="{{route("recipes.index")}}"
           class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Saved Recipes') }}
        </a>
        <a href="{{route("dietary.advice.form")}}"
           class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Nutrition advice') }}
        </a>
        {{--        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">--}}
        {{--            {{ __('Dashboard') }}--}}
        {{--        </h2>--}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4">
                    <form method="POST" action="{{route('recipes.generate')}}">
                        @csrf
                        <button class="dark:text-gray-200 border-amber-400 pr-1.5" type="submit">Generate recipe
                        </button>
                        <input type="text" name="prompt" required placeholder="type ingredients and mail address"
                               class="border p-2 rounded w-full"/>
                    </form>
                </div>
                <div class="p-4">
                    <form method="POST" action={{route('ingredients.store')}} >
                        @csrf
                        <button class="dark:text-gray-200 border-amber-400 pr-1.5" type="submit">Add ingredient</button>
                        <input type="text" name="name" required placeholder="new Ingredient"
                               class="border p-2 rounded"/>
                    </form>
                </div>
                <h3 class="p-6 font-bold text-red-500 dark:text-red-800-100">
                    Ingredients list
                </h3>
                <div>
                    <ul class="list-disc pl-6">
                        @foreach($ingredients as $ingredient)
                            <li class="p-8 dark:text-green-100">
                                <span class="mr-20">{{$ingredient->name}}</span>
                                <a href="{{route("ingredients.show", $ingredient->id)}}"
                                   class="bg-blue-500 text-white px-4 py-2 rounded mr-3">
                                    Show details
                                </a>
                                <a href="{{route("ingredients.edit", $ingredient->id)}}"
                                   class="bg-green-500 text-white px-4 py-2 rounded mr-3">
                                    Edit
                                </a>

                                <form action="{{ route('ingredients.destroy', $ingredient->id) }}" method="POST"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE') <!-- Ova direktiva omogućava DELETE metodu -->
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>

                </div>
                <div class=" flex justify-between p-10 dark:text-teal-200">
                    <a href="{{route("recipes.create")}}">
                        Submit list
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
