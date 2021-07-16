<?php
    require_once("AccesoDatos.php");
    require_once("autentificadora.php");
    use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
    use Slim\Psr7\Request;
    use Slim\Psr7\Response as ResponseMW;
    use Slim\Psr7\Response;

    class Auto
    {
        public $id;
        public $color;
        public $marca;
        public $precio;
        public $modelo;

        public function __construct($id = 0,$color = "",$marca = "",$precio = 0,$modelo = "")
        {
            $this->id = $id;
            $this->color = $color;
            $this->marca = $marca;
            $this->precio = $precio;
            $this->modelo = $modelo;
        }

        public function AgregarAuto(){
            
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            
            $query = $accesoDatos->RetornarConsulta("INSERT INTO autos 
            (color,marca ,precio, modelo) 
            VALUES (:color,:marca,:precio, :modelo)");

            $query->bindValue(':color',$this->color, PDO::PARAM_STR);
            $query->bindValue(':marca',$this->marca, PDO::PARAM_STR);
            $query->bindValue(':precio',$this->precio, PDO::PARAM_INT);
            $query->bindValue(':modelo',$this->modelo, PDO::PARAM_STR);
        
            $obj = new stdClass();
            $obj->exito = false;
            $obj->mensaje = "No se pudo agregar el auto";

            try
            {
                $query->execute();
                if($query->rowCount())
                {
                    $obj->exito = true;
                    $obj->mensaje = "Se agrego un auto con el id {$accesoDatos->RetornarUltimoIdInsertado()}";
                }
            }
            catch(PDOException $e)
            {
                echo "Error: {$e->getMessage()}";
            }

            return json_encode($obj);
        
        }

        public static function ModificarAutomovil($json)
        {
            $json = json_decode($json);

            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            
            $query = $accesoDatos->RetornarConsulta("UPDATE autos SET 
            color = :color, marca = :marca, precio = :precio, modelo = :modelo
            WHERE id = :id");

            $query->bindValue(':color',$json->auto->color, PDO::PARAM_STR);
            $query->bindValue(':marca',$json->auto->marca, PDO::PARAM_STR);
            $query->bindValue(':precio',$json->auto->precio, PDO::PARAM_INT);
            $query->bindValue(':modelo',$json->auto->modelo, PDO::PARAM_STR);
            $query->bindValue(':id',$json->id_auto, PDO::PARAM_INT);

            $obj = new stdClass();
            $obj->exito = false;
            $obj->mensaje = "No se pudo modificar el auto";

            try
            {
                $query->execute();
                if($query->rowCount())
                {
                    $obj->exito = true;
                    $obj->mensaje = "Se modifico el auto con exito";
                }
            }
            catch(PDOException $e)
            {
                echo "Error: {$e->getMessage()}";
            }

            return json_encode($obj);
        }

        public function AltaAuto(Request $request, Response $response, array $args) : Response{

            $params = $request->getParsedBody();

            $json = json_decode($params["auto"]);

            $auto = new Auto(0,$json->color,$json->marca,$json->precio,$json->modelo);

            $agregar = json_decode($auto->AgregarAuto());

            $retorno = new stdClass();
            $retorno->exito = false;
            $retorno->mensaje = "Hubo un error.";
            $retorno->status = 418;

            $newResponse = new Response();

            if($agregar->exito){
                $retorno->exito = $agregar->exito;
                $retorno->mensaje = $agregar->mensaje;
                $retorno->status = 200;
                $newResponse->getBody()->write(json_encode($retorno));
            }else
            {
                $retorno->mensaje = $agregar->mensaje;
                $newResponse->getBody()->write(json_encode($retorno));
            }

            return $newResponse->withHeader('Content-Type', 'application/json');
        }

        public static function EliminarAuto($id)
        {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            
            $query = $accesoDatos->RetornarConsulta("DELETE FROM autos WHERE id = :id");

            $query->bindValue(':id',$id, PDO::PARAM_INT);

            $obj = new stdClass();
            $obj->exito = false;
            $obj->mensaje = "No se pudo eliminar el auto";

            try
            {
                $query->execute();
                if($query->rowCount())
                {
                    $obj->exito = true;
                    $obj->mensaje = "Se elimino el auto con exito";
                }
            }
            catch(PDOException $e)
            {
                echo "Error: {$e->getMessage()}";
            }

            return json_encode($obj);
        }


        public function ListadoAutos(Request $request, Response $response, array $args) : Response{
            $autos = Auto::TraerAutos();

            $json = new stdClass();

            $json->exito = false;
            $json->mensaje = "No hay autos.";
            $json->dato = "";
            $json->status = 424;

            $newResponse = new Response();

            if(count($autos)){
                $json->exito = true;
                $json->mensaje = "Listado de autos";
                $json->dato = $autos;
                $json->status = 200;

                $newResponse = $response->withStatus(200, "OK");
                $newResponse->getBody()->write(json_encode($json));

                return $newResponse->withHeader('Content-Type', 'application/json');
            }
            
            $response->withStatus(403);
            return $newResponse->withHeader('Content-Type', 'application/json');
        }

        public static function TraerAutos()
        {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso(); 
            $query = $accesoDatos->RetornarConsulta("SELECT 
            autos.id, 
            autos.color, 
            autos.marca, 
            autos.precio, 
            autos.modelo 
            FROM autos");
            
            $query->execute();

            $array = $query->fetchAll(PDO::FETCH_OBJ);
            $arrayAutos = [];

            foreach($array as $item)
            {
                $aux = new Auto($item->id,$item->color,$item->marca,$item->precio,$item->modelo);
                array_push($arrayAutos,$aux);
            }

            return $arrayAutos;
        }

        

        public function BorrarAuto(Request $request, Response $response, array $args) : Response{

            $id = json_decode($request->getBody());
            

            $respuesta = new stdClass();
            $respuesta->mensaje = "No se borro el auto.";
            $respuesta->status = 418;
            $respuesta->exito = false;

            $retornoBorrado = json_decode(Auto::EliminarAuto($id->id_auto));

            if($retornoBorrado->exito){

                $respuesta->exito = $retornoBorrado->exito;
                $respuesta->mensaje = "Se elimino correctamente.";
                $respuesta->status = 200;

                $newResponse = $response->withStatus(200);
            }else{
                $respuesta->mensaje = "Error al eliminar.";
                $newResponse = $response->withStatus(418);
            }

            $newResponse->getBody()->write(json_encode($respuesta));

            return $newResponse->withHeader('Content-Type' , 'application/json');
        }

        public function ModificarAuto(Request $request, Response $response, array $args) : Response{

            $json = $request->getBody();

            $respuesta = new stdClass();
            $respuesta->mensaje = "No se modifico el auto.";
            $respuesta->status = 418;
            $respuesta->exito = false;

            $retornoModificado = json_decode(Auto::ModificarAutomovil($json));

            if($retornoModificado->exito){

                $respuesta->exito = $retornoModificado->exito;
                $respuesta->mensaje = "Se modifico correctamente.";
                $respuesta->status = 200;

                $newResponse = $response->withStatus(200);
            }else{
                $respuesta->mensaje = "Error al modificar.";
                $newResponse = $response->withStatus(418);
            }

            $newResponse->getBody()->write(json_encode($respuesta));

            return $newResponse->withHeader('Content-Type' , 'application/json');
        }
    }
?>