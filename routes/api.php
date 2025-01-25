<?php

use Dwoodard\Ollama\Controllers\OllamaController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::post('/ollama/generate', [OllamaController::class, 'generate'])
        ->name('api.ollama.generate');
});
