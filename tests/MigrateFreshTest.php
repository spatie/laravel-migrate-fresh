<?php

namespace Spatie\MigrateFresh\Test;

use Illuminate\Support\Facades\Schema;

class MigrateFreshTest extends TestCase
{
    /** @test */
    public function it_can_create_a_fresh_database()
    {
        $this->assertTableExists('old_table');
        $this->assertTableNotExists('new_table');

        $this->artisan('migrate:fresh');

        $this->assertTableNotExists('old_table');
        $this->assertTableExists('new_table');
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
