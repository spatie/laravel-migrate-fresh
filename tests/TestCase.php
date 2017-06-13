<?php

namespace Spatie\MigrateFresh\Test;

use stdClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function setUp()
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'mysql');
        $app['config']->set('database.connections.mysql', [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'laravel_migrate_fresh',
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
            MigrateFreshServiceProvider::class,
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        $this->dropAllTables();

        $app->useDatabasePath(__DIR__.'/database');

        $app['db']->connection()->getSchemaBuilder()->create('old_table', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
    }

    public function dropAllTables()
    {
        Schema::disableForeignKeyConstraints();

        collect(DB::select('SHOW TABLES'))
            ->map(function (stdClass $tableProperties) {
                return get_object_vars($tableProperties)[key($tableProperties)];
            })
            ->each(function (string $tableName) {
                Schema::drop($tableName);
            });

        Schema::enableForeignKeyConstraints();
    }
}
