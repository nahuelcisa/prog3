<?php

    require_once "persona.php";
    require_once "empleado.php"; 
    require_once "interfaces.php";

    class Fabrica implements IArchivo{       

        private $_cantidadMaxima;
        private $_empleados;
        private $_razonSocial;

        public function __construct($razonsocial, $_cantmax = 5)
        {
            $this->_cantidadMaxima = $_cantmax;
            $this->_empleados = array();
            $this->_razonSocial = $razonsocial;

        }

        public function AgregarEmpleado($emp)
        {
            $rta = false;
            if($this->_cantidadMaxima > count($this->_empleados))
            {
                array_push($this->_empleados,$emp);
                $this->EliminarEmpleadoRepetido();
                $rta = true;
            }

            return $rta;

        }

        public function CalcularSueldos()
        {
            $count = 0;

            foreach($this->_empleados as $item)
            {
                $count += $item->GetSueldo();
            }

            return $count;
        }

        public function EliminarEmpleado($emp)
        {
            $rta = false;

            foreach($this->_empleados as $key => $value)
            {
                if($value == $emp){
                    unset($this->_empleados[$key]);
                    $rta = true;
                    break;
                }
            }

            return $rta;
        }

        private function EliminarEmpleadoRepetido()
        {
            $this->_empleados = array_unique($this->_empleados,SORT_REGULAR);
        }

        public function ToString()
        {
            $cadena = "";

            $cadena = "-Cantidad maxima: $this->_cantidadMaxima <br>";

            foreach($this->_empleados as $item)
            {
                $cadena .= "<br>" . $item->ToString() . "<br>";
            }

            $cadena .= "<br>-Razon Social: $this->_razonSocial <br>";

            $cadena .= "-Sueldos Totales: " . $this->CalcularSueldos();

            return $cadena;
        }

        public function TraerDeArchivo($nArchivo)
        {
            
            $archivo = fopen($nArchivo,"r");
        
            if(file_exists($nArchivo))
            {
                if(filesize($nArchivo))
                {
                    do
                    {
                        $cadena = fgets($archivo);
                        $cadena = is_string($cadena) ? trim($cadena) : false;
                        if($cadena != false)
                        {
                            $arr = explode(" - ", $cadena);
                            if($arr[0] != "" && $arr[0] != "\r\n")
                            {   
                            $empleado = new Empleado($arr[0],
                            $arr[1],
                            $arr[3],
                            $arr[2],
                            $arr[4],
                            $arr[5],
                            $arr[6]);
                            $this->AgregarEmpleado($empleado);
                            }
                        }
                        
                    }while(!feof($archivo));
                }
                fclose($archivo);
            }
            return $this;
        }

        public function GuardarArchivo($nArchivo)
        {
            $archivo = fopen($nArchivo,"w");
            if(file_exists($nArchivo))
            {
                foreach($this->_empleados as $item)
                {
                    $cadena = $item->toString() . PHP_EOL;
                    fwrite($archivo,$cadena);
                }
                fclose($archivo);
                return true;
            }
            return false;
        }
    }
?>