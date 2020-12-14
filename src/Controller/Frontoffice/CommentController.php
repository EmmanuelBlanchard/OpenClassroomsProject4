<?php

declare(strict_types=1);

namespace App\Controller\Frontoffice;

use App\Controller\Error;
use App\Model\CommentManager;
use App\Model\PostManager;
use App\Service\Http\Request;
use App\Service\Http\Session;
use App\Service\Security\Token;
use App\View\View;

class CommentController
{
    private PostManager $postManager;
    private CommentManager $commentManager;
    private View $view;
    private Request $request;
    private Session $session;
    private Token $token;
    private Error $error;

    public function __construct(PostManager $postManager, CommentManager $commentManager, View $view, Session $session, Error $error)
    {
        $this->postManager = $postManager;
        $this->commentManager = $commentManager;
        $this->view = $view;
        $this->session = $session;
        $this->error = $error;
    }

    public function addComment(int $postId, array $data, Token $token, Request $request): void
    {
        if ($request->getPostItem('csrfToken') !== null) {
            if (!$token->verify($request->getPostItem('csrfToken'))) {
                $this->session->setSessionMessage('erreur', 'Votre commentaire ne peut être posté !');
                header('Location: index.php?action=detailOfPost&id='.$postId);
                exit();
            }
        }
        
        if (!empty($data['pseudo']) && !empty($data['comment'])) {
            $this->commentManager->postComment($postId, htmlspecialchars($data['comment']), htmlspecialchars($data['pseudo']));
        } else {
            header('Location: index.php?action=error&id='.$postId);
            exit();
        }
        header('Location: index.php?action=detailOfPost&id='.$postId);
        exit();
    }
    
    public function reported(int $commentId, int $postId): void
    {
        $this->commentManager->reportedComment($commentId);

        header('Location: index.php?action=detailOfPost&commentid=' .$commentId . '&id=' .$postId);
        exit();
    }

    public function error(int $postId): void
    {
        $dataPost = $this->postManager->getPost($postId);

        if ($dataPost !== null) {
            // http://localhost:8000/index.php?action=error&id=21
            $this->error->display('Erreur', 'Il n\' y a pas de post n°' . $postId . '', 'frontoffice');
        } elseif ($dataPost === null) {
            $this->error->display('Erreur', 'Il n\'y pas de post !', 'frontoffice');
        }
    }
}
