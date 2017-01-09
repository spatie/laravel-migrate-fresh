<?php

namespace Spatie\MigrateFresh\Commands\MigrateFresh;

use DB;
use Schema;
use stdClass;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;

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
    protected $description = 'Nuke the entire db and rebuild it using migrations.';

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
        $this->dropAllTables();

        $this->info('Running migrations...');
        $this->call('migrate', ['--force' => true]);

        if ($this->hasOption('seed')) {
            $this->info('Running seeders...');
            $this->call('db:seed', ['--force' => true]);
        }

        $this->comment('All done!');
    }

    public function dropAllTables()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        collect(DB::select('SHOW TABLES'))
            ->map(function (stdClass $tableProperties) {
                return get_object_vars($tableProperties)[key($tableProperties)];
            })
            ->each(function (string $tableName) {
                Schema::drop($tableName);
            });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
