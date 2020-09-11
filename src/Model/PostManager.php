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
    
    public function getPostNbPosts(): int
    {
        $request = $this->database->prepare('SELECT COUNT(*) AS nb_total_posts FROM `Posts`;');
        $request->execute();
        $result = $request->fetch();
        $nbTotalPosts = (int)$result['nb_total_posts'];
        return $nbTotalPosts;
    }

    public function getPostNbPages(int $nbTotalPosts,int $nbPostsPerPage): float
    {
        $nbTotalPages = ceil($nbTotalPosts / $nbPostsPerPage);
        return $nbTotalPages;
    }

    public function getDetailPostPagination(int $currentPage, int $nbPostsPerPage): ?array
    {   
        $firstPostPage = ($currentPage * $nbPostsPerPage) - $nbPostsPerPage;

        $request = $this->database->prepare('SELECT * FROM Posts ORDER BY post_date DESC LIMIT :firstPostPage, :nbPostsPerPage;');
        $request->bindValue(':firstPostPage', $firstPostPage, \PDO::PARAM_INT);
        $request->bindValue(':nbPostsPerPage', $nbPostsPerPage, \PDO::PARAM_INT);
        $request->execute();
        $posts = $request->fetchAll(\PDO::FETCH_ASSOC);
        return $posts;
    }

    public function getListPostPagination(int $currentPage, int $nbPostsPerPage): ?array
    {
        $firstPostPage = ($currentPage * $nbPostsPerPage) - $nbPostsPerPage;

        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();

        //$request = $this->database->prepare('SELECT id, title, introduction, CONCAT_WS(\' \', \'le\', DAYNAME(post_date), DAY(post_date), MONTHNAME(post_date), YEAR(post_date)) AS post_date_fr FROM Posts ORDER BY post_date DESC LIMIT :firstPostPage, :nbPostsPerPage;');
        // SQLSTATE[42000]: Syntax error or access violation: 1064 Erreur de syntaxe près de ''5', '5'' à la ligne 1
        //$request->execute(['firstPostPage' => $firstPostPage, 'nbPostsPerPage' => $nbPostsPerPage]);
        
        $request = $this->database->prepare('SELECT id, title, introduction, CONCAT_WS(\' \', \'le\', DAYNAME(post_date), DAY(post_date), MONTHNAME(post_date), YEAR(post_date)) AS post_date_fr FROM Posts ORDER BY post_date DESC LIMIT '.$firstPostPage.','.$nbPostsPerPage);
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

    public function previousPage(): ?int
    {
        return 1;
    }
    
    public function nextPage(): ?int
    {
        return 3;
    }
    




}
