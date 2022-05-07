<?php

namespace migrations;

use Phoenix\Database\Element\Index;
use Phoenix\Migration\AbstractMigration;

class BrandsMigration extends AbstractMigration
{
    protected function up(): void
    {
        $this->table('brands')
             ->addColumn('brandname', 'string')
             ->addColumn('name', 'string')
             ->addColumn('created_at', 'datetime')
             ->addIndex('brandname', Index::TYPE_UNIQUE)
             ->create();

        $table = $this->table('brands');
        $rows = [
            [
                'brandname'  => 'microsoft',
                'name'       => 'Microsoft',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'brandname'  => 'apple',
                'name'       => 'Apple',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'brandname'  => 'meta',
                'name'       => 'Meta',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'brandname'  => 'snapchat',
                'name'       => 'Snapchat',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'brandname'  => 'twitter',
                'name'       => 'Twitter',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->insert('brands', $rows);
    }

    protected function down(): void
    {
        $this->table('brands')
             ->drop();
    }
}
