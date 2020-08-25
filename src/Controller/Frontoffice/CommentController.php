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

    public function addComment(int $id, string $comment, string $author): void
    {
        $this->postManager->findId($id);
        $this->commentManager->postComment($id, $comment, $author);

        // Redirection du visiteur vers la page du detailofepisode avec l'identifiant de l'episode où le commentaire est publié
        header('Location: index.php?action=detailofepisode&id='.$id);
    }

}