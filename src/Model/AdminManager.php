<?php

declare(strict_types=1);

namespace App\Model;

use App\Service\Database;

if (!isset($_SESSION)) {
    // On demarre la session
    session_start();
}

class AdminManager
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database->getPdo();
    }
}
