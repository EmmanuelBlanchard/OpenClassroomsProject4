<?php

declare(strict_types=1);

namespace App\Model;

use App\Service\Database;

if (!isset($_SESSION)) {
    // On demarre la session
    session_start();
}

class AdminManager
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database->getPdo();
    }

    public function showAllPosts(): ?array
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();

        $request = $this->database->prepare('SELECT id, chapter, title, introduction, CONCAT_WS(\' \', \'le\', DAYNAME(post_date), DAY(post_date), MONTHNAME(post_date), YEAR(post_date)) AS post_date_fr FROM Posts ORDER BY post_date');
        $request->execute();
        return $request->fetchAll();
    }
    
    public function showAllComment(): ?array
    {
        $request = $this->database->prepare('SELECT id, pseudo, comment, comment_date, post_id FROM Comments ORDER BY comment_date DESC');
        $request->execute();
        return $request->fetchAll();
    }
    // ESSAI
    public function showAllPost()
    {
        $request = $this->database->prepare('SELECT * FROM Posts ORDER BY post_date');
        $request->execute();
        // On stocke le resultat dans un tableau associatif
        return $request->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function showAllPostsById()
    {
        $request = $this->database->prepare('SELECT * FROM Posts ORDER BY id');
        $request->execute();
        // On stocke le resultat dans un tableau associatif
        return $request->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function showAllPostsByIdDesc()
    {
        $request = $this->database->prepare('SELECT * FROM Posts ORDER BY id DESC');
        $request->execute();
        // On stocke le resultat dans un tableau associatif
        return $request->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function showOnePost(int $postId)
    {   // Que mettre comme proprietes typées ?
        //  : ?array pour recuperer les données dans un tableau
        // Mais si l'id est inconnu, exemple 99 problème: non affichage du message erreur "Cet id n'existe pas" Alors qu'avec
        //  : ? bool , affichage du message erreur, si id inconnu ex 99 mais la recuperation des données ne marche pas ...
        $request = $this->database->prepare('SELECT id, chapter, title, introduction, content, author, post_date FROM Posts WHERE id=:id');
        //$request->execute(['id' => $postId]);
        //return $request->fetch();
        $request->bindValue(':id', $postId, \PDO::PARAM_INT);
        $request->execute();
        return $request->fetch();
    }

    public function newPost(string $chapter, string $title, string $introduction, string $content, string $author): void
    {
        $request = $this->database->prepare('INSERT INTO `Posts` (chapter, title, introduction, content, author, post_date) VALUES (:chapter, :title, :introduction, :content, :author, NOW())');
        $request->bindValue('chapter', $chapter, \PDO::PARAM_INT);
        $request->bindValue('title', $title, \PDO::PARAM_STR);
        $request->bindValue('introduction', $introduction, \PDO::PARAM_STR);
        $request->bindValue('content', $content, \PDO::PARAM_STR);
        $request->bindValue('author', $author, \PDO::PARAM_STR);
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
        $request = $this->database->prepare('UPDATE `Posts` SET `chapter`=:chapter, `title`=:title, `introduction`=:introduction, `content`=:content, `author`=:author WHERE `id`=:id');
        $request->bindValue('id', $id, \PDO::PARAM_INT);
        $request->bindValue('chapter', $chapter, \PDO::PARAM_INT);
        $request->bindValue('title', $title, \PDO::PARAM_STR);
        $request->bindValue('introduction', $introduction, \PDO::PARAM_STR);
        $request->bindValue('content', $content, \PDO::PARAM_STR);
        $request->bindValue('author', $author, \PDO::PARAM_STR);
        $request->execute();
    }

    public function deletePost(int $postId): void
    {
        $request = $this->database->prepare('DELETE FROM `Posts` WHERE `id`=:id');
        $request->bindValue(':id', $postId, \PDO::PARAM_INT);
        $request->execute();
    }

    public function getComments(int $postId): ?array
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();
        
        $request = $this->database->prepare('SELECT id, pseudo, comment, DATE_FORMAT(comment_date, \'%e %M %Y à %H:%i\') AS comment_date_fr, post_id, report FROM Comments WHERE post_id=:post_id ORDER BY comment_date DESC');
        $request->bindValue(':post_id', $postId, \PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll();
    }
    // Probleme si int post_id et report pour AdminController.php
    // public function newComment(string $pseudo, string $comment, int $post_id, int $report): void
    public function newComment(string $pseudo, string $comment, string $post_id, string $report): void
    {
        $request = $this->database->prepare('INSERT INTO `Comments` (pseudo, comment, post_id, report, post_date) VALUES (:pseudo, :comment, :post_id, :report, NOW())');
        $request->bindValue('pseudo', $pseudo, \PDO::PARAM_STR);
        $request->bindValue('comment', $comment, \PDO::PARAM_STR);
        $request->bindValue('post_id', $post_id, \PDO::PARAM_INT);
        $request->bindValue('report', $report, \PDO::PARAM_INT);
        $request->execute();
    }

    public function approveComment($commentId): void
    {
        //var_dump('Salut');
        //die();
        //$request = $this->database->prepare('UPDATE `Comments` SET `report`=:report WHERE `id`=:id');
        $request= $this->database->prepare('UPDATE comments SET report=2 WHERE id=:id');
        $request->bindValue('id', $commentId, \PDO::PARAM_INT);
        //$request->bindValue('report', 2, \PDO::PARAM_INT);
        $request->execute();
    }

    public function deleteComment(int $commentId): void
    {
        $request = $this->database->prepare('DELETE FROM `Comments` WHERE `id`=:id');
        $request->bindValue(':id', $commentId, \PDO::PARAM_INT);
        $request->execute();
    }

    public function showOneComment(int $id): ?array
    {   // Que mettre comme proprietes typées ?
        $request = $this->database->prepare('SELECT id, pseudo, comment, DATE_FORMAT(comment_date, \'%e %M %Y à %H:%i\') AS comment_date_fr, post_id, report FROM Comments WHERE id=:id ORDER BY comment_date DESC');
        $request->bindValue(':id', $id, \PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll();
        //return $request->fetch();
    }
}
