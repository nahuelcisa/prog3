<?php

    require_once("Usuario.php");    
    require_once("Autentificadora.php");    
    
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
    use Slim\Psr7\Response as ResponseMW;

    class Verificadora{

        public function VerificarUsuario(Request $request, Response $response, array $args) : Response{

            $retorno = new stdClass();
            $retorno->jwt = NULL;
            $retorno->status = 403;

            $params = $request->getParsedBody();

            $usuario = Usuario::TraerUnoCorreoClave($params["obj_json"]);

            if($usuario != NULL){

                $retorno->jwt = Autentificadora::CrearJWT(json_encode($usuario));
                $retorno->status = 200;

                $newResponse = $response->withStatus(200);
            }

            $newResponse->getBody()->write(json_encode($retorno));

            return $newResponse->withHeader('Content-Type' , 'application/json');

        }

        public function ValidarParametrosUsuario(Request $request, RequestHandler $handler) :ResponseMW{

            $retorno = new stdClass();
            $retorno->mensaje = "Error";
            $retorno->status = 403;

            $responseMW = new ResponseMW();

            $params = $request->getParsedBody();

            if(isset($params["obj_json"]))
            {
                $obj = json_decode($params["obj_json"]);

                if(isset($obj->correo)){

                    if(isset($obj->clave)){

                        $response = $handler->handle($request);
                        $responseMW->withStatus($response->getStatusCode());
                        $responseMW->getBody()->write((string)$response->getBody());
                        return $responseMW;
                    }
                    else
                    {
                        $retorno->mensaje = "No existe el parametro clave";
                    }

                }
                else
                {
                    $retorno->mensaje = "No existe el parametro correo";
                }
            }
            else
            {
                $retorno->mensaje = "No existe obj_json";
            }

            $responseMW->withStatus(403);
            $responseMW->getBody()->write(json_encode($retorno));

            return $responseMW;
        }

        public function ObtenerDataJWT(Request $request, Response $response, array $args): Response{

            $respuesta = new stdClass();
            $respuesta->exito = false;
            $respuesta->payload = NULL;
            $respuesta->mensaje = "";

            $params = $request->getHeader("token")[0];
 
            $datos = Autentificadora::VerificarJWT($params);

            if($datos->verificado){

                $token = Autentificadora::ObtenerPayLoad($params);

                $respuesta->exito = $datos->verificado;
                $respuesta->payload = $token->payload;
                $respuesta->mensaje = $datos->mensaje;

                $newResponse = $response->withStatus(200);
            }

            $newResponse->getBody()->write(json_encode($respuesta));

            return $newResponse->withHeader('Content-Type' , 'application/json');
        }

        public function ChequearJWT(Request $request, RequestHandler $handler) :ResponseMW{
            
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

        public function ValidarParametrosCDAgregar(Request $request, RequestHandler $handler) :ResponseMW{

            $params = $request->getParsedBody();
            $retorno = new stdClass();
            $retorno->mensaje = "";
            $retorno->status = 403;

            $responseMW = new ResponseMW();

            if(isset($params['titulo'])){
                if(isset($params['interprete'])){
                    if(isset($params['anio'])){
                        $response = $handler->handle($request);
                        $responseMW->withStatus($response->getStatusCode());
                        $responseMW->getBody()->write((string)$response->getBody());
                        return $responseMW;
                    }
                    else
                    {
                        $retorno->mensaje = "No se paso el anio.";
                    }
                }
                else
                {
                $retorno->mensaje = "No se paso el interprete.";
                }
            }
            else
            {
                $retorno->mensaje = "No se paso el titulo.";
            }

            $responseMW->withStatus(403);
            $responseMW->getBody()->write(json_encode($retorno));
            return $responseMW;
        }

        public function ValidarParametrosCDModificar(Request $request, RequestHandler $handler) :ResponseMW{

            $params = json_decode($request->getBody());
            $retorno = new stdClass();
            $retorno->mensaje = "";
            $retorno->status = 500;

            $responseMW = new ResponseMW();

            if($params != NULL){
                if(isset($params->id)){
                    if(isset($params->titulo)){
                        if(isset($params->interprete)){
                            if(isset($params->anio)){

                                $response = $handler->handle($request);
                                $responseMW->withStatus($response->getStatusCode());
                                $responseMW->getBody()->write((string)$response->getBody());
                                return $responseMW;

                            }else{
                                $retorno->mensaje = "No se paso el anio";
                            }
                        }else{
                            $retorno->mensaje = "No se paso el interprete";
                        }
                    }else{
                        $retorno->mensaje = "No se paso el titulo";
                    }
                }else{
                    $retorno->mensaje = "No se paso el id.";
                }
            }else{
                $retorno->mensaje = "El Json se paso erroneamente.";
            }

            $responseMW->withStatus(500);
            $responseMW->getBody()->write(json_encode($retorno));
            return $responseMW;
        }
        public function ValidarParametrosCDBorrar(Request $request, RequestHandler $handler) :ResponseMW{

            $params = json_decode($request->getBody());
            $retorno = new stdClass();
            $retorno->mensaje = "";
            $retorno->status = 500;

            $responseMW = new ResponseMW();

            if($params != NULL){
                if(isset($params->id)){
                    $response = $handler->handle($request);
                    $responseMW->withStatus($response->getStatusCode());
                    $responseMW->getBody()->write((string)$response->getBody());
                    return $responseMW;           
                }
                else
                {
                    $retorno->mensaje = "No se paso el id.";
                }
            }
            else
            {
                $retorno->mensaje = "El Json se paso erroneamente.";
            }
            $responseMW->withStatus(500);
            $responseMW->getBody()->write(json_encode($retorno));
            return $responseMW;
        }
    }
?>
