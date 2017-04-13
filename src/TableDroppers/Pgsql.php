<?php

namespace Spatie\MigrateFresh\TableDroppers;

use DB;

class Pgsql implements TableDropper
{
    public function dropAllTables()
    {
        $tableNames = $this->getTableNames();

        if ($tableNames->isEmpty()) {
            return;
        }

        DB::statement("DROP TABLE {$tableNames->implode(',')} CASCADE");
    }

    /**
     * Get a list of all tables in the schema.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getTableNames()
    {
        $schemas = DB::getConfig('used_schemas') ?: [DB::getConfig('schema')];

        $schemas_count = count($schemas);

        $binds = implode(',', array_fill(0, $schemas_count, '?'));

        return collect(
            DB::select("SELECT schemaname || '.' || tablename AS table FROM pg_catalog.pg_tables WHERE schemaname IN (" . $binds . ")", $schemas)
        )->pluck('table');
    }
}
