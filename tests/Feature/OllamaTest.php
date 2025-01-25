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
}
