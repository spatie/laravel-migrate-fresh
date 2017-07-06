<?php

namespace Spatie\MigrateFresh\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\ConfirmableTrait;
use Spatie\MigrateFresh\TableDropperFactory;
use Spatie\MigrateFresh\Events\DroppedTables;
use Spatie\MigrateFresh\Events\DroppingTables;
use Spatie\MigrateFresh\TableDroppers\TableDropper;

class MigrateFresh extends Command
{
    use ConfirmableTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'migrate:fresh {--database= : The database connection to use.}
                {--force : Force the operation to run when in production.}
                {--path= : The path of migrations files to be executed.}
                {--seed : Indicates if the seed task should be re-run.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop all database tables and re-run all migrations';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $database = $this->input->getOption('database');

        $path = $this->input->getOption('path');

        if (! $this->confirmToProceed()) {
            return;
        }

        $this->info('Dropping all tables...');

        event(new DroppingTables());
        if ($database !== null) {
            DB::setDefaultConnection($database);
        }
        $this->getTableDropper()->dropAllTables();
        event(new DroppedTables());

        $this->info('Running migrations...');
        $this->call('migrate', [
            '--database' => $database,
            '--path' => $path,
            '--force' => true,
        ]);

        if ($this->option('seed')) {
            $this->info('Running seeders...');
            $this->call('db:seed', ['--force' => true]);
        }

        $this->comment('All done!');
    }

    public function getTableDropper(): TableDropper
    {
        return TableDropperFactory::create(DB::getDriverName());
    }
}
