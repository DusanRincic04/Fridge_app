<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use OpenAI\Client;
use OpenAI;
use function Pest\Laravel\withHeaders;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $recipes = $user->recipes()->get();
        //dd($recipes);
        return view('recipesSaved')->with('recipes', $recipes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = auth()->user();

        $ingredients = $user->ingredients()->pluck('name')->toArray();

        //ray($ingredients);
        if (empty($ingredients)) {
            return response()->json(['error' => 'No ingredients found']);
        }


        //            'response_format' => [
//                'type' => 'json_schema',
//                'json_schema' => [
//                    'name' => 'recipe',
//                    'schema' => [
//                        'type' => 'object',
//                        'properties' => [
//                            'name' => [
//                                'type' => 'string',
//                            ],
//                            'instructions' => [
//                                'description' => 'provide step by step instructions for cooking the recipe',
//                                'type' => 'string',
//                            ],
//                            'ingredients' => [
//                                'type' => 'array',
//                                'description' => 'provide the array of all ingredients',
//                                'items' => [
//                                    'type' => 'string',
//                                ]
//                            ],
//                        ],
//                        'required' => ['name', 'instructions', 'ingredients'],
//                        'additionalProperties' => false
//                    ],
//                    'strict' => true
//                ]
//            ],


        $prompt = "Please, generate 3 best food recipes using the following ingredients: " . implode(", ", $ingredients) .
            ".Try to use the most ingredients i have, but don't be exclusive to use all of them,
             For each recipe, return the result in the following format:

                name: [name of the meal]
                Ingredients: [comma separated list of ingredients]
                Instructions: [how to prepare the meal]

                Please make sure the format is strictly followed, not include extra information'.";


        //ray($prompt);
        $yourApiKey = config('services.openai.api_key');
        $client = OpenAI::client($yourApiKey);

        $response = $client->chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => 'You are AI who generate recipes'],
                ['role' => 'system', 'content' => $prompt],
            ],
            'response_format' => [
                'type' => 'json_schema',
                'json_schema' => [
                    'name' => 'recipe',
                    'schema' => [
                        'type' => 'object',  // Must be an object at the top level
                        'properties' => [
                            'recipes' => [
                                'type' => 'array',
                                'description' => 'A list of generated recipes',
                                'items' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'name' => [
                                            'type' => 'string',
                                        ],
                                        'instructions' => [
                                            'description' => 'Provide step-by-step instructions for cooking the recipe',
                                            'type' => 'string',
                                        ],
                                        'ingredients' => [
                                            'type' => 'array',
                                            'description' => 'Provide the array of all ingredients',
                                            'items' => [
                                                'type' => 'string',
                                            ],
                                        ],
                                    ],
                                    'required' => ['name', 'instructions', 'ingredients'],
                                    'additionalProperties' => false,
                                ],
                            ],
                        ],
                        'required' => ['recipes'],  // Ensure "recipes" is required
                        'additionalProperties' => false,
                    ],
                ],
            ],
            'max_tokens' => 3000,
            'temperature' => 0.7,
        ]);

        $recipesText = $response->choices[0]->message->content;
        //ray($recipesText);
        $recipes = json_decode($recipesText, true);
        //ray($recipes);
        //ray(json_decode($recipesText));
        //return response()->json(['recipes' => $recipesText]);
        return view('RecipesGenerated')->with('recipes', $recipes);
    }

//        $recipeArray = explode('RECIPE_SEPARATOR', $recipesText);
//
//
//        $recipeList = [];
//        foreach ($recipeArray as $recipe) {
//            // Ako postoji barem jedan recept
//            if (trim($recipe)) {
//                $recipeParts = explode("\n", trim($recipe));
//                $name = '';
//                $ingredients = '';
//                $instructions = '';
//
//                // Parsiranje linija za svaki recept
//                foreach ($recipeParts as $line) {
//                    if (strpos($line, 'name:') === 0) {
//                        $name = substr($line, 5);  // Skidamo "name: " i ostavljamo samo ime
//                    } elseif (strpos($line, 'Ingredients:') === 0) {
//                        $ingredients = substr($line, 12);  // Skidamo "Ingredients: " i ostavljamo listu
//                    } elseif (strpos($line, 'Instructions:') === 0) {
//                        $instructions = substr($line, 13);  // Skidamo "Instructions: " i ostavljamo instrukcije
//                    }
//                }
//
//                // Dodavanje recepta u niz
//                $recipeList[] = [
//                    'name' => $name,
//                    'ingredients' => $ingredients,
//                    'instructions' => $instructions,
//                ];
//            }
//        }
//
//// Vraćanje odgovora kao JSON
//        //return response()->json(['recipes' => $recipeList]);
//        return view('RecipeIndex')->with('recipes', $recipeList);
//    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        ray($request);
        $user = auth()->user();
        ray($request);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'ingredients' => 'required|array',
            'instructions' => 'required|string',
        ]);

        ray($validatedData);

        $recipe = Recipe::create([
            'name' => $request->name,
            'ingredients' => json_encode($request->ingredients),
            'instructions' => $request->instructions,
        ]);

        $user->recipes()->attach([$recipe->id]);

        $userIngredientNames = $user->ingredients()->pluck('name')->toArray();
        ray($userIngredientNames);

        $matchingIngredients = array_filter($validatedData['ingredients'], function ($ingredientName) use ($userIngredientNames) {
            return in_array($ingredientName, $userIngredientNames);
        });

        foreach ($matchingIngredients as $ingredientName) {
            $ingredient = Ingredient::where('name', $ingredientName)->first();
            if ($ingredient) {
                $recipe->ingredients()->attach($ingredient->id);
            }
        }



        return redirect('/ingredients')->with('success', 'Recipe created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //OVO JE POZIV KA FREE API MEAL KOJI RADI
//        $user = auth()->user();
//        $ingredients = $user->ingredients()->pluck('name')->toArray();
//
//        $ingredientString = implode(',', $ingredients);
//
//        // Prvi API poziv - uzmi osnovne podatke o receptima
//        $response = Http::get("https://www.themealdb.com/api/json/v1/1/filter.php", [
//            'i' => $ingredientString
//        ]);
//
//        $recipes = $response->json()['meals'] ?? [];
//
//        // Drugi API poziv - uzmi detalje za svaki recept
//        $detailedRecipes = [];
//
//        foreach ($recipes as $recipe) {
//            $recipeDetails = Http::get("https://www.themealdb.com/api/json/v1/1/lookup.php", [
//                'i' => $recipe['idMeal']
//            ])->json();
//
//            $detailedRecipes[] = $recipeDetails['meals'][0] ?? null;
//        }
//
//        return view('RecipesIndex', ['recipes' => $detailedRecipes]);
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
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();
        return redirect('/ingredients')->with('success', 'Recipe Deleted');
    }

    public function search()
    {

    }
}
