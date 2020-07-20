<?php

declare(strict_types=1);

namespace App\Model;

class PostManager
{
    public function showOne(int $id): ?array
    {
        // *** exemple fictif d'accès à la base de données
        if ($id > 600) {
            return null;
        }

        return ['id' => $id, 'title' => 'Article '. $id .' du blog', 'text' => 'Lorem ipsum'];
    }
}
