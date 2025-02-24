<?php

use App\Models\Ingredient;
use App\Models\User;

it('user can attach ingredient to list', function () {
    $user = User::factory()->create();
    $ingredient = Ingredient::factory()->create();

    $user->ingredients()->attach($ingredient);
    expect($user->ingredients)->toHaveCount(1);
});
