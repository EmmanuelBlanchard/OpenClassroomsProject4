<?php

declare(strict_types=1);

namespace App\Model;

use App\Service\Database;

class AdminManager
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database->getPdo();
    }

    public function showAllPosts(): ?array
    {
        $request = $this->database->prepare('SET lc_time_names = \'fr_FR\';');
        $request->execute();

        $request = $this->database->prepare('SELECT id, chapter, title, introduction, CONCAT_WS(\' \', \'le\', DAYNAME(post_date), DAY(post_date), MONTHNAME(post_date), YEAR(post_date)) AS post_date_fr FROM Posts ORDER BY post_date');
        $request->execute();
        return $request->fetchAll();
    }
    
    public function showAllComment(): ?array
    {
        $request = $this->database->prepare('SELECT id, pseudo, comment, comment_date, post_id FROM Comments ORDER BY comment_date DESC');
        $request->execute();
        return $request->fetchAll();
    }
}
