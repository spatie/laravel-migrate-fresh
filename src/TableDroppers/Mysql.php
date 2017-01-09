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
