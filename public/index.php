<?php

declare(strict_types=1);
require_once '../vendor/autoload.php';

use App\Service\Router;
use App\Service\Http\Session;

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$session = new Session();

$router = new Router();
$router->run();