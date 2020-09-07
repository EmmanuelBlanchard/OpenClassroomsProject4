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
            $this->commentManager->postComment($postId, htmlspecialchars($data['comment']), htmlspecialchars($data['author']));
        } else {
            header('Location: index.php?action=error&id='.$postId);
            exit();
        }
        
        header('Location: index.php?action=detailofpost&id='.$postId);
        exit();
    }

    public function report(int $commentId, int $postId): void
    {
        $this->commentManager->reportComment($commentId);

        header('Location: index.php?action=detailofpost&commentid=' .$commentId . '&id=' .$postId);
        exit();
    }

    // Essai en cas d'erreur, route vers la page d'erreur
    public function Error(int $postId): void
    {
        $data_post = $this->postManager->getPost($postId);
        $data_comments = $this->commentManager->getComments($postId);

        if ($data_post !== null) {
            $this->view->render(['template' => 'error', 'post' => $data_post, 'allcomment' => $data_comments]);
        } elseif ($data_post === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }

    }
}