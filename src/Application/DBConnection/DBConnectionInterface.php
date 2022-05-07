<?php

declare(strict_types=1);

namespace App\Application\DBConnection;

interface DBConnectionInterface
{
    /**
     * @return Object
     */
    public function get();
}
