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
    
    public function generate($name, $value): string
    {
        $this->session->setSession($name, $value);
        return $value;
    }

    public function set($name, $value): void
    {
        if (isset($_SESSION)) {
            $_SESSION[$name] = $value;
        }
    }

    public function get($name): ?array
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return null;
    }

    public function display($name, $value, $origin): void
    {
        $errorTab = [['errorName' => $name, 'errorValue' => $value]];

        $this->view->render(['template' => 'error', 'errortab' => $errorTab ], $origin);
    }

    public function show($name): ?array
    {
        if (isset($_SESSION[$name])) {
            $key = $this->get($name);
            $this->remove($name);
            return $key;
        }
    }

    public function remove($name): void
    {
        unset($_SESSION[$name]);
    }
}
