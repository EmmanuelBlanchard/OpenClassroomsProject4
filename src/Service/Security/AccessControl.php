<?php

declare(strict_types=1);

namespace App\Service\Security;

use App\Service\Http\Session;

// Class permettant de gérer les contrôles d'accès aux pages en fonction du rôle ou de la connection au compte de l'utilisateur
class AccessControl
{
    private Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function isAuthorized(): bool
    {
        if ($this->session->getLogin() === true) {
            return true;
        }
        return false;
    }
}
