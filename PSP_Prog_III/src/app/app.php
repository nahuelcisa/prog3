<?php


use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

require_once __DIR__ . '/../poo/Usuarios.php';
require_once __DIR__ . '/../poo/cd.php';
require_once __DIR__ . '/../poo/Verificadora.php';
require __DIR__ . '/../../vendor/autoload.php';

$app = AppFactory::create();

$app->post('/login[/]',Verificadora::class . ':VerificarUsuario')->add(Verificadora::class . ':ValidarParametrosUsuario');
$app->get('/login/test',Verificadora::class . ':ObtenerDataJWT')->add(Verificadora::class . ':ChequearJWT');

$app->group('/jason_bd', function(RouteCollectorProxy $group){
    $group->get('/', cd::class . ':TraerTodos');
    $group->get('/{id}', cd::class . ':TraerUno');
    $group->post('/', cd::class . ':agregar')->add(Verificadora::class . ':ValidarParametrosCDAgregar');
    $group->put('/', cd::class . ':modificar')->add(Verificadora::class . ':ValidarParametrosCDModificar');
    $group->delete('/', cd::class . ':eliminar')->add(Verificadora::class . ':ValidarParametrosCDEliminar');
})->add(Verificadora::class . ':ChequearJWT');

$app->run();