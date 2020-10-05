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

    public function adminLogin(): int
    {
        return 1;
    }

    public function showAllPosts(): ?array
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();

        $request = $this->database->prepare('SELECT id, chapter, title, introduction, CONCAT_WS(\' \', \'le\', DAYNAME(post_date), DAY(post_date), MONTHNAME(post_date), YEAR(post_date)) AS post_date_fr FROM Posts ORDER BY post_date');
        $request->execute();
        return $request->fetchAll();
    }

    // Reflexion pour affichage ListOfEpisodes afficher les commentaires en fonction de l'episode dans la rangée
    
    public function getComments(int $postId): ?array
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();
        
        $request = $this->database->prepare('SELECT id, pseudo, comment, DATE_FORMAT(comment_date, \'%e %M %Y à %H:%i\') AS comment_date_fr, post_id, report FROM Comments WHERE post_id=:post_id ORDER BY comment_date DESC');
        $request->bindValue(':post_id', $postId, \PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll();
    }
        
    public function getPostNbComments(int $postId): ?int
    {
        $request = $this->database->prepare('SELECT COUNT(*) AS nb_total_comments FROM Comments WHERE post_id=:post_id');
        $request->execute(['post_id' => $postId]);
        $result = $request->fetch();
        $nbTotalComments = (int)$result['nb_total_comments'];
        return $nbTotalComments;        
    }

    public function showAllComment(int $postId): ?array
    {
        $request = $this->database->prepare('SELECT id, pseudo, comment, comment_date, post_id FROM Comments WHERE post_id=:post_id ORDER BY comment_date DESC');
        $request->execute(['post_id' => $postId]);
        return $request->fetch();
    }

    public function showAllComments(): ?array
    {
        $request = $this->database->prepare('SELECT id, pseudo, comment, comment_date, post_id FROM Comments ORDER BY comment_date DESC');
        $request->execute();
        return $request->fetchAll();
    }
}