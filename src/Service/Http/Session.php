<?php

declare(strict_types=1);

namespace App\Service\Http;

// Class permettant de gérer la variable super globale $_SESSION
class Session
{
    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }
    
    public function startSession(): void
    {
        session_start();
    }
 
    public function getToken(): string
    {
        return $_SESSION['csrfToken'];
    }

    public function setToken(string $hash): void
    {
        $_SESSION['csrfToken'] = $hash;
    }

    public function getLogin(): bool
    {
        if (isset($_SESSION['login'])) {
            return $_SESSION['login'];
        }
        return false;
    }

    public function setSession($name, $value): void
    {
        if (isset($_SESSION)) {
            $_SESSION[$name] = $value;
        }
    }

    public function getSession($name): ?string
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return null;
    }

    public function setSessionMessage(string $typeMessage, string $message)
    {
        if (isset($_SESSION)) {
            return $_SESSION[$typeMessage] = $message;
        }
    }

    public function getSessionMessage(string $typeMessage)
    {
        $sessionMessage = $_SESSION[$typeMessage];
        unset($sessionMessage);
        return $sessionMessage;
        //unset($_SESSION[$typeMessage]);
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
