<?php

    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Psr7\Response as ResponseMW;
    use Slim\Factory\AppFactory;
    use \Slim\Routing\RouteCollectorProxy;

    use Slim\Views\Twig;
    use Slim\Views\TwigMiddleware;

    require __DIR__ . '../../vendor/autoload.php';
    require '../src/poo/Usuario.php';
    require '../src/poo/Auto.php';
    require '../src/poo/mw.php';

  
    $app = AppFactory::create();

    $twig = Twig::create('../src/views', ['cache' => false]);

    $app->add(TwigMiddleware::create($app, $twig));


    $app->post('/usuarios',\Usuario::class . ':AltaUsuario')->add(\MW::class . '::VerificarExistenciaCorreoBD')->add(
    \MW::class . '::ValidarParametrosUsuarioVacios')->add(\MW::class . ':ValidarParametrosUsuario');
    $app->get('/',\Usuario::class . ':ListadoUsuarios')->add(\MW::class . ':AccedePropietarioB')->add(\MW::class . ':AccedeEncargadoB')
    ->add(\MW::class . ':AccedeEmpleadoB')->add(\MW::class . ':ChequearJWT');
    $app->post('/',\Auto::class . ':AltaAuto')->add(\MW::class . ':VerificarAutoMW');
    $app->get('/autos',\Auto::class . ':ListadoAutos')->add(\MW::class . ':AccedePropietario')->add(\MW::class . ':AccedeEncargado')
    ->add(\MW::class . ':AccedeEmpleado')->add(\MW::class . ':ChequearJWT');
    $app->post('/login',\Usuario::class . ':VerificarUsuario')->add(\MW::class . ':VerificarUsuarioBD')->add(
    \MW::class . '::ValidarParametrosUsuarioVacios')->add(\MW::class . ':ValidarParametrosUsuario');
    $app->get('/login',\Usuario::class . ':ObtenerDataJWT');
    $app->delete('/',\Auto::class . ':BorrarAuto')->add(\MW::class . '::VerificarPropietario')->add(\MW::class . ':ChequearJWT');
    $app->put('/',\Auto::class . ':ModificarAuto')->add(\MW::class . '::VerificarEncargado')->add(\MW::class . ':ChequearJWT');


    $app->get('/loginusuarios', function (Request $request, Response $response, array $args) : Response { 
        $view = Twig::fromRequest($request);
        return $view->render($response, 'login.php');
    });
    
    $app->get('/registro', function (Request $request, Response $response, array $args) : Response { 
        $view = Twig::fromRequest($request);
        return $view->render($response, 'registro.php');
    });

    $app->get('/principal', function (Request $request, Response $response, array $args) : Response { 
        $view = Twig::fromRequest($request);
        return $view->render($response, 'principal.php');
    });

    $app->get('/altaAuto', function (Request $request, Response $response, array $args) : Response { 
        $view = Twig::fromRequest($request);
        return $view->render($response, 'altaAuto.php');
    });

    $app->run();
?>