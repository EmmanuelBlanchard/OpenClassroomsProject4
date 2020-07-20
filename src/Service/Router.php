<?php

declare(strict_types=1);

namespace  App\Service;

use App\Controller\Frontoffice\PostController;
use App\Model\PostManager;
use App\View\View;

// cette classe router est un exemple très basic. Cette façon de faire n'est pas optimale
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

        // En attendant de mettre en place la class App\Service\Http\Request
        $this->get = $_GET;
    }

    public function run(): void
    {
        $action = isset($this->get['action']) && isset($this->get['id']) && $this->get['action'] === 'post';

        if ($action) {
            // route http://localhost:8000/?action=post&id=5
            $this->postController->displayOneAction((int)$this->get['id']);
        } elseif (!$action) {
            // faire un controller pour la gestion d'erreur
            echo "Error 404 - cette page n'existe pas<br><a href=http://localhost:8000/?action=post&id=5>Aller Ici</a>";
        }
    }
}
