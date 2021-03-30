<?php

namespace Ankitjaiswal\Langman;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;

class LangmanServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/langman.php' => config_path('langman.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/langman.php', 'langman');

        $this->app->bind(Manager::class, function () {
            return new Manager(
                new Filesystem,
                $this->app['config']['langman.path'],
                array_merge($this->app['config']['view.paths'], [$this->app['path']])
            );
        });

        $this->commands([
            \Ankitjaiswal\Langman\Commands\MissingCommand::class,
            \Ankitjaiswal\Langman\Commands\RemoveCommand::class,
            \Ankitjaiswal\Langman\Commands\TransCommand::class,
            \Ankitjaiswal\Langman\Commands\ShowCommand::class,
            \Ankitjaiswal\Langman\Commands\FindCommand::class,
            \Ankitjaiswal\Langman\Commands\SyncCommand::class,
            \Ankitjaiswal\Langman\Commands\RenameCommand::class,
        ]);
    }
}
