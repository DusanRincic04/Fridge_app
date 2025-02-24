<?php

use App\Models\Recipe;
use App\Models\User;

it('user can delete a recipe', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->create();

    $recipe->users()->attach($user);

    $this->actingAs($user)
        ->delete("/recipes/{$recipe->id}");

    expect(Recipe::find($recipe->id))->toBeNull();
});
