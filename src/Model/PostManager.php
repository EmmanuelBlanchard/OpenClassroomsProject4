<?php

declare(strict_types=1);

namespace App\Model;

use App\Service\Database;

class PostManager
{
    private $database;
    
    public function __construct(Database $database)
    {
        $this->database = $database->getPdo();
    }
    
    public function showAll() : ?array
    {
        $request= $this->database->prepare('SELECT id, title, introduction FROM episodes ORDER BY episode_created_the');
        $request->execute();
        return $request->fetchAll();
    }

    public function showAllEpisodes() : ?array
    {
        $request= $this->database->prepare('SELECT id, title, introduction FROM episodes ORDER BY episode_created_the');
        $request->execute();
        return $request->fetchAll();
    }

    public function showLastThreeEpisodes() : ?array
    {
        $request = $this->database->prepare('SELECT id, title, introduction, episode_created_the FROM episodes ORDER BY episode_created_the DESC LIMIT 0,3');
        $request->execute();
        return $request->fetchAll();
    }

    public function showOne(int $id) : ?array
    {
        //return $this->executeSqlDB($id);

        echo"<pre>";
        print_r($id);
        echo"</pre>";
        die();

        $request= $this->database->prepare('SELECT * FROM episodes WHERE id=:id');
        $request->execute(array(['id' => $id]));
        return $request->fetch();

    }

    public function findId(int $id) : ?array
    {
        $request= $this->database->prepare('SELECT * FROM episodes WHERE id=:id');
        //var_dump($request);
        //die();
        $request->execute(['id' => $id]);
        //var_dump($request);
        //die();
        return $request->fetchAll();
    }

    // Afficher les commentaires publiés à partir de l'id d'un episode
    public function showAllComment(int $id) : ?array
    {
        $request = $this->database->prepare('SELECT id, pseudo, comment, comment_created_the, episode_id FROM comments WHERE episode_id=:id ORDER BY comment_created_the DESC');
        $request->execute(array(['episode_id' => $id]));
        return $request->fetch();
    }

}
