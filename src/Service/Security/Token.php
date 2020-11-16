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
        // d6c7b731fff6e79e08ba63e84573e005891380b732a5f5f79210368e2a4f8ed881839de9654bc9be42bcb6747a009bdeaf7ef956f11b0fa193d5279fc57fddfb
        return $token;
    }

    public function verify(): bool
    {
        $tokenSession = $this->session->getToken();
        
        echo '<pre>';
        var_dump($tokenSession);
        die();
        echo '</pre>';

        return false;
    }
}
