<?php
    require_once("AccesoDatos.php");
    require_once("autentificadora.php");
    use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
    use Slim\Psr7\Request;
    use Slim\Psr7\Response as ResponseMW;
    use Slim\Psr7\Response;
    
    class Usuario
    {
        public $id;
        public $correo;
        public $clave;
        public $nombre;
        public $apellido;
        public $perfil;
        public $foto;

        public function __construct($id = 0,$correo = "",$clave = "",$nombre = "",$apellido = "",$perfil = "",$foto = NULL)
        {
            $this->id = $id;
            $this->correo = $correo;
            $this->clave = $clave;
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->perfil = $perfil;
            $this->foto = $foto;
        }

        public static function TraerUsuarios()
        {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso(); 
            $query = $accesoDatos->RetornarConsulta("SELECT 
            usuarios.id, 
            usuarios.correo, 
            usuarios.clave, 
            usuarios.nombre, 
            usuarios.apellido, 
            usuarios.foto, 
            usuarios.perfil 
            FROM usuarios");
            
            $query->execute();

            $array = $query->fetchAll(PDO::FETCH_OBJ);
            $arrayUsuarios = [];

            foreach($array as $item)
            {
                $aux = new Usuario($item->id,$item->correo,$item->clave,$item->nombre,$item->apellido,$item->perfil,$item->foto);
                array_push($arrayUsuarios,$aux);
            }

            return $arrayUsuarios;
        }

        public static function TraerUnoCorreoClave($json)
        {
            $usuario = json_decode($json);
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            
            $query = $accesoDatos->RetornarConsulta("SELECT * from usuarios WHERE correo = :correo AND clave = :clave");

            $query->bindValue(':clave', $usuario->clave, PDO::PARAM_STR);
            $query->bindValue(':correo', $usuario->correo, PDO::PARAM_STR);

            try
            {
                $query->execute();
                return $query->fetchAll(PDO::FETCH_OBJ);
            }
            catch(PDOException $e)
            {
                echo "Error: {$e->getMessage()}";
            }
        }
        public static function TraerUnoCorreo($correo)
        {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            
            $query = $accesoDatos->RetornarConsulta("SELECT * from usuarios WHERE correo = :correo");

            $query->bindValue(':correo', $correo, PDO::PARAM_STR);

            try
            {
                $query->execute();
                return $query->fetchAll(PDO::FETCH_OBJ);
            }
            catch(PDOException $e)
            {
                echo "Error: {$e->getMessage()}";
            }
        }

        public static function TraerUnoID($id)
        {   
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            
            $query = $accesoDatos->RetornarConsulta("SELECT * from usuarios WHERE id = :id");

            $query->bindValue(':id', $id, PDO::PARAM_INT);

            try
            {
                $query->execute();
                return $query->fetchObject("Usuario");
            }
            catch(PDOException $e)
            {
                echo "Error: {$e->getMessage()}";
            }
        }

        public function VerificarUsuario(Request $request, Response $response, array $args): Response{

            $retorno = new stdClass();
            $retorno->exito = false;
            $retorno->jwt = NULL;
            $retorno->status = 403;

            $params = $request->getParsedBody();

            $usuario = Usuario::TraerUnoCorreoClave($params["user"]);

            if($usuario != NULL){

                $retorno->jwt = Autentificadora::CrearJWT(json_encode($usuario));
                $retorno->status = 200;
                $retorno->exito = true;

                $newResponse = $response->withStatus(200);
            }

            $newResponse->getBody()->write(json_encode($retorno));

            return $newResponse->withHeader('Content-Type' , 'application/json');
        }

        public function ObtenerDataJWT(Request $request, Response $response, array $args): Response{

            $respuesta = new stdClass();
            $respuesta->exito = false;
            $respuesta->payload = NULL;
            $respuesta->status = 403;

            $params = $request->getHeader("token")[0];
 
            $datos = Autentificadora::VerificarJWT($params);
            $newResponse = new Response();

            if($datos->verificado){

                $token = Autentificadora::ObtenerPayLoad($params);

                $respuesta->exito = $datos->verificado;
                $respuesta->payload = $token->payload;
                $respuesta->status = 200;

                $newResponse = $response->withStatus(200);
            }

            $newResponse->getBody()->write(json_encode($respuesta));

            return $newResponse->withHeader('Content-Type' , 'application/json');
        }


        public function VerificarBD(Request $request, Response $response, array $args): Response
        {
            $usuario = Usuario::TraerUnoCorreoClave($args["json"]);

            $response->getBody()->write(json_encode($usuario));
            
            return $response;
        }


        public function ListadoUsuarios(Request $request, Response $response, array $args): Response 
        {
            $usuarios = Usuario::TraerUsuarios();

            $json = new stdClass();

            $json->exito = false;
            $json->mensaje = "No hay usuarios.";
            $json->dato = "";
            $json->status = 424;
            

            $newResponse = new Response();

            if(count($usuarios)){
                $json->exito = true;
                $json->mensaje = "Listado de usuarios";
                $json->dato = $usuarios;
                $json->status = 200;

                $newResponse = $response->withStatus(200, "OK");
                $newResponse->getBody()->write(json_encode($json));

                return $newResponse->withHeader('Content-Type', 'application/json');
            }
            
            $response->withStatus(403);
            return $newResponse->withHeader('Content-Type', 'application/json');

        }

        public function AltaUsuario(Request $request, Response $response, array $args) : Response
        {
            $params = $request->getParsedBody();
            $json = json_decode($params["usuario"]);
            $foto = $request->getUploadedFiles()["foto"];


            $retornoUsuario = new stdClass();
            $retornoUsuario->exito = false;
            $retornoUsuario->mensaje = "Error al agregar.";
            $retornoUsuario->status = 418;
            
            
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();

            foreach(self::TraerUsuarios() as $item){
                $ultimoId = $item->id;
            }

            $ultimoId += 1;


            $newResponse = new Response();


                $usuario = new Usuario(0,$json->correo,$json->clave,$json->nombre,$json->apellido,$json->perfil);

                if($foto != NULL)
                {
                    $pathDestino = "../fotosBD/" . $foto->getClientFilename();
                    $flag = false;
                
                    $tipoDeArchivo = pathinfo($pathDestino,PATHINFO_EXTENSION);
                    $nombreArchivo = $usuario->correo . "_". $ultimoId . "." . $tipoDeArchivo;
                    $pathDestino = "../src/fotos/" . $nombreArchivo;

                    if($tipoDeArchivo == "jpg" || $tipoDeArchivo == "bmp" || $tipoDeArchivo == "gif" || $tipoDeArchivo == "png" || $tipoDeArchivo == "jpeg")
                    {
                        
                        $foto->moveTo($pathDestino);
                        $usuario->foto = $pathDestino;
                        $flag = true;
                    }

                    if($flag)
                    {
                        $retorno = json_decode($usuario->AgregarUno());
                            if($retorno->exito){
                                $retornoUsuario->exito = $retorno->exito;
                                $retornoUsuario->mensaje = "Agregado con exito.";
                                $retornoUsuario->status = 200;

                                $newResponse->getBody()->write(json_encode($retornoUsuario));
                            }else{
                                $retornoUsuario->mensaje = $retorno->mensaje;
                                $newResponse->getBody()->write(json_encode($retornoUsuario));
                            }
                    }
                }
           
            return $newResponse;
        }

        public function AgregarUno()
        {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            
            $query = $accesoDatos->RetornarConsulta("INSERT INTO usuarios 
            (nombre, apellido, correo, clave, perfil, foto) 
            VALUES (:nombre, :apellido, :correo, :clave, :perfil, :foto)");

            $query->bindValue(':correo',$this->correo, PDO::PARAM_STR);
            $query->bindValue(':clave',$this->clave, PDO::PARAM_STR);
            $query->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
            $query->bindValue(':apellido',$this->apellido, PDO::PARAM_STR);
            $query->bindValue(':perfil',$this->perfil, PDO::PARAM_STR);
            $query->bindValue(':foto',$this->foto, PDO::PARAM_STR);

            $obj = new stdClass();
            $obj->exito = false;
            $obj->mensaje = "No se pudo agregar el usuario";

            try
            {
                $query->execute();
                if($query->rowCount())
                {
                    $obj->exito = true;
                    $obj->id = $accesoDatos->RetornarUltimoIdInsertado();
                }
            }
            catch(PDOException $e)
            {
                echo "Error: {$e->getMessage()}";
            }

            return json_encode($obj);
        }


        public function ModificarUsuario(Request $request, Response $response, array $args) : Response
        {
            if(isset($_COOKIE['idUsuario']))
            {
                $obj = json_decode($args["usuario_json"]);

                $usuarioPrevio = Usuario::TraerUnoID($obj->id);

                unlink($usuarioPrevio->foto);

                $this->nombre = $obj->nombre;
                $this->apellido = $obj->apellido;
                $this->correo = $obj->correo;
                $this->clave = $obj->clave;
                $this->id_perfil = $obj->id_perfil;
                $this->id = $obj->id;

                $archivos = $request->getUploadedFiles();
                $destino = "../fotos/";
                
                $nombreAnterior = $archivos['foto']->getClientFilename();
                $extension = explode(".", $nombreAnterior);
                $extension = array_reverse($extension);
                
                $nombreFinal = $destino .  $this->nombre . "." . $extension[0];
                $archivos['foto']->moveTo($destino .  $this->nombre . "." . $extension[0]);
                $this->foto = $nombreFinal;

                $mensajeJSON = $this->ModificarUno();
                $newResponse = $response->withStatus(200, "OK");
                $newResponse->getBody()->write($mensajeJSON);

                return $newResponse->withHeader('Content-Type', 'application/json');
            }
            else
            {
                echo "ERROR PRIMERO DEBE LOGEARSE";
                return $response->withStatus(403);
            }
        }

        public function ModificarUno()
        {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            
            $query = $accesoDatos->RetornarConsulta("UPDATE usuarios SET nombre = :nombre, apellido = :apellido, correo = :correo, clave = :clave, id_perfil = :id_perfil WHERE id = :id");

            $query->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
            $query->bindValue(':apellido',$this->apellido, PDO::PARAM_STR);
            $query->bindValue(':correo',$this->correo, PDO::PARAM_STR);
            $query->bindValue(':clave',$this->clave, PDO::PARAM_STR);
            $query->bindValue(':id_perfil',$this->id_perfil, PDO::PARAM_INT);
            $query->bindValue(':id',$this->id, PDO::PARAM_INT);

            $obj = new stdClass();
            $obj->exito = false;
            $obj->mensaje = "No se pudo modificar el usuario";

            try
            {
                $query->execute();
                if($query->rowCount())
                {
                    $obj->exito = true;
                    $obj->mensaje = "Se modifico el usuario con exito";
                }
            }
            catch(PDOException $e)
            {
                echo "Error: {$e->getMessage()}";
            }

            return json_encode($obj);
        }

        public function EliminarUno()
        {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            
            $query = $accesoDatos->RetornarConsulta("DELETE FROM usuarios WHERE id = :id");

            $query->bindValue(':id',$this->id, PDO::PARAM_INT);

            $obj = new stdClass();
            $obj->exito = false;
            $obj->mensaje = "No se pudo eliminar el usuario";

            try
            {
                $query->execute();
                if($query->rowCount())
                {
                    $obj->exito = true;
                    $obj->mensaje = "Se elimino el usuario con exito";
                }
            }
            catch(PDOException $e)
            {
                echo "Error: {$e->getMessage()}";
            }

            return json_encode($obj);
        }

        public function EliminarUsuario(Request $request, Response $response, array $args) : Response
        {
            if(isset($_COOKIE['idUsuario']))
            {
                $id = $args['id'];
                $response->getBody()->write($id);
                return $response->withStatus(200);
            }
            else
            {
                $response->getBody()->write("ERROR PRIMERO DEBE LOGEARSE");
                return $response->withStatus(403);
            }
        }
    }
?>