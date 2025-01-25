<?php

namespace Dwoodard\Ollama\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class OllamaTest extends TestCase
{
    use RefreshDatabase;

    public function test_ollama_route_exists()
    {
        // Ensure the route exists
        $this->assertTrue(Route::has('api.ollama.generate'));
    }

    public function test_ollama_generate()
    {

        // Ensure the route returns a 200 status code
        $response = $this->postJson('/api/ollama/generate', [
            'model' => env('OLLAMA_DEFAULT_MODEL', 'llama3.2:latest'),
            'prompt' => 'Tell me a joke',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'model',
            'created_at',
            'response',
            'done',
        ]);
    }

    public function test_ollama_generate_stream_false()
    {
        // Ensure the route returns a 200 status code
        $response = $this->postJson('/api/ollama/generate', [
            'model' => env('OLLAMA_DEFAULT_MODEL', 'llama3.2:latest'),
            'prompt' => 'Tell me a joke',
            'stream' => false,
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'model',
            'created_at',
            'response',
            'done',
        ]);
    }

    /*
      test if it can format as json
      for example:
        curl -X POST http://localhost:11434/api/generate -H "Content-Type: application/json" -d '{
  "model": "llama3.1:8b",
  "prompt": "Ollama is 22 years old and is busy saving the world. Respond using JSON",
  "stream": false,
  "format": {
    "type": "object",
    "properties": {
      "age": {
        "type": "integer"
      },
      "available": {
        "type": "boolean"
      }
    },
    "required": [
      "age",
      "available"
    ]
  }
}'


      */
    public function test_ollama_generate_format_json()
    {
        // Ensure the route returns a 200 status code
        $response = $this->postJson('/api/ollama/generate', [
            'model' => env('OLLAMA_DEFAULT_MODEL', 'llama3.2:latest'),
            'prompt' => 'Ollama is 22 years old and is busy saving the world. Respond using JSON',
            'stream' => false,
            'format' => [
                'type' => 'object',
                'properties' => [
                    'age' => [
                        'type' => 'integer',
                    ],
                    'available' => [
                        'type' => 'boolean',
                    ],
                ],
                'required' => [
                    'age',
                    'available',

                ],
            ],
        ]);

        // assert keys of the response
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'model',
            'created_at',
            'response' => [
                'age',
                'available',
            ],
            'done',
        ]);
    }
}
