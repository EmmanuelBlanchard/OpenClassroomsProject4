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

    public function showLastThreePosts(): ?array
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();
        
        $request = $this->database->prepare('SELECT id, title, introduction, CONCAT_WS(\' \', \'le\', DAYNAME(post_date), DAY(post_date), MONTHNAME(post_date), YEAR(post_date)) AS post_date_fr FROM Posts ORDER BY post_date DESC LIMIT 0,3');
        $request->execute();
        return $request->fetchAll();
    }

    public function showAllPosts(): ?array
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();

        $request = $this->database->prepare('SELECT id, title, introduction, CONCAT_WS(\' \', \'le\', DAYNAME(post_date), DAY(post_date), MONTHNAME(post_date), YEAR(post_date)) AS post_date_fr FROM Posts ORDER BY post_date');
        $request->execute();
        return $request->fetchAll();
    }

    public function getPost(int $postId): ?array
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();

        $request = $this->database->prepare('SELECT id, title, content, CONCAT_WS(\' \', \'le\', DAYNAME(post_date), DAY(post_date), MONTHNAME(post_date), YEAR(post_date)) AS post_date_fr FROM Posts WHERE id=:id');
        $request->execute(['id' => $postId]);
        return $request->fetch();
    }

    // Essai pour la pagination
    public function getPost2(int $postId): ?array
	{   /*
        $request = $this->database->prepare('SELECT id, title, chapter, author, content, DATE_FORMAT(post_date, "%d/%m/%Y") post_date_fr FROM posts WHERE id=:id');*/
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();

        $request = $this->database->prepare('SELECT id, chapter, title, content, CONCAT_WS(\' \', \'le\', DAYNAME(post_date), DAY(post_date), MONTHNAME(post_date), YEAR(post_date)) AS post_date_fr FROM Posts WHERE id=:id');
        
		$request->execute(['id' => $postId]);
		return $request->fetch();
    }
    
    public function getInfosEpisodes(): ? array
    {
        // On prépare la requête
        $request = $this->database->prepare('SELECT * FROM `Posts` ORDER BY `post_date` DESC;');
        // On exécute
        $request->execute();
        // On récupère les valeurs dans un tableau associatif
        return $request->fetchAll();
    }

    public function getPostNbPosts(): ? int
    {
        // On détermine le nombre total de posts
        // On prépare la requête
        $request = $this->database->prepare('SELECT COUNT(*) AS nb_posts FROM `Posts`;');
        // On exécute 
        $request->execute();
        // On récupère le nombre de posts
        $result = $request->fetch();
        
        $nbPosts = (int) $result['nb_posts'];

        return $nbPosts;
        
    }

    public function getPostNbPages(int $nbPosts)
    {
        // On détermine le nombre de posts par page
        $perPage = 10;

        // On calcule le nombre de pages total
        $pages = ceil($nbPosts / $perPage);

        return $pages;
    }

    public function getPostNbPages2()
    {
        // On prépare la requête qui détermine le nombre total de posts
        $request = $this->database->prepare('SELECT COUNT(*) AS nb_posts FROM `Posts`;');
        // On exécute 
        $request->execute();
        // On récupère le nombre de posts
        $result = $request->fetch();
        
        $nbPosts = (int) $result['nb_posts'];

        // On détermine le nombre de posts par page
        $perPage = 10;

        // On calcule le nombre de pages total
        $pages = ceil($nbPosts / $perPage);

        return $pages;
    }

    public function getPostPagination(int $currentPage): ? array
    {
        // On détermine le nombre de posts par page
         $perPage = 10;

        // Calcul du 1er post de la page
         $first = ($currentPage * $perPage) - $perPage;

        // $request = $this->database->prepare('SELECT * FROM `Episodes` ORDER BY `episode_date` DESC LIMIT :first, :perpage;');
        // $request->execute(['first' => $first, 'perpage' => $perPage]);
        // $episodes = $request->fetchAll();
        // return $episodes;


        $request = $this->database->prepare('SELECT * FROM `Posts` ORDER BY `post_date` DESC LIMIT :first, :perpage;');

        $request->bindValue(':first', $first, \PDO::PARAM_INT);
        $request->bindValue(':perpage', $perPage, \PDO::PARAM_INT);
        // On exécute
        $request->execute();
        // On récupère les valeurs dans un tableau associatif
        $posts = $request->fetchAll(\PDO::FETCH_ASSOC);
        return $posts;
    }

    public function getPaginationList(): ? array
    {
        // On détermine le nombre de posts par page
        $perPage = 10;

        // Page actuelle par defaut => 1
        $currentPage = 1;

        // Calcul du 1er post de la page
         $first = ($currentPage * $perPage) - $perPage;

        $request = $this->database->prepare('SELECT * FROM `Posts` ORDER BY `post_date` DESC LIMIT :first, :perpage;');

        $request->bindValue(':first', $first, \PDO::PARAM_INT);
        $request->bindValue(':perpage', $perPage, \PDO::PARAM_INT);
        // On exécute
        $request->execute();
        // On récupère les valeurs dans un tableau associatif
        $posts = $request->fetchAll(\PDO::FETCH_ASSOC);
        return $posts;
    }
    

}
