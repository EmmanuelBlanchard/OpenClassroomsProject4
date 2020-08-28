<?php

declare(strict_types=1);

namespace App\Model;

use App\Service\Database;

class PostManager
{
    private $database;
    
    public function __construct(Database $database)
    {
        $this->database = $database->getPdo();
    }

    public function showLastThreeEpisodes(): ?array
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();
        
        $request = $this->database->prepare('SELECT id, title, introduction, CONCAT_WS(\' \', \'le\', DAYNAME(episode_date), DAY(episode_date), MONTHNAME(episode_date), YEAR(episode_date)) AS episode_date_fr FROM Episodes ORDER BY episode_date DESC LIMIT 0,3');
        $request->execute();
        return $request->fetchAll();
    }

    public function showAllEpisodes(): ?array
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();

        $request = $this->database->prepare('SELECT id, title, introduction, CONCAT_WS(\' \', \'le\', DAYNAME(episode_date), DAY(episode_date), MONTHNAME(episode_date), YEAR(episode_date)) AS episode_date_fr FROM Episodes ORDER BY episode_date');
        $request->execute();
        return $request->fetchAll();
    }

    public function getEpisode(int $postId): ?array
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();

        $request = $this->database->prepare('SELECT id, title, content, CONCAT_WS(\' \', \'le\', DAYNAME(episode_date), DAY(episode_date), MONTHNAME(episode_date), YEAR(episode_date)) AS episode_date_fr FROM Episodes WHERE id=:id');
        $request->execute(['id' => $postId]);
        return $request->fetch();
    }

    // Essai pagination de page
    public function getPagination()
    {
        $page = $_GET['page'];
        $page = (!empty($_GET['page']) ? $_GET['page'] : 1);

        $limit = 10;
        // Partie "Requête"
        /* On commence par récupérer le nombre d'éléments total. Comme c'est une requête,
        * il ne faut pas oublier qu'on ne récupère pas directement le nombre.
        * Ici, comme la requête ne contient aucune donnée client pour fonctionner,
        * on peut l'exécuter ainsi directement */
        $resultFoundRows = $request = $this->database->prepare('SELECT COUNT(id) FROM `Episodes`');
        /* On doit extraire le nombre du jeu de résultat */
        $nombredElementsTotal = $resultFoundRows->fetchColumn();

        // Partie "Requête"
        /* On calcule le numéro du premier élément à récupérer */
        $start = ($page - 1) * $limit;
        /* La requête contient désormais l'indication de l'élément de départ,
        * avec le nouveau marqueur … */
        $request = $this->database->prepare('SELECT * FROM `Episodes` LIMIT :limit OFFSET :start');

        $request->execute(['limit' => $limit, 'start' => $start]);
        
    }
}
