<?php

use App\Models\User;
use OpenAI\Client;

it('can generate recipes using a mocked OpenAi client', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $user->ingredients()->create(['name' => 'Tomato']);
    $user->ingredients()->create(['name' => 'Banana']);

    $realClient = app(Client::class);

    $mockOpenAI = Mockery::instanceMock($realClient);
    $mockOpenAI->shouldReceive('chat')->once()->andReturnSelf();

    $mockOpenAI->shouldReceive('create')->once()->andReturn([
        'choices' => [
            ['message' => ['content' => '{"recipes": [{"name": "Pasta", "ingredients": ["Tomato", "Cheese"], "instructions": "Cook it"}]}']],
        ],
    ]);

    // Bind mock to the service container
    $this->app->instance(Client::class, $mockOpenAI);

    // Call the API route that triggers OpenAI
    $response = $this->postJson('/api/generate-recipe');

    // Assertions
    $response->assertStatus(200)
        ->assertJsonFragment(['name' => 'Pasta']);
});
