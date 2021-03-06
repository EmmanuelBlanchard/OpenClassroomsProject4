<?php

declare(strict_types=1);

namespace  App\Service;

use App\Controller\Backoffice\AdminController;
use App\Controller\Error;
use App\Controller\Frontoffice\CommentController;
use App\Controller\Frontoffice\PostController;
use App\Model\AdminManager;
use App\Model\CommentManager;
use App\Model\PostManager;
use App\Model\UserManager;
use App\Service\Database;
use App\Service\Http\Request;
use App\Service\Http\Session;
use App\Service\Security\AccessControl;
use App\Service\Security\Token;
use App\View\View;

// Cette classe router est un exemple très basique. Cette façon de faire n'est pas optimale
class Router
{
    private Database $database;
    private AdminManager $adminManager;
    private UserManager $userManager;
    private PostManager $postManager;
    private CommentManager $commentManager;
    private View $view;
    private AdminController $adminController;
    private PostController $postController;
    private CommentController $commentController;
    private Request $request;
    private Session $session;
    private AccessControl $accesscontrol;
    private Token $token;
    private Error $error;

    public function __construct()
    {
        // Dépendances
        $this->database = new Database();
        $this->adminManager = new AdminManager($this->database);
        $this->userManager = new UserManager($this->database);
        $this->postManager = new PostManager($this->database);
        $this->commentManager = new CommentManager($this->database);
        $this->view = new View();
        $this->request = new Request();
        $this->session = new Session();
        $this->accesscontrol = new AccessControl($this->session);
        $this->token = new Token($this->session);
        $this->error = new Error($this->session, $this->view);

        // Injection des dépendances
        $this->adminController = new AdminController($this->adminManager, $this->userManager, $this->postManager, $this->commentManager, $this->view, $this->session, $this->accesscontrol, $this->token);
        $this->postController = new PostController($this->postManager, $this->commentManager, $this->view, $this->session, $this->error);
        $this->commentController = new CommentController($this->postManager, $this->commentManager, $this->view, $this->session, $this->error);
    }

    public function run(): void
    {
        $action = $this->request->getGetItem('action') ?? 'home';

        // Déterminer sur quelle route nous sommes // Attention algorithme naïf
        if ($action === 'home') {
            // route http://localhost:8000/?action=home
            $this->postController->displayHomeWithTheLastThreePosts();
        } elseif ($action === 'detailOfPost' && (($this->request->getGetItem('id')) !== null)) {
            // route http://localhost:8000/?action=detailOfPost&id=5
            $this->postController->displayDetailOfPost((int)$this->request->getGetItem('id'), $this->token, $this->session);
        } elseif ($action === 'listOfPosts') {
            // route http://localhost:8000/?action=listOfPosts
            $currentPage = ($this->request->getGetItem('page') !== null) ? (int) $this->request->getGetItem('page') : 1;
            $this->postController->displayListOfPosts($currentPage, $this->session);
        } elseif ($action === 'addComment' && ($this->request->getGetItem('id') !== null)) {
            // route http://localhost:8000/?action=addCommente&id=5
            $this->commentController->addComment((int)$this->request->getGetItem('id'), $this->request->getPost(), $this->token, $this->request);
        } elseif ($action === 'reported' && ($this->request->getGetItem('commentid') !== null) && ($this->request->getGetItem('id') !== null)) {
            // route http://localhost:8000/?action=reported&commentid=1&id=1
            $this->commentController->reported((int)$this->request->getGetItem('commentid'), (int)$this->request->getGetItem('id'));
        } elseif ($action === 'error' && ($this->request->getGetItem('id') !== null)) {
            // route http://localhost:8000/?action=error&id=5
            $this->commentController->error((int)$this->request->getGetItem('id'));
        } elseif ($action === 'login') {
            // route http://localhost:8000/?action=login
            $this->adminController->login($this->request->getPost(), $this->session, $this->token, $this->request);
        } elseif ($action === 'logout') {
            // route http://localhost:8000/?action=blogControlPanel
            $this->adminController->logout($this->session);
        } elseif ($action === 'blogControlPanel') {
            // route http://localhost:8000/?action=blogControlPanel
            $this->adminController->blogControlPanel($this->session);
        } elseif ($action === 'myProfile') {
            // route http://localhost:8000/?action=myProfile
            $this->adminController->myProfile($this->session, $this->token, $this->request);
        } elseif ($action === 'readEpisodes') {
            // route http://localhost:8000/?action=readEpisodes
            $currentPage = ($this->request->getGetitem('page') !== null) ? (int) $this->request->getGetItem('page') : 1;
            $this->adminController->readEpisodes($currentPage, $this->session);
        } elseif ($action === 'addEpisode') {
            // route http://localhost:8000/?action=addEpisode
            $this->adminController->addEpisode($this->request->getPost(), $this->session, $this->token, $this->request);
        } elseif ($action === 'editEpisode' && ($this->request->getGetItem('id') !== null)) {
            // route http://localhost:8000/?action=editEpisode&id=5
            $this->adminController->editEpisode((int)$this->request->getGetitem('id'), $this->request->getPost(), $this->session, $this->token, $this->request);
        } elseif ($action === 'deleteEpisode') {
            // route http://localhost:8000/?action=deleteEpisode&id=5
            $this->adminController->deleteEpisode((int)$this->request->getGetItem('id'), $this->session);
        } elseif ($action === 'readComments') {
            // route http://localhost:8000/?action=readComments
            $currentPage = ($this->request->getGetItem('page') !== null) ? (int) $this->request->getGetItem('page') : 1;
            $this->adminController->readComments($currentPage, $this->session);
        } elseif ($action === 'reportedComments') {
            // route http://localhost:8000/?action=reportedComments
            $this->adminController->reportedComments($this->session);
        } elseif ($action === 'approveComment' && ($this->request->getGetItem('id') !== null)) {
            // route http://localhost:8000/?action=approveComment&id=5
            $this->adminController->approveComment((int)$this->request->getGetItem('id'), $this->session);
        } elseif ($action === 'deleteComment') {
            // route http://localhost:8000/?action=deleteComment&id=5
            $this->adminController->deleteComment((int)$this->request->getGetItem('id'), $this->session);
        } else {
            $this->error->display('Erreur 404', 'Cette page n\'existe pas !', 'frontoffice');
        }
    }
}
