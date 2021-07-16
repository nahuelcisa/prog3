<?php

    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Psr7\Response as ResponseMW;
    use Slim\Factory\AppFactory;
    use \Slim\Routing\RouteCollectorProxy;

    require __DIR__ . '../../vendor/autoload.php';
    require '../src/verificadora.php';
    require '../src/cd.php';

    $app = AppFactory::create();

    $app->get('/login/test',\Verificadora::class . ':ObtenerDataJWT')->add(\Verificadora::class . ':ChequearJWT');
    
    $app->post('/login[/]', \Verificadora::class . ':VerificarUsuario')->add(\Verificadora::class . ':ValidarParametrosUsuario');

    $app->group('/json_bd', function (RouteCollectorProxy $grupo){
        $grupo->get('/',\cd::class . ':TraerTodos');
        $grupo->get('/{id}',\cd::class . ':TraerUno');
        $grupo->post('/',\cd::class . ':Agregar')->add(\Verificadora::class . ':ValidarParametrosCDAgregar');
        $grupo->put('/',\cd::class . ':Modificar')->add(\Verificadora::class . ':ValidarParametrosCDModificar');
        $grupo->delete('/',\cd::class . ':Eliminar')->add(\Verificadora::class . ':ValidarParametrosCDBorrar');
    })->add(\Verificadora::class . ':ChequearJWT');

    $app->run();
?>