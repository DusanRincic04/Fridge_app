<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;

class DietaryAdviceController extends Controller
{
    // Funkcija za prikazivanje forme
    public function showForm()
    {
        return view('dietary_advice');
    }

    public function getDietaryAdvice(Request $request)
    {
        // Validacija korisničkog unosa
        $request->validate([
            'goal' => 'required|string',
        ]);

        // Dobijamo logovanog korisnika i njegove sastojke iz baze
        $user = auth()->user();
        $ingredients = $user->ingredients()->pluck('name')->toArray();

        // Ako nema sastojaka, vraćamo grešku
        if (empty($ingredients)) {
            return back()->withErrors(['error' => 'You do not have any ingredients listed in your profile.']);
        }

        // Dobijamo alergije i preferencije iz forme
        $allergies = explode(',', $request->input('allergies', ''));
        $preferences = explode(',', $request->input('preferences', ''));

        // Brišemo prazne vrednosti ako korisnik nije uneo ništa
        $allergies = array_filter(array_map('trim', $allergies));
        $preferences = array_filter(array_map('trim', $preferences));

        // Cilj ishrane
        $goal = $request->input('goal');

        // Pozivamo OpenAI API da dobijemo preporuke
        $client = OpenAI::client(config('services.openai.api_key'));

        $response = $client->chat()->create([
            'model' => 'gpt-4-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a professional dietitian.'],
                ['role' => 'user', 'content' => 'I want dietary advice based on my ingredients, allergies, and preferences.'],
            ],
            'functions' => [
                [
                    'name' => 'getPersonalizedDietaryAdvice',
                    'description' => 'Provide dietary advice considering ingredients, allergies, and preferences.',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'ingredients' => [
                                'type' => 'array',
                                'description' => 'List of available ingredients.',
                                'items' => ['type' => 'string'],
                            ],
                            'allergies' => [
                                'type' => 'array',
                                'description' => 'List of allergens to avoid.',
                                'items' => ['type' => 'string'],
                            ],
                            'preferences' => [
                                'type' => 'array',
                                'description' => 'Dietary preferences (e.g., vegan, high-protein, low-carb).',
                                'items' => ['type' => 'string'],
                            ],
                            'goal' => [
                                'type' => 'string',
                                'description' => 'User’s dietary goal (e.g., weight loss, muscle gain, healthy eating).',
                            ],
                        ],
                        'required' => ['ingredients', 'allergies', 'preferences', 'goal'],
                    ],
                ],
            ],
            'function_call' => [
                'name' => 'getPersonalizedDietaryAdvice',
                'arguments' => json_encode([
                    'ingredients' => $ingredients,
                    'allergies' => $allergies,
                    'preferences' => $preferences,
                    'goal' => $goal,
                ]),
            ],
        ]);

        // dd($response);
        // Proveravamo da li postoji odgovor iz funkcije
        if (isset($response->choices[0]->message->functionCall)) {
            $functionArgs = json_decode($response->choices[0]->message->functionCall->arguments, true);

            // Kreiramo odgovor simulirajući da je stigao iz funkcije
            $dietaryAdvice = 'Based on your ingredients: '.implode(', ', $functionArgs['ingredients']).
                '. Avoid these allergens: '.implode(', ', $functionArgs['allergies']).
                '. Your preferences: '.implode(', ', $functionArgs['preferences']).
                '. Your goal is: '.$functionArgs['goal'].'. Here’s a suitable meal plan: Try making a healthy stir-fry with '.
                $functionArgs['ingredients'][0].' and '.$functionArgs['ingredients'][1].' to meet your '.$functionArgs['goal'].' goals.';
        } else {
            $dietaryAdvice = 'No dietary advice generated.';
        }

        // Prikazivanje korisniku
        return view('dietary_advice')->with('dietaryAdvice', $dietaryAdvice);
    }
}
