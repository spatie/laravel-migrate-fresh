<?php

namespace Spatie\MigrateFresh\TableDroppers;

use Illuminate\Support\Facades\DB;

class Sqlite implements TableDropper
{
    public function dropAllTables()
    {
        $dbPath = DB::getConfig('database');

        if ($dbPath === ':memory:') {
            return;
        }

        if (file_exists($dbPath)) {
            unlink($dbPath);
        }

        touch($dbPath);
    }
}
