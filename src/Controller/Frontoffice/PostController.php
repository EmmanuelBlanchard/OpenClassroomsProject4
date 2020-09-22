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
        $nbPostsPerPage = 5;
        $nbTotalPosts = $this->postManager->getNbPosts();
        $nbTotalPages = ceil($nbTotalPosts / $nbPostsPerPage);
        
        if($currentPage>$nbTotalPages) {
            $currentPage=$nbTotalPages;
        } elseif ($currentPage<=0) {
            $currentPage=1;
        }

        $previousPage = $currentPage<=1 ? null : ($currentPage-1);
        $nextPage = $currentPage>=$nbTotalPages ? null : ($currentPage+1);

        $dataAllPostsPagination = $this->postManager->getListPostsPagination($currentPage, $nbPostsPerPage);

        if ($dataAllPostsPagination !== null) {
            $this->view->render(['template' => 'listofposts', 'allpostspagination' => $dataAllPostsPagination, 'previouspage' => $previousPage, 'nextpage'=> $nextPage]);
        } elseif ($dataAllPostsPagination === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }

    }
    
    public function displayDetailOfPost(int $postId): void
    {
        $dataPost = $this->postManager->getPost($postId);
        $dataComments = $this->commentManager->getComments($postId);

        $previousPost = $this->postManager->previousPost($postId);
        $nextPost = $this->postManager->nextPost($postId);

        if ($dataPost !== null) {
            $this->view->render(['template' => 'detailofpost', 'post' => $dataPost, 'allcomment' => $dataComments, 'previouspost' => $previousPost, 'nextpost'=> $nextPost]);
        } elseif ($dataPost === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }

    }

    public function displayLogin(): void
    {
        $this->view->render(['template' => 'adminloginpage',]);
    }

    public function displayLoginAdmin(array $data): void
    {
        if (!empty($data['pseudo']) && !empty($data['password']) && $data['pseudo'] == "JeanForteroche" && $data['password'] == "motdepasse" ) {
            $this->postManager->postLogin(htmlspecialchars($data['pseudo']), htmlspecialchars($data['password']));
            
            // Creation du champ password_hash dans la DB ?
            // https://www.php.net/manual/fr/faq.passwords.php
            // https://www.php.net/manual/fr/function.password-hash.php
            // https://www.php.net/manual/fr/function.password-verify.php
            // https://www.php.net/manual/fr/book.password.php
            
            // Verification de la valeur pseudo et du password
            // Hachage et salage du mot de passe puis comparaison
            // password_hash ( string $password , int $algo [, array $options ] ) : string

        } else {
            header('Location: index.php?action=error');
            exit();
        }
        // Redirection vers page d'administration
        header('Location: index.php?action=blogControlPanel'); 
        exit();
    }

    public function displayAdmin(): void
    {
        $this->view->render(['template' => 'blogcontrolpanelpage']);
    }
    
    public function displayAdminSetNewPassword(): void
    {
        $this->view->render(['template' => 'adminsetnewpassword']);
    }

}
