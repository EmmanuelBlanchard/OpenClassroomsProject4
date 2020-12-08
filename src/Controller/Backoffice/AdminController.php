<?php

declare(strict_types=1);

namespace App\Controller\Backoffice;

use App\Model\AdminManager;
use App\Model\CommentManager;
use App\Model\PostManager;
use App\Model\UserManager;
use App\Service\Http\Request;
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
    private Request $request;
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

    public function login(array $data, Session $session, Token $token, Request $request): void
    {
        //var_dump($data);
        //echo '<pre>';
        //var_dump($session, $request->getPostItem('csrfToken'));
        //echo '</pre>';
        //die();
        
        if ($request->getPostItem('csrfToken') !== null) {
            if (!$token->verify($request->getPostItem('csrfToken'))) {
                $this->session->setSessionMessage('erreur', 'Vous ne pouvez pas vous connecter !');
                header('Location: index.php?action=login');
                exit();
            }
        }

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
                    $session->setLogin('login', true);

                    //var_dump($_SESSION['id'], $_SESSION['pseudo']);
                    //die();
                    
                    header('Location: index.php?action=blogControlPanel');
                    exit();
                }
                $session->setSessionMessage('erreur', 'Mauvais identifiant ou mot de passe !');
            }
        }
        $this->view->render(['template' => 'adminloginpage', 'csrfToken' => $token->generate(), 'sessionmessage' => $session->getSessionMessage('message'), 'sessionerreur' => $session->getSessionMessage('erreur')], 'frontoffice');
    }
    
    public function logout(Session $session): void
    {
        $session->stopSession();
        header('Location: index.php?action=home');
        exit();
    }

    public function blogControlPanel(Session $session): void
    {
        if (!$this->accesscontrol->isAuthorized()) {
            header('Location: index.php?action=login');
            exit();
        }
        $this->view->render(['template' => 'blogcontrolpanelpage', 'sessionmessage' => $session->getSessionMessage('message')], 'backoffice');
    }
    
    public function myProfile(Session $session, Token $token, Request $request): void
    {
        if (!$this->accesscontrol->isAuthorized()) {
            header('Location: index.php?action=login');
            exit();
        }
        
        if ($request->getPostItem('csrfToken') !== null) {
            if (!$token->verify($request->getPostItem('csrfToken'))) {
                $session->setSessionMessage('erreur', 'Modification non possible !');
                header('Location: index.php?action=login');
            }
        }

        $this->view->render(['template' => 'myprofile', 'csrfToken' => $token->generate(), 'sessionmessage' => $session->getSessionMessage('message'), 'sessionerreur' => $session->getSessionMessage('erreur')], 'backoffice');
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
            $session->setSessionMessage('erreur', 'La page n°' .$currentPage . ' n\'existe pas ! Voici la denière page de Liste des épisodes.');
            $currentPage= $nbTotalPages;
            header('Location: index.php?action=readEpisodes&page=' .$currentPage . '');
            exit();
        } elseif ($currentPage<=0) {
            $session->setSessionMessage('erreur', 'La page n°' .$currentPage . ' n\'existe pas ! Voici la première page de Liste des épisodes.');
            $currentPage=1;
            header('Location: index.php?action=readEpisodes&page=' .$currentPage . '');
            exit();
        }

        $previousPage = $currentPage<=1 ? null : ($currentPage-1);
        $nextPage = $currentPage>=$nbTotalPages ? null : ($currentPage+1);

        $dataAllEpisodesPagination = $this->postManager->getListEpisodesPagination($currentPage, $nbEpisodesPerPage);

        $this->view->render(['template' => 'readepisodes', 'allepisodespagination' => $dataAllEpisodesPagination, 'previouspage' => $previousPage, 'nextpage'=> $nextPage, 'lastpage' => $nbTotalPages, 'sessionmessage' => $session->getSessionMessage('message'), 'sessionerreur' => $session->getSessionMessage('erreur')], 'backoffice');
    }
    
    public function addEpisode(array $data, Session $session, Token $token, Request $request): void
    {
        if (!$this->accesscontrol->isAuthorized()) {
            header('Location: index.php?action=login');
            exit();
        }

        if ($request->getPostItem('csrfToken') !== null) {
            if (!$token->verify($request->getPostItem('csrfToken'))) {
                $session->setSessionMessage('erreur', 'Modification non possible !');
                header('Location: index.php?action=login');
                exit();
            }
        }

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
                $session->setSessionMessage('message', 'Épisode n°' . $chapter . ' ajouté');
                header('Location: index.php?action=readEpisodes');
                exit();
            }
            $session->setSessionMessage('erreur', 'Le formulaire est incomplet !');
            header('Location: index.php?action=addEpisode');
            exit();
        }
        $this->view->render(['template' => 'addepisode', 'csrfToken' => $token->generate(), 'sessionmessage' => $session->getSessionMessage('message'), 'sessionerreur' => $session->getSessionMessage('erreur')], 'backoffice');
    }

    public function editEpisode(int $postId, array $data, Session $session, Token $token, Request $request): void
    {
        if (!$this->accesscontrol->isAuthorized()) {
            header('Location: index.php?action=login');
            exit();
        }
        
        if ($request->getPostItem('csrfToken') !== null) {
            if (!$token->verify($request->getPostItem('csrfToken'))) {
                $session->setSessionMessage('erreur', 'Modification non possible !');
                header('Location: index.php?action=login');
            }
        }

        if (isset($postId) && !empty($postId)) {
            $dataPost = $this->postManager->showOnePost($postId);
            // On verifie si le post existe
            if (!$dataPost) {
                $session->setSessionMessage('erreur', 'L\'épisode n°' . $postId . ' n\'existe pas');
                header('Location: index.php?action=readEpisodes');
                exit();
            }
        } else {
            $session->setSessionMessage('erreur', 'URL invalide');
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
                $session->setSessionMessage('message', 'Épisode n°' . $chapter . ' modifié');
                header('Location: index.php?action=readEpisodes');
                exit();
            }
            $session->setsessionMessage('erreur', 'Le formulaire est incomplet');
            header('Location: index.php?action=editEpisode&id=' . $postId . '');
            exit();
        }
        $this->view->render(['template' => 'editepisode', 'post' => $dataPost, 'csrfToken' => $token->generate(), 'sessionmessage' => $session->getSessionMessage('message'), 'sessionerreur' => $session->getSessionMessage('erreur')], 'backoffice');
    }

    public function deleteEpisode(int $postId, Session $session): void
    {
        if (!$this->accesscontrol->isAuthorized()) {
            header('Location: index.php?action=login');
            exit();
        }

        if (isset($postId) && !empty($postId)) {
            $dataPost = $this->postManager->showOnePost($postId);
            // On verifie si le post existe
            if (!$dataPost) {
                $session->setSessionMessage('erreur', 'L\'épisode n°' . $dataPost['chapter'] . ' avec pour numéro d\'identifiant ' . $postId . ' n\'existe pas');
                header('Location: index.php?action=readEpisodes');
                exit();
            }
            $this->postManager->deletePost($postId);
            $session->setsessionMessage('message', 'L\'épisode n°' . $dataPost['chapter'] . ' avec pour numéro d\'identifiant ' . $postId . ' est supprimé');
            header('Location: index.php?action=readEpisodes');
            exit();
        }
        $session->setSessionMessage('erreur', 'URL invalide');
        header('Location: index.php?action=readEpisodes');
        exit();
    }

    public function readComments(int $currentPage, Session $session): void
    {
        if (!$this->accesscontrol->isAuthorized()) {
            header('Location: index.php?action=login');
            exit();
        }

        $nbCommentsPerPage = 5;
        $nbTotalComments = $this->commentManager->getNbComments();
        $nbTotalPages = ceil($nbTotalComments / $nbCommentsPerPage);
        if ($currentPage>$nbTotalPages) {
            $session->setSessionMessage('erreur', 'La page n°' .$currentPage . ' n\'existe pas ! Voici la denière page de Liste des commentaires.');
            $currentPage = $nbTotalPages;
            header('Location: index.php?action=readComments&page=' .$currentPage .'');
            exit();
        } elseif ($currentPage<=0) {
            $session->setSessionMessage('erreur', 'La page n°' .$currentPage . ' n\'existe pas ! Voici la première page de Liste des commentaires.');
            $currentPage=1;
            header('Location: index.php?action=readComments&page=' . $currentPage . '');
            exit();
        }
        $previousPage = $currentPage<=1 ? null : ($currentPage-1);
        $nextPage = $currentPage>=$nbTotalPages ? null : ($currentPage+1);
        $dataAllCommentsPagination = $this->commentManager->getListCommentsPagination($currentPage, $nbCommentsPerPage);
        $this->view->render(['template' => 'readcomments', 'allcommentspagination' => $dataAllCommentsPagination, 'previouspage' => $previousPage, 'nextpage' => $nextPage, 'lastpage' => $nbTotalPages, 'sessionmessage' => $session->getSessionMessage('message'), 'sessionerreur' => $session->getSessionMessage('erreur')], 'backoffice');
    }
    
    public function reportedComments(Session $session): void
    {
        if (!$this->accesscontrol->isAuthorized()) {
            header('Location: index.php?action=login');
            exit();
        }
        $dataReportedComments = $this->commentManager->showAllReportedComment();

        $this->view->render(['template' => 'reportedcomments', 'allreportedcomment' => $dataReportedComments, 'sessionmessage' => $session->getSessionMessage('message'), 'sessionerreur' => $session->getSessionMessage('erreur')], 'backoffice');
    }

    public function approveComment(int $commentId, Session $session): void
    {
        if (!$this->accesscontrol->isAuthorized()) {
            header('Location: index.php?action=login');
            exit();
        }
        if (isset($commentId) && !empty($commentId)) {
            $dataComment = $this->commentManager->showOneComment($commentId);

            // On verifie si le commentaire existe
            if (!$dataComment) {
                $session->setSessionMessage('erreur', 'Le commentaire n°' .$commentId . ' de l\'épisode n°' . $dataComment['post_id'] . ' n\'existe pas');
                header('Location: index.php?action=readComments');
                exit();
            }
            $this->commentManager->approveComment($commentId);
            $session->setSessionMessage('message', 'Commentaire n°' . $commentId . ' de l\'épisode n°' . $dataComment['post_id'] . ' approuvé');
            header('Location: index.php?action=reportedComments');
            exit();
        }
        $session->setSessionMessage('erreur', 'URL invalide');
        header('Location: index.php?action=readComments');
        exit();
    }

    public function deleteComment(int $commentId, Session $session): void
    {
        if (!$this->accesscontrol->isAuthorized()) {
            header('Location: index.php?action=login');
            exit();
        }
        if (isset($commentId) && !empty($commentId)) {
            $dataComment = $this->commentManager->showOneComment($commentId);
            // On verifie si le commentaire existe
            if (!$dataComment) {
                $session->setSessionMessage('erreur', 'Le commentaire n°' .$commentId . ' de l\'épisode n°' . $dataComment['post_id'] . ' n\'existe pas');
                header('Location: index.php?action=readComments');
                exit();
            }
            $dataComment = $this->commentManager->deleteComment($commentId);
            $session->setSessionMessage('message', 'Commentaire n°' . $commentId . ' de l\'épisode n°' . $dataComment['post_id'] . ' supprimé');
            header('Location: index.php?action=readComments');
            exit();
        }
        $session->setSessionMessage('erreur', 'URL invalide');
        header('Location: index.php?action=readComments');
        exit();
    }
}
