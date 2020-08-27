<?php

declare(strict_types=1);

namespace  App\Controller\Frontoffice;

use App\Model\CommentManager;
use App\Model\PostManager;
use App\View\View;

class PostController
{
    private PostManager $postManager;
    private CommentManager $commentManager;
    private View $view;

    public function __construct(PostManager $postManager, CommentManager $commentManager, View $view)
    {
        $this->postManager = $postManager;
        $this->commentManager = $commentManager;
        $this->view = $view;
    }

    public function displayHomeWithTheLastThreeEpisodes(): void
    {
        $data = $this->postManager->showLastThreeEpisodes();
        /*
        echo"<pre>";
        print_r($data);
        echo"</pre>";
        die();*/

        if ($data !== null) {
            $this->view->render(['template' => 'home', 'allposts' => $data]);
        } elseif ($data === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }
    }

    public function displayListOfEpisodes(): void
    {
        $data = $this->postManager->showAllEpisodes();

        if ($data !== null) {
            $this->view->render(['template' => 'listofepisodes', 'allposts' => $data]);
        } elseif ($data === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }
    }
    
    public function displayDetailOfEpisode(int $postId): void
    {
        $data_episode = $this->postManager->getEpisode($postId);
        // $commentaires= $this->commentManager->findAllEpisode($id);
        $data_comments = $this->commentManager->getComments($postId);

        //echo"<pre>";
        //print_r($data_episode);
        //print_r($data_comments);
        //echo"</pre>";
        //die();

        if ($data_episode !== null) {
            $this->view->render(['template' => 'detailofepisode', 'episode' => $data_episode, 'allcomment' => $data_comments]);
        } elseif ($data_episode === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, il n\'y pas de post</h1><a href="index.php?action=home">Accueil</a><br>';
        }
    }

}
