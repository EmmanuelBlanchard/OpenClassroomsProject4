<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\Http\Session;
use App\View\View;

class Error
{
    private Session $session;
    private View $view;

    public function __construct(Session $session, View $view)
    {
        $this->session = $session;
        $this->view = $view;
    }
    
    public function generate($typeMessage, $message): string
    {
        $this->session->setSessionMessage($typeMessage, $message);
        return $message;
    }

    public function set($typeMessage, $message): void
    {
        if (isset($_SESSION)) {
            $_SESSION[$typeMessage] = $message;
        }
    }

    public function get($typeMessage): ?array
    {
        if (isset($_SESSION[$typeMessage])) {
            return $_SESSION[$typeMessage];
        }
        return null;
    }

    public function display($typeMessage, $message, $origin): void
    {
        $errorTab = [['errorName' => $typeMessage, 'errorValue' => $message]];

        $this->view->render(['template' => 'error', 'errortab' => $errorTab ], $origin);
    }

    public function show($typeMessage): ?array
    {
        if (isset($_SESSION[$typeMessage])) {
            $key = $this->get($typeMessage);
            $this->remove($typeMessage);
            return $key;
        }
    }

    public function remove($typeMessage): void
    {
        unset($_SESSION[$typeMessage]);
    }
}
