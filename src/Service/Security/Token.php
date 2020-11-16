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

    public function __construct(Session $session, Request $request)
    {
        $this->session = $session;
    }

    public function generate(): string
    {
        //$token = 'toto';
        //$this->session->setToken($token);
        //return $token;
        
        $length = 64;
        $token = bin2hex(random_bytes($length));
        $this->session->setToken($token);
        //echo '<pre>';
        //var_dump($token);
        //die();
        //echo '</pre>';
        return $token;
    }

    public function verify(Request $request): bool
    {
        $tokenSession = $this->session->getToken();
        
        $token = $request['csrfToken'];

        echo '<pre>';
        var_dump($token, $tokenSession);
        die();
        echo '</pre>';

        return false;
    }
}
