<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //ovde treba da atachujem listu ingreients na recipe

        $user = auth()->user();

        $ingredients = $user->ingredients()->pluck('name')->toArray();

        ray($ingredients);
        $ingredientString = implode(',', $ingredients);

        ray($ingredientString);

        $response = Http::get("https://www.themealdb.com/api/json/v1/1/filter.php", [
            'i' => $ingredientString
        ]);

        $recipes = $response->json();
        return $recipes;
        //return view('recipes.index', ['recipes' => $recipes['meals'] ?? []]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
