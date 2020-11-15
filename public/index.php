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

//$token = new Token(64, 32, $session);

//$csrf = $token->getToken();

/************************* */
//session_start();
//$token = uniqid(rand(), true);
//$token = random_bytes(64);

$token = new Token(64,32);
//$token->generateToken();
//$token($this->generateToken());

echo '<pre>';
//var_dump($_SESSION['token'], $_POST['token']);
var_dump($_SESSION['CSRF']);
die();
echo '</pre>';
 
$_SESSION['token'] = $token;
 

//echo '<pre>';
//var_dump($session, $token, $csrf);
//die();
//echo '</pre>';

$router = new Router();
$router->run();