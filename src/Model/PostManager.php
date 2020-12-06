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
        
        $request = $this->database->prepare('SELECT id, title, introduction, CONCAT_WS(\' \', \'le\', DAYNAME(post_date), DAY(post_date), MONTHNAME(post_date), YEAR(post_date)) AS post_date_fr, post_status FROM posts WHERE post_status=\'publish\' ORDER BY post_date DESC LIMIT 0,3');
        $request->execute();
        $result = $request->fetchAll();
        return !$result ? null : $result;
    }

    public function getListPostsPagination(int $currentPage, int $nbPostsPerPage): ?array
    {
        $firstPostPage=($currentPage-1)*$nbPostsPerPage;
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();

        $request = $this->database->prepare('SELECT id, chapter, title, introduction, CONCAT_WS(\' \', \'le\', DAYNAME(post_date), DAY(post_date), MONTHNAME(post_date), YEAR(post_date)) AS post_date_fr, post_status FROM posts WHERE post_status=\'publish\' ORDER BY chapter, post_date ASC LIMIT :firstPostPage, :nbPostsPerPage');
        $request->bindValue(':firstPostPage', $firstPostPage, \PDO::PARAM_INT);
        $request->bindValue(':nbPostsPerPage', $nbPostsPerPage, \PDO::PARAM_INT);
        $request->execute();
        $result = $request->fetchAll();
        return !$result ? null : $result;
    }

    public function getListEpisodesPagination(int $currentPage, int $nbEpisodesPerPage): ?array
    {
        $firstEpisodePage=($currentPage-1)*$nbEpisodesPerPage;
        $request = $this->database->prepare('SELECT id, chapter, title, introduction, post_date, post_status FROM posts ORDER BY chapter, post_date ASC LIMIT :firstEpisodePage, :nbEpisodesPerPage');
        $request->bindValue(':firstEpisodePage', $firstEpisodePage, \PDO::PARAM_INT);
        $request->bindvalue(':nbEpisodesPerPage', $nbEpisodesPerPage, \PDO::PARAM_INT);
        $request->execute();
        $result = $request->fetchAll();
        return !$result ? null : $result;
    }
    
    public function getPost(int $postId): ?array
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();

        $request = $this->database->prepare('SELECT id, chapter, title, content, CONCAT_WS(\' \', \'le\', DAYNAME(post_date), DAY(post_date), MONTHNAME(post_date), YEAR(post_date)) AS post_date_fr FROM posts WHERE id = :id');
        $request->execute(['id' => $postId]);
        $result = $request->fetch();
        return !$result ? null : $result;
    }
    
    public function getNbPosts(): int
    {
        $request = $this->database->prepare('SELECT COUNT(*) AS nb_total_posts FROM posts WHERE post_status=\'publish\' ');
        $request->execute();
        $result = $request->fetch();
        $nbTotalPosts = (int)$result['nb_total_posts'];
        return $nbTotalPosts;
    }

    public function getNbEpisodes():int
    {
        $request = $this->database->prepare('SELECT COUNT(*) AS nb_total_episodes FROM posts');
        $request->execute();
        $result = $request->fetch();
        $nbTotalEpisodes = (int)$result['nb_total_episodes'];
        return $nbTotalEpisodes;
    }

    public function previousPost($chapter): ?int
    {
        $request = $this->database->prepare('SELECT id FROM posts WHERE chapter = (SELECT MAX(chapter) FROM posts WHERE chapter < :chapter)');
        $request->execute(['chapter' => $chapter]);
        $result = $request->fetch();
        return $result === false ? null : (int)$result['id'];
    }

    public function nextPost($chapter): ?int
    {
        $request = $this->database->prepare('SELECT id FROM posts WHERE chapter = (SELECT MIN(chapter) FROM posts WHERE chapter > :chapter)');
        $request->execute(['chapter' => $chapter]);
        $result = $request->fetch();
        return $result === false ? null : (int)$result['id'];
    }

    public function showOnePost(int $postId): ?array
    {
        $request = $this->database->prepare('SELECT id, chapter, title, introduction, content, post_date, post_status FROM posts WHERE id = :id');
        $request->bindValue(':id', $postId, \PDO::PARAM_INT);
        $request->execute();
        $result = $request->fetch();
        return !$result ? null : $result;
    }

    public function newPost(string $chapter, string $title, string $introduction, string $content, string $episodeStatus): void
    {
        $request = $this->database->prepare('INSERT INTO posts (chapter, title, introduction, content, post_date, post_status) VALUES (:chapter, :title, :introduction, :content, NOW(), :post_status)');
        $request->bindValue(':chapter', $chapter, \PDO::PARAM_INT);
        $request->bindValue(':title', $title, \PDO::PARAM_STR);
        $request->bindValue(':introduction', $introduction, \PDO::PARAM_STR);
        $request->bindValue(':content', $content, \PDO::PARAM_STR);
        $request->bindValue(':post_status', $episodeStatus, \PDO::PARAM_STR);
        $request->execute();
        // Chercher, trouver comment envoyer la date au format datetime de mysql
        // dans le formulaire avec un input type date et recupere la variable $date dans la fonction ??
    }

    public function editPost(string $id, string $chapter, string $title, string $introduction, string $content, string $episodeStatus): void
    {
        $request = $this->database->prepare('UPDATE posts SET chapter = :chapter, title = :title, introduction = :introduction, content = :content, post_date = NOW(), post_status = :post_status WHERE id = :id');
        $request->bindValue(':id', $id, \PDO::PARAM_INT);
        $request->bindValue(':chapter', $chapter, \PDO::PARAM_INT);
        $request->bindValue(':title', $title, \PDO::PARAM_STR);
        $request->bindValue(':introduction', $introduction, \PDO::PARAM_STR);
        $request->bindValue(':content', $content, \PDO::PARAM_STR);
        $request->bindValue(':post_status', $episodeStatus, \PDO::PARAM_STR);
        $request->execute();
    }

    public function deletePost(int $postId): void
    {
        $request = $this->database->prepare('DELETE FROM posts WHERE id = :id');
        $request->bindValue(':id', $postId, \PDO::PARAM_INT);
        $request->execute();
    }
}
