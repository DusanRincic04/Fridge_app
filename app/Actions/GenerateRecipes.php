<?php

namespace App\Actions;

use App\Mail\GeneratedRecipes;
use App\Models\Recipe;
use Illuminate\Support\Facades\Mail;

class GenerateRecipes
{
    public function handle(string $arguments, string $email): ?array
    {
        $savedRecipes = [];

        try {
            $recipesData = json_decode($arguments, true)['recipes'];

            foreach ($recipesData as $recipeData) {
                $savedRecipes[] = Recipe::create([
                    'name' => $recipeData['name'],
                    'ingredients' => json_encode($recipeData['ingredients']),
                    'instructions' => $recipeData['instructions'],
                ]);
            }

            Mail::to($email)->send(new GeneratedRecipes($savedRecipes));
        } catch( \Exception $e ) {
            return null;
        }

        return $savedRecipes;
    }
}
