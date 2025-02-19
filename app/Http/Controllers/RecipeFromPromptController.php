<?php

namespace App\Http\Controllers;

use App\Actions\GenerateRecipeFromPrompt;
use App\Actions\GenerateRecipes;
use Illuminate\Http\Request;

class RecipeFromPromptController extends Controller
{
    public function index()
    {
        $recipes = session('recipes', []);

        return view('RecipesGeneratedPrompt', ['recipes' => $recipes]);
    }

    public function store(Request $request, GenerateRecipes $generatedRecipes, GenerateRecipeFromPrompt $generateRecipeFromPrompt)
    {
        $request->validate([
            'prompt' => 'required|string',
        ]);

        $prompt = $request->input('prompt');

        $response = $generateRecipeFromPrompt->handle($prompt);

        $functionCall = $response->choices[0]->message->functionCall ?? null;
        $responseContent = $response->choices[0]->message->content ?? null;

        ray($functionCall);

        if (! $functionCall) {
            return redirect()->route('ingredients.index')->with('error', $responseContent);

        }

        $savedRecipes = match ($functionCall->name) {
            'generateRecipes' => $generatedRecipes->handle($functionCall->arguments),
            default => false
        };

        ray($savedRecipes);

        if (! $savedRecipes) {
            return redirect()->route('generated.recipes')->with('error', 'Recipes cant be generated.');
        }

        return view('RecipesGeneratedPrompt', ['recipes' => $savedRecipes]);
    }
}
