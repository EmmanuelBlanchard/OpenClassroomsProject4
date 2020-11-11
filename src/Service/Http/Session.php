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

    public function displaySession(): void
    {
        if (isset($_SESSION['erreur'])) {
            echo '<div class="alert alert-danger" role="alert"> '. $_SESSION['erreur'] . '</div>';
            unset($_SESSION['erreur']);
        } elseif (isset($_SESSION['message'])) {
            echo '<div class="alert alert-success" role="alert">'. $_SESSION['message'] . '</div>';
            unset($_SESSION['message']);
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
        $this->setSession('message', 'Vous êtes maintenant déconnecté !');
        $this->setSession('login', false);
        //echo '<pre>';
        //var_dump($_SESSION);
        //die();
        //echo '</pre>';
    }
}
