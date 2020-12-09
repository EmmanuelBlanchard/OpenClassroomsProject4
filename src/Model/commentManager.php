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
        
        $request = $this->database->prepare('SELECT id, pseudo, comment, DATE_FORMAT(comment_date, \'%e %M %Y à %H:%i\') AS comment_date_fr, post_id, reported, approved FROM comments WHERE post_id = :post_id ORDER BY comment_date DESC');
        $request->bindValue(':post_id', $postId, \PDO::PARAM_INT);
        $request->execute();
        $result = $request->fetchAll();
        return !$result ? null : $result;
    }
    
    public function getNbComments(): int
    {
        $request = $this->database->prepare('SELECT COUNT(*) AS nb_total_comments FROM comments');
        $request->execute();
        $result = $request->fetch();
        $nbTotalComments = (int)$result['nb_total_comments'];
        return $nbTotalComments;
    }

    public function getNbCommentsReported(): int
    {
        $request = $this->database->prepare('SELECT COUNT(*) AS nb_total_comments_reported FROM comments WHERE reported=1');
        $request->execute();
        $result = $request->fetch();
        $nbTotalCommentsReported = (int)$result['nb_total_comments_reported'];
        return $nbTotalCommentsReported;
    }

    public function getNbCommentsApproved(): ?int
    {
        $request = $this->database->prepare('SELECT COUNT(*) AS nb_total_comments_approved FROM comments WHERE approved=1');
        $request->execute();
        $result = $request->fetch();
        return $result === false ? null : (int)$result['nb_total_comments_approved'];
        //$nbTotalCommentsApproved = (int)$result['nb_total_comments_approved'];
        //return $nbTotalCommentsApproved;
    }
    public function getPostNbComments(int $postId): ?int
    {
        $request = $this->database->prepare('SELECT COUNT(*) AS nb_total_comments FROM comments WHERE post_id = :post_id');
        $request->execute(['post_id' => $postId]);
        $result = $request->fetch();
        // Ne fonctionne pas avec la ligne ci dessous
        //return $result === false ? null : (int)$result['nb_total_comments'];
        $nbTotalComments = (int)$result['nb_total_comments'];
        return $nbTotalComments;
    }

    public function showAllCommentOfPost(int $postId): ?array
    {
        $request = $this->database->prepare('SELECT id, pseudo, comment, comment_date, post_id FROM comments WHERE post_id = :post_id ORDER BY comment_date DESC');
        $request->execute(['post_id' => $postId]);
        $result = $request->fetch();
        return !$result ? null : $result;
    }

    public function postComment(int $postId, string $comment, string $pseudo): bool
    {
        $request = $this->database->prepare('INSERT INTO comments (pseudo, comment, comment_date, post_id) VALUES
        (:pseudo, :comment, NOW(), :post_id)');
        return $request->execute([
            'pseudo' => $pseudo,
            'comment' => $comment,
            'post_id' => $postId
            ]);
    }
    
    public function reportedComment(int $commentId): bool
    {
        $request = $this->database->prepare('UPDATE comments SET reported=1 WHERE id = :id');
        return $request->execute(['id' => $commentId]);
    }

    public function showAllComment(): ?array
    {
        $request = $this->database->prepare('SELECT id, pseudo, comment, comment_date, post_id, reported, approved FROM comments ORDER BY post_id, pseudo DESC');
        $request->execute();
        $result = $request->fetchAll();
        return !$result ? null : $result;
    }

    public function getListCommentsPagination($currentPage, $nbCommentsPerPage): ?array
    {
        $firstCommentPage=($currentPage-1)*$nbCommentsPerPage;
        $request = $this->database->prepare('SELECT id, pseudo, comment, comment_date, post_id, reported, approved FROM comments ORDER BY post_id, pseudo ASC LIMIT :firstCommentPage, :nbCommentsPerPage');
        $request->bindValue(':firstCommentPage', $firstCommentPage, \PDO::PARAM_INT);
        $request->bindValue(':nbCommentsPerPage', $nbCommentsPerPage, \PDO::PARAM_INT);
        $request->execute();
        $result = $request->fetchAll();
        return !$result ? null : $result;
    }

    public function showAllReportedComment(): ?array
    {
        $request = $this->database->prepare('SELECT id, pseudo, comment, comment_date, post_id FROM comments WHERE reported=1 ORDER BY post_id, pseudo DESC');
        $request->execute();
        $result = $request->fetchAll();
        return !$result ? null : $result;
    }

    public function showAllApprovedComment(): ?array
    {
        $request = $this->database->prepare('SELECT id, pseudo, comment, comment_date, post_id FROM comments WHERE approved=1 ORDER BY post_id, pseudo DESC');
        $request->execute();
        $result = $request->fetchAll();
        return !$result ? null : $result;
    }

    public function newComment(string $pseudo, string $comment, string $post_id, string $reported): void
    {
        $request = $this->database->prepare('INSERT INTO comments (pseudo, comment, post_id, reported, post_date) VALUES (:pseudo, :comment, :post_id, :reported, NOW())');
        $request->bindValue(':pseudo', $pseudo, \PDO::PARAM_STR);
        $request->bindValue(':comment', $comment, \PDO::PARAM_STR);
        $request->bindValue(':post_id', $post_id, \PDO::PARAM_INT);
        $request->bindValue(':reported', $reported, \PDO::PARAM_INT);
        $request->execute();
    }

    public function approveComment($commentId): void
    {
        $request= $this->database->prepare('UPDATE comments SET reported=0 WHERE id = :id');
        $request->bindValue(':id', $commentId, \PDO::PARAM_INT);
        $request->execute();

        $request= $this->database->prepare('UPDATE comments SET approved=1 WHERE id = :id');
        $request->bindValue(':id', $commentId, \PDO::PARAM_INT);
        $request->execute();
    }

    public function deleteComment(int $commentId): void
    {
        $request = $this->database->prepare('DELETE FROM comments WHERE id = :id');
        $request->bindValue(':id', $commentId, \PDO::PARAM_INT);
        $request->execute();
    }

    public function showOneComment(int $id): ?array
    {
        $request = $this->database->prepare('SELECT id, pseudo, comment, DATE_FORMAT(comment_date, \'%e %M %Y à %H:%i\') AS comment_date_fr, post_id, reported, approved FROM comments WHERE id = :id ORDER BY post_id, pseudo DESC');
        $request->bindValue(':id', $id, \PDO::PARAM_INT);
        $request->execute();
        $result = $request->fetch();
        return !$result ? null : $result;
    }
}
