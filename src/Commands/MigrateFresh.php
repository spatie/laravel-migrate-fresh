<?php

namespace Spatie\MigrateFresh\Commands;

use DB;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Spatie\MigrateFresh\TableDroppers\TableDropper;
use Spatie\MigrateFresh\Exceptions\CannotDropTables;

class MigrateFresh extends Command
{
    use ConfirmableTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'migrate:fresh {--seed} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop all tables from db and rebuild it using migrations.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! $this->confirmToProceed()) {
            return;
        }

        $this->info('Dropping all tables...');
        $this->getTableDropper()->dropAllTables();

        $this->info('Running migrations...');
        $this->call('migrate', ['--force' => true]);

        if ($this->option('seed')) {
            $this->info('Running seeders...');
            $this->call('db:seed', ['--force' => true]);
        }

        $this->comment('All done!');
    }

    public function getTableDropper(): TableDropper
    {
        $driverName = DB::getDriverName();

        $dropperClass = '\\Spatie\\MigrateFresh\\TableDroppers\\'.ucfirst($driverName);

        if (! class_exists($dropperClass)) {
            throw CannotDropTables::unsupportedDbDriver($driverName);
        }

        return new $dropperClass;
    }
}
