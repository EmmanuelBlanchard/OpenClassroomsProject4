<?php

declare(strict_types=1);

namespace App\Service;

use App\Controller\Backoffice\AdminController;

// Class permettant de gérer la variable super globale $_SESSION
class Session
{
    public static function start(): void
    {
        session_start();
    }

    public static function set($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    public static function remove($key): void
    {
        unset($_SESSION[$key]);
    }
}
