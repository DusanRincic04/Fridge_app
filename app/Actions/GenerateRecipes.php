<?php

namespace App\Actions;

use App\Mail\GeneratedRecipes;
use App\Models\Recipe;
use Illuminate\Support\Facades\Mail;

class GenerateRecipes
{
    public function handle(string $arguments): ?array
    {
        $savedRecipes = [];

        try {
            $recipesData = json_decode($arguments, true)['recipes'];
            $email = json_decode($arguments, true)['email'];
            ray($email);
            if (!$email || $email === ['user@example.com', 'example@example.com']) {
                throw new \Exception('Invalid mail: Email must be in the prompt.');
            }
            foreach ($recipesData as $recipeData) {
                $savedRecipes[] = Recipe::create([
                    'name' => $recipeData['name'],
                    'ingredients' => json_encode($recipeData['ingredients']),
                    'instructions' => $recipeData['instructions'],
                ]);
            }
            //dd($savedRecipes);

            Mail::to($email)->send(new GeneratedRecipes($savedRecipes));
        } catch( \Exception $e ) {
            return null;
        }

        return $savedRecipes;
    }
}
