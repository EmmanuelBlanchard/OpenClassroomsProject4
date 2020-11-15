<?php

declare(strict_types=1);
require_once '../vendor/autoload.php';

use App\Service\Router;
use App\Service\Http\Session;
use App\Service\Security\Token;

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$session = new Session();

$token = new Token(64, 32);

//echo '<pre>';
//var_dump($session, $token);
//die();
//echo '</pre>';

$router = new Router();
$router->run();