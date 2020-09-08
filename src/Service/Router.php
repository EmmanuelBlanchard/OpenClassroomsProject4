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
        } elseif ($action === 'detailofpost' && isset($this->get['id'])) {
            // route http://localhost:8000/?action=detailofpost&id=5
            $this->postController->displayDetailOfPost((int)$this->get['id']);
        } elseif ($action === 'testpagination') {
            // route http://localhost:8000/?action=testpagination
            $this->postController->paginationListOfPosts();
        } elseif ($action === 'testpaginationid' && isset($this->get['id'])) {
            // route http://localhost:8000/?action=testpaginationid&id=5
            $this->postController->paginationDetailOfPost((int)$this->get['id']);
        } elseif ($action === 'listofposts') {
            // route http://localhost:8000/?action=listofposts
            $this->postController->displayListOfPosts();
        } elseif ($action === 'addComment' && isset($this->get['id'])) {
            // route http://localhost:8000/?action=addCommente&id=5
            $this->commentController->addComment((int)$this->get['id'], $this->post);
        } elseif ($action === 'report' && isset($this->get['commentid'], $this->get['id'])) {
            // route http://localhost:8000/?action=report&commentid=1&id=1
            $this->commentController->report((int)$this->get['commentid'], (int)$this->get['id']);
        } elseif ($action === 'error' && isset($this->get['id'])) {
            // route http://localhost:8000/?action=error&id=5
            $this->commentController->error((int)$this->get['id']);
        } elseif ($action === 'postfront') {
            // route http://localhost:8000/?action=postfront
            if (isset($this->get['id'])) 
            {
                if(isset($this->get['page']) && intval($this->get['page']))
                {
                    $page = intval($this->get['page']);
                    $limit = 10;
                    $start = ($this->get['page']-1)*$limit;
                    $PostAndComments = $this->postController->Post((int)$this->get['id'], $start, $limit, $page);
                } else {
                    $page = 1;
                    $limit = 10;
                    $start = ($page-1)*$limit;
                    $PostAndComments = $this->postController->Post((int)$this->get['id'], $start, $limit, $page);
                }
            } else {
                echo "l\'id du post n\'est pas trouvable <a href=http://localhost:8000/?action=home>Aller Ici</a>";
            }
        } elseif ($action === "page") {
            // route http://localhost:8000/?action=page
            if(isset($this->get['page']) && !empty($this->get['page'])){
                $currentPage = (int) strip_tags($this->get['page']);
                $this->postController->paginationDetailOfPost($currentPage);
            }else{
                $currentPage = 1;
                $this->postController->paginationDetailOfPost($currentPage);
            }
        } else {
            echo "Error 404 - cette page n'existe pas<br><a href=http://localhost:8000/?action=home>Aller Ici</a>";
        }
    }
}
