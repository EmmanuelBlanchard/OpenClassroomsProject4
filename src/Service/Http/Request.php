<?php

declare(strict_types=1);

namespace App\Service\Http;

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

    public function getGetItem(string $key): ?string
    {
        if (!isset($this->get[$key])) {
            return null;
        }
        return $this->get[$key];
    }

    public function getPostItem(string $key): ?string
    {
        if (!isset($this->post[$key])) {
            return null;
        }
        return $this->post[$key];
    }
}
