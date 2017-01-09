<?php

namespace Spatie\MigrateFresh\Test;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\MigrateFresh\Commands\MigrateFresh;

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
