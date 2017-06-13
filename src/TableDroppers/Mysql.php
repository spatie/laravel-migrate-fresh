<?php

namespace Spatie\MigrateFresh\TableDroppers;

use stdClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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

        Schema::enableForeignKeyConstraints();
    }
}
