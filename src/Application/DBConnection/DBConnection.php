<?php

declare(strict_types=1);

namespace App\Application\DBConnection;

use Illuminate\Database\Capsule\Manager;

class DBConnection implements DBConnectionInterface
{
    private $db;

    public function __construct()
    {
        $this->db = new Manager;
        $this->db->addConnection([
            'driver'    => 'mysql',
            'host'      => $_ENV['MYSQL_HOST'],
            'database'  => $_ENV['MYSQL_DBNAME'],
            'username'  => $_ENV['MYSQL_USER'],
            'password'  => $_ENV['MYSQL_PASSWORD'],
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);
    }
    /**
     * @return Object
     */
    public function get()
    {
        return $this->db;
    }
}
