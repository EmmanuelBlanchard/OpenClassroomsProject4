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

    public function displayListOfPosts($currentPage): void
    {
        $nbTotalPosts = $this->postManager->getPostNbPosts();
        $nbPostsPerPage = 5;
        $nbTotalPages = $this->postManager->getPostNbPages($nbTotalPosts, $nbPostsPerPage);
        /*
        if($currentPage > $nbTotalPages) {
            $currentPage = 1;
            header('Location: index.php?action=listOfPosts&id='.$currentPage);
        }
        */
        if($currentPage === $nbTotalPages) {
            $currentPage = 1;
            header('Location: index.php?action=listOfPosts&id='.$currentPage);
        }
        
        $previousPage = $this->postManager->previousPage($currentPage);
        $nextPage = $this->postManager->nextPage($currentPage);
        
        $dataAllPostsPagination = $this->postManager->getListPostsPagination($currentPage, $nbPostsPerPage);

        //echo"<pre>";
        //print_r(' Nombre de pages : ' .$nbTotalPages);
        //print_r(' Pagination : ' .$dataAllPostsPagination); // Array to string conversion
        //print_r('Numero page Précédente : ' .$previousPage);
        //print_r(' Numero page Suivante : ' .$nextPage);
        // http://localhost:8000/index.php?action=listOfPosts&page=2
        // Display => Numero page Précédente : 1 Numero page Suivante : 3
        //echo"</pre>";
        //die();

        //var_dump($dataAllPostsPagination);
        //var_dump($previousPage,$nextPage);

        if ($dataAllPostsPagination !== null) {
            $this->view->render(['template' => 'listofposts', 'allpostspagination' => $dataAllPostsPagination, 'previouspage' => $previousPage, 'nextpage'=> $nextPage]);
        } elseif ($dataAllPostsPagination === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }

    }
    
    public function displayDetailOfPost(int $postId, int $page): void
    {
        // Utiliser $req->bindValue(':limitation', $nbByPage, \PDO::PARAM_INT); pour le limit du sql
        // Revoir l'algo sur le calcul des pages
        $limit = 5;
        $start = ($page-1)*$limit;

        $dataPost = $this->postManager->getPost($postId);
        $dataComments = $this->commentManager->getComments($postId, $start, $limit);

        $previousPost = $this->postManager->previousPost($postId);
        $nextPost = $this->postManager->nextPost($postId);

        //$totalComments = $this->commentManager->getPostNbComments($postId);
        //$totalPageComments = ceil($totalComments / $limit);

        $nbTotalPosts = $this->postManager->getPostNbPosts();
        $nbPostsPerPage = 5;
        $nbTotalPages = $this->postManager->getPostNbPages($nbTotalPosts, $nbPostsPerPage);
        
        $dataPostPagination = $this->postManager->getDetailPostPagination($postId, $nbPostsPerPage);

        //echo"<pre>";
        //print_r('Nombre de pages : ' .$nbTotalPages);
        //echo"</pre>";
        //die();
        
        //var_dump($dataPostPagination);
        //var_dump($previousPost,$nextPost);

        if ($dataPost !== null) {
            $this->view->render(['template' => 'detailofpost', 'post' => $dataPost, 'datapostpagination' => $dataPostPagination, 'allcomment' => $dataComments, 'previouspost' => $previousPost, 'nextpost'=> $nextPost]);
        } elseif ($dataPost === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }

    }
    
}
