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
        $length = 64;
        $token = bin2hex(random_bytes($length));
        $this->session->setToken($token);
        
        return $token;
    }

    public function verify($token): bool
    {
        $tokenSession = $this->session->getToken();
        return $token === $tokenSession;
    }
}
