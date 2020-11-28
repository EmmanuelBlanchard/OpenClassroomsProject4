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
        //var_dump($token, $request->getPostItem('csrfToken'), $_POST);
        //die();
        if (!$token->verify($request->getPostItem('csrfToken'))) {
            ////////// A FINIR
            $this->session->setSession('erreur', 'Le token du formulaire n\'est pas valide !');
            // Suppression du token puis renouveller un autre token pour une nouvelle validation
            $this->session->removeSession('csrfToken');
            header('Location: index.php?action=detailOfPost&id='.$postId);
            exit();
        } elseif ($token->verify($request->getPostItem('csrfToken'))) {
            $this->session->setSession('message', 'Le token du formulaire est valide !');
                
            if (!empty($data['pseudo']) && !empty($data['comment'])) {
                $this->commentManager->postComment($postId, htmlspecialchars($data['comment']), htmlspecialchars($data['pseudo']));
            } else {
                header('Location: index.php?action=error&id='.$postId);
                exit();
            }
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

    // Essai en cas d'erreur, route vers la page d'erreur
    public function error(int $postId): void
    {
        $dataPost = $this->postManager->getPost($postId);

        if ($dataPost !== null) {
            // http://localhost:8000/index.php?action=error&id=21
            $this->error->display('Erreur', 'Il n\' y a pas de post n°' . $postId . '', 'frontoffice');
        // Avant
            //$this->view->render(['template' => 'error', 'post' => $dataPost], 'frontoffice');
        } elseif ($dataPost === null) {
            //echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
            // Essai sans le echo
            $this->error->display('Erreur', 'Il n\'y pas de post !', 'frontoffice');
        }
    }
}
