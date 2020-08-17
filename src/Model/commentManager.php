<?php

declare(strict_types=1);

namespace App\Model;

use App\Service\Database;

class CommentManager
{
    private $database;
    
    public function __construct(Database $database)
    {
        $this->database = $database->getPdo();
    }
    
    // Changement de WHERE episode_id=:id et execute(['id' => $id])
    public function getComments(int $id) : ?array
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();
        /*
        $request = $this->database->prepare('SELECT episode_id, author, comment, DAY(comment_created_the) AS day_comment_created_the, MONTHNAME(comment_created_the) AS name_month_comment_created_the, YEAR(comment_created_the) AS year_comment_created_the, HOUR(comment_created_the) AS hour_comment_created_the, MINUTE(comment_created_the) AS minute_comment_created_the FROM comments WHERE episode_id=:episode_id ORDER BY comment_created_the DESC');
        */
        $request = $this->database->prepare('SELECT episode_id, author, comment, DATE_FORMAT(comment_created_the, \'%e %M %Y à %H:%i\') AS date_comment_created_the FROM comments WHERE episode_id=:episode_id ORDER BY comment_created_the DESC');
        
        $request->execute(['episode_id' => $id]);
        return $request->fetchAll();
    }

    public function postComment(int $id, string $author, string $comment)
    {
        $request= $this->database->prepare('INSERT INTO comments (id, pseudo, author, comment, comment_created_the, episode_id) VALUES(id=:id, pseudo=:author, author=:author, comment=:comment, NOW(), episode_id=:id)');
        $request->execute(['episode_id'=> $id, 'author' => $author, 'comment' => $comment]);
        return $request;
    }

    // Afficher les commentaires publiés à partir de l'id d'un episode
    public function showAllComment(int $id) : ?array
    {
        $request = $this->database->prepare('SELECT id, author, comment, comment_created_the, episode_id FROM comments WHERE episode_id=:episode_id ORDER BY comment_created_the DESC');
        $request->execute(['episode_id' => $id]);
        return $request->fetch();
    }
}
