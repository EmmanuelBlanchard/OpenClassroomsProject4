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

    //Essai pour la pagination
    public function getPost(int $postId): ?array
	{   /*
        $request = $this->database->prepare('SELECT id, title, chapter, author, content, DATE_FORMAT(post_date, "%d/%m/%Y") post_date_fr FROM posts WHERE id=:id');*/
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();

        $request = $this->database->prepare('SELECT id, title, content, CONCAT_WS(\' \', \'le\', DAYNAME(episode_date), DAY(episode_date), MONTHNAME(episode_date), YEAR(episode_date)) AS episode_date_fr FROM Episodes WHERE id=:id');
        
		$request->execute(['id' => $postId]);
		return $request->fetch();
    }
    
    //Essai pour la pagination
    public function getPostPagination()
    {
        // $sql = 'SELECT * FROM `articles` ORDER BY `created_at` DESC;';
        // $sql = 'SELECT * FROM `Episodes` ORDER BY `episode_date` DESC;';
        // On prépare la requête
        // $query = $db->prepare($sql);
        $request = $this->database->prepare('SELECT * FROM `Episodes` ORDER BY `episode_date` DESC;');

        // On exécute
        //$query->execute();
        $request->execute();

        // On récupère les valeurs dans un tableau associatif
        //$articles = $query->fetchAll(PDO::FETCH_ASSOC);
        return $request->fetchAll();

    }

    public function getPostNbEpisodes(int $nbEpisodes)
    {
        // On détermine le nombre total d'articles
        //$sql = 'SELECT COUNT(*) AS nb_articles FROM `articles`;';
        // On prépare la requête
        //$query = $db->prepare($sql);
        $request = $this->database->prepare('SELECT COUNT(*) AS nb_episodes FROM `Episodes`;');

        // On exécute
        //$query->execute();
        $request->execute();

        // On récupère le nombre d'articles
        //$result = $query->fetch();
        $request->fetch();

        //$nbArticles = (int) $result['nb_articles'];
        $nbEpisodes = (int) $request['nb_episodes'];
        
        return $nbEpisodes;
    }

}
