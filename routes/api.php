<?php

use Dwoodard\Ollama\Controllers\OllamaController;
use Illuminate\Support\Facades\Route;

Route::post('/ollama/generate', [OllamaController::class, 'process']);
