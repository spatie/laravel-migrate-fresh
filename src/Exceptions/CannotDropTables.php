<?php

namespace Spatie\MigrateFresh\Exceptions;

use Exception;

class CannotDropTables extends Exception
{
    public static function unsupportedDbDriver($driverName)
    {
        return new static("The migrate:fresh command does not support `{$driverName}`-databases.");
    }
}
