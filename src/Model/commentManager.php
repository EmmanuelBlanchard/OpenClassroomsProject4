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
    
    public function findAllEpisode(int $id): ?array
    {
        $request= $this->database->prepare('SELECT * FROM comments WHERE id=:episode_id');
        $request->execute(['episode_id'=> $id]);
        return $request->fetchAll();
    }

    // Changement de WHERE episode_id=:id et execute(['id' => $id])
    public function getComments(int $id) : ?array
    {
        $request= $this->database->prepare('SELECT episode_id, pseudo, comment, comment_created_the FROM comments WHERE episode_id=:episode_id ORDER BY comment_created_the DESC');
        $request->execute(['episode_id' => $id]);
        return $request->fetchAll();
    }

    public function postComment(int $id, string $pseudo, string $comment)
    {   // Table episodes
        // INSERT INTO `episodes` (`id`, `title`, `introduction`, `content`, `episode_created_the`) VALUES
        // Table comments
        // INSERT INTO `comments` (`id`, `pseudo`, `comment`, `comment_created_the`, `episode_id`)
        // Recuperer les commentaires où id de la table episodes = episode_id de la table comments
        $request= $this->database->prepare('INSERT INTO comments (episode_id, pseudo, comment, comment_created_the) VALUES(id=:episode_id, pseudo=:pseudo, comment=:comment, NOW())');
        $request->execute(['episode_id'=> $id, 'pseudo' => $pseudo, 'comment' => $comment]);
        return $request->fetchAll();
    }
}
