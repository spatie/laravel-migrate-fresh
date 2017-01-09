<?php

namespace Spatie\MigrateFresh\Test;

use Illuminate\Support\ServiceProvider;
use Spatie\MediaLibrary\Commands\CleanCommand;
use Spatie\MediaLibrary\Commands\ClearCommand;
use Laravel\Lumen\Application as LumenApplication;
use Spatie\MediaLibrary\Commands\RegenerateCommand;
use Illuminate\Foundation\Application as LaravelApplication;
use Spatie\MigrateFresh\Commands\MigrateFresh;

class MigrateFreshServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {

    }

    /**
     * Register the service provider.
     */
    public function register()
    {

        $this->app->bind('command.migrate:fresh', MigrateFresh::class);

        $this->commands([
            'command.migrate:fresh',
        ]);
    }
}
