<?php

declare(strict_types=1);

namespace App\Controller\Backoffice;

use App\Model\AdminManager;
use App\Model\CommentManager;
use App\Model\PostManager;
use App\View\View;

if (!isset($_SESSION)) {
    // On demarre la session
    session_start();
}

class AdminController
{
    private AdminManager $adminManager;
    private PostManager $postManager;
    private CommentManager $commentManager;
    private View $view;

    public function __construct(AdminManager $adminManager, PostManager $postManager, CommentManager $commentManager, View $view)
    {
        $this->adminManager = $adminManager;
        $this->postManager = $postManager;
        $this->commentManager = $commentManager;
        $this->view = $view;
    }

    public function login(array $data): void
    {
        //var_dump($_POST);
        if (!empty($data['pseudo']) && !empty($data['password']) && $data['pseudo'] === "JeanForteroche" && $data['password'] === "motdepasse") {
            header('Location: index.php?action=blogControlPanel');
            exit();
        }
        $this->view->render(['template' => 'adminloginpage'], 'backoffice');
    }
    
    public function logout(): void
    {
        // Ajouter deconnexion données de session

        $this->view->render(['template' => 'adminloginpage'], 'backoffice');
    }

    public function blogControlPanel(): void
    {
        $this->view->render(['template' => 'blogcontrolpanelpage'], 'backoffice');
    }
    
    public function myProfile(): void
    {
        $this->view->render(['template' => 'myprofile'], 'backoffice');
    }

    public function readEpisodes(): void
    {   // Affichage Liste des épisodes par id DESC => 3,2,1
        $data = $this->postManager->showAllPostsByIdDesc();
        // Affichage Liste des épisodes par id ASC => 1,2,3
        //$data = $this->adminManager->showAllPostsById();
        // Affichage Liste des épisodes par post_date
        //$data = $this->adminManager->showAllPost();
        $this->view->render(['template' => 'readepisodes', 'allpost' => $data], 'backoffice');
    }
    // Reflexion suppresion de l'input date
    // puisqu'il y a un probleme d'insertion dans la base de données
    // recupere type date or insertion dans la base de donnees => format datetime
    // provisoire, suppression de l input type="date" et mettre NOW() ? dans VALUES ?
    public function detailEpisode(int $postId): void
    {
        if (isset($postId) && !empty($postId)) {
            $dataPost = $this->postManager->showOnePost($postId);
            // On verifie si le post existe
            if (!$dataPost) {
                $_SESSION['erreur'] = "Cet id n'existe pas";
                header('Location: index.php?action=readEpisodes');
                exit();
            }
            $this->view->render(['template' => 'detailepisode', 'post' => $dataPost], 'backoffice');
        } else {
            $_SESSION['erreur'] = "URL invalide";
            header('Location: index.php?action=readEpisodes');
            exit();
        }
    }

    public function addEpisode(array $data): void
    {
        if ($data) {
            if (isset($data['chapter']) && !empty($data['chapter'])
             && isset($data['title']) && !empty($data['title'])
             && isset($data['introduction']) && !empty($data['introduction'])
             && isset($data['content']) && !empty($data['content'])
             && isset($data['author']) && !empty($data['author'])) {
                // On nettoie les données envoyées
                $chapter = strip_tags($data['chapter']);
                $title = strip_tags($data['title']);
                $introduction = strip_tags($data['introduction']);
                $content = strip_tags($data['content']);
                $author = strip_tags($data['author']);
                $this->postManager->newPost($chapter, $title, $introduction, $content, $author);
                $_SESSION['message'] = "Épisode ajouté";
                header('Location: index.php?action=readEpisodes');
                exit();
            }
            $_SESSION['erreur'] = "Le formulaire est incomplet";
            $this->view->render(['template' => 'addepisode'], 'backoffice');
        }
        $this->view->render(['template' => 'addepisode'], 'backoffice');
    }

    public function editEpisode(int $postId, array $data): void
    {
        if (isset($postId) && !empty($postId)) {
            // On nettoie l'id envoyé
            //$id = strip_tags($_GET['id']);
            $dataPost = $this->postManager->showOnePost($postId);
            // On verifie si le post existe
            if (!$dataPost) {
                $_SESSION['erreur'] = "Cet id n'existe pas";
                header('Location: index.php?action=readEpisodes');
                exit();
            }
            $this->view->render(['template' => 'editepisode', 'post' => $dataPost], 'backoffice');
        } else {
            $_SESSION['erreur'] = "URL invalide";
            header('Location: index.php?action=readEpisodes');
            exit();
        }

        if ($data) {
            if (isset($data['id']) && !empty($data['id'])
             && isset($data['chapter']) && !empty($data['chapter'])
             && isset($data['title']) && !empty($data['title'])
             && isset($data['introduction']) && !empty($data['introduction'])
             && isset($data['content']) && !empty($data['content'])
             && isset($data['author']) && !empty($data['author'])) {
                // On nettoie les données envoyées
                $id = strip_tags($data['id']);
                $chapter = strip_tags($data['chapter']);
                $title = strip_tags($data['title']);
                $introduction = strip_tags($data['introduction']);
                $content = strip_tags($data['content']);
                $author = strip_tags($data['author']);
                $this->postManager->editPost($id, $chapter, $title, $introduction, $content, $author);
                $_SESSION['message'] = "Épisode modifié";
                // Cannot modify header information - headers already sent by
                //header('Location: index.php?action=readEpisodes');
                //exit();
            }
            $_SESSION['erreur'] = "Le formulaire est incomplet";
            $this->view->render(['template' => 'editepisode'], 'backoffice');
        }
        $this->view->render(['template' => 'editepisode'], 'backoffice');
    }

