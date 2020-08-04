<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\Model\PostManager;
use App\Model\CommentManager;
use App\View\View;

class PostController
{
    private PostManager $postManager;
    private CommentManager $commentManager;
    private View $view;

    public function __construct(PostManager $postManager,CommentManager $commentManager, View $view)
    {
        $this->postManager = $postManager;
        $this->commentManager = $commentManager;
        $this->view = $view;
    }

    public function displayOneAction(int $id): void
    {
        $data = $this->postManager->showOne($id);

        if ($data !== null) {
            $this->view->render(['template' => 'post','onepost' => $data]);
        } elseif ($data === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, ce post n\'existe pas</h1><a href="index.php?action=home">Accueil</a><br>';
        }
    }

    public function displayAllAction(): void
    {
        $data = $this->postManager->showAll();

        if ($data !== null) {
            $this->view->render(['template' => 'posts', 'allposts' => $data]);
        } elseif ($data === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }
    }

    public function displayHomeWithTheLastThreeEpisodes(): void
    {
        $data = $this->postManager->showLastThreeEpisodes();
        //var_dump($threeEpisodes);
        echo implode(' ', $data);
        var_dump($data);
        die();
        if ($data !== null) {
            $this->view->render(['template' => 'home', 'threeEpisodes' => $data]);
        } elseif ($data === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }
    }

    public function displayListOfEpisodes(): void
    {
        $data = $this->postManager->showAll();

        echo implode(' ', $data);
        var_dump($data);
        die();

        if ($data !== null) {
            $this->view->render(['template' => 'listofepisodes', 'allposts' => $data]);
        } elseif ($data === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }
    }
    
    public function displayDetailOfEpisode(int $id): void
    {
        $episode = $this->postManager->findId($id);
        $commentaires= $this->commentManager->findAllEpisode($id);

        echo implode(' ', $episode);
        var_dump($episode);
        //var_dump($commentaires);
        die();
        if ($episode !== null) {
            $this->view->render(['template' => 'detailofepisodes', 'episode' => $episode, 'allcomments' => $commentaires]);
        } elseif ($episode === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }
    }
}
