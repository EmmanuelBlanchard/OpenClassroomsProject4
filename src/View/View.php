<?php

declare(strict_types=1);

namespace App\View;

class View
{
    public function render(array $data): void
    {
        ob_start();
        require_once '..\templates\frontoffice\post.html.php';
        $content = ob_get_clean();
        require_once '..\templates\frontoffice\layout.html.php';
    }
}
