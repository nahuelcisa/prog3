<?php

    class Cocinero{

        public $especialidad;
        public $email;
        public $clave;

        public function __construct($especialidad,$email,$clave)
        {
            $this->especialidad = $especialidad;
            $this->email = $email;
            $this->clave = $clave;
        }

        public function ToJSON(){

            $std = new stdClass();

            $std->especialidad = $this->especialidad;
            $std->email = $this->email;
            $std->clave = $this->clave;

            return json_encode($std);
        }

        public function GuardarEnArchivo(){

            $rta = new stdClass();
            $rta->bool = false;
            $rta->mensaje = "Hubo un error al guardar en el archivo.";

            $path = "./archivos/cocinero.json";
            
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

        public static function TraerTodos(){

            $archivo = fopen("./archivos/cocinero.json", "r");

            $lectura = fread($archivo, filesize("./archivos/cocinero.json"));

            $productos = json_decode($lectura);

            $arrayCocineros = [];

            foreach ($productos as $item){

                $aux = new Cocinero($item->especialidad,$item->email,$item->clave);

                array_push($arrayCocineros,$aux);
            }

            return $arrayCocineros;
        }

        public static function VerificarExistencia($cocinero){

            $cocineros = Cocinero::TraerTodos();
            $vec = [];
            $cont = 0;
            $mayor = 0;
            $anterior = 0;
            $nombreMayor = "";
            $flag = false;
            
            $rta = new stdClass();
            $rta->bool = false;
            $rta->mensaje = "No se encontro cocinero.";

            foreach($cocineros as $item)
            {
                if($item->email == $cocinero->email && $item->clave == $cocinero->clave)
                {
                    $cont++;
                    
                        $rta->bool = true;
                    
                }
                array_push($vec,$item->especialidad);
            }
            if($rta->bool)
            {           
                $rta->mensaje = "Se encontro coincidencia, hay '$cont' cocineros con esa especialidad.";              
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
                $rta->mensaje = "La especialidad mas popular es '$nombreMayor', se repite '$mayor' veces."; 
            }
            return json_encode($rta);
        }
    }

?>