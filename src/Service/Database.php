<?php

declare(strict_types=1);
// class pour gérer la connection à la base de donnée
class Database
{
    /**
     *  Retourne une connexion à la base de données
     *
     * @return PDO
     */
    public function getPdo(): PDO
    {
        $pdo = new PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'studentBlogPOO', 'zkollf9ITvoJeupP', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        return $pdo;
    }
}
