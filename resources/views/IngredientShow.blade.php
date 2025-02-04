<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="text-center py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-10">
                <span class="font-bold text-9xl dark:text-white ">{{$ingredient->name}}</span>
            </div>
            <div class="text-green-100 text-2xl pt-6 mt-10 px-6 pb-10 mb-10">
                {{$ingredient->description}}
            </div>
            <div class="mt-10 pt-10 px-10">
                <a class="bg-blue-500 text-white px-4 py-2 rounded" href="{{route("ingredients.index")}}">Go back</a>
            </div>
        </div>
    </div>
</x-app-layout>
