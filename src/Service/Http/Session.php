<?php

declare(strict_types=1);

namespace App\Service;

use App\Controller\Backoffice\AdminController;

// Class permettant de gérer la variable super globale $_SESSION
class Session {

    static public function start() {
        session_start();
    }

    static public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    static public function get($key) {
        if (isset($_SESSION[$key]))
            return $_SESSION[$key];
    }

    static public function remove($key) {
        unset($_SESSION[$key]);
    }
}