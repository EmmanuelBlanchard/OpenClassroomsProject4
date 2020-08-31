<?php

declare(strict_types=1);

namespace App\Controller\Frontoffice;

use App\Model\CommentManager;
use App\Model\PostManager;
use App\View\View;

class CommentController
{
    private PostManager $postManager;
    private CommentManager $commentManager;
    private View $view;

    public function __construct(PostManager $postManager, CommentManager $commentManager, View $view)
    {
        $this->postManager = $postManager;
        $this->commentManager = $commentManager;
        $this->view = $view;
    }

    public function addComment(int $postId, array $data): void
    {
        if (!empty($data['author']) && !empty($data['comment'])) {
            $this->commentManager->postComment($postId, $data['comment'], $data['author']);
        } else {
            echo "Erreur : tous les champs ne sont pas remplis !<br><a href=http://localhost:8000/?action=home>Aller Ici</a>";
        }
        
        header('Location: index.php?action=detailofepisode&id='.$postId);
        exit();
    }

    public function report(int $commentId, int $postId): void
    {
        $this->commentManager->reportComment($commentId);

         header('Location: index.php?action=detailofepisode&id='.$postId);
         exit();
    }

}