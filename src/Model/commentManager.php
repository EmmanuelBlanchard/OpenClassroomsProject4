<?php

declare(strict_types=1);

namespace App\Model;

use App\Service\Database;

class CommentManager
{
    private $database;
    
    public function __construct(Database $database)
    {
        $this->database = $database->getPdo();
    }
    
    public function getComments(int $id) : ?array
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();
        
        $request = $this->database->prepare('SELECT id, author, comment, DATE_FORMAT(comment_created_the, \'%e %M %Y à %H:%i\') AS date_comment_created_the, episode_id FROM comments WHERE episode_id=:episode_id ORDER BY comment_created_the DESC');
        $request->execute(['episode_id' => $id]);
        return $request->fetchAll();
    }

    public function showAllComment(int $id) : ?array
    {
        $request = $this->database->prepare('SELECT id, author, comment, comment_created_the, episode_id FROM comments WHERE episode_id=:episode_id ORDER BY comment_created_the DESC');
        $request->execute(['episode_id' => $id]);
        return $request->fetch();
    }

    public function postComment(int $id, string $author, string $comment)
    {/*
        $request= $this->database->prepare('INSERT INTO comments (id, pseudo, author, comment, comment_created_the, episode_id) VALUES
        (id=:id, pseudo=:author, author=:author, comment=:comment, NOW(), episode_id=:id)');
        $request->execute(['id'=> $id, 'pseudo'=> $author, 'author' => $author, 'comment' => $comment, 'episode_id'=> $id]);
        return $request;*/

        $request= $this->database->prepare('INSERT INTO comments (id, pseudo, author, comment, comment_created_the, episode_id) VALUES
        (:id, :pseudo, :author, :comment, NOW(), :episode_id)');
        $request->execute(array(
            'id' => $id,
            'pseudo' => $author,
            'author' => $author,
            'comment' => $comment,
            'comment_created_the' => '',
            'episode_id' => $id
            ));
        /*
        <?php
        $req = $bdd->prepare('INSERT INTO jeux_video(nom, possesseur, console, prix, nbre_joueurs_max, commentaires) VALUES(:nom, :possesseur, :console, :prix, :nbre_joueurs_max, :commentaires)');
        $req->execute(array(
            'nom' => $nom,
            'possesseur' => $possesseur,
            'console' => $console,
            'prix' => $prix,
            'nbre_joueurs_max' => $nbre_joueurs_max,
            'commentaires' => $commentaires
            ));

        echo 'Le jeu a bien été ajouté !';
        ?>

        <?php
        $req = $bdd->prepare('UPDATE jeux_video SET prix = :nvprix, nbre_joueurs_max = :nv_nb_joueurs WHERE nom = :nom_jeu');
        $req->execute(array(
            'nvprix' => $nvprix,
            'nv_nb_joueurs' => $nv_nb_joueurs,
            'nom_jeu' => $nom_jeu
            ));
        ?>
        */

    }

}
