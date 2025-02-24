<?php

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\User;

it('recipe can have multiple ingredients', function () {
    $recipe = Recipe::factory()->create();
    $ingredients = Ingredient::factory()->count(3)->create();

    $recipe->ingredients()->attach($ingredients);
    expect($recipe->ingredients()->count())->toBe(3);
});

it('ingredient can be add to list of ingredients', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $ingredientData = [
        'name' => 'lamb',
    ];

    $response = $this->post(route('ingredients.store'), $ingredientData);

    $this->assertDatabaseHas('ingredients', [
        'name' => 'lamb',
    ]);

    // $response->assertRedirect(route('ingredients.index'));

    $this->get(route('ingredients.index'))
        ->assertSee('lamb');
});

it('ingredient can be edited', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $ingredient = Ingredient::factory()->create();
    $newName = 'Updated ingredient';

    $response = $this->put(route('ingredients.update', $ingredient->id), [
        'name' => $newName,
    ]);

    $this->assertDatabaseHas('ingredients', [
        'id' => $ingredient->id,
        'name' => $newName,
    ]);

    $response->assertRedirect(route('ingredients.index'));
});

it('ingredient can be deleted', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $ingredient = Ingredient::factory()->create();
    $response = $this->delete(route('ingredients.destroy', $ingredient->id));
    $this->assertDatabaseMissing('ingredients', [
        'id' => $ingredient->id,
    ]);

    $response->assertRedirect(route('ingredients.index'));
});
