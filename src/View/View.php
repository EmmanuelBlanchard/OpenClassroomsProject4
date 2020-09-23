<?php

declare(strict_types=1);

namespace App\View;

class View
{
    public function render(array $data): void
    {
        //echo"<pre>";
        //print_r($data);
        //echo"</pre>";
        //die();
        ob_start();
        require_once "..\\templates\\frontoffice\\${data['template']}.html.php";
        $content = ob_get_clean();
        require_once '..\templates\frontoffice\layout.html.php';
    }

    public function renderBack(array $data): void
    {
        //echo"<pre>";
        //print_r($data);
        //echo"</pre>";
        //die();
        ob_start();
        require_once "..\\templates\\backoffice\\${data['template']}.html.php";
        $content = ob_get_clean();
        require_once '..\templates\backoffice\layout.html.php';
    }


}
