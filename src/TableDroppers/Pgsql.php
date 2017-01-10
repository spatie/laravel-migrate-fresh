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
        return collect(
            DB::select('SELECT tablename FROM pg_catalog.pg_tables WHERE schemaname = ?', [DB::getConfig('schema')])
        )->pluck('tablename');
    }
}
