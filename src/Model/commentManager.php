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
        
        $request = $this->database->prepare('SELECT id, pseudo, comment, DATE_FORMAT(comment_date, \'%e %M %Y à %H:%i\') AS comment_date_fr, post_id, reported, approved FROM Comments WHERE post_id=:post_id ORDER BY comment_date DESC');
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

    public function showAllCommentOfPost(int $postId): ?array
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
    
    /*************************************************************************/

    public function showAllComment(): ?array
    {
        $request = $this->database->prepare('SELECT id, pseudo, comment, comment_date, post_id, reported, approved FROM Comments ORDER BY comment_date DESC');
        $request->execute();
        return $request->fetchAll();
    }

    public function showAllReportedComment()
    {
        $request = $this->database->prepare('SELECT id, pseudo, comment, comment_date, post_id FROM Comments WHERE reported=1 ORDER BY comment_date DESC');
        $request->execute();
        return $request->fetchAll();
    }

    public function showAllApprovedComment()
    {
        $request = $this->database->prepare('SELECT id, pseudo, comment, comment_date, post_id FROM Comments WHERE approved=1 ORDER BY comment_date DESC');
        $request->execute();
        return $request->fetchAll();
    }

    // Probleme si int post_id et reported pour AdminController.php
    public function newComment(string $pseudo, string $comment, string $post_id, string $reported): void
    {
        $request = $this->database->prepare('INSERT INTO `Comments` (pseudo, comment, post_id, reported, post_date) VALUES (:pseudo, :comment, :post_id, :reported, NOW())');
        $request->bindValue('pseudo', $pseudo, \PDO::PARAM_STR);
        $request->bindValue('comment', $comment, \PDO::PARAM_STR);
        $request->bindValue('post_id', $post_id, \PDO::PARAM_INT);
        $request->bindValue('reported', $reported, \PDO::PARAM_INT);
        $request->execute();
    }

    public function approveComment($commentId): void
    {
        $request= $this->database->prepare('UPDATE comments SET reported=0 WHERE id=:id');
        $request->bindValue('id', $commentId, \PDO::PARAM_INT);
        $request->execute();

        $request= $this->database->prepare('UPDATE comments SET approved=1 WHERE id=:id');
        $request->bindValue('id', $commentId, \PDO::PARAM_INT);
        $request->execute();
    }

    public function deleteComment(int $commentId): void
    {
        $request = $this->database->prepare('DELETE FROM Comments WHERE id=:id');
        $request->bindValue(':id', $commentId, \PDO::PARAM_INT);
        $request->execute();
    }

    public function showOneComment(int $id): ?array
    {
        $request = $this->database->prepare('SELECT id, pseudo, comment, DATE_FORMAT(comment_date, \'%e %M %Y à %H:%i\') AS comment_date_fr, post_id, reported, approved FROM Comments WHERE id=:id ORDER BY comment_date DESC');
        $request->bindValue(':id', $id, \PDO::PARAM_INT);
        $request->execute();
        return $request->fetchAll();
        //return $request->fetch();
    }
}
