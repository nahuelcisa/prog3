<?php
    class Producto
    {
        public $nombre;
        public $origen;

        public function __construct($nombre, $origen)
        {
            $this->nombre = $nombre;
            $this->origen = $origen;
        }

        public function ToJSON()
        {
            $obj = new stdClass();
            $obj->nombre = $this->nombre;
            $obj->origen = $this->origen;
            
            return json_encode($obj);
        }

        public function GuardarJSON($path)
        {
            $retornoJSON = new stdClass();
            $retornoJSON->exito = false;
            $retornoJSON->mensaje = "Hubo un error al guardar en el archivo.";
                
                if(file_exists($path))
                {
                    $archivo = fopen($path,"r");

                    if(filesize($path) > 0)
                    {
                        $aux = fread($archivo, filesize($path));
                    }

                    fclose($archivo);

                    $archivo = fopen($path,"w");
                }
                else
                {
                    $archivo = fopen($path,"a");
                }


                if(filesize($path) == 0)
                {
                    if(fwrite($archivo, "[". $this->ToJSON() . "]") != 0)
                    {
                        $retornoJSON->exito = true;
                        $retornoJSON->mensaje = "Se pudo guardar en el archivo.";
                        
                    }

                    fclose($archivo);
                }
                else
                {

                    $lectura = explode("]", $aux);

                        if(fwrite($archivo, $lectura[0] . "," . $this->ToJSON() . "]") != 0)
                        {
                            $retornoJSON->exito = true;
                            $retornoJSON->mensaje = "Se pudo guardar en el archivo.";
                        }
                        fclose($archivo);
                }
            
            return json_encode($retornoJSON);
        }

        public static function TraerJSON()
        {
            $path = "./archivos/productos.json";

            if(!file_exists($path))
            {
                $crearArchivo = fopen($path,"w");
                fclose($crearArchivo);
            }

            $archivo = fopen($path, "r");

            $json = fread($archivo,filesize($path));

            fclose($archivo);
            
            return json_decode($json);

        }

        public static function VerificarProductoJSON($producto)
        {
            $arrayP = array(); 
            $arrayP = Producto::TraerJSON();
            $retornoJSON = new stdClass();
            $nombresArray = array();
            $cantidadOrigen = 0;
            $flagMax = true;
            $max = 0;
            $flag = false;

            foreach($arrayP as $item)
            {
                array_push($nombresArray, $item->nombre);

                
                if($item->nombre == $producto->nombre && $item->origen == $producto->origen)
                {
                    $flag = true;
                }
                
                if($item->origen == $producto->origen)
                {
                    $cantidadOrigen++;
                }
            }
            
            $nombresAsociativo = array_count_values($nombresArray);

            $cantidadProducto = 0;
            $productoMayor = "";

            foreach($nombresAsociativo as $key => $item)
            {
                $cantidadProducto = $item;

                if($flagMax || $cantidadProducto > $max)
                {
                    $max = $cantidadProducto;
                    $productoMayor = $key;
                    $flagMax = false;        
                }
            }

            if($flag)
            {
                $retornoJSON->existe = true;
                $retornoJSON->mensaje = "Hay un total de {$cantidadOrigen} productos con el mismo origen que el pasado por parametro";
            }
            else
            {
                    $retornoJSON->existe = false;
                    $retornoJSON->mensaje = "El producto con mas apariciones es {$productoMayor} con un total de {$max}"; 
            }

            return json_encode($retornoJSON);
        }
    }
?>