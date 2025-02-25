<?php

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\User;

it('removes user relationships from pivot tables upon deletion', function () {
    $user = User::factory()->create();

    $ingredient1 = Ingredient::factory()->create();
    $ingredient2 = Ingredient::factory()->create();
    $recipe1 = Recipe::factory()->create();
    $recipe2 = Recipe::factory()->create();

    $user->ingredients()->attach([$ingredient1->id, $ingredient2->id]);
    $user->recipes()->attach([$recipe1->id, $recipe2->id]);

    $user->delete();

    $this->assertDatabaseMissing('ingredient_user', ['user_id' => $user->id]);
    $this->assertDatabaseMissing('recipe_user', ['user_id' => $user->id]);
});
