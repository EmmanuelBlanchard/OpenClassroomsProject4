<?php

declare(strict_types=1);

namespace App\Model;

use App\Service\Database;

if (!isset($_SESSION)) {
    session_start();
}

class UserManager
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database->getPdo();
    }

    public function recoveryIdAndHashedPassword(string $pseudo): ?array
    {
        // A partir du pseudo, recuperation de l'identifiant et de son mot de passe hashé
        $request = $this->database->prepare('SELECT id, pseudo, hashed_password FROM users WHERE pseudo = :pseudo');
        $request->execute(['pseudo' => $pseudo]);
        return $resultat = $request->fetchAll();
    }
}
