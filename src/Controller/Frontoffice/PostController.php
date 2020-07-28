<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\Model\PostManager;
use App\View\View;

class PostController
{
    private PostManager $postManager;
    private View $view;

    public function __construct(PostManager $postManager, View $view)
    {
        $this->postManager = $postManager;
        $this->view = $view;
    }

    public function displayOneAction(int $id): void
    {
        $data = $this->postManager->showOne($id);

        if ($data !== null) {
            $this->view->render(['template' => 'post','onepost' => $data]);
        } elseif ($data === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, ce post n\'existe pas</h1><a href="index.php?action=posts">Liste des posts</a><br>';
        }
    }

    public function displayAllAction(): void
    {
        $data = $this->postManager->showAll();

        if ($data !== null) {
            $this->view->render(['template' => 'posts', 'allposts' => $data]);
        } elseif ($data === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1>';
        }
    }

    public function displayListOfEpisodes(): void
    {
        $data = $this->postManager->showAll();

        if ($data !== null) {
            $this->view->render(['template' => 'lisofepisodes', 'allposts' => $data]);
        } elseif ($data === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1>';
        }
    }
}
