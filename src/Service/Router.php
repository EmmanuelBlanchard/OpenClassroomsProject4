<?php

declare(strict_types=1);

namespace  App\Service;

use App\Service\Database;
use App\Controller\Frontoffice\PostController;
use App\Model\PostManager;
use App\View\View;

// Cette classe router est un exemple très basique. Cette façon de faire n'est pas optimale
class Router
{
    private Database $database;
    private PostManager $postManager;
    private View $view;
    private PostController $postController;
    private array $get;

    public function __construct()
    {
        // Dépendances
        $this->database = new Database();
        $this->postManager = new PostManager($this->database);
        $this->view = new View();

        // Injection des dépendances
        $this->postController = new PostController($this->postManager, $this->view);

        // En attendant de mettre en place la classe App\Service\Http\Request
        $this->get = $_GET;
    }

    public function run(): void
    {
        // Nous avons deux routes :
        // - une pour afficher tous les posts => http://localhost:8000/?action=posts
        // - une pour afficher un post en particulier => http://localhost:8000/?action=post&id=5
        
        //On test si une action a été définie ? si oui alors on récupére l'action : sinon on mets une action par défaut (ici l'action posts)
        $action = isset($this->get['action']) ? $this->get['action'] : 'posts';

        //Déterminer sur quelle route nous sommes // Attention algorithme naïf
        if ($action === 'home') {
            // route http://localhost:8000/?action=home
            $this->postController->displayAllAction();
        } elseif ($action === 'posts') {
            // route http://localhost:8000/?action=posts
            $this->postController->displayAllAction();
        } elseif ($action === 'post' && isset($this->get['id'])) {
            // route http://localhost:8000/?action=post&id=5
            $this->postController->displayOneAction((int)$this->get['id']);
        } elseif ($action === 'listofepisodes') {
            // route http://localhost:8000/?action=listofepisodes
            $this->postController->displayListOfEpisodes();
        } else {
            echo "Error 404 - cette page n'existe pas<br><a href=http://localhost:8000/?action=posts>Aller Ici</a>";
        }
    }
}
