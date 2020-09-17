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

        $request = $this->database->prepare('SELECT id, chapter, title, content, CONCAT_WS(\' \', \'le\', DAYNAME(post_date), DAY(post_date), MONTHNAME(post_date), YEAR(post_date)) AS post_date_fr FROM Posts WHERE id=:id');
		$request->execute(['id' => $postId]);
		return $request->fetch();
    }
    
    public function getNbPosts(): int
    {
        $request = $this->database->prepare('SELECT COUNT(*) AS nb_total_posts FROM `Posts`;');
        $request->execute();
        $result = $request->fetch();
        $nbTotalPosts = (int)$result['nb_total_posts'];
        return $nbTotalPosts;
    }

    public function getNbPages(int $nbTotalPosts, int $nbPostsPerPage): int
    {
        $nbTotalPages = ceil($nbTotalPosts / $nbPostsPerPage);
        return (int)$nbTotalPages;
    }

    public function getListPostsPagination(int $currentPage, int $nbPostsPerPage): ?array
    {
        // Essai
        $firstPostPage=($currentPage-1)*$nbPostsPerPage;
        //$firstPostPage = ($currentPage * $nbPostsPerPage) - $nbPostsPerPage;
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();

        $request = $this->database->prepare('SELECT id, title, introduction, CONCAT_WS(\' \', \'le\', DAYNAME(post_date), DAY(post_date), MONTHNAME(post_date), YEAR(post_date)) AS post_date_fr FROM Posts ORDER BY post_date ASC LIMIT :firstPostPage, :nbPostsPerPage');
        $request->bindValue(':firstPostPage', $firstPostPage, \PDO::PARAM_INT);
        $request->bindValue(':nbPostsPerPage', $nbPostsPerPage, \PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll();
    }
    
    public function previousPage($currentPage): ?int
    {
        //return 1;
        // Chercher la requete qui convient
        // Ne pas avoir page 8 et l'onglet Page suivante
        // Ne pas avoir page 0 et l'onglet Page precedente
        
        /*
        if ($currentPage === 0 && $currentPage === 8) {
            $currentPage = null;
        }
        */
        // Reflexion
        //$request = $this->database->prepare('SELECT id FROM Posts WHERE chapter = :chapter ORDER BY post_date ASC LIMIT :start, :limit');
        //$request = $this->database->prepare('SELECT id FROM Posts WHERE page = :page ORDER BY post_date ASC LIMIT :start, :limit');
        //$request = $this->database->prepare('SELECT id FROM Posts WHERE chapter = (SELECT MAX(chapter) FROM Posts WHERE chapter < :chapter)');
        
        $request = $this->database->prepare('SELECT page FROM Posts WHERE page = (SELECT MAX(page) FROM Posts WHERE page < :page)');
        //$request = $this->database->prepare('SELECT page FROM Posts WHERE page = :page ORDER BY post_date');
        $request->execute(['page' => $currentPage]);
        $result = $request->fetch();
        return $result === false ? null : (int)$result['page'];

        //$request->bindValue(':start', $start, \PDO::PARAM_INT);
        //$request->bindValue(':limit', $limit, \PDO::PARAM_INT);
        //$request->bindValue(':page', $currentPage, \PDO::PARAM_INT);
        //$request->execute();
        //$result = $request->fetch();
        //return $result === false ? null : (int)$result['id'];
    }
    
    public function nextPage($currentPage): ?int
    {
        //return 3;
        /*
        if ($currentPage === 7) {
            $currentPage = null;
        }
        return $currentPage = $currentPage+1;
        */

        $request = $this->database->prepare('SELECT page FROM Posts WHERE page = (SELECT MIN(page) FROM Posts WHERE page > :page)');
        //$request = $this->database->prepare('SELECT page FROM Posts WHERE page = :page ORDER BY post_date');
        $request->execute(['page' => $currentPage]);
        $result = $request->fetch();
        return $result === false ? null : (int)$result['page'];
    }

    public function getDetailPostPagination(int $currentPage, int $nbPostsPerPage): ?array
    {   
        $firstPostPage=($currentPage-1)*$nbPostsPerPage;
        //$firstPostPage = ($currentPage * $nbPostsPerPage) - $nbPostsPerPage;
        
        $request = $this->database->prepare('SELECT * FROM Posts ORDER BY post_date DESC LIMIT :firstPostPage, :nbPostsPerPage');
        $request->bindValue(':firstPostPage', $firstPostPage, \PDO::PARAM_INT);
        $request->bindValue(':nbPostsPerPage', $nbPostsPerPage, \PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll();
    }

    public function previousPost($chapter): ?int
    {
        $request = $this->database->prepare('SELECT id FROM Posts WHERE chapter = (SELECT MAX(chapter) FROM Posts WHERE chapter < :chapter)');
        $request->execute(['chapter' => $chapter]);
        $result = $request->fetch();
        return $result === false ? null : (int)$result['id'];
    }

    public function nextPost($chapter): ?int
    {
        $request = $this->database->prepare('SELECT id FROM Posts WHERE chapter = (SELECT MIN(chapter) FROM Posts WHERE chapter > :chapter)');
        $request->execute(['chapter' => $chapter]);
        $result = $request->fetch();
        return $result === false ? null : (int)$result['id'];
    }

}