    public function deleteEpisode(int $postId): void
    {
        if (isset($postId) && !empty($postId)) {
            $dataPost = $this->postManager->showOnePost($postId);
            // On verifie si le post existe
            if (!$dataPost) {
                $_SESSION['erreur'] = "Cet id n'existe pas";
                header('Location: index.php?action=readEpisodes');
                exit();
            }
            $this->postManager->deletePost($postId);
            $_SESSION['message'] = "Épisode supprimé";
            header('Location: index.php?action=readEpisodes');
            exit();
        }
        $_SESSION['erreur'] = "URL invalide";
        header('Location: index.php?action=readEpisodes');
        exit();
    }

    public function readComments(): void
    {
        $dataComments = $this->commentManager->showAllComment();
        $this->view->render(['template' => 'readcomments', 'allcomment' => $dataComments], 'backoffice');
    }
    
    public function reportedComments(): void
    {
        //echo '<pre>';
        //var_dump($report);
        //die();
        //echo '</pre>';
        // int(1)
        $dataReportedComments = $this->commentManager->showAllReportedComment();
        
        //echo '<pre>';
        //var_dump($dataReportedComments);
        //die();
        //echo '</pre>';
        $this->view->render(['template' => 'reportedcomments', 'allreportedcomment' => $dataReportedComments], 'backoffice');
    }

    public function approvedComments(): void
    {
        $dataApprovedComments = $this->commentManager->showAllApprovedComment();
        $this->view->render(['template' => 'approvedcomments', 'allapprovedcomment' => $dataApprovedComments], 'backoffice');
    }

    // A RESOUDRE, marque que le formulaire est incomplet malgré le remplissage de tous les champs
    public function addComment(array $data): void
    {
        if ($data) {
            if (isset($data['pseudo']) && !empty($data['pseudo'])
             && isset($data['comment']) && !empty($data['comment'])
             && isset($data['post_id']) && !empty($data['post_id'])
             && isset($data['reported']) && !empty($data['reported'])) {
                // On nettoie les données envoyées
                $pseudo = strip_tags($data['pseudo']);
                $comment = strip_tags($data['comment']);
                $post_id = strip_tags($data['post_id']);
                $reported = strip_tags($data['reported']);
                $this->commentManager->newComment($pseudo, $comment, $post_id, $reported);
                $_SESSION['message'] = "Commentaire ajouté";
                header('Location: index.php?action=readComments');
                exit();
            }
            $_SESSION['erreur'] = "Le formulaire est incomplet";
            $this->view->render(['template' => 'addcomment'], 'backoffice');
        }
        $this->view->render(['template' => 'addcomment'], 'backoffice');
    }

    public function approveComment($commentId): void
    {
        if (isset($commentId) && !empty($commentId)) {
            $dataComment = $this->commentManager->showOneComment($commentId);
            // On verifie si le commentaire existe
            if (!$dataComment) {
                $_SESSION['erreur'] = "Cet id n'existe pas";
                header('Location: index.php?action=readComments');
                exit();
            }
            $this->commentManager->approveComment($commentId);
            $_SESSION['message'] = "Commentaire approuvé";
            header('Location: index.php?action=readComments');
            exit();
        }
        $_SESSION['erreur'] = "URL invalide";
        header('Location: index.php?action=readComments');
        exit();
    }

    public function deleteComment(int $commentId): void
    {
        if (isset($commentId) && !empty($commentId)) {
            $dataComment = $this->commentManager->showOneComment($commentId);
            // On verifie si le commentaire existe
            if (!$dataComment) {
                $_SESSION['erreur'] = "Cet id n'existe pas";
                header('Location: index.php?action=readComments');
                exit();
            }
            $dataComment = $this->commentManager->deleteComment($commentId);
            $_SESSION['message'] = "Commentaire supprimé";
            header('Location: index.php?action=readComments');
            exit();
        }
        $_SESSION['erreur'] = "URL invalide";
        header('Location: index.php?action=readComments');
        exit();
    }
}
