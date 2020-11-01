<?php

declare(strict_types=1);

namespace App\Controller\Backoffice;

use App\Model\AdminManager;
use App\Model\CommentManager;
use App\Model\PostManager;
use App\Model\UserManager;
use App\View\View;

/*
if (!isset($_SESSION)) {
    // On demarre la session
    session_start();
}
*/
class AdminController
{
    private AdminManager $adminManager;
    private UserManager $userManager;
    private PostManager $postManager;
    private CommentManager $commentManager;
    private View $view;

    public function __construct(AdminManager $adminManager, UserManager $userManager, PostManager $postManager, CommentManager $commentManager, View $view)
    {
        $this->adminManager = $adminManager;
        $this->userManager = $userManager;
        $this->postManager = $postManager;
        $this->commentManager = $commentManager;
        $this->view = $view;
    }

    public function login(array $data): void
    {
        //var_dump($data);
        //echo '<pre>';
        //var_dump($_SESSION);
        //die();
        //echo '</pre>';
        if (!empty($data['pseudo']) && !empty($data['password'])) {
            // Quand on est connecté ne pas mettre "connexion"
            $pseudo= $data['pseudo'];
            $password = $data['password'];
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            //echo '<pre>';
            //var_dump($password);
            //var_dump($hashed_password);
            //die();
            //echo '</pre>';
            
            //Récupération de l'id et de son mot de passe hashé
            $result = $this->userManager->recoveryIdAndHashedPassword($data['pseudo']);

            $resultHashPassword = $this->userManager->recoveryHashedPassword($data['pseudo']);
            //echo '<pre>';
            //var_dump($result);
            //die();
            //echo '</pre>';

            // Probleme
            /*
            Whoops \ Exception \ ErrorException (E_NOTICE)
            Trying to access array offset on value of type bool
            */
            // Comparaison du mot de passe envoyé via le formulaire avec celui de la base de donnees
            //$isPasswordValid = password_verify($password, $result['hashed_password']);
            
            //$isPasswordValid = password_verify($password, $resultHashPassword[0]['hashed_password']);
            
            if (!$result) {
                echo 'Mauvais identifiant ou mot de passe !';
                $_SESSION['message'] = "Mauvais identifiant ou mot de passe !";
                echo '<pre>';
                var_dump(!$result . "dans !result");
                die();
                echo '</pre>';
            } else {
                $isPasswordValid = password_verify($password, $resultHashPassword[0]['hashed_password']);
                if ($isPasswordValid) {
                    $_SESSION['id'] = $result['id'];
                    $_SESSION['pseudo'] = htmlspecialchars($pseudo);
                    echo 'Bonjour ' . htmlspecialchars($pseudo);
                    $_SESSION['message'] = "Vous êtes maintenant connecté ! " . htmlspecialchars($pseudo);
                    $_SESSION['login'] = true;
                    //echo '<pre>';
                    //var_dump($isPasswordValid);
                    //die();
                    //echo '</pre>';
                    header('Location: index.php?action=blogControlPanel');
                    exit();
                }
                 
                echo 'Mauvais identifiant ou mot de passe! !';
                $_SESSION['message'] = "Mauvais identifiant ou mot de passe !";
                echo '<pre>';
                var_dump(!$isPasswordValid . "mot de passe incorrect");
                die();
                echo '</pre>';
            }
        }
        $this->view->render(['template' => 'adminloginpage'], 'frontoffice');
    }
    
    public function logout(): void
    {
        // Suppression des variables de session et de la session
        $_SESSION = [];
        session_destroy();
        //echo '<pre>';
        //var_dump($_SESSION);
        //die();
        //echo '</pre>';
        $_SESSION['message'] = "Vous êtes maintenant déconnecté !";
        $_SESSION['login'] = false;
        //echo '<pre>';
        //var_dump($_SESSION);
        //die();
        //echo '</pre>';
        // Affichage de la div "Vous êtes maintenant déconnecté !" ne marche pas si code
        //header('Location: index.php?action=login');
        //exit();
        $this->view->render(['template' => 'adminloginpage'], 'frontoffice');
    }

    public function blogControlPanel(): void
    {
        $this->view->render(['template' => 'blogcontrolpanelpage'], 'backoffice');
    }
    
    public function myProfile(): void
    {
        $this->view->render(['template' => 'myprofile'], 'backoffice');
    }

    public function readEpisodes(int $currentPage): void
    {
        $nbEpisodesPerPage = 5;
        $nbTotalEpisodes = $this->postManager->getNbEpisodes();
        $nbTotalPages = ceil($nbTotalEpisodes / $nbEpisodesPerPage);
        
        if ($currentPage>$nbTotalPages) {
            $_SESSION['erreur'] = "La page demandée n'existe pas ! Voici la dernière page du blog.";
            $currentPage= $nbTotalPages;
            header('Location: index.php?action=readEpisodes&page=' .$currentPage . '');
            exit();
        } elseif ($currentPage<=0) {
            $currentPage=1;
        }

        $previousPage = $currentPage<=1 ? null : ($currentPage-1);
        $nextPage = $currentPage>=$nbTotalPages ? null : ($currentPage+1);

        $dataAllEpisodesPagination = $this->postManager->getListEpisodesPagination($currentPage, $nbEpisodesPerPage);

        $this->view->render(['template' => 'readepisodes', 'allepisodespagination' => $dataAllEpisodesPagination, 'previouspage' => $previousPage, 'nextpage'=> $nextPage], 'backoffice');
    }
    
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
        echo '<pre>';
        var_dump($_SESSION['token'], $_SESSION['token_time'], $_POST['token']);
        die();
        echo '</pre>';

