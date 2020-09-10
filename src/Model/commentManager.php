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
        $request->execute(['post_id' => $postId]);
        return $request->fetchAll();
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
        $request->execute(['id' => $commentId]);
        return $request;

    }

    public function reportList(): bool
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();
        
        $request = $this->database->prepare('SELECT id, pseudo, comment, DATE_FORMAT(comment_created_the, \'%e %M %Y à %H:%i\') AS date_comment_created_the, episode_id FROM Comments WHERE report= "1"');
        $request->execute();
        return $request;
    }

    public function getCommentsP($postId, $start, $limit): ?array
	{   /*
		$request = $this->database->prepare('SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, "%d/%m/%Y %Hh%i:%ss") comment_date_fr, alert FROM comments WHERE post_id= ? ORDER BY comment_date DESC LIMIT '.$start.','.$limit);
        $request->execute(array($postId)); */
        
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();

		$request = $this->database->prepare('SELECT id, pseudo, comment, DATE_FORMAT(comment_date, \'%e %M %Y à %H:%i\') AS comment_date_fr, post_id, report FROM Comments WHERE post_id=:post_id ORDER BY comment_date DESC LIMIT '.$start.','.$limit );
        $request->execute(['post_id' => $postId]);
        return $request->fetchAll();
    }
    
    public function getPagination($postId): ?array
	{
		$request = $this->database->prepare('SELECT COUNT(*) totalc FROM Comments WHERE post_id=:post_id');
		$request->execute(['post_id' => $postId]);
        $totalComment = $request->fetch();
        return $totalComment;
	}

}
