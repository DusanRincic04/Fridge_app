<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\RecipeController;

it('validates class', function () {
    expect(RecipeController::class)->toHaveMethod(['index', 'store']);

    expect(RecipeController::class)->toExtend(Controller::class);
});
