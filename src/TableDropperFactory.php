<?php

namespace Spatie\MigrateFresh;

use Spatie\MigrateFresh\TableDroppers\TableDropper;

class TableDropperFactory
{
    public static function create($driverName): TableDropper
    {
        $dropperClass = '\\Spatie\\MigrateFresh\\TableDroppers\\'.ucfirst($driverName);

        if (! class_exists($dropperClass)) {
            throw CannotDropTables::unsupportedDbDriver($driverName);
        }

        return new $dropperClass;
    }
}
