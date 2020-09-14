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
        // Si la page actuelle est à 8 donc superieur à 7 alors $currentPage à 1, mettre $this->get['page']=1;
        if($currentPage > $nbTotalPages) {
            $currentPage = 1;
        } elseif ($currentPage === 0) {
            $currentPage = (int)$nbTotalPages;
        }

        $previousPage = $this->postManager->previousPage($currentPage);
        $nextPage = $this->postManager->nextPage($currentPage);
        
        //echo"<pre>";
        //print_r('PageCourante : ' .$currentPage);
        //print_r(' Numero page Précédente : ' .$previousPage);
        //print_r(' Numero page Suivante : ' .$nextPage);
        //echo"</pre>";
        //die();
        
        $dataAllPostsPagination = $this->postManager->getListPostsPagination($currentPage, $nbPostsPerPage);

        //echo"<pre>";
        //print_r('PageCourante : ' .$currentPage);
        //print_r(' Nombre total de posts : ' .$nbTotalPosts);
        //print_r(' Nombre de posts par page : ' .$nbPostsPerPage);
        //print_r(' Nombre de pages : ' .$nbTotalPages);
        //print_r(' Pagination : ' .$dataAllPostsPagination); // Array to string conversion
        //print_r('Numero page Précédente : ' .$previousPage);
        //print_r(' Numero page Suivante : ' .$nextPage);
        // http://localhost:8000/index.php?action=listOfPosts&page=2
        // Display => Numero page Précédente : 1 Numero page Suivante : 3
        //echo"</pre>";
        //die();

        if ($dataAllPostsPagination !== null) {
            $this->view->render(['template' => 'listofposts', 'allpostspagination' => $dataAllPostsPagination, 'previouspage' => $previousPage, 'nextpage'=> $nextPage]);
        } elseif ($dataAllPostsPagination === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }

    }
    
    public function displayDetailOfPost(int $postId, int $page): void
    {
        $limit = 5;
        $start = ($page-1)*$limit;

        $dataPost = $this->postManager->getPost($postId);
        $dataComments = $this->commentManager->getComments($postId, $start, $limit); 
        $previousPost = $this->postManager->previousPost($postId);
        $nextPost = $this->postManager->nextPost($postId);
        
        $totalComments = $this->commentManager->getPostNbComments($postId);
        $totalPageComments = ceil($totalComments / $limit);

        $nbTotalPosts = $this->postManager->getPostNbPosts();
        $nbPostsPerPage = 5;
        $nbTotalPages = $this->postManager->getPostNbPages($nbTotalPosts, $nbPostsPerPage);
        
        $dataPostPagination = $this->postManager->getDetailPostPagination($postId, $nbPostsPerPage);

        //echo"<pre>";
        //print_r($dataPost);
        //print_r($dataComments);
        //print_r($previousPost);
        //print_r($nextPost);
        //print_r($totalComments);
        //print_r($limit);
        //print_r($totalPageComments);
        //print_r('Nombre d\'episodes : ' .$nbTotalPosts);
        //print_r('Nombre de pages : ' .$nbTotalPages);

        //print_r('Pagination : ' .$detailPostPagination);
        //echo"</pre>";
        //die();

        if ($dataPost !== null) {
            $this->view->render(['template' => 'detailofpost', 'post' => $dataPost, 'datapostpagination' => $dataPostPagination, 'allcomment' => $dataComments, 'previouspost' => $previousPost, 'nextpost'=> $nextPost]);
        } elseif ($dataPost === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }

    }
    
}
