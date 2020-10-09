<?php

declare(strict_types=1);

namespace App\Model;

use App\Service\Database;

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
    
    public function postNew(string $chapter, string $title, string $introduction, string $content, string $author, string $date): bool
    {
        /* Probleme si je mets int $chapter, avertissement trouve string au lieu de int */
        /* Probleme dans la base de données, donnée pas inscrit dans les bons champs ...
        2020-10-06 dans le champ introduction
        Introduction du test de l'épisode 37 dans le champ author
        0000-00-00 00:00:00 dans le champ post_date
         */
        $request = $this->database->prepare('INSERT INTO Posts (id, chapter, title, introduction, content, author, post_date) VALUES (NULL, :chapter, :title, :introduction, :content, :author, :post_date)');
        $request->bindValue('chapter', $chapter, \PDO::PARAM_INT);
        $request->bindValue('title', $title, \PDO::PARAM_STR);
        $request->bindValue('introduction', $introduction, \PDO::PARAM_STR);
        $request->bindValue('content', $content, \PDO::PARAM_STR);
        $request->bindValue('author', $author, \PDO::PARAM_STR);
        $request->bindValue('post_date', $date, \PDO::PARAM_STR);
        //$request->bindValue('post_date', $date("Y-m-d H:i:s", strtotime($date)), \PDO::PARAM_STR);
        return $request->execute();
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

    // Reflexion avoir l'id du post cliqué et ensuite le modifier avec UPDATE ?
    public function postEdit(int $postId): ?array
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();

        $request = $this->database->prepare('SELECT id, chapter, title, content, CONCAT_WS(\' \', \'le\', DAYNAME(post_date), DAY(post_date), MONTHNAME(post_date), YEAR(post_date)) AS post_date_fr FROM Posts WHERE id=:id');
        $request->execute(['id' => $postId]);
        return $request->fetch();
    }

    public function postTrash(int $postId): ?array
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();

        $request = $this->database->prepare('SELECT id, chapter, title, content, CONCAT_WS(\' \', \'le\', DAYNAME(post_date), DAY(post_date), MONTHNAME(post_date), YEAR(post_date)) AS post_date_fr FROM Posts WHERE id=:id');
        $request->execute(['id' => $postId]);
        return $request->fetch();
    }

    public function postDelete(int $postId): ?array
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();

        $request = $this->database->prepare('SELECT id, chapter, title, content, CONCAT_WS(\' \', \'le\', DAYNAME(post_date), DAY(post_date), MONTHNAME(post_date), YEAR(post_date)) AS post_date_fr FROM Posts WHERE id=:id');
        $request->execute(['id' => $postId]);
        return $request->fetch();
    }
}