        //On va vérifier :
        //Si le jeton est présent dans la session et dans le formulaire
        if (isset($_SESSION['token']) && isset($_SESSION['token_time']) && isset($_POST['token'])) {
            echo '<pre>';
            var_dump($_SESSION['token'], $_SESSION['token_time'], $_POST['token']);
            die();
            echo '</pre>';

            //Si le jeton de la session correspond à celui du formulaire
            if ($_SESSION['token'] === $_POST['token']) {
                //On stocke le timestamp qu'il était il y a 15 minutes
                $timestamp_ancien = time() - (15*60);
                //Si le jeton n'est pas expiré
                if ($_SESSION['token_time'] >= $timestamp_ancien) {
                    //ON FAIT TOUS LES TRAITEMENTS ICI
                    if ($data) {
                        if (isset($data['chapter']) && !empty($data['chapter'])
                            && isset($data['title']) && !empty($data['title'])
                            && isset($data['introduction']) && !empty($data['introduction'])
                            && isset($data['content']) && !empty($data['content'])) {
                            // On nettoie les données envoyées
                            $chapter = strip_tags($data['chapter']);
                            $title = strip_tags($data['title']);
                            $introduction = ($data['introduction']);
                            $content = ($data['content']);
                            $this->postManager->newPost($chapter, $title, $introduction, $content);
                            $_SESSION['message'] = "Épisode ajouté";
                            header('Location: index.php?action=readEpisodes');
                            exit();
                        }
                        $_SESSION['erreur'] = "Le formulaire est incomplet";
                        $this->view->render(['template' => 'addepisode'], 'backoffice');
                    }
                    $this->view->render(['template' => 'addepisode'], 'backoffice');
                }
            }
        }
        //$this->view->render(['template' => 'addepisode'], 'backoffice');
        $_SESSION['erreur'] = "Accès non autorisé";
        header('Location: index.php?action=home');
        exit();
    }

    public function draftEpisode(array $data): void
    {
        if ($data) {
            if (isset($data['chapter']) && !empty($data['chapter'])
             && isset($data['title']) && !empty($data['title'])
             && isset($data['introduction']) && !empty($data['introduction'])
             && isset($data['content']) && !empty($data['content'])) {
                // On nettoie les données envoyées
                $chapter = strip_tags($data['chapter']);
                $title = strip_tags($data['title']);
                $introduction = ($data['introduction']);
                $content = ($data['content']);
                $this->postManager->draftPost($chapter, $title, $introduction, $content);
                $_SESSION['message'] = "Brouillon de l'épisode ";
                header('Location: index.php?action=readEpisodes');
                exit();
            }
            $_SESSION['erreur'] = "Le formulaire est incomplet";
            $this->view->render(['template' => 'draftepisode'], 'backoffice');
        }
        $this->view->render(['template' => 'draftepisode'], 'backoffice');
    }

    public function publishEpisode(array $data): void
    {
        if ($data) {
            if (isset($data['chapter']) && !empty($data['chapter'])
             && isset($data['title']) && !empty($data['title'])
             && isset($data['introduction']) && !empty($data['introduction'])
             && isset($data['content']) && !empty($data['content'])) {
                // On nettoie les données envoyées
                $chapter = strip_tags($data['chapter']);
                $title = strip_tags($data['title']);
                $introduction = ($data['introduction']);
                $content = ($data['content']);
                $this->postManager->publishPost($chapter, $title, $introduction, $content);
                $_SESSION['message'] = "Épisode publié";
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
            $dataPost = $this->postManager->showOnePost($postId);
            // On verifie si le post existe
            if (!$dataPost) {
                $_SESSION['erreur'] = "Cet id n'existe pas";
                header('Location: index.php?action=readEpisodes');
                exit();
            }
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
             && isset($data['content']) && !empty($data['content'])) {
                // On nettoie les données envoyées
                $id = strip_tags($data['id']);
                $chapter = strip_tags($data['chapter']);
                $title = strip_tags($data['title']);
                $introduction = ($data['introduction']);
                $content = ($data['content']);
                $this->postManager->editPost($id, $chapter, $title, $introduction, $content);
                $_SESSION['message'] = "Épisode modifié";
                header('Location: index.php?action=readEpisodes');
                exit();
            }
            $_SESSION['erreur'] = "Le formulaire est incomplet";
            $this->view->render(['template' => 'editepisode'], 'backoffice');
        }
        $this->view->render(['template' => 'editepisode', 'post' => $dataPost], 'backoffice');
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
        $dataReportedComments = $this->commentManager->showAllReportedComment();
        $this->view->render(['template' => 'reportedcomments', 'allreportedcomment' => $dataReportedComments], 'backoffice');
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
            header('Location: index.php?action=reportedComments');
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
