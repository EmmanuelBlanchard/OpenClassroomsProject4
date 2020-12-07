<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\Controller\Error;
use App\Model\CommentManager;
use App\Model\PostManager;
use App\Service\Http\Session;
use App\Service\Security\Token;
use App\View\View;

class PostController
{
    private PostManager $postManager;
    private CommentManager $commentManager;
    private View $view;
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

    public function displayHomeWithTheLastThreePosts(): void
    {
        $data = $this->postManager->showLastThreePosts();

        $this->view->render(['template' => 'home', 'allposts' => $data], 'frontoffice');
    }

    public function displayListOfPosts(int $currentPage, Session $session): void
    {
        $nbPostsPerPage = 5;
        $nbTotalPosts = $this->postManager->getNbPosts();
        $nbTotalPages = ceil($nbTotalPosts / $nbPostsPerPage);
        
        if ($currentPage>$nbTotalPages) {
            $this->session->setSessionMessage('erreur', 'La page demandée n\'existe pas ! Voici la dernière page du blog.');
            $currentPage= $nbTotalPages;
            header('Location: index.php?action=listOfPosts&page=' . $currentPage . '');
            exit();
        } elseif ($currentPage<=0) {
            $this->session->setSessionMessage('erreur', 'La page demandée n\'existe pas ! Voici la première page du blog.');
            $currentPage=1;
            header('Location: index.php?action=listOfPosts&page=' . $currentPage . '');
            exit();
        }

        $previousPage = $currentPage<=1 ? null : ($currentPage-1);
        $nextPage = $currentPage>=$nbTotalPages ? null : ($currentPage+1);

        $dataAllPostsPagination = $this->postManager->getListPostsPagination($currentPage, $nbPostsPerPage);

        $this->view->render(['template' => 'listofposts', 'allpostspagination' => $dataAllPostsPagination, 'previouspage' => $previousPage, 'nextpage'=> $nextPage, 'sessionmessage' => $session->getSessionMessage('message'), 'sessionerreur' => $session->getSessionMessage('erreur')], 'frontoffice');
    }
    
    public function displayDetailOfPost(int $postId, Token $token, Session $session): void
    {
        $dataPost = $this->postManager->getPost($postId);
        $dataComments = $this->commentManager->getComments($postId);

        $previousPost = $this->postManager->previousPost($postId);
        $nextPost = $this->postManager->nextPost($postId);

        $this->view->render(['template' => 'detailofpost', 'post' => $dataPost, 'allcomment' => $dataComments, 'previouspost' => $previousPost, 'nextpost'=> $nextPost, 'csrfToken' => $token->generate(), 'sessionmessage' => $session->getSessionMessage('message'), 'sessionerreur' => $session->getSessionMessage('erreur')], 'frontoffice');
    }
}
