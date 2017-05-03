<?php

namespace Spatie\MigrateFresh\Test;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Spatie\MigrateFresh\Events\DroppedTables;
use Spatie\MigrateFresh\Events\DroppingTables;

class MigrateFreshTest extends TestCase
{
    /** @test */
    public function it_can_create_a_fresh_database()
    {
        $this->assertTableExists('old_table');
        $this->assertTableNotExists('new_table');

        Artisan::call('migrate:fresh');

        $this->assertTableNotExists('old_table');
        $this->assertTableExists('new_table');
    }

    /** @test */
    public function it_will_fire_events()
    {
        $this->expectsEvents([
            DroppingTables::class,
            DroppedTables::class,
        ]);

        Artisan::call('migrate:fresh');
    }

    protected function assertTableExists(string $tableName)
    {
        $this->assertTrue(
            $this->tableExists($tableName),
            "Failed asserting that table `{$tableName}` exists"
        );
    }

    protected function assertTableNotExists(string $tableName)
    {
        $this->assertFalse($this->tableExists($tableName),
            "Failed asserting that table `{$tableName}` does not exist"
        );
    }

    protected function tableExists(string $tableName): bool
    {
        return Schema::hasTable($tableName);
    }
}
