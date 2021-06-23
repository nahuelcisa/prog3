<?php

    class Producto
    {
        public $nombre;
        public $origen;


        public function __construct($nombre, $origen)
        {
            $this->origen = $origen;
            $this->nombre = $nombre;
        }

        public function ToJSON()
        {
            $std = new stdClass();

            $std->nombre = $this->nombre;
            $std->origen = $this->origen;

            return json_encode($std);
        }

        public function GuardarJSON($path)
        {
            $rta = new stdClass();
            $rta->bool = false;
            $rta->mensaje = "Hubo un error al guardar en el archivo.";
            
                if(file_exists($path))
                {
                    $aux1 = fopen($path,"r");

                    $aux = fread($aux1, filesize($path));

                    fclose($aux1);

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
                        $rta->bool = true;
                        $rta->mensaje = "Se pudo guardar en el archivo.";
                        
                    }

                    fclose($archivo);
                }
                else
                {

                    $lectura = explode("]", $aux);

                        if(fwrite($archivo, $lectura[0] . "," . $this->ToJSON() . "]") != 0)
                        {
                            $rta->bool = true;
                            $rta->mensaje = "Se pudo guardar en el archivo.";
                        }

                        fclose($archivo);

                }
            
            return json_encode($rta);
        }

        public static function TraerJSON()
        {
            $archivo = fopen("./archivos/productos.json", "r");

            $lectura = fread($archivo, filesize("./archivos/productos.json"));

            $productos = json_decode($lectura);

            return $productos;
        }

        public static function VerificarProductoJSON($producto)
        {
            $productosArr = Producto::TraerJSON();
            $vec = [];
            $cont = 0;
            $mayor = 0;
            $anterior = 0;
            $nombreMayor = "";
            $flag = false;
            
            $rta = new stdClass();
            $rta->bool = false;
            $rta->mensaje = "No se encontro producto.";

            foreach($productosArr as $item)
            {
                if($item->origen == $producto->origen)
                {
                    $cont++;
                    if($item->nombre == $producto->nombre){
                        $rta->bool = true;
                    }
                }
                array_push($vec,$item->nombre);
            }
            if($rta->bool)
            {           
                $rta->mensaje = "Se encontro coincidencia, hay '$cont' productos.";              
            }
            else
            {
                $vecNombre = array_count_values($vec);
                foreach($vecNombre as $i => $item)
                {
                    if(!$flag){
                        $mayor = $item;
                        $nombreMayor = $i;
                        $flag = true;
                    }else{
                        
                        if($anterior < $item )
                        {
                            $anterior = $item;
                            $mayor = $item;
                            $nombreMayor = $i;
                        }
                    }
                    
                }
                $rta->mensaje = "El producto mas popular es '$nombreMayor', se repite '$mayor' veces."; 
            }
            return json_encode($rta);
        }
    }
?>

