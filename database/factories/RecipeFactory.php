<?php

namespace Database\Factories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'ingredients' => $this->faker->text(),
            'instructions' => $this->faker->text(),
        ];
    }
}
