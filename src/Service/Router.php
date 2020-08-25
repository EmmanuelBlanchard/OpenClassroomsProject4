<?php

declare(strict_types=1);

namespace  App\Service;

use App\Controller\Frontoffice\PostController;
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
    private array $get;

    public function __construct()
    {
        // Dépendances
        $this->database = new Database();
        $this->postManager = new PostManager($this->database);
        $this->commentManager = new CommentManager($this->database);
        $this->view = new View();

        // Injection des dépendances
        $this->postController = new PostController($this->postManager, $this->commentManager, $this->view);

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
            $this->postController->displayHomeWithTheLastThreeEpisodes();
        } elseif ($action === 'detailofepisode' && isset($this->get['id'])) {
            // route http://localhost:8000/?action=detailofepisode&id=5
            $this->postController->displayDetailOfEpisode((int)$this->get['id']);
        } elseif ($action === 'listofepisodes') {
            // route http://localhost:8000/?action=listofepisodes
            $this->postController->displayListOfEpisodes();
        } elseif ($action === 'addComment' && isset($this->get['id'])) {
            // route http://localhost:8000/?action=addCommente&id=5
            if (!empty($this->post['author']) && !empty($this->post['comment'])) {
                $this->commentController->addComment((int)$this->get['id'], (string)$this->post['author'], (string)$this->post['comment']);
            } else {
                echo "Erreur : tous les champs ne sont pas remplis !<br><a href=http://localhost:8000/?action=home>Aller Ici</a>";
            }
        } else {
            echo "Error 404 - cette page n'existe pas<br><a href=http://localhost:8000/?action=home>Aller Ici</a>";
        }
    }
}
