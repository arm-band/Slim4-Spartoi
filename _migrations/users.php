<?php

namespace migrations;

use Phoenix\Database\Element\Index;
use Phoenix\Migration\AbstractMigration;

class UsersMigration extends AbstractMigration
{
    protected function up(): void
    {
        $this->table('users')
             ->addColumn('username', 'string')
             ->addColumn('firstName', 'string')
             ->addColumn('lastName', 'string')
             ->addColumn('created_at', 'datetime')
             ->addIndex('username', Index::TYPE_UNIQUE)
             ->create();

        $table = $this->table('users');
        $rows = [
            [
                'username'   => 'bill.gates',
                'firstName'  => 'Bill',
                'lastName'   => 'Gates',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'steve.jobs',
                'firstName'  => 'Steve',
                'lastName'   => 'Jobs',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'mark.zuckerberg',
                'firstName'  => 'Mark',
                'lastName'   => 'Zuckerberg',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'evan.spiegel',
                'firstName'  => 'Evan',
                'lastName'   => 'Spiegel',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'jack.dorsey',
                'firstName'  => 'Jack',
                'lastName'   => 'Dorsey',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->insert('users', $rows);
    }

    protected function down(): void
    {
        $this->table('users')
             ->drop();
    }
}
