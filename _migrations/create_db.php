<?php

namespace migrations;

use Phoenix\Database\Element\Index;
use Phoenix\Migration\AbstractMigration;

class LOiseaudefeuMigration extends AbstractMigration
{
    protected function up(): void
    {
        $this->table('loiseaudefeu')
            ->addColumn('title', 'string')
            ->addColumn('url', 'string')
            ->addColumn('sorting', 'integer')
            ->addColumn('created_at', 'datetime')
            ->addIndex('url', Index::TYPE_UNIQUE)
            ->create();
    }

    protected function down(): void
    {
        $this->table('loiseaudefeu')
            ->drop();
    }
}
