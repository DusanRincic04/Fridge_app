<?php

use App\Models\User;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Resources\Chat;
use OpenAI\Responses\Chat\CreateResponse;

it('can generate recipes using a mocked OpenAI client', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $user->ingredients()->create(['name' => 'Tomato']);
    $user->ingredients()->create(['name' => 'Banana']);

    // OpenAI Fake sa očekivanim odgovorom
    OpenAI::fake([
        CreateResponse::fake([
            'choices' => [
                [
                    'message' => [
                        'content' => json_encode([
                            'recipes' => [
                                [
                                    'name' => 'Tomato Pasta',
                                    'ingredients' => ['Tomato', 'Garlic', 'Pasta'],
                                    'instructions' => 'Boil pasta. Add sauce. Serve hot.',
                                ],
                            ],
                        ]),
                    ],
                ],
            ],
        ]),
    ]);

    // Pozivanje endpointa koji koristi OpenAI API
    $response = $this->postJson('/recipes', [
        'name' => 'Pasta',
        'ingredients' => ['Tomato', 'Garlic'],
        'instructions' => 'Boil pasta and add sauce.',
    ]);
    ray($response);

    // Provera HTTP statusa i redirekcije
    $response->assertStatus(302);
    $response->assertRedirect('/ingredients');
    $this->assertEquals(session('success'), 'Recipe created');

    $response->assertStatus(302);
    $response->assertRedirect('/ingredients');
    $this->assertEquals(session('success'), 'Recipe created');

    // Proveri da li je chat()->create() pozvan sa očekivanim parametrima
    OpenAI::assertSent(Chat::class, function (string $method, array $parameters) {
        return $method === 'create' &&
            str_contains($parameters['messages'][1]['content'], 'Tomato');
    });
});
