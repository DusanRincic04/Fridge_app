<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class IngredientController extends Controller
{
    public function index()
    {
        return view('Ingredients');
    }

    public function create()
    {

    }

    public function update(Request $request, Ingredient $ingredient)
    {

    }

    public function store(Request $request)
    {
        //Redirect::route('ListOfIngredients');
    }

    public function delete()
    {

    }


}
