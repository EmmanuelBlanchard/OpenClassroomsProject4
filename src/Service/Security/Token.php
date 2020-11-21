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
        //var_dump("Affichage des token, le token du formulaire : " .$token . " et le token de session : ", $tokenSession);
        //die();
        // http://localhost:8000/index.php?action=addComment&id=36
        // string(72) "Affichage des token, le token du formulaire : et le token de session : " string(128) "25294818439e21525ac95e670c24f47034593b26cc679efcd202b61f470c2acdeca2901c586e23f81443f4a7a98a6c42e3192482578764ae4a3b5f15fd0ab6dd"
        return $token === $tokenSession;
    }
}
