<?php

declare(strict_types=1);

namespace  App\Service;

use App\Controller\Frontoffice\PostController;
use App\Model\PostManager;
use App\View\View;

// Cette classe router est un exemple très basique. Cette façon de faire n'est pas optimale
class Router
{
    private PostManager $postManager;
    private View $view;
    private PostController $postController;
    private array $get;

    public function __construct()
    {
        // Dépendances
        $this->postManager = new PostManager();
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
        if ($action === 'posts') {
            // route http://localhost:8000/?action=posts
            $this->postController->displayAllAction();
        } elseif ($action === 'post' && isset($this->get['id'])) {
            // route http://localhost:8000/?action=post&id=5
            $this->postController->displayOneAction((int)$this->get['id']);
        } else {
            echo "Error 404 - cette page n'existe pas<br><a href=http://localhost:8000/?action=posts>Aller Ici</a>";
        }
    }
}
