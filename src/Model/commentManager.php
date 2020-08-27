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
        
        $request = $this->database->prepare('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%e %M %Y à %H:%i\') AS comment_date_fr, episode_id, report FROM Comments WHERE episode_id=:episode_id ORDER BY comment_date DESC');
        $request->execute(['episode_id' => $postId]);
        return $request->fetchAll();
    }

    public function showAllComment(int $postId): ?array
    {
        $request = $this->database->prepare('SELECT id, author, comment, comment_date, episode_id FROM Comments WHERE episode_id=:episode_id ORDER BY comment_date DESC');
        $request->execute(['episode_id' => $postId]);
        return $request->fetch();
    }

    public function postComment(int $postId, string $comment, string $author): bool
    {
        $request = $this->database->prepare('INSERT INTO Comments (author, comment, comment_date, episode_id) VALUES
        (:author, :comment, NOW(), :episode_id)');
        return $request->execute([
            'author' => $author,
            'comment' => $comment,
            'episode_id' => $postId
            ]);
    }
    
    public function updateComment(int $commentId)
    {
        $request = $this->database->prepare('UPDATE Comments SET comment= "Ce message a été supprimé par l\'administrateur", report= "2" WHERE id=:id');
        $request->execute(['id' => $commentId]);
        return $request;
    }

    public function validateComment(int $commentId)
    {
        $request= $this->database->prepare('UPDATE Comments SET report= "2" WHERE id=:id');
        $request->execute(['id'=> $commentId]);
        return $request;
    }

    public function reportComment(int $commentId)
    {
        $request = $this->database->prepare('UPDATE Comments SET report= "1" WHERE id=:id AND report= "0"');
        $request->execute(['id' => $commentId]);
        return $request;

    }

    /*
    <?php
    
    while ($comment = $getcomment->fetch())
    {
        if ($comment['alert'] == 1)
        {
            ?>
            <section id="backcomments">
                <aside id="separatecomments">
                    <p><strong class="brown"><?= htmlspecialchars($comment['author']) ?></strong><em class="date"> - le <?= htmlspecialchars($comment['comment_date_fr']) ?><a class="brown" id="alert" href="index.php?action=alertc&amp;commentid=<?= htmlspecialchars($comment['id'])?>&amp;id=<?= htmlspecialchars($post['id'])?>"> - <span class="red">Commentaire signalé</span></a></em></p>
                    <p><?= nl2br($comment['comment'])?></p>
                </aside>
            </section>
            <?php
        }

        elseif ($comment['alert'] == 2)
        {
            ?>
            <section id="backcomments">
                <aside id="separatecomments">
                    <p><strong class="brown"><?= htmlspecialchars($comment['author']) ?></strong><em class="date"> - le <?= htmlspecialchars($comment['comment_date_fr']) ?> - <span class="brown">Commentaire modéré par l'auteur</span></em></p>
                    <p><?= nl2br($comment['comment'])?></p>
                </aside>
            </section>
            <?php
        }

        else
        {
            ?>
            <section id="backcomments">
                <aside id="separatecomments">
                    <p><strong class="brown"><?= htmlspecialchars($comment['author']) ?></strong><em class="date"> - le <?= htmlspecialchars($comment['comment_date_fr']) ?><a class="brown" id="alert" href="index.php?action=alertc&amp;commentid=<?= htmlspecialchars($comment['id'])?>&amp;id=<?= htmlspecialchars($post['id'])?>"> - Signaler le commentaire</a></em></p>
                    <p><?= nl2br($comment['comment'])?></p>
                </aside>
            </section>
            <?php
        }
    }
    $getcomment->closeCursor();
    ?>
    */

    public function reportList()
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();
        
        $request = $this->database->prepare('SELECT id, author, comment, DATE_FORMAT(comment_created_the, \'%e %M %Y à %H:%i\') AS date_comment_created_the, episode_id FROM Comments WHERE report= "1"');
        $request->execute();
        return $request;
    }


}
