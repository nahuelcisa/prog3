<?php
    require_once("empleado.php");
    require_once("IArchivo.php");

    class Fabrica implements IArchivo
    {
        private $_cantidadMaxima;
        private $_empleados;
        private $_razonSocial;

        public function __construct($razonSocial, $cantidad = 5)
        {
            $this->_cantidadMaxima = $cantidad;
            $this->_empleados = array();
            $this->_razonSocial = $razonSocial;
        }

        public function GetEmpleados()
        {
            return $this->_empleados;
        }

        public function AgregarEmpleado($empleado)
        {
            if(is_object($empleado) && get_class($empleado) == "Empleado")
            {
                if($this->_cantidadMaxima > count($this->_empleados))
                {
                    array_push($this->_empleados, $empleado);
                    $this->EliminarEmpleadosRepetidos();
                    return true;
                }
            }
            return false;
        }

        public function CalcularSueldos()
        {
            $total = 0;

            foreach($this->_empleados as $item)
            {
                $total += $item->GetSueldo(); 
            }

            return $total;
        }

        public function EliminarEmpleado($empleado)
        {
            foreach($this->_empleados as $key => $value)
            {
                if($value->GetLegajo() === $empleado->GetLegajo())
                {
                    unset($this->_empleados[$key]);
                    return true;
                }
            } 
            return false;
        }

        private function EliminarEmpleadosRepetidos()
        {
            $this->_empleados = array_unique($this->_empleados, SORT_REGULAR);
        }
        
        public function ToString()
        {
            $resultado = "Cantidad maxima de empleados: $this->_cantidadMaxima <br> $this->_razonSocial <br>";

            foreach($this->_empleados as $item)
            {
                $resultado .= $item->__toString();
            }

            $resultado .= "Sueldo total a pagar: " . $this->CalcularSueldos() . "<br>";

            return $resultado;
        }

        public function TraerDeArchivo($nombreArchivo)
        {
            
            $archivo = fopen($nombreArchivo,"r");
        
            if(file_exists($nombreArchivo))
            {
                if(filesize($nombreArchivo))
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
                                $empleado = new Empleado($arr[1],$arr[2],$arr[0],$arr[3],$arr[4],$arr[5],$arr[6]);
                                $empleado->SetPathFoto($arr[7]);
                                $this->AgregarEmpleado($empleado);
                            }
                        }
                        
                    }while(!feof($archivo));
                }
                fclose($archivo);
            }
        }

        public function GuardarArchivo($nombreArchivo)
        {
            $archivo = fopen($nombreArchivo,"w");
            if(file_exists($nombreArchivo))
            {
                foreach($this->_empleados as $item)
                {
                    $cadena = $item->__toString() . PHP_EOL;
                    fwrite($archivo,$cadena);
                }
                fclose($archivo);
                return true;
            }
            return false;
        }
    }
?>