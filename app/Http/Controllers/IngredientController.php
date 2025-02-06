<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::all();
        return view('ingredients', compact('ingredients'));
    }


    public function create(Request $request)
    {

    }

    public function show($id)
    {
        $ingredient = Ingredient::find($id);
        return view('IngredientShow', compact('ingredient'));
    }

    public function edit($id)
    {
        $ingredient = Ingredient::findOrFail($id);
        ray($ingredient);
        return view('IngredientEdit')->with('ingredient', $ingredient);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $ingredient = Ingredient::findOrFail($id);

        $ingredient->name = $request->input('name');
        $ingredient->save();

        return redirect()->route('ingredients.index');
    }

    public function store(Request $request)
    {
        ray($request);
        $request->validate([
            'name' => 'required|string',
        ]);

        $user = auth()->user(); // Trenutni korisnik

//        $ingredient = Ingredient::where('name', $request->name)->first();
//        if(!$ingredient) {
        $ingredient = Ingredient::create([
            'name' => $request->name,

        ]);

        ray($ingredient);
        $user->ingredients()->attach($ingredient);

        //ray($request->name);
        return redirect()->back();
    }

    public function destroy($id)
    {
        $ingredient = Ingredient::findOrFail($id);
        $ingredient->delete();
        return redirect()->route('ingredients.index');
    }


}
