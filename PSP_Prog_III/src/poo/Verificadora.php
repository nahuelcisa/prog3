<?php

use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Request;
use Slim\Psr7\Response as ResponseMW;
use Slim\Psr7\Response;

include_once __DIR__ . "./AccesoDatos.php";
include_once __DIR__ . "./Usuarios.php";
include_once __DIR__ . "./Autentificadora.php";


class Verificadora
{

    public static function VerificarUsuario(Request $request, Response $response, array $args): Response
    {
        $jwt = null;
        $status = 403;
        $datos = $request->getParsedBody();
        $obj = json_decode($datos['obj_json']);
        $usuario = Usuario::verificarUsuario($obj->correo, $obj->clave);

        if ($usuario != false) {
            $jwt = Autentificadora::CrearJWT($usuario);
            $status = 200;
        }

        $newResponse = $response->withStatus($status);
        $newResponse->getBody()->write(json_encode($jwt));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public static function ValidarParametrosUsuario(Request $request, RequestHandler $handler): ResponseMW{
        $requestBody = $request->getParsedBody();
        $jsonRet = new stdClass();
        $jsonRet->msj = "";
        $status = 200;
        if(!isset($requestBody['obj_json'])){
            $jsonRet->msj = "No se pasaron parametros";
            $status = 403;
        }
        else{
            $obj_json = json_decode($requestBody['obj_json']);
            if(!isset($obj_json->clave)){
                $jsonRet->msj = "No se paso la clave. ";
                $status = 403;
            }
            if(!isset($obj_json->correo)){
                $jsonRet->msj .= " No se paso el correo ";
                $status = 403;
            }
        }
        
        if($status == 200){
            $jsonRet = json_decode($handler->handle($request)->getBody());
        }

        $responseMW = new ResponseMW($status);
        $responseMW->getBody()->write(json_encode($jsonRet));
        return $responseMW;
    }

    public static function ObtenerDataJWT(Request $request, Response $response,array $args): Response{
        $token = $request->getHeader("token")[0];
        $retValue = Autentificadora::ObtenerPayLoad($token);
        $newResponse = new Response();
        $newResponse->getBody()->write(json_encode($retValue));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    public static function ChequearJWT(Request $request, RequestHandler $handler): ResponseMW{
        $response = json_decode($handler->handle($request)->getBody());
        $token = $request->getHeader("token")[0];
        $verifyToken = Autentificadora::VerificarJWT($token);
        $newResponse = new ResponseMW();
        if(!$verifyToken->verificado){
            $newResponse->getBody()->write(json_encode($verifyToken));
        }
        else{
            $newResponse->getBody()->write(json_encode($response));
        }
        return  $newResponse;
    }

    public function ValidarParametrosCDAgregar(Request $request, RequestHandler $handler) : ResponseMW{
        $retJson = new stdClass();
        $retJson->msj = "";
        $status = 200;
        if(isset($request->getParsedBody()['obj_json'])){
            $obj_json = json_decode($request->getParsedBody()['obj_json']);
            if(!isset($obj_json->titulo)){
            $status = 403;
            $retJson->msj = "No se paso el titulo. ";
            }
            if(!isset($obj_json->interprete)){
            $status = 403;
            $retJson->msj .= "No se paso el interprete. ";
            }
            if(!isset($obj_json->anio)){
            $status = 403;
            $retJson->msj .= "No se paso el anio.";
            }
        }
        else{
            $retJson->msj = "No se paso el json";
            $status = 403;
        }

        $newResponse = new ResponseMW($status);

        if($retJson->msj == ""){
            $datos = json_decode($handler->handle($request)->getBody());
            $newResponse->getBody()->write(json_encode($datos));
            $newResponse->withHeader('Content-type', 'application/json');
        }
        else
        {
            $newResponse->getBody()->write(json_encode(($retJson)));
            $newResponse->withHeader('Content-type', 'application/json');
        }
        return $newResponse;
    }

    public function ValidarParametrosCDModificar(Request $request, RequestHandler $handler): ResponseMW{
        $retJson = new stdClass();
        $retJson->msj = "";
        $status = 200;
        $obj = json_decode($request->getBody());

        if(isset($obj)){
            $obj = json_decode($request->getBody());
            if(!isset($obj->id)){
                $status = 500;
                $retJson->msj = "No se paso el id.";
            }
            if(!isset($obj->titulo)){
                $status = 500;
                $retJson->msj .= "No se paso el titulo. ";
            }
            if(!isset($obj->interprete)){
                $status = 500;
                $retJson->msj .= "No se paso el interprete. ";
            }
            if(!isset($obj->anio)){
                $status = 500;
                $retJson->msj .= "No se paso el anio.";
            }
        }
        else{
            $retJson->msj = "No se paso el json";
            $status = 500;
        }

        $newResponse = new ResponseMW($status);

        if($retJson->msj == ""){
            $datos = json_decode($handler->handle($request)->getBody());
            $newResponse->getBody()->write(json_encode($datos));
        }
        else
        {
            $newResponse->getBody()->write(json_encode(($retJson)));
        }

        $newResponse->withHeader('Content-type', 'application/json');
        return $newResponse;
    }

    public function ValidarParametrosCDEliminar(Request $request, RequestHandler $handler): ResponseMW{
        $retJson = new stdClass();
        $retJson->msj = "";
        $status = 200;
        $obj = json_decode($request->getBody());

        if(isset($obj)){
            $obj = json_decode($request->getBody());
            if(!isset($obj->id)){
                $status = 500;
                $retJson->msj = "No se paso el id.";
            }
        }
        else{
            $retJson->msj = "No se paso el json";
            $status = 500;
        }

        $newResponse = new ResponseMW($status);

        if($retJson->msj == ""){
            $datos = json_decode($handler->handle($request)->getBody());
            $newResponse->getBody()->write(json_encode($datos));
        }
        else
        {
            $newResponse->getBody()->write(json_encode(($retJson)));
        }

        $newResponse->withHeader('Content-type', 'application/json');
        return $newResponse;
    }

}
