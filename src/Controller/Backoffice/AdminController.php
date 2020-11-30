<?php

declare(strict_types=1);

namespace App\Controller\Backoffice;

use App\Model\AdminManager;
use App\Model\CommentManager;
use App\Model\PostManager;
use App\Model\UserManager;
use App\Service\Http\Session;
use App\Service\Security\AccessControl;
use App\Service\Security\Token;
use App\View\View;

class AdminController
{
    private AdminManager $adminManager;
    private UserManager $userManager;
    private PostManager $postManager;
    private CommentManager $commentManager;
    private View $view;
    private Session $session;
    private AccessControl $accesscontrol;
    private Token $token;

    public function __construct(AdminManager $adminManager, UserManager $userManager, PostManager $postManager, CommentManager $commentManager, View $view, Session $session, AccessControl $accesscontrol, Token $token)
    {
        $this->adminManager = $adminManager;
        $this->userManager = $userManager;
        $this->postManager = $postManager;
        $this->commentManager = $commentManager;
        $this->view = $view;
        $this->session = $session;
        $this->accesscontrol = $accesscontrol;
        $this->token = $token;
    }

    public function login(array $data, Session $session): void
    {
        //var_dump($data);
        //echo '<pre>';
        //var_dump($session);
        //die();
        //echo '</pre>';
        if (!empty($data['pseudo']) && !empty($data['password'])) {
            $pseudo= $data['pseudo'];
            $password = $data['password'];
            // Récupération de l'id et de son mot de passe hashé
            $result = $this->userManager->recoveryIdAndHashedPassword($data['pseudo']);
            if (!$result) {
                $session->setSessionMessage('erreur', 'Mauvais identifiant ou mot de passe !');
            } else {
                $isPasswordValid = password_verify($password, $result['hashed_password']);
                if ($isPasswordValid) {
                    $session->setSessionMessage('id', $result['id']);
                    $session->setSessionMessage('pseudo', htmlspecialchars($pseudo));
                    $session->setSessionMessage('message', 'Vous êtes maintenant connecté ! ' . htmlspecialchars($pseudo));
                    $session->setSession('login', true);
                    header('Location: index.php?action=blogControlPanel');
                    exit();
                }
                $session->setSessionMessage('erreur', 'Mauvais identifiant ou mot de passe !');
            }
        }
        $this->view->render(['template' => 'adminloginpage'], 'frontoffice');
    }
    
    public function logout(Session $session): void
    {
        // Suppression des variables de session et de la session
        $session->stopSession();
        $this->view->render(['template' => 'adminloginpage'], 'frontoffice');
    }

    public function blogControlPanel(Session $session): void
    {
        if ($this->accesscontrol->isAuthorized()) {
            $this->view->render(['template' => 'blogcontrolpanelpage', 'session' => $session], 'backoffice');
        } else {
            header('Location: index.php?action=login');
            exit();
        }
    }
    
    public function myProfile(): void
    {
        if ($this->accesscontrol->isAuthorized()) {
            $this->view->render(['template' => 'myprofile'], 'backoffice');
        } else {
            header('Location: index.php?action=login');
            exit();
        }
    }

