<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-red-500 dark:text-red-800-100">
                    Ingredients list
                </div>
                <div class="p-8 dark:text-green-100">Prvi sastojak</div>
                <div class="p-8 dark:text-green-100">Drugi sastojak</div>
                <div class="p-8 dark:text-green-100">Treci sastojak</div>
                <div class="p-8 dark:text-green-100">Cetvrti sastojak</div>

                <div class=" flex justify-between p-10 dark:text-teal-200">
                    <button>Add ingredient</button>
                    <button>Submit list</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
