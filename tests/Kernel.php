<?php

namespace Spatie\MigrateFresh\Test;

use Spatie\MigrateFresh\Commands\MigrateFresh;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
       MigrateFresh::class,
    ];
}
