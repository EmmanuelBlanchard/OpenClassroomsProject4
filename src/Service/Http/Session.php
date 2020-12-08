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

    public function setLogin(string $typeMessage, bool $value): void
    {
        if (isset($_SESSION)) {
            $_SESSION[$typeMessage] = $value;
        }
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

    public function setSessionMessage(string $typeMessage, string $message): void
    {
        if (isset($_SESSION[$typeMessage])) {
            $_SESSION[$typeMessage] = $message;
        }
    }

    public function getSessionMessage(string $typeMessage): ?string
    {
        if (isset($_SESSION[$typeMessage])) {
            $sessionMessage = $_SESSION[$typeMessage];
            unset($_SESSION[$typeMessage]);
            return $sessionMessage;
        }
        return null;
    }

    public function showSession($typeMessage): ?array
    {
        if (isset($_SESSION[$typeMessage])) {
            $key = $this->getSessionMessage($typeMessage);
            $this->removeSession($typeMessage);
            return $key;
        }
    }

    public function removeSession($typeMessage): void
    {
        unset($_SESSION[$typeMessage]);
    }

    public function stopSession(): void
    {
        $_SESSION = [];
        session_destroy();
        $this->setSessionMessage('message', 'Vous êtes maintenant déconnecté !');
        //$this->setLogin('login', false);
        $this->session->setSession('login', false);
    }
}