    public function readEpisodes(int $currentPage, Session $session): void
    {
        if (!$this->accesscontrol->isAuthorized()) {
            header('Location: index.php?action=login');
            exit();
        }
        $nbEpisodesPerPage = 5;
        $nbTotalEpisodes = $this->postManager->getNbEpisodes();
        $nbTotalPages = ceil($nbTotalEpisodes / $nbEpisodesPerPage);
        
        if ($currentPage>$nbTotalPages) {
            $session->setSession('erreur', 'La page n°' .$currentPage . ' n\'existe pas ! Voici la denière page de Liste des épisodes.');
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
    
    public function addEpisode(array $data, Session $session): void
    {
        if ($this->accesscontrol->isAuthorized()) {
            if ($data) {
                if (isset($data['chapter']) && !empty($data['chapter'])
                    && isset($data['title']) && !empty($data['title'])
                    && isset($data['introduction']) && !empty($data['introduction'])
                    && isset($data['content']) && !empty($data['content'])
                    && isset($data['episodeStatus']) && !empty($data['episodeStatus'])) {
                    // On nettoie les données envoyées
                    $chapter = strip_tags($data['chapter']);
                    $title = strip_tags($data['title']);
                    $introduction = ($data['introduction']);
                    $content = ($data['content']);
                    $episodeStatus = strip_tags($data['episodeStatus']);
                    $this->postManager->newPost($chapter, $title, $introduction, $content, $episodeStatus);
                    $session->setSession('message', 'Épisode ajouté');
                    header('Location: index.php?action=readEpisodes');
                    exit();
                }
                $session->setSession('erreur', 'le formulaire est incomplet');
                $this->view->render(['template' => 'addepisode'], 'backoffice');
            }
            $this->view->render(['template' => 'addepisode'], 'backoffice');
        } else {
            header('Location: index.php?action=login');
            exit();
        }
    }

    public function editEpisode(int $postId, array $data, Session $session): void
    {
        if ($this->accesscontrol->isAuthorized()) {
            if (isset($postId) && !empty($postId)) {
                $dataPost = $this->postManager->showOnePost($postId);
                // On verifie si le post existe
                if (!$dataPost) {
                    $session->setSession('erreur', 'L\'épisode n°' . $postId . ' n\'existe pas');
                    header('Location: index.php?action=readEpisodes');
                    exit();
                }
            } else {
                $session->setSession('erreur', 'URL invalide');
                header('Location: index.php?action=readEpisodes');
                exit();
            }

            if ($data) {
                if (isset($data['id']) && !empty($data['id'])
                && isset($data['chapter']) && !empty($data['chapter'])
                && isset($data['title']) && !empty($data['title'])
                && isset($data['introduction']) && !empty($data['introduction'])
                && isset($data['content']) && !empty($data['content'])
                && isset($data['episodeStatus']) && !empty($data['episodeStatus'])) {
                    // On nettoie les données envoyées
                    $id = strip_tags($data['id']);
                    $chapter = strip_tags($data['chapter']);
                    $title = strip_tags($data['title']);
                    $introduction = ($data['introduction']);
                    $content = ($data['content']);
                    $episodeStatus = strip_tags($data['episodeStatus']);
                    $this->postManager->editPost($id, $chapter, $title, $introduction, $content, $episodeStatus);
                    $session->setSession('message', 'Épisode modifié');
                    header('Location: index.php?action=readEpisodes');
                    exit();
                }
                $session->setsession('erreur', 'Le formulaire est incomplet');
                $this->view->render(['template' => 'editepisode'], 'backoffice');
            }
            $this->view->render(['template' => 'editepisode', 'post' => $dataPost], 'backoffice');
        } else {
            header('Location: index.php?action=login');
            exit();
        }
    }

    public function deleteEpisode(int $postId, Session $session): void
    {
        if ($this->accesscontrol->isAuthorized()) {
            if (isset($postId) && !empty($postId)) {
                $dataPost = $this->postManager->showOnePost($postId);
                // On verifie si le post existe
                if (!$dataPost) {
                    $session->setSession('erreur', 'L\'épisode n°' . $postId . ' n\'existe pas');
                    header('Location: index.php?action=readEpisodes');
                    exit();
                }
                $this->postManager->deletePost($postId);
                $session->setsession('message', 'Épisode n°' . $postId . ' supprimé');
                header('Location: index.php?action=readEpisodes');
                exit();
            }
            $session->setSession('erreur', 'URL invalide');
            header('Location: index.php?action=readEpisodes');
            exit();
        }
        header('Location: index.php?action=login');
        exit();
    }

    public function readComments(int $currentPage, Session $session): void
    {
        if ($this->accesscontrol->isAuthorized()) {
            $nbCommentsPerPage = 5;
            $nbTotalComments = $this->commentManager->getNbComments();
            $nbTotalPages = ceil($nbTotalComments / $nbCommentsPerPage);
            if ($currentPage>$nbTotalPages) {
                $session->setSession('erreur', 'La page n°' .$currentPage . ' n\'existe pas ! Voici la denière page de Liste des commentaires.');
                $currentPage = $nbTotalPages;
                header('Location: index.php?action=readComments&page=' .$currentPage .'');
                exit();
            } elseif ($currentPage<=0) {
                $currentPage=1;
            }
            $previousPage = $currentPage<=1 ? null : ($currentPage-1);
            $nextPage = $currentPage>=$nbTotalPages ? null : ($currentPage+1);
            $dataAllCommentsPagination = $this->commentManager->getListCommentsPagination($currentPage, $nbCommentsPerPage);
            $this->view->render(['template' => 'readcomments', 'allcommentspagination' => $dataAllCommentsPagination, 'previouspage' => $previousPage, 'nextpage' => $nextPage], 'backoffice');
        } else {
            header('Location: index.php?action=login');
            exit();
        }
    }
    
    public function reportedComments(): void
    {
        if ($this->accesscontrol->isAuthorized()) {
            $dataReportedComments = $this->commentManager->showAllReportedComment();
            $this->view->render(['template' => 'reportedcomments', 'allreportedcomment' => $dataReportedComments], 'backoffice');
        } else {
            header('Location: index.php?action=login');
            exit();
        }
    }

    public function approveComment(int $commentId, Session $session): void
    {
        if ($this->accesscontrol->isAuthorized()) {
            if (isset($commentId) && !empty($commentId)) {
                $dataComment = $this->commentManager->showOneComment($commentId);
                // On verifie si le commentaire existe
                if (!$dataComment) {
                    $session->setSession('erreur', 'Le commentaire n°' .$commentId . ' n\'existe pas');
                    header('Location: index.php?action=readComments');
                    exit();
                }
                $this->commentManager->approveComment($commentId);
                $session->setSession('message', 'Commentaire n°' . $commentId . ' approuvé');
                header('Location: index.php?action=reportedComments');
                exit();
            }
            $session->setSession('erreur', 'URL invalide');
            header('Location: index.php?action=readComments');
            exit();
        }
        header('Location: index.php?action=login');
        exit();
    }

    public function deleteComment(int $commentId, Session $session): void
    {
        if ($this->accesscontrol->isAuthorized()) {
            if (isset($commentId) && !empty($commentId)) {
                $dataComment = $this->commentManager->showOneComment($commentId);
                // On verifie si le commentaire existe
                if (!$dataComment) {
                    $session->setSession('erreur', 'Le commentaire n°' .$commentId . ' n\'existe pas');
                    header('Location: index.php?action=readComments');
                    exit();
                }
                $dataComment = $this->commentManager->deleteComment($commentId);
                $session->setSession('message', 'Commentaire n°' . $commentId . ' supprimé');
                header('Location: index.php?action=readComments');
                exit();
            }
            $session->setSession('erreur', 'URL invalide');
            header('Location: index.php?action=readComments');
            exit();
        }
        header('Location: index.php?action=login');
        exit();
    }
}
