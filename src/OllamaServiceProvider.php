<?php

namespace Dwoodard\Ollama;

use Illuminate\Support\ServiceProvider;

class OllamaServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/ollama.php', 'ollama');

        $this->app->singleton('ollama', function () {
            return new Ollama(config('ollama.api_url'));
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/ollama.php' => config_path('ollama.php'),
        ], 'ollama-config');

        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        $this->publishesMigrations([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
        ], 'ollama-migrations');
    }
}
