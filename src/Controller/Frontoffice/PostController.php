<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\Model\CommentManager;
use App\Model\PostManager;
use App\View\View;

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

        if ($data !== null) {
            $this->view->render(['template' => 'home', 'allposts' => $data]);
        } elseif ($data === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }
    }

    public function displayListOfPosts(): void
    {
        $data = $this->postManager->showAllPosts();

        if ($data !== null) {
            $this->view->render(['template' => 'listofposts', 'allposts' => $data]);
        } elseif ($data === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }

        // Fusionner la fonction public function paginationListOfPosts(): void 
        $data = $this->postManager->showAllPosts();

        $nbPages = $this->postManager->getPostNbPages2();
        $pagination = $this->postManager->getPaginationList();

        //echo"<pre>";
        //print_r('Nombre de pages : ' .$nbPages);
        //print_r('Pagination : ' .$pagination);
        //echo"</pre>";
        //die();

    }
    
    public function displayDetailOfPost(int $postId, int $start, int $limit, int $page): void
    {
        $dataPost = $this->postManager->getPost($postId);
        $dataComments = $this->commentManager->getComments($postId, $start, $limit); 
        $previousPost = $this->postManager->previousPost($postId);
        $nextPost = $this->postManager->nextPost($postId);
        
        $totalComments = $this->commentManager->getPostNbComments($postId);
        $totalPageComments = ceil($totalComments / $limit);

        //echo"<pre>";
        //print_r($dataPost);
        //print_r($dataComments);
        //print_r($previousPost);
        //print_r($nextPost);
        //print_r($totalComments);
        //print_r($limit);
        //print_r($totalPageComments);
        //echo"</pre>";
        //die();

        $nbPosts = $this->postManager->getPostNbPosts();
        //$nbTotalPages = $this->postManager->getPostNbPages($nbPosts);
        $nbPages = $this->postManager->getPostNbPages2();
        //$pagination = $this->postManager->getPostPagination($currentPage);
        $pagination = $this->postManager->getPostPagination($postId);

        //echo"<pre>";
        //print_r('Nombre d\'episodes : ' .$nbPosts);
        //print_r('Nombre de pages : ' .$nbTotalPages);
        //print_r('Nombre de pages : ' .$nbPages);
        //print_r('Pagination : ' .$pagination);
        //echo"</pre>";
        //die();

        if ($dataPost !== null) {
            $this->view->render(['template' => 'detailofpost', 'post' => $dataPost, 'allcomment' => $dataComments, 'previouspost' => $previousPost, 'nextpost'=> $nextPost]);
        } elseif ($dataPost === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }

    }
    
}
