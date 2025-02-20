<?php

namespace Dwoodard\Ollama\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OllamaController extends Controller
{
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'model' => 'required|string',
            'prompt' => 'nullable|string',
            'stream' => 'nullable|boolean',
            'options' => 'nullable|array',
            'format' => 'nullable|array',
            'images' => 'nullable|array',
        ]);

        $response = Http::post(config('ollama.api_url').'/api/generate', array_merge([
            'model' => $validated['model'] ?? config('ollama.default_model'),
        ], $validated));

        if ($response->successful()) {
            $data = $response->json();
            return response()->json([
                'model' => $data['model'] ?? $validated['model'],
                'created_at' => now()->toIso8601String(),
                'response' => $data['response'] ?? '',
                'done' => $data['done'] ?? false,
            ]);
        }

        return response()->json(['error' => 'Failed to process request'], 500);
    }
}
