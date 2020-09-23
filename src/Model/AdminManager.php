<?php

declare(strict_types=1);

namespace App\Model;

use App\Service\Database;

class AdminManager
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database->getPdo();
    }

    public function adminLogin(): int
    {
        var_dump("Accès à la page de connexion !");
        return 1;
    }
}