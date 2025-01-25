<?php

use Dwoodard\Ollama\Controllers\OllamaController;
use Illuminate\Support\Facades\Route;

Route::post('/process-invoice', [OllamaController::class, 'process']);
