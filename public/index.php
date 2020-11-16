<?php

declare(strict_types=1);
require_once '../vendor/autoload.php';

use App\Service\Router;
use App\Service\Http\Request;
use App\Service\Http\Session;
use App\Service\Security\Token;

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$session = new Session();

$token = new Token($session, $request);
$token->generate();

//echo '<pre>';
//var_dump($token);
//var_dump($_SESSION['csrfToken']);
//die();
//echo '</pre>';

$router = new Router();
$router->run();