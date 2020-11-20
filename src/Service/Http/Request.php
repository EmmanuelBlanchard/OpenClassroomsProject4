<?php

declare(strict_types=1);

namespace App\Service\Http;

use App\Controller\Backoffice\AdminController;

// class permettant la gestion des variables supers globales de php sauf $_SESSION
class Request
{
    private array $get;
    private array $post;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
    }

    /**
     * @return mixed
     */
    public function getGet(): ?array
    {
        return $this->get;
    }

    /**
     * @return mixed
     */
    public function getPost(): ?array
    {
        return $this->post;
    }
}
