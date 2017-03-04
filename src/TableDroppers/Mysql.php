<?php

namespace Spatie\MigrateFresh\TableDroppers;

use DB;
use Schema;
use stdClass;

class Mysql implements TableDropper
{
    public function dropAllTables()
    {
        Schema::disableForeignKeyConstraints();

        collect(DB::select("SHOW FULL TABLES WHERE Table_Type = 'BASE TABLE'"))
            ->map(function (stdClass $tableProperties) {
                return get_object_vars($tableProperties)[key($tableProperties)];
            })
            ->each(function (string $tableName) {
                Schema::drop($tableName);
            });
			
		collect(DB::select("SHOW FULL TABLES WHERE Table_Type = 'VIEW'"))
            ->map(function (stdClass $tableProperties) {
                return get_object_vars($tableProperties)[key($tableProperties)];
            })
            ->each(function (string $viewName) {
                DB::statement('DROP VIEW '.$viewName);
            });

        Schema::enableForeignKeyConstraints();
    }
}
