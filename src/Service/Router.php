<?php

declare(strict_types=1);

namespace  App\Service;

use App\Controller\Backoffice\AdminController;
use App\Controller\Frontoffice\CommentController;
use App\Controller\Frontoffice\PostController;
use App\Model\AdminManager;
use App\Model\CommentManager;
use App\Model\PostManager;
use App\Model\UserManager;
use App\Service\Database;
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
    private array $get;
    private array $post;

    public function __construct()
    {
        // Dépendances
        $this->database = new Database();
        $this->adminManager = new AdminManager($this->database);
        $this->userManager = new UserManager($this->database);
        $this->postManager = new PostManager($this->database);
        $this->commentManager = new CommentManager($this->database);
        $this->view = new View();

        // Injection des dépendances
        $this->adminController = new AdminController($this->adminManager, $this->userManager, $this->postManager, $this->commentManager, $this->view);
        $this->postController = new PostController($this->postManager, $this->commentManager, $this->view);
        $this->commentController = new CommentController($this->postManager, $this->commentManager, $this->view);
        
        // En attendant de mettre en place la classe App\Service\Http\Request
        $this->get = $_GET;
        $this->post = $_POST;
    }

    public function run(): void
    {
        // Nous avons quatres routes
        // On teste si une action a été définie ? si oui alors on récupére l'action : sinon on mets une action par défaut (ici l'action home)
        $action = $this->get['action'] ?? 'home';

        // Déterminer sur quelle route nous sommes // Attention algorithme naïf
        if ($action === 'home') {
            // route http://localhost:8000/?action=home
            $this->postController->displayHomeWithTheLastThreePosts();
        } elseif ($action === 'detailOfPost' && isset($this->get['id'])) {
            // route http://localhost:8000/?action=detailOfPost&id=5
            $this->postController->displayDetailOfPost((int)$this->get['id']);
        } elseif ($action === 'listOfPosts') {
            // route http://localhost:8000/?action=listOfPosts
            $currentPage = isset($this->get['page']) ? (int) $this->get['page'] : 1;
            $this->postController->displayListOfPosts($currentPage);
        } elseif ($action === 'addComment' && isset($this->get['id'])) {
            // route http://localhost:8000/?action=addCommente&id=5
            $this->commentController->addComment((int)$this->get['id'], $this->post);
        } elseif ($action === 'reported' && isset($this->get['commentid'], $this->get['id'])) {
            // route http://localhost:8000/?action=reported&commentid=1&id=1
            $this->commentController->reported((int)$this->get['commentid'], (int)$this->get['id']);
        } elseif ($action === 'error' && isset($this->get['id'])) {
            // route http://localhost:8000/?action=error&id=5
            $this->commentController->error((int)$this->get['id']);
        } elseif ($action === 'login') {
            // route http://localhost:8000/?action=login
            $this->adminController->login($this->post);
        } elseif ($action === 'logout') {
            // route http://localhost:8000/?action=blogControlPanel
            $this->adminController->logout();
        } elseif ($action === 'blogControlPanel') {
            // route http://localhost:8000/?action=blogControlPanel
            $this->adminController->blogControlPanel();
        } elseif ($action === 'myProfile') {
            // route http://localhost:8000/?action=myProfile
            $this->adminController->myProfile();
        } elseif ($action === 'readEpisodes') {
            // route http://localhost:8000/?action=readEpisodes
            $currentPage = isset($this->get['page']) ? (int) $this->get['page'] : 1;
            $this->adminController->readEpisodes($currentPage);
        } elseif ($action === 'detailEpisode' && isset($this->get['id'])) {
            // route http://localhost:8000/?action=detailEpisode&id=5
            $this->adminController->detailEpisode((int)$this->get['id']);
        } elseif ($action === 'addEpisode') {
            // route http://localhost:8000/?action=addEpisode
            $this->adminController->addEpisode($this->post);
        } elseif ($action === 'draftEpisode') {
            // route http://localhost:8000/?action=draftEpisode
            $this->adminController->draftEpisode($this->post);
        } elseif ($action === 'publishEpisode') {
            // route http://localhost:8000/?action=publishEpisode
            $this->adminController->publishEpisode($this->post);
        } elseif ($action === 'editEpisode' && isset($this->get['id'])) {
            // route http://localhost:8000/?action=editEpisode&id=5
            $this->adminController->editEpisode((int)$this->get['id'], $this->post);
        } elseif ($action === 'deleteEpisode') {
            // route http://localhost:8000/?action=deleteEpisode&id=5
            $this->adminController->deleteEpisode((int)$this->get['id'], $this->post);
        } elseif ($action === 'readComments') {
            // route http://localhost:8000/?action=readComments
            $this->adminController->readComments();
        } elseif ($action === 'reportedComments') {
            // route http://localhost:8000/?action=reportedComments
            $this->adminController->reportedComments();
        } elseif ($action === 'approveComment' && isset($this->get['id'])) {
            // route http://localhost:8000/?action=approveComment&id=5
            $this->adminController->approveComment((int)$this->get['id']);
        } elseif ($action === 'addComment') {
            // route http://localhost:8000/?action=addComment
            $this->adminController->addComment($this->post);
        } elseif ($action === 'deleteComment') {
            // route http://localhost:8000/?action=deleteComment&id=5
            $this->adminController->deleteComment((int)$this->get['id'], $this->post);
        } else {
            echo "Error 404 - cette page n'existe pas<br><a href=http://localhost:8000/?action=home>Aller Ici</a>";
        }
    }
}
