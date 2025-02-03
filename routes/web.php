<?php

use App\Http\Controllers\IngredientController;
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

    Route::get('listOfIngredients', [IngredientController::class, 'list'])->name('ingredients.list'); //da li praviti komtroler?
});

require __DIR__.'/auth.php';
