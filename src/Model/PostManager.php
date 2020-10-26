<?php

declare(strict_types=1);

namespace App\Model;

use App\Service\Database;

if (!isset($_SESSION)) {
    // On demarre la session
    session_start();
}

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
        
        $request = $this->database->prepare('SELECT id, title, introduction, CONCAT_WS(\' \', \'le\', DAYNAME(post_date), DAY(post_date), MONTHNAME(post_date), YEAR(post_date)) AS post_date_fr FROM posts ORDER BY post_date DESC LIMIT 0,3');
        $request->execute();
        return $request->fetchAll();
    }

    public function showAllPosts(): ?array
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();

        $request = $this->database->prepare('SELECT id, title, introduction, CONCAT_WS(\' \', \'le\', DAYNAME(post_date), DAY(post_date), MONTHNAME(post_date), YEAR(post_date)) AS post_date_fr FROM posts ORDER BY post_date');
        $request->execute();
        return $request->fetchAll();
    }

    public function getPost(int $postId): ?array
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();

        $request = $this->database->prepare('SELECT id, chapter, title, content, CONCAT_WS(\' \', \'le\', DAYNAME(post_date), DAY(post_date), MONTHNAME(post_date), YEAR(post_date)) AS post_date_fr FROM posts WHERE id = :id');
        $request->execute(['id' => $postId]);
        return $request->fetch();
    }
    
    public function getNbPosts(): int
    {
        $request = $this->database->prepare('SELECT COUNT(*) AS nb_total_posts FROM posts;');
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

    public function getListPostsPagination(int $currentPage, int $nbPostsPerPage): ?array
    {
        $firstPostPage=($currentPage-1)*$nbPostsPerPage;
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();

        $request = $this->database->prepare('SELECT id, title, introduction, CONCAT_WS(\' \', \'le\', DAYNAME(post_date), DAY(post_date), MONTHNAME(post_date), YEAR(post_date)) AS post_date_fr FROM posts ORDER BY post_date ASC LIMIT :firstPostPage, :nbPostsPerPage');
        $request->bindValue(':firstPostPage', $firstPostPage, \PDO::PARAM_INT);
        $request->bindValue(':nbPostsPerPage', $nbPostsPerPage, \PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll();
    }

    public function getListEpisodesPagination(int $currentPage, int $nbEpisodesPerPage): ?array
    {
        $firstEpisodePage=($currentPage-1)*$nbEpisodesPerPage;
        $request = $this->database->prepare('SELECT id, chapter, title, introduction, post_date FROM posts ORDER BY post_date ASC LIMIT :firstEpisodePage, :nbEpisodesPerPage');
        $request->bindValue(':firstEpisodePage', $firstEpisodePage, \PDO::PARAM_INT);
        $request->bindvalue(':nbEpisodesPerPage', $nbEpisodesPerPage, \PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll();
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

    /*************************************************************************/
    
    public function showAllPost()
    {
        $request = $this->database->prepare('SELECT * FROM posts ORDER BY post_date');
        $request->execute();
        return $request->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function showAllPostsById()
    {
        $request = $this->database->prepare('SELECT * FROM posts ORDER BY id');
        $request->execute();
        return $request->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function showAllPostsByIdDesc()
    {
        $request = $this->database->prepare('SELECT * FROM posts ORDER BY id DESC');
        $request->execute();
        return $request->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function showOnePost(int $postId)
    {   // Que mettre comme proprietes typées ?
        //  : ?array pour recuperer les données dans un tableau
        // Mais si l'id est inconnu, exemple 99 problème: non affichage du message erreur "Cet id n'existe pas" Alors qu'avec
        //  : ? bool , affichage du message erreur, si id inconnu ex 99 mais la recuperation des données ne marche pas ...
        $request = $this->database->prepare('SELECT id, chapter, title, introduction, content, author, post_date FROM posts WHERE id = :id');
        //$request->execute(['id' => $postId]);
        //return $request->fetch();
        $request->bindValue(':id', $postId, \PDO::PARAM_INT);
        $request->execute();
        return $request->fetch();
    }

    public function newPost(string $chapter, string $title, string $introduction, string $content, string $author): void
    {
        $request = $this->database->prepare('INSERT INTO posts (chapter, title, introduction, content, author, post_date) VALUES (:chapter, :title, :introduction, :content, :author, NOW())');
        $request->bindValue(':chapter', $chapter, \PDO::PARAM_INT);
        $request->bindValue(':title', $title, \PDO::PARAM_STR);
        $request->bindValue(':introduction', $introduction, \PDO::PARAM_STR);
        $request->bindValue(':content', $content, \PDO::PARAM_STR);
        $request->bindValue(':author', $author, \PDO::PARAM_STR);
        $request->execute();
        // Chercher, trouver comment envoyer la date au format datetime de mysql
        // dans le formulaire avec un input type date et recupere la variable $date dans la fonction ??
        //$request->bindValue('post_date', $date("Y-m-d H:i:s", strtotime($date)), \PDO::PARAM_STR);
        // return $request->execute();
        /*return $request->execute([
            'chapter' => $chapter,
            'title' => $title,
            'introduction' => $introduction,
            'content' => $content,
            'author' => $author,
            'post_date' => $date
            ]);
        */
    }
    
    public function editPost(string $id, string $chapter, string $title, string $introduction, string $content, string $author): void
    {
        $request = $this->database->prepare('UPDATE posts SET chapter = :chapter, title = :title, introduction = :introduction, content = :content, author = :author WHERE id = :id');
        $request->bindValue(':id', $id, \PDO::PARAM_INT);
        $request->bindValue(':chapter', $chapter, \PDO::PARAM_INT);
        $request->bindValue(':title', $title, \PDO::PARAM_STR);
        $request->bindValue(':introduction', $introduction, \PDO::PARAM_STR);
        $request->bindValue(':content', $content, \PDO::PARAM_STR);
        $request->bindValue(':author', $author, \PDO::PARAM_STR);
        $request->execute();
    }

    public function deletePost(int $postId): void
    {
        $request = $this->database->prepare('DELETE FROM posts WHERE id = :id');
        $request->bindValue(':id', $postId, \PDO::PARAM_INT);
        $request->execute();
    }
}
