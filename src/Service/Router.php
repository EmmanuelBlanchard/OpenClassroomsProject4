<?php

declare(strict_types=1);

namespace  App\Service;

use App\Controller\Frontoffice\PostController;
use App\Controller\Frontoffice\CommentController;
use App\Model\CommentManager;
use App\Model\PostManager;
use App\Service\Database;
use App\View\View;

// Cette classe router est un exemple très basique. Cette façon de faire n'est pas optimale
class Router
{
    private Database $database;
    private PostManager $postManager;
    private CommentManager $commentManager;
    private View $view;
    private PostController $postController;
    private CommentController $commentController;
    private array $get;
    private array $post;

    public function __construct()
    {
        // Dépendances
        $this->database = new Database();
        $this->postManager = new PostManager($this->database);
        $this->commentManager = new CommentManager($this->database);
        $this->view = new View();

        // Injection des dépendances
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
            if(isset($this->get['page']) && intval($this->get['page']))
            {
                    $page = intval($this->get['page']);
                    $this->postController->displayDetailOfPost((int)$this->get['id'], $page);
            } else {
                    $page = 1;
                    $this->postController->displayDetailOfPost((int)$this->get['id'], $page);
            }
        } elseif ($action === 'listOfPosts') {
            // route http://localhost:8000/?action=listOfPosts
            if(isset($this->get['page']) && intval($this->get['page']))
            {
                $currentPage = intval($this->get['page']);
                $this->postController->displayListOfPosts($currentPage);
            } else {
                $currentPage=1;
                $this->postController->displayListOfPosts($currentPage);
            }
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
            $this->postController->displayLogin();   
        } else {
            echo "Error 404 - cette page n'existe pas<br><a href=http://localhost:8000/?action=home>Aller Ici</a>";
        }
    }
}
