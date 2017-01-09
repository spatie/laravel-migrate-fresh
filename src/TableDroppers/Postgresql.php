<?php

namespace Spatie\MigrateFresh\TableDroppers;

use DB;

class Postgresql implements TableDropper
{
    public function dropAllTables()
    {
        $tableProperties = DB::select("SELECT tablename FROM pg_catalog.pg_tables WHERE schemaname='public'");

        $tableNames = array_column($tableProperties, 'tablename');

        foreach ($tableNames as $tableName) {
            DB::statement("DROP TABLE {$tableName} CASCADE");
        }
    }
}
