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
        $pdo = new PDO('mysql:host=localhost;dbname=openclassrooms_project4;charset=utf8', 'studentOCProject4', 'a#V%tOlefW!*qY&m?eR-$=ZnBw', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        return $pdo;
    }
}
