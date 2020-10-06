<?php

declare(strict_types=1);

namespace  App\Service;

use App\Controller\Backoffice\AdminController;
use App\Controller\Frontoffice\PostController;
use App\Controller\Frontoffice\CommentController;
use App\Model\AdminManager;
use App\Model\CommentManager;
use App\Model\PostManager;
use App\Service\Database;
use App\View\View;

// Cette classe router est un exemple très basique. Cette façon de faire n'est pas optimale
class Router
{
    private Database $database;
    private AdminManager $adminManager;
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
        $this->postManager = new PostManager($this->database);
        $this->commentManager = new CommentManager($this->database);
        $this->view = new View();

        // Injection des dépendances
        $this->adminController = new AdminController($this->adminManager, $this->view);
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
        $action = isset($this->get['action']) ? $this->get['action'] : 'home';

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
        } elseif ($action === 'report' && isset($this->get['commentid'], $this->get['id'])) {
            // route http://localhost:8000/?action=report&commentid=1&id=1
            $this->commentController->report((int)$this->get['commentid'], (int)$this->get['id']);
        } elseif ($action === 'error' && isset($this->get['id'])) {
            // route http://localhost:8000/?action=error&id=5
            $this->commentController->error((int)$this->get['id']);     
        } elseif ($action === 'login') {
            // route http://localhost:8000/?action=login
            $this->adminController->login($this->post);
        } elseif ($action === 'blogControlPanel') {
            // route http://localhost:8000/?action=blogControlPanel
            $this->adminController->blogControlPanel(); 
        } elseif ($action === 'blogControlPanelMyProfile') {
            // route http://localhost:8000/?action=blogControlPanelMyProfile
            $this->adminController->blogControlPanelMyProfile();
        } elseif ($action === 'blogControlPanelListOfEpisodes') {
            // route http://localhost:8000/?action=blogControlPanelListOfEpisodes
            $this->adminController->blogControlPanelListOfEpisodes();
        } elseif ($action === 'blogControlPanelCreateOfEpisode') {
            // route http://localhost:8000/?action=blogControlPanelCreateOfEpisode
            $this->adminController->blogControlPanelCreateOfEpisode();
        } elseif ($action === 'blogControlPanelComments') {
            // route http://localhost:8000/?action=blogControlPanelComments
            $this->adminController->blogControlPanelComments();
        } else {
            echo "Error 404 - cette page n'existe pas<br><a href=http://localhost:8000/?action=home>Aller Ici</a>";
        }
    }
}
