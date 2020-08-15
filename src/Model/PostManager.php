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
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();

        $request = $this->database->prepare('SELECT id, title, introduction, CONCAT_WS(\' \', \'le\', DAYNAME(episode_created_the), DAY(episode_created_the), MONTHNAME(episode_created_the), YEAR(episode_created_the)) AS date_episode_created_the FROM episodes ORDER BY episode_created_the');
        $request->execute();
        return $request->fetchAll();
    }

    public function showLastThreeEpisodes() : ?array
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();
        
        /*$request = $this->database->prepare('SELECT id, title, introduction, DAY(episode_created_the) AS day_episode_created_the, MONTHNAME(episode_created_the) AS name_month_episode_created_the, YEAR(episode_created_the) AS year_episode_created_the, HOUR(episode_created_the) AS hour_episode_created_the, MINUTE(episode_created_the) AS minute_episode_created_the, SECOND(episode_created_the) AS second_episode_created_the FROM episodes ORDER BY episode_created_the DESC LIMIT 0,3'); */
        $request = $this->database->prepare('SELECT id, title, introduction, CONCAT_WS(\' \', \'le\', DAYNAME(episode_created_the), DAY(episode_created_the), MONTHNAME(episode_created_the), YEAR(episode_created_the)) AS date_episode_created_the FROM episodes ORDER BY episode_created_the DESC LIMIT 0,3');
        $request->execute();
        return $request->fetchAll();
    }

    public function showOne(int $id) : ?array
    {
        $request= $this->database->prepare('SELECT * FROM episodes WHERE id=:id');
        $request->execute([['id' => $id]]);
        return $request->fetch();
    }

    public function findId(int $id) : ?array
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();

        /*$request= $this->database->prepare('SELECT * FROM episodes WHERE id=:id');*/
        $request = $this->database->prepare('SELECT id, title, content, CONCAT_WS(\' \', \'le\', DAYNAME(episode_created_the), DAY(episode_created_the), MONTHNAME(episode_created_the), YEAR(episode_created_the)) AS date_episode_created_the FROM episodes WHERE id=:id');
        $request->execute(['id' => $id]);
        return $request->fetch();
    }

    // Afficher les commentaires publiés à partir de l'id d'un episode
    public function showAllComment(int $id) : ?array
    {
        $request = $this->database->prepare('SELECT id, author, comment, comment_created_the, episode_id FROM comments WHERE episode_id=:episode_id ORDER BY comment_created_the DESC');
        $request->execute(['episode_id' => $id]);
        return $request->fetch();
    }
}
