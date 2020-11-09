<?php

declare(strict_types=1);

namespace App\Service\Http;

use App\Controller\Backoffice\AdminController;

// Class permettant de gérer la variable super globale $_SESSION
class Session
{
    private $session;

    public function __construct()
    {
        if (isset($_SESSION)) {
            session_start();
        }
    }

    public function startSession(): void
    {
        session_start();
    }

    public function setSession($name, $value): void
    {
        if (isset($_SESSION)) {
            $_SESSION[$name] = $value;
        }
    }

    public function getSession($name): ?array
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return null;
    }

    public function showSession($name): ?array
    {
        if (isset($_SESSION[$name])) {
            $key = $this->getSession($name);
            $this->removeSession($name);
            return $key;
        }
    }

    public function removeSession($name): void
    {
        unset($_SESSION[$name]);
    }

    public function stopSession(): void
    {
        $_SESSION = [];
        session_destroy();
        //echo '<pre>';
        //var_dump($_SESSION);
        //die();
        //echo '</pre>';
        $_SESSION['message'] = "Vous êtes maintenant déconnecté !";
        $_SESSION['login'] = false;
        //echo '<pre>';
        //var_dump($_SESSION);
        //die();
        //echo '</pre>';
    }
}
