<?php

declare(strict_types=1);

namespace App\Actions;

use OpenAI;
use OpenAI\Responses\Chat\CreateResponse;

class GenerateRecipeFromPrompt
{
    public function handle($prompt): CreateResponse
    {
        $yourApiKey = config('services.openai.api_key');
        $client = OpenAI::client($yourApiKey);

        $response = $client->chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => 'You are an AI assistant that generates recipes based solely on the users ingredients and sends them to an email. If the query is not related to ingredients and recipes, respond with: Error: This service is only for generating recipes based on ingredients. Do not respond to other threads under any circumstances'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'functions' => [
                [
                    'name' => 'generateRecipes',
                    'description' => 'Generates the 3 best recipes based on the users ingredients and sends them to an email that I forward in the prompt, if I dont forward the email, it throws an error.',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'email' => [
                                'type' => 'string',
                                'description' => 'The email address to which the generated recipes will be sent. If no email is entered, let me know the error, dont generate another email',
                                'format' => 'email',
                            ],
                            'recipes' => [
                                'type' => 'array',
                                'description' => 'The list of generated recipes',
                                'items' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'name' => ['type' => 'string', 'description' => 'Recipe name'],
                                        'ingredients' => ['type' => 'array', 'items' => ['type' => 'string']],
                                        'instructions' => ['type' => 'string'],
                                    ],
                                ],
                            ],
                        ],
                        'required' => ['email', 'recipes'],
                    ],

                ],
            ],
            'function_call' => 'auto',
        ]);

        return $response;

    }

}
