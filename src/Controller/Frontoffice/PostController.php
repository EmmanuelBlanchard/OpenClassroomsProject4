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
        // Utiliser $req->bindValue(':limitation', $nbByPage, \PDO::PARAM_INT); pour le limit du sql
        // Revoir l'algo sur le calcul des pages
        $nbPostsPerPage = 5;
        $nbTotalPosts = $this->postManager->getNbPosts();
        $nbTotalPages = $this->postManager->getNbPages($nbTotalPosts, $nbPostsPerPage);
        //var_dump("Page actuelle : " .$currentPage);
        //var_dump("Nombre total de pages : " .$nbTotalPages);
        if($currentPage>$nbTotalPages) {
            $currentPage=$nbTotalPages;
            
            //echo"<pre>";
            //print_r('Page actuelle (Dans le if currentPage> nbTotalPages) : ' .$currentPage);
            //echo"</pre>";
            //die();
            
            //header('Location: index.php?action=listOfPosts&id='.$currentPage);
            //exit;
        }

        $dataAllPostsPagination = $this->postManager->getListPostsPagination($currentPage, $nbPostsPerPage);
        $previousPage = $this->postManager->previousPage($currentPage);
        $nextPage = $this->postManager->nextPage($currentPage);
        //echo"<pre>";
        //print_r(' Nombre de pages : ' .$nbTotalPages);
        //print_r(' Pagination : ' .$dataAllPostsPagination); // Array to string conversion
        //print_r('Numero page Précédente : ' .$previousPage);
        //print_r(' Numero page Suivante : ' .$nextPage);
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
        $limit = 5;
        $start = ($page-1)*$limit;

        $dataPost = $this->postManager->getPost($postId);
        $dataComments = $this->commentManager->getComments($postId, $start, $limit);

        $previousPost = $this->postManager->previousPost($postId);
        $nextPost = $this->postManager->nextPost($postId);

        //$totalComments = $this->commentManager->getPostNbComments($postId);
        //$totalPageComments = ceil($totalComments / $limit);

        $nbTotalPosts = $this->postManager->getNbPosts();
        $nbPostsPerPage = 5;
        $nbTotalPages = $this->postManager->getNbPages($nbTotalPosts, $nbPostsPerPage);
        
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

    public function displayLogin(): void
    {
        //var_dump("Accès à la page de connexion");
        $this->view->render(['template' => 'adminloginpage',]);
    }

    public function displayLoginAdmin(array $data): void
    {
        if (!empty($data['pseudo']) && !empty($data['password']) && $data['pseudo'] == "JeanForteroche" && $data['password'] == "motdepasse" ) {
            $this->postManager->postLogin(htmlspecialchars($data['pseudo']), htmlspecialchars($data['password']));
            // Verification valeur pseudo et password
        } else {
            header('Location: index.php?action=error');
            exit();
        }
        // Redirection vers page d'administration à creer | pour l instant vers la page home
        //header('Location: index.php?action=home');
        header('Location: index.php?action=blogControlPanel'); 
        exit();
    }

    public function displayAdmin(): void
    {
        var_dump("Bienvenue à la page d'administration du blog ! ");
        $this->view->render(['template' => 'blogcontrolpanelpage',]);

    }
    
}
