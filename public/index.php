<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require __DIR__ . '/../vendor/autoload.php';
require '../src/config/db.php';

$app = new \Slim\App;

// Route clients
require '../src/routes/clients.php';



$app->run();
