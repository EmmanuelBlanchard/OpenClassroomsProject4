<?php

declare(strict_types=1);

namespace App\Controller\Frontoffice;

use App\Model\CommentManager;
use App\Model\PostManager;
use App\Service\Http\Request;
use App\Service\Http\Session;
use App\Service\Security\Token;
use App\View\View;

class CommentController
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

    public function addComment(int $postId, array $data, Token $token, Session $session, Request $request): void
    {
        //$token->verify($data['csrfToken']);
        //echo '<pre>';
        //var_dump($token, $token->verify($data['csrfToken']));
        //die();
        //echo '</pre>';

        echo '<pre>';
        //var_dump($data['csrfToken'], $data['csrfTokenTime'], $_POST['crsfToken']); // NON ACCES ?? aux données de formulaire $_POST['csrfToken'], $data['csrfToken']
        //var_dump("Session Token ". $session->getToken() . " ", "Session TokenTime ". $session->getTokenTime() . " ");
        
        var_dump("requete Token " . $request->getRequest('csrfToken') . " ");
        //  Whoops \ Exception \ ErrorException (E_NOTICE)
        // Undefined index: csrfToken
        //var_dump("Session Token ". $session->getToken() . " ", "Session TokenTime ". $session->getTokenTime() . " ", "Request Token " . $request->getRequest('csrfToken') . " ");
        die();
        echo '</pre>';

        // $request->getPost();

        $tokenSession = $this->session->getToken();
        $tokenTimeSession = $this->session->getTokenTime();

        //Si le jeton est présent dans la session et dans le formulaire
        if (isset($_SESSION['csrfToken']) && isset($_SESSION['csrfTokenTime']) && isset($_POST['crsfToken'])) {
            echo '<pre>';
            var_dump("Dans la condition if ! ");
            var_dump($_SESSION['csrfToken'], $_SESSION['csrfTokenTime'], $_POST['crsfToken']);
            die();
            echo '</pre>';
            //Si le jeton de la session correspond à celui du formulaire
            if ($_SESSION['token'] === $_POST['token']) {
                //On stocke le timestamp qu'il était il y a 15 minutes
                $timestamp_ancien = time() - (15*60);
                //Si le jeton n'est pas expiré
                if ($_SESSION['token_time'] >= $timestamp_ancien) {
                    //ON FAIT TOUS LES TRAITEMENTS ICI
                        //...
                        //...
                }
            }
        }

        if (!empty($data['pseudo']) && !empty($data['comment'])) {
            $this->commentManager->postComment($postId, htmlspecialchars($data['comment']), htmlspecialchars($data['pseudo']));
        } else {
            header('Location: index.php?action=error&id='.$postId);
            exit();
        }
        header('Location: index.php?action=detailOfPost&id='.$postId);
        exit();
    }
    
    public function reported(int $commentId, int $postId): void
    {
        $this->commentManager->reportedComment($commentId);

        header('Location: index.php?action=detailOfPost&commentid=' .$commentId . '&id=' .$postId);
        exit();
    }

    // Essai en cas d'erreur, route vers la page d'erreur
    public function error(int $postId): void
    {
        $dataPost = $this->postManager->getPost($postId);

        if ($dataPost !== null) {
            $this->view->render(['template' => 'error', 'post' => $dataPost], 'frontoffice');
        } elseif ($dataPost === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }
    }
}
