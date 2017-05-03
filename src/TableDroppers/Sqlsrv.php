<?php

namespace Spatie\MigrateFresh\TableDroppers;

use Illuminate\Support\Facades\DB;

class Sqlsrv implements TableDropper
{
    private $constraintDropScript = '
        DECLARE @Sql NVARCHAR(500) DECLARE @Cursor CURSOR
        SET @Cursor = CURSOR FAST_FORWARD FOR
        SELECT DISTINCT sql = \'ALTER TABLE [\'+tc2.CONSTRAINT_SCHEMA+\'].[\' + tc2.TABLE_NAME + \'] DROP [\' + rc1.CONSTRAINT_NAME + \']\'
        FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS rc1
        LEFT JOIN INFORMATION_SCHEMA.TABLE_CONSTRAINTS tc2 ON tc2.CONSTRAINT_NAME =rc1.CONSTRAINT_NAME
        
        OPEN @Cursor FETCH NEXT FROM @Cursor INTO @Sql
        
        WHILE (@@FETCH_STATUS = 0)
        BEGIN
        PRINT @Sql
        Exec (@Sql)
        FETCH NEXT FROM @Cursor INTO @Sql
        END
        
        CLOSE @Cursor DEALLOCATE @Cursor';

    public function dropAllTables()
    {
        DB::unprepared($this->constraintDropScript);
        DB::unprepared("exec sp_MSforeachtable 'DROP TABLE ?'");
    }
}
