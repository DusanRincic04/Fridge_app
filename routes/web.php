<?php

use App\Http\Controllers\AdviceController;
use App\Http\Controllers\DietaryAdviceController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\post;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('ingredients', [IngredientController::class, 'index'])->name('ingredients.index');
    Route::post('ingredients', [IngredientController::class, 'store'])->name('ingredients.store');
    Route::get('ingredients/{ingredient}', [IngredientController::class, 'show'])->name('ingredients.show');
    Route::get('ingredients/{ingredient}/edit', [IngredientController::class, 'edit'])->name('ingredients.edit');
    Route::put('ingredients/{ingredient}', [IngredientController::class, 'update'])->name('ingredients.update');
    Route::delete('ingredients/{ingredient}', [IngredientController::class, 'destroy'])->name('ingredients.destroy');

    Route::get('recipes', [RecipeController::class, 'index'])->name('recipes.index');
    Route::get('recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
    Route::post('recipes', [RecipeController::class, 'store'])->name('recipes.store');
    Route::delete('recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
    Route::post('recipes/generate', [RecipeController::class, 'generate'])->name('recipes.generate');
    Route::get('/generated-recipes', function () {
        $recipes = session('recipes', []);
        return view('RecipesGeneratedPrompt', compact('recipes'));
    })->name('generated.recipes');
    Route::get('/dietary-advice', [DietaryAdviceController::class, 'showForm'])->name('dietary.advice.form');
    Route::post('/dietary-advice', [DietaryAdviceController::class, 'getDietaryAdvice'])->name('dietary.advice');


});

require __DIR__.'/auth.php';
