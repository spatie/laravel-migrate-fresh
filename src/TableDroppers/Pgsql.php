<?php

namespace Spatie\MigrateFresh\TableDroppers;

use DB;
use Illuminate\Support\Collection;

class Pgsql implements TableDropper
{
    public function dropAllTables()
    {
        $tables = $this->getTables($this->getSchema());

        if ($tables->isEmpty()) {
            return;
        }

        $this->drop($tables);
    }

    /**
     * Drop tables.
     *
     * @param \Illuminate\Support\Collection $tables
     */
    protected function drop(Collection $tables)
    {
        DB::statement("DROP TABLE {$tables->implode(',')} CASCADE");
    }

    /**
     * Get a list of all tables in the schema.
     *
     * @param $schema
     * @return \Illuminate\Support\Collection
     */
    protected function getTables($schema)
    {
        return collect(
            DB::select('SELECT tablename FROM pg_catalog.pg_tables WHERE schemaname = ?', [$schema])
        )->pluck('tablename');
    }

    /**
     * Get schema name for the connection.
     *
     * @return string
     */
    protected function getSchema()
    {
        return DB::getConfig('schema');
    }
}
