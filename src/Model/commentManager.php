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
    
    public function findAllEpisode(int $id): ?array
    {
        $request= $this->database->prepare('SELECT * FROM comments WHERE episode_id=:id');
        $request->execute(['id'=> $id]);
        return $request->fetch();
    }

}


