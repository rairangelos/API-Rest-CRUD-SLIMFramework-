<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/db.php';

$app = new \Slim\App;

$app->get('/', function ($request, $response) {

    $name = $request->getAttribute('name');

    $response->getBody()->write("Hello, $name");

    return $response;
});

//Rotas USUARIOS
require '../src/routes/usuarios.php';

$app->run();
?>