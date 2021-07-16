<?php

use Slim\Psr7\Response;
use Slim\Psr7\Request;

interface ISlimeable{

    function TraerTodos(Request $request, Response $response, array $args): Response;
    function TraerUno(Request $request, Response $response, array $args): Response;
    function AgregarUno(Request $request, Response $response, array $args): Response;
    function ModificarUno(Request $request, Response $response, array $args): Response;
    function BorrarUno(Request $request, Response $response, array $args): Response;
}