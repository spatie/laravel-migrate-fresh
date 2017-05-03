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

        event(new DroppingTables());
        $this->getTableDropper()->dropAllTables();
        event(new DroppedTables());

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
        return TableDropperFactory::create(DB::getDriverName());
    }
}
