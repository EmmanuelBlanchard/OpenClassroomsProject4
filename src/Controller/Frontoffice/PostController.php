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
    }
    
    public function displayDetailOfPost(int $postId): void
    {
        $data_post = $this->postManager->getPost($postId);
        $data_comments = $this->commentManager->getComments($postId);

        //echo"<pre>";
        //print_r($data_post);
        //print_r($data_comments);
        //echo"</pre>";
        //die();

        if ($data_post !== null) {
            $this->view->render(['template' => 'detailofpost', 'post' => $data_post, 'allcomment' => $data_comments]);
        } elseif ($data_post === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }
    }
    
    public function Post(int $postId, int $start, int $limit, int $page) //getcomment for one post
	{
        $post = $this->postManager->getPost2($postId);
		$getcomment = $this->commentManager->getCommentsP($postId, $start, $limit); 
		$totalcomments = $this->commentManager->getPagination($postId);
		$total = $totalcomments['totalc']; //Pagination
        $totalpagecomments = ceil($total / $limit); //Pagination
        
        $page = 5;
        //echo"<pre>";
        //print_r($page);
        //print_r($post);
        //print_r($getcomment);
        //print_r($totalcomments);
        //print_r($total);
        //print_r($limit);
        //print_r($totalpagecomments);
        //echo"</pre>";
        //die();

        if ($post !== null) {
            $this->view->render(['template' => 'detailofpostandpagination', 'post' => $post, 'allcomment' => $getcomment, 'totalcomment' => $totalcomments, 'total' => $total, 'totalpagecomments' => $totalpagecomments, 'page' => $page]);
        } elseif ($post === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }

	}

    public function paginationDetailOfPost(int $postId): void
    {
        $data_post = $this->postManager->getPost($postId);
        $data_comments = $this->commentManager->getComments($postId);

        $infosPosts = $this->postManager->getInfosEpisodes();
        $nbPosts = $this->postManager->getPostNbPosts();
        //$nbTotalPages = $this->postManager->getPostNbPages($nbPosts);
        $nbPages = $this->postManager->getPostNbPages2();
        //$pagination = $this->postManager->getPostPagination($currentPage);
        $pagination = $this->postManager->getPostPagination($postId);

        //echo"<pre>";
        //print_r($infosEpisodes);
        //print_r('Nombre d\'episodes : ' .$nbPosts);
        //print_r('Nombre de pages : ' .$nbTotalPages);
        //print_r('Nombre de pages : ' .$nbPages);
        //print_r('Pagination : ' .$pagination);
        //echo"</pre>";
        //die();

        if ($infosPosts !== null) {
            $this->view->render(['template' => 'detailofpostandpagination', 'post' => $data_post, 'allcomment' => $data_comments, 'nbPosts' => $nbPosts, 'nbPages' => $nbPages, 'pagination' => $pagination]);
        } elseif ($infosPosts === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }

    }

    public function paginationListeofPosts(): void
    {
        $data = $this->postManager->showAllPosts();

        if ($data !== null) {
            $this->view->render(['template' => 'listofposts', 'allposts' => $data]);
        } elseif ($data === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }

        $nbPages = $this->postManager->getPostNbPages2();
        $pagination = $this->postManager->getPaginationList();

        //echo"<pre>";
        //print_r('Nombre de pages : ' .$nbTotalPages);
        //print_r('Nombre de pages : ' .$nbPages);
        //print_r('Pagination : ' .$pagination);
        //echo"</pre>";
        //die();

        if ($data !== null) {
            $this->view->render(['template' => 'listofpostsandpagination', 'allposts' => $data, 'nbPages' => $nbPages, 'pagination' => $pagination]);
        } elseif ($data === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }

    }


}
