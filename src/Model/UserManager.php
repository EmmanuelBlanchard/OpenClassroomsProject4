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

    public function recoveryIdAndHashedPassword(string $pseudo)
    {
        // A partir du pseudo, recuperation de l'identifiant et de son mot de passe hashé
        //$request = $this->database->prepare('SELECT id, pseudo, hashed_password FROM users WHERE pseudo = :pseudo');
        //$request->execute(['pseudo' => $pseudo]);
        //return $result = $request->fetchAll();

        $request = $this->database->prepare('SELECT id, pseudo, hashed_password FROM users WHERE pseudo = :pseudo');
        $request->execute(['pseudo' => $pseudo]);
        return $result = $request->fetch();
    }

    public function recoveryPseudoDatabaseExist(string $pseudo)
    {
        $request = $this->database->prepare('SELECT pseudo FROM users WHERE pseudo = :pseudo');
        $request->execute(['pseudo' => $pseudo]);
        return $resultat = $request->fetch();
    }

    public function TryPseudoPassword(string $pseudo, string $hashedpassword): void
    {
        $request = $this->database->prepare('SELECT count(*) FROM users WHERE pseudo = :pseudo AND hashed_password = :hashed_password');
        $request->bindParam('pseudo', $pseudo, \PDO::PARAM_STR);
        $request->bindParam('hashed_password', $hashedpassword, \PDO::PARAM_STR);
        $result = $request->fetchAll();
        //echo '<pre>';
        //var_dump($result);
        //print_r($result);
        //die();
        //echo '</pre>';
        //unset($request);
        //$this->database=NULL;
    }
}
