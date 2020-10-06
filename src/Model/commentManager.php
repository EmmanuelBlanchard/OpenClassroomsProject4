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
        // Ne fonctionne pas avec la ligne ci dessous
        //return $result === false ? null : (int)$result['nb_total_comments'];
        $nbTotalComments = (int)$result['nb_total_comments'];
        return $nbTotalComments;
    }

    public function showAllComment(int $postId): ?array
    {
        $request = $this->database->prepare('SELECT id, pseudo, comment, comment_date, post_id FROM Comments WHERE post_id=:post_id ORDER BY comment_date DESC');
        $request->execute(['post_id' => $postId]);
        return $request->fetch();
    }

    public function postComment(int $postId, string $comment, string $pseudo): bool
    {
        $request = $this->database->prepare('INSERT INTO Comments (pseudo, comment, comment_date, post_id) VALUES
        (:pseudo, :comment, NOW(), :post_id)');
        return $request->execute([
            'pseudo' => $pseudo,
            'comment' => $comment,
            'post_id' => $postId
            ]);
    }
    
    public function updateComment(int $commentId): bool
    {
        $request = $this->database->prepare('UPDATE Comments SET comment="Ce message a été supprimé par l\'administrateur", report=2 WHERE id=:id');
        $request->execute(['id' => $commentId]);
        return $request;
    }

    public function validateComment(int $commentId): bool
    {
        $request= $this->database->prepare('UPDATE Comments SET report=2 WHERE id=:id');
        $request->execute(['id'=> $commentId]);
        return $request;
    }

    public function reportComment(int $commentId): bool
    {
        $request = $this->database->prepare('UPDATE Comments SET report=1 WHERE id=:id');
        return $request->execute(['id' => $commentId]);
    }

    public function reportList(): bool
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();
        
        $request = $this->database->prepare('SELECT id, pseudo, comment, DATE_FORMAT(comment_created_the, \'%e %M %Y à %H:%i\') AS date_comment_created_the, episode_id FROM Comments WHERE report= "1"');
        $request->execute();
        return $request;
    }
}
