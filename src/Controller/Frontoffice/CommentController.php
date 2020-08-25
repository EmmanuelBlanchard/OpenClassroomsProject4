<?php

declare(strict_types=1);

namespace App\Controller\Frontoffice;

use App\Model\CommentManager;
use App\Model\PostManager;
use App\View\View;

class CommentController
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

    public function addComment(int $id, string $comment, string $author): void
    {
        $data_episode = $this->postManager->findId($id);

        $data_comment = $this->commentManager->postComment($id, $comment, $author);

        echo"<pre>";
        //print_r($data_episode);
        print_r($data_comment);
        echo"</pre>";
        die();

        if ($data_comment !== null) {
            $this->view->render(['template' => 'detailofepisode', 'episode' => $data_episode, 'allcomment' => $data_comment]);
        } elseif ($data_comment === null) {
            echo '<h1>faire une redirection vers la page d\'erreur, Impossible d\'ajouter le commentaire !</h1><a href="index.php?action=home">Accueil</a><br>';
        }
    }

}