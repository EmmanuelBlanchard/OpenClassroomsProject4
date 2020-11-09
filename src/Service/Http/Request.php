<?php

declare(strict_types=1);
// class permettant la gestion des variables supers globales de php sauf $_SESSION
class Request
{
    private $get;
    private $post;
    private $session;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->session = $_SESSION;
    }

    /**
     * @return mixed
     */
    public function getGet()
    {
        return $this->get;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        return $this->session;
    }
}