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
        return $token;
    }

    public function verify($token): bool
    {
        $tokenSession = $this->session->getToken();
        
        //$token = $_POST['csrfToken']; // Undefined index: csrfToken
        //$token = $this->generate();
        //echo '<pre>';
        //var_dump($token);
        //die();
        //echo '</pre>';
        return hash_equals($token, $tokenSession);
        //echo '<pre>';
        //var_dump($token, $tokenSession, hash_equals($token, $tokenSession));
        //die();
        //echo '</pre>';

        //return false;
    }

    public function generateTime(): int
    {
        $tokenTime = time();
        $this->session->setTokenTime($tokenTime);
        return $tokenTime;
    }
}
