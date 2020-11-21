<?php

declare(strict_types=1);

namespace App\Service\Http;

use App\Controller\Backoffice\AdminController;

// Class permettant de gérer la variable super globale $_SESSION
class Session
{
    private Session $session;

    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        //var_dump($_SESSION);
        //die();
        // http://localhost:8000/index.php?action=addComment&id=36
        // array(1) { ["csrfToken"]=> string(128) "25294818439e21525ac95e670c24f47034593b26cc679efcd202b61f470c2acdeca2901c586e23f81443f4a7a98a6c42e3192482578764ae4a3b5f15fd0ab6dd" }
    }
    
    public function getToken(): string
    {
        return $_SESSION['csrfToken'];
    }

    public function setToken(string $hash): void
    {
        if (!isset($_SESSION['csrfToken'])) {
            $_SESSION['csrfToken'] = $hash;
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
