<?php

namespace Dwoodard\Ollama;

use Illuminate\Support\Facades\Http;

class Ollama
{
    protected $apiUrl;

    public function __construct($apiUrl)
    {
        $this->apiUrl = rtrim($apiUrl, '/');
    }

    public function processText(string $text, string $model = 'llama3:8b')
    {
        $response = Http::post("{$this->apiUrl}/generate", [
            'model' => $model,
            'format' => 'json',
            'prompt' => "Extract total amount and customer from the text:\n{$text}",
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Error connecting to Ollama API: '.$response->body());
    }
}
