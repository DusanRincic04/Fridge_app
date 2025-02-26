<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\User;
use OpenAI\Contracts\ClientContract;
use OpenAI\Responses\Chat\CreateResponse;
use OpenAI\Testing\ClientFake;

it('can generate recipes using a mocked OpenAI client', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $ingredients = Ingredient::factory()->count(3)->create();
    $user->ingredients()->attach($ingredients);

    app()->bind(ClientContract::class, function () {
        $client = new ClientFake([
            CreateResponse::fake([
                'choices' => [
                    [
                        'message' => [
                            'content' => json_encode([
                                'recipes' => [
                                    [
                                        'name' => 'Pasta Carbonara',
                                        'ingredients' => ['Pasta', 'Eggs', 'Bacon', 'Parmesan'],
                                        'instructions' => 'Cook pasta, mix with eggs and bacon, serve with Parmesan.',
                                    ],
                                    [
                                        'name' => 'Tomato Soup',
                                        'ingredients' => ['Tomatoes', 'Onion', 'Garlic'],
                                        'instructions' => 'Blend tomatoes, cook with onion and garlic.',
                                    ],
                                    [
                                        'name' => 'Grilled Chicken Salad',
                                        'ingredients' => ['Chicken', 'Lettuce', 'Olive Oil'],
                                        'instructions' => 'Grill chicken, mix with lettuce and olive oil.',
                                    ],
                                ],
                            ]),
                        ],
                    ],
                ],
            ]),
        ]);

        return $client;
    });

    $response = $this->get(route('recipes.create'));
    ray($response);

    $response->assertStatus(200);
    $response->assertViewIs('RecipesGenerated');

    $response->assertViewHas('recipes', function ($recipes) {
        return count($recipes['recipes']) === 3
            && $recipes['recipes'][1]['name'] === 'Tomato Soup';
    });
});
