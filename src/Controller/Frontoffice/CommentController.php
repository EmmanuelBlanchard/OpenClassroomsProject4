<?php

declare(strict_types=1);

namespace App\Controller\Frontoffice;

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

    public function __construct(PostManager $postManager, CommentManager $commentManager, View $view)
    {
        $this->postManager = $postManager;
        $this->commentManager = $commentManager;
        $this->view = $view;
    }

    public function addComment(int $postId, array $data, Token $token, Request $request): void
    {
        //var_dump($token, $request->getPostItem('csrfToken'), $_POST);
        //die();

        if (!$token->verify($request->getPostItem('csrfToken'))) {
            ////////// A FINIR

            //var_dump(!$token->verify($request->getPostItem('csrfToken')), $token->verify($request->getPostItem('csrfToken')));
            //die;
            
            //var_dump("Le token du formulaire n'est pas valide");
            //die();
        }

        //var_dump("Le token du formulaire est valide !");
        //die();
        
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

    // Essai en cas d'erreur, route vers la page d'erreur
    public function error(int $postId): void
    {
        $dataPost = $this->postManager->getPost($postId);

        if ($dataPost !== null) {
            $this->view->render(['template' => 'error', 'post' => $dataPost], 'frontoffice');
        } elseif ($dataPost === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }
    }
}
