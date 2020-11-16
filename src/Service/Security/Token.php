<?php

declare(strict_types=1);

namespace App\Service\Security;

use App\Controller\Backoffice\AdminController;
use App\Service\Http\Request;
use App\Service\Http\Session;

class Token
{
    private Session $session;
    private Request $request;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function generate(): string
    {
        $token = 'toto';
        $this->session->setToken($token);
        return $token;
    }

    public function verify(): bool
    {
        $tokenSession = $this->session->getToken();
        return false;
    }
}
