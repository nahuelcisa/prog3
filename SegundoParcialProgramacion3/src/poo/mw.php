<?php

    use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
    use Slim\Psr7\Request;
    use Slim\Psr7\Response as ResponseMW;
    use Slim\Psr7\Response;

    require_once("autentificadora.php");
    require_once("Auto.php");
    require_once("Usuario.php");
    
    class MW{

        public function ValidarParametrosUsuario(Request $request, RequestHandler $handler) :ResponseMW{

            $json = $request->getParsedBody();

            if(isset($json['user']))
            {
                $params = json_decode($json["user"]);
            }
            else if(isset($json['usuario']))
            {
                $params = json_decode($json["usuario"]);
            }

            $retorno = new stdClass();
            $retorno->mensaje = "No se paso ni el correo ni la clave.";
            $retorno->status = 403;

            $responseMW = new ResponseMW();

            if(isset($params->correo)){
                if(isset($params->clave)){

                    $retorno->status = 200;
                    $response = $handler->handle($request);
                    $responseMW->withStatus($response->getStatusCode());
                    $responseMW->getBody()->write((string)$response->getBody());
                    return $responseMW;
                }
                else
                {
                $retorno->mensaje = "No se paso la clave.";
                }
            }
            else if(isset($params->clave))
            {
                $retorno->mensaje = "No se paso el correo.";
            }

            $responseMW->withStatus(403);
            $responseMW->getBody()->write(json_encode($retorno));
            return $responseMW;
        }

        public static function ValidarParametrosUsuarioVacios(Request $request, RequestHandler $handler) :ResponseMW{

            $json = $request->getParsedBody();

            if(isset($json['user']))
            {
                $params = json_decode($json["user"]);
            }
            else if(isset($json['usuario']))
            {
                $params = json_decode($json["usuario"]);
            }

            $retorno = new stdClass();
            $retorno->mensaje = "El correo y la clave estan vacios.";
            $retorno->status = 403;

            $responseMW = new ResponseMW();

            if($params->correo != ""){
                if($params->clave != ""){
                    
                    $retorno->status = 200;
                    $response = $handler->handle($request);
                    $responseMW->withStatus($response->getStatusCode());
                    $responseMW->getBody()->write((string)$response->getBody());
                    return $responseMW;
                }
                else
                {
                $retorno->mensaje = "La clave esta vacia.";
                }
            }
            else if($params->clave != "")
            {
                $retorno->mensaje = "El correo esta vacio.";
            }

            $responseMW->withStatus(403);
            $responseMW->getBody()->write(json_encode($retorno));
            return $responseMW;
        }

        public function VerificarUsuarioBD(Request $request, RequestHandler $handler) :ResponseMW{

            $json = $request->getParsedBody();

            $retorno = new stdClass();
            $retorno->mensaje = "El usuario no se encuentra en la base de datos.";
            $retorno->status = 403;

            $responseMW = new ResponseMW();

            $json = $request->getParsedBody();

            if(isset($json['user']))
            {
                $usuario = Usuario::TraerUnoCorreoClave($json['user']);
            }
            else if(isset($json['usuario']))
            {
                $usuario = Usuario::TraerUnoCorreoClave($json['usuario']);
            }

            if(isset($usuario[0])){

                $retorno->mensaje = "El usuario se encuentra en la base de datos.";
                $retorno->status = 200;

                $response = $handler->handle($request);
                $responseMW->withStatus($response->getStatusCode());
                $responseMW->getBody()->write((string)$response->getBody());
                return $responseMW;
            }

            $responseMW->withStatus(403);
            $responseMW->getBody()->write(json_encode($retorno));
            return $responseMW;
        }
        
        public static function VerificarExistenciaCorreoBD(Request $request, RequestHandler $handler) :ResponseMW{

            $json = $request->getParsedBody();

            if(isset($json['user']))
            {
                $user = Usuario::TraerUnoCorreoClave($json['user']);
            }
            else if(isset($json['usuario']))
            {
                $user = Usuario::TraerUnoCorreoClave($json['usuario']);
            }

            $retorno = new stdClass();
            $retorno->mensaje = "El correo se encuentra en la base de datos.";
            $retorno->status = 403;

            $responseMW = new ResponseMW();

            if(!count($user)){

                $retorno->mensaje = "El correo no se encuentra en la base de datos.";
                $retorno->status = 200;

                $response = $handler->handle($request);
                $responseMW->withStatus($response->getStatusCode());
                $responseMW->getBody()->write((string)$response->getBody());
                return $responseMW;
            }

            $responseMW->withStatus(403);
            $responseMW->getBody()->write(json_encode($retorno));
            return $responseMW;
        }

        public function VerificarAutoMW(Request $request, RequestHandler $handler) :ResponseMW{

            $json = $request->getParsedBody();
            $json = json_decode($json['auto']);

            $retorno = new stdClass();
            $retorno->mensaje = "El precio no esta en el rango valido y el auto es amarillo.";
            $retorno->status = 409;

            $responseMW = new ResponseMW();

            if($json->color != "amarillo"){
                if($json->precio >= 50000 && $json->precio <= 600000){
                    
                    $retorno->status = 200;
                    $response = $handler->handle($request);
                    $responseMW->withStatus($response->getStatusCode());
                    $responseMW->getBody()->write((string)$response->getBody());
                    return $responseMW;
                }
                else
                {
                    $retorno->mensaje = "El precio no esta dentro de los parametros aceptados.";
                }
            }
            else if($json->precio >= 50000 && $json->precio <= 600000)
            {
                $retorno->mensaje = "El color amarillo no esta permitido.";
            }

            $responseMW->withStatus(409);
            $responseMW->getBody()->write(json_encode($retorno));
            return $responseMW;
        }

        public function ChequearJWT(Request $request, RequestHandler $handler) :ResponseMW{
            
            $respuesta = new stdClass();
            $respuesta->mensaje = "";
            $respuesta->status = 403;

            $token = $request->getHeader("token")[0];
            $verifyToken = Autentificadora::VerificarJWT($token);
            $newResponse = new ResponseMW();
            if(!$verifyToken->verificado){
                $respuesta->mensaje = $verifyToken;
                $newResponse->getBody()->write(json_encode($respuesta));
            }
            else
            {
                $response = $handler->handle($request);
                $newResponse->getBody()->write((string)$response->getBody());
                return $newResponse->withHeader('Content-Type', 'application/json');
            }
            return  $newResponse;
        }

        public static function VerificarPropietario(Request $request, RequestHandler $handler) :ResponseMW{

            $token = $request->getHeader("token")[0];

            $respuesta = new stdClass();
            $respuesta->mensaje = "No es propietario.";
            $respuesta->usuario = NULL;
            $respuesta->status = 418;
            
            $payloadObtenido = Autentificadora::ObtenerPayLoad($token);

            $usuario = json_decode($payloadObtenido->payload->data);

            $responseMW = new ResponseMW();


            if($usuario[0]->perfil == "propietario"){

                $respuesta->status = 200;
                $response = $handler->handle($request);
                $responseMW->withStatus($response->getStatusCode());
                $responseMW->getBody()->write((string)$response->getBody());
                return $responseMW;

            }else{
                $respuesta->mensaje = "El usuario no es propietario, quien quiso realizar la accion es: ";
                $respuesta->usuario = $usuario[0];
                $responseMW->withStatus(418);
            }

            $responseMW->getBody()->write(json_encode($respuesta));
            return $responseMW;
        }

        public static function VerificarEncargado(Request $request, RequestHandler $handler) :ResponseMW{

            $token = $request->getHeader("token")[0];

            $respuesta = new stdClass();
            $respuesta->mensaje = "No es encargado.";
            $respuesta->status = 409;
            
            $payloadObtenido = Autentificadora::ObtenerPayLoad($token);

            $usuario = json_decode($payloadObtenido->payload->data);

            $responseMW = new ResponseMW();

            if($usuario[0]->perfil == "encargado"){

                $respuesta->status = 200;
                $response = $handler->handle($request);
                $responseMW->withStatus($response->getStatusCode());
                $responseMW->getBody()->write((string)$response->getBody());
                return $responseMW;

            }else{
                $respuesta->mensaje = "El usuario no es encargado, quien quiso realizar la accion es: " . json_encode($usuario[0]);
                $responseMW->withStatus(409);
            }
            
            $responseMW->getBody()->write(json_encode($respuesta));
            return $responseMW;
        }

        public function AccedeEncargado(Request $request, RequestHandler $handler) :ResponseMW{

            $token = $request->getHeader("token")[0];
           
            $payloadObtenido = Autentificadora::ObtenerPayLoad($token);

            if(isset($payloadObtenido->payload)){

                $usuario = json_decode($payloadObtenido->payload->data);

                $responseMW = new ResponseMW();
    
                    $response = $handler->handle($request);
                    $responseMW->withStatus($response->getStatusCode());
    
                    if($usuario[0]->perfil == 'encargado'){
        
                        $datosDeAutos = json_decode($response->getBody());
        
                        $arrayDeAutos = $datosDeAutos->dato;
        
                        $datosDeAutos->dato = $arrayDeAutos;
        
                        $responseMW->getBody()->write(json_encode($datosDeAutos));
                    }
                    else
                    {
        
                        $responseMW->getBody()->write((string)$response->getBody());
                    }
            }
            return $responseMW;  
        }

        public function AccedeEmpleado(Request $request, RequestHandler $handler) :ResponseMW{

            $token = $request->getHeader("token")[0];
           
            $payloadObtenido = Autentificadora::ObtenerPayLoad($token);

            if(isset($payloadObtenido->payload)){

                $usuario = json_decode($payloadObtenido->payload->data);

                $responseMW = new ResponseMW();
    
                    $response = $handler->handle($request);
                    $responseMW->withStatus($response->getStatusCode());
    
                    if($usuario[0]->perfil == 'empleado'){
        
                        $datosDeAutos = json_decode($response->getBody());
        
                        $arrayDeAutos = $datosDeAutos->dato;

                        $colores = [];
        
                        foreach($arrayDeAutos as $item){
                            array_push($colores,$item->color);
                        }

                        $cantColores = array_count_values($colores);

                        $rta = new stdClass();

                        $rta->mensaje = "Hay " . count($cantColores) . " colores distintos.";
                        $rta->colores = $cantColores;
                                
                        $responseMW->getBody()->write(json_encode($rta));
                    }
                    else
                    {
        
                        $responseMW->getBody()->write((string)$response->getBody());
                    }
            }
            return $responseMW;  
        }

        public static function AccedePropietario(Request $request, RequestHandler $handler) :ResponseMW{

            $token = $request->getHeader("token")[0];
            $id= isset($request->getHeader("id_auto")[0]) ? isset($request->getHeader("id_auto")[0]) : NULL;

            $payloadObtenido = Autentificadora::ObtenerPayLoad($token);

            if(isset($payloadObtenido->payload)){

                $usuario = json_decode($payloadObtenido->payload->data);

                $responseMW = new ResponseMW();
    
                    $response = $handler->handle($request);
                    $responseMW->withStatus($response->getStatusCode());
    
                    if($usuario[0]->perfil == 'propietario'){
        
                        $datosDeAutos = json_decode($response->getBody());
        
                        $autos = $datosDeAutos->dato;

                        if($id != NULL){
                            foreach($autos as $item){
                                if($item->id == $id){
                                    $autos = $item;
                                }
                            }
                        }
               
                        $responseMW->getBody()->write(json_encode($autos));
                    }
                    else
                    {
        
                        $responseMW->getBody()->write((string)$response->getBody());
                    }
            }
            return $responseMW;  
        }

        public function AccedeEncargadoB(Request $request, RequestHandler $handler) :ResponseMW{

            $token = $request->getHeader("token")[0];
           
            $payloadObtenido = Autentificadora::ObtenerPayLoad($token);

            if(isset($payloadObtenido->payload)){

                $usuario = json_decode($payloadObtenido->payload->data);

                $responseMW = new ResponseMW();
    
                    $response = $handler->handle($request);
                    $responseMW->withStatus($response->getStatusCode());
    
                    if($usuario[0]->perfil == 'encargado'){
        
                        $datosDeUsuarios = json_decode($response->getBody());
        
                        $datosDeUsuarios = $datosDeUsuarios->dato;
        
                        foreach($datosDeUsuarios as $item){
                            unset($item->id);     
                            unset($item->clave);   
                        }
        
                        $datosDeUsuarios = $datosDeUsuarios;
        
                        $responseMW->getBody()->write(json_encode($datosDeUsuarios));
                    }
                    else
                    {
        
                        $responseMW->getBody()->write((string)$response->getBody());
                    }
            }
            return $responseMW;  
        }

        public function AccedeEmpleadoB(Request $request, RequestHandler $handler) :ResponseMW{

            $token = $request->getHeader("token")[0];
           
            $payloadObtenido = Autentificadora::ObtenerPayLoad($token);

            if(isset($payloadObtenido->payload)){

                $usuario = json_decode($payloadObtenido->payload->data);

                $responseMW = new ResponseMW();
    
                    $response = $handler->handle($request);
                    $responseMW->withStatus($response->getStatusCode());
    
                    if($usuario[0]->perfil == 'empleado'){
        
                        $datosDeUsuarios = json_decode($response->getBody());
        
                        $datosDeUsuarios = $datosDeUsuarios->dato;
        
                        foreach($datosDeUsuarios as $item){
                            unset($item->id);     
                            unset($item->correo);     
                            unset($item->clave);
                            unset($item->perfil);
                        }
        
                        $responseMW->getBody()->write(json_encode($datosDeUsuarios));
                    }
                    else
                    {
        
                        $responseMW->getBody()->write((string)$response->getBody());
                    }
            }
            return $responseMW;  
        }

        public static function AccedePropietarioB(Request $request, RequestHandler $handler) :ResponseMW{

            $token = $request->getHeader("token")[0];
            $apellido = isset($request->getHeader("apellido")[0]) ? $request->getHeader("apellido")[0] : NULL;

           
            $payloadObtenido = Autentificadora::ObtenerPayLoad($token);

            if(isset($payloadObtenido->payload)){

                $usuario = json_decode($payloadObtenido->payload->data);

                $responseMW = new ResponseMW();
    
                    $response = $handler->handle($request);
                    $responseMW->withStatus($response->getStatusCode());
    
                    if($usuario[0]->perfil == 'propietario'){
        
                        $datosDeUsuarios = json_decode($response->getBody());
        
                        $datosDeUsuarios = $datosDeUsuarios->dato;
                        $apellidosIguales = [];
                        $todosLosApellidos = [];

                        if($apellido != NULL){
                            foreach($datosDeUsuarios as $item){
                                if($item->apellido == $apellido){
                                    array_push($apellidosIguales,$item);
                                }
                            }

                            if(count($apellidosIguales) == NULL){
                                $cantidad = 0;
                            }else{
                                $cantidad = count($apellidosIguales);
                            }
                            

                            $responseMW->getBody()->write("la cantidad de apellidos iguales es : " . $cantidad);

                        }
                        else
                        {
                            foreach($datosDeUsuarios as $item){
                                array_push($todosLosApellidos,$item->apellido);
                            }

                            $todosLosApellidos = array_count_values($todosLosApellidos);
                            $responseMW->getBody()->write(json_encode($todosLosApellidos));
                        }         
                        
                    }
                    else
                    {
        
                        $responseMW->getBody()->write((string)$response->getBody());
                    }
            }
            return $responseMW;  
        }
    }
?>