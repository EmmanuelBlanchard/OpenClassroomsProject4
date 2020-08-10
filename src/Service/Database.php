<?php

declare(strict_types=1);

namespace App\Service;

// Class pour gérer la connection à la base de données
class Database
{
    /**
     *  Retourne une connexion à la base de données
     *
     * @return PDO
     */
    public function getPdo(): \PDO
    {
        $pdo = new \PDO('mysql:host=localhost;dbname=openclassrooms_project4;port=3306;charset=utf8mb4', 'root', 'vFaGsjLk8WpkQtxYJ8XZXAf690shjBzW', [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ]);

        return $pdo;
    }
}
