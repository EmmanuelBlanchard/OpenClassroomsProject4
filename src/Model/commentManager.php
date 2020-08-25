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
    
    public function getComments(int $id) : ?array
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();
        
        $request = $this->database->prepare('SELECT id, author, comment, DATE_FORMAT(comment_created_the, \'%e %M %Y à %H:%i\') AS date_comment_created_the, episode_id FROM Comments WHERE episode_id=:episode_id ORDER BY comment_created_the DESC');
        $request->execute(['episode_id' => $id]);
        return $request->fetchAll();
    }

    public function showAllComment(int $id) : ?array
    {
        $request = $this->database->prepare('SELECT id, author, comment, comment_created_the, episode_id FROM Comments WHERE episode_id=:episode_id ORDER BY comment_created_the DESC');
        $request->execute(['episode_id' => $id]);
        return $request->fetch();
    }

    public function postComment(int $id, string $comment, string $author): bool
    {
        $request = $this->database->prepare('INSERT INTO Comments (author, comment, comment_created_the, episode_id) VALUES
        (:author, :comment, NOW(), :episode_id)');
        return $request->execute([
            'author' => $author,
            'comment' => $comment,
            'episode_id' => $id
            ]);

        // Redirection du visiteur vers la page du detailofepisode avec l'identifiant de l'episode où le commentaire est publié
        //header('Location: index.php?action=detailofepisode&id=$id'); marche pas problème 
        header('Location: index.php?action=detailofepisode&id='.$id);
    }

}
