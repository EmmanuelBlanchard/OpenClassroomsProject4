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
        $request= $this->database->prepare('SELECT * FROM comments WHERE episode_id=:id');
        $request->execute(['episode_id'=> $id]);
        return $request->fetch();
    }

    // Inserer les commentaires publiés dans la base de donnees comments
    public function insertComment() 
    {
        $_POST['pseudo']; // recupère le pseudo de la publication, création du commentaire sous les commentaires deja cree
        $_POST['comment']; // recupère le commentaire de la publication, création du commentaire sous les commentaires deja cree
    }

    public function postComment(int $id, string $pseudo, string $comment)
    {   // Table episodes
        // INSERT INTO `episodes` (`id`, `title`, `introduction`, `content`, `episode_created_the`) VALUES
        // Table comments
        // INSERT INTO `comments` (`id`, `pseudo`, `comment`, `comment_created_the`, `episode_id`)
        $request= $this->database->prepare('INSERT INTO comments (episode_id, pseudo, comment, comment_created_the) VALUES(episode_id=:id, pseudo=:pseudo, comment=:comment, NOW())');
        $affectedLines = $request->execute(array(['episode_id'=> $id, 'pseudo' => $pseudo, 'comment' => $comment]));
        return $affectedLines;
    }

}


