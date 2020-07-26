<?php

declare(strict_types=1);

namespace App\Model;

class PostManager
{
    private function executeSqlDB(?int $id = null) : ?array
    {
        // *** exemple fictif d'accès à la base de données
        $data = null;
        $postTable = [];
        $postTable[1] = ['id' => 1, 'title' => 'Article $1 du blog', 'text' => 'Lorem ipsum 1'];
        $postTable[25] = ['id' => 25, 'title' => 'Article $25 du blog', 'text' => 'Lorem ipsum 25'];

        if ($id === null) {
            $data = $postTable;
        } elseif ($id !== null && array_key_exists($id, $postTable)) {
            $data = $postTable[$id];
        }

        return $data;
    }
    
    public function showAll(): ?array
    {
        // renvoie tous les posts
        return $this->executeSqlDB();
    }

    public function showOne(int $id): ?array
    {
        return $this->executeSqlDB($id);
    }
}
