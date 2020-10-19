<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\Model\CommentManager;
use App\Model\PostManager;
use App\View\View;

if (!isset($_SESSION)) {
    // On demarre la session
    session_start();
}

class PostController
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

    public function displayHomeWithTheLastThreePosts(): void
    {
        $data = $this->postManager->showLastThreePosts();

        $this->view->render(['template' => 'home', 'allposts' => $data], 'frontoffice');
    }

    public function displayListOfPosts(int $currentPage): void
    {
        $nbPostsPerPage = 5;
        $nbTotalPosts = $this->postManager->getNbPosts();
        $nbTotalPages = ceil($nbTotalPosts / $nbPostsPerPage);
        
        if ($currentPage>$nbTotalPages) {
            $_SESSION['erreur'] = "Cette page n'existe pas";
            $currentPage= $nbTotalPages;
            header('Location: index.php?action=listOfPosts&page=' .$currentPage . '');
            exit();
        } elseif ($currentPage<=0) {
            $currentPage=1;
        }

        $previousPage = $currentPage<=1 ? null : ($currentPage-1);
        $nextPage = $currentPage>=$nbTotalPages ? null : ($currentPage+1);

        $dataAllPostsPagination = $this->postManager->getListPostsPagination($currentPage, $nbPostsPerPage);

        $this->view->render(['template' => 'listofposts', 'allpostspagination' => $dataAllPostsPagination, 'previouspage' => $previousPage, 'nextpage'=> $nextPage], 'frontoffice');
    }
    
    public function displayDetailOfPost(int $postId): void
    {
        $dataPost = $this->postManager->getPost($postId);
        $dataComments = $this->commentManager->getComments($postId);

        $previousPost = $this->postManager->previousPost($postId);
        $nextPost = $this->postManager->nextPost($postId);

        $this->view->render(['template' => 'detailofpost', 'post' => $dataPost, 'allcomment' => $dataComments, 'previouspost' => $previousPost, 'nextpost'=> $nextPost], 'frontoffice');
    }
}
