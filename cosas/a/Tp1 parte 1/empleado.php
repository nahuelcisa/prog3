<?php

    require_once "persona.php";

    class Empleado extends Persona
    {

        protected $_legajo;
        protected $_sueldo;
        protected $_turno;

        public function __construct($nombre, $apellido, $dni, $sexo, $legajo, $sueldo, $turno)
        {
            parent::__construct($nombre, $apellido, $dni, $sexo);

            $this->_legajo = $legajo;

            $this->_sueldo = $sueldo;

            $this->_turno = $turno;                               
        }

        public function GetLegajo()
        {
            return $this->_legajo;
        }

        public function GetSueldo()
        {
            return $this->_sueldo;
        }

        public function GetTurno()
        {
            return $this->_turno;
        }

        public function Hablar($idioma)
        {

            $str1 = "El empleado habla: ";
            $str2 = "";

            foreach($idioma as $valor){
                if($str2 == ""){
                    $str2 = $str2 . $valor;
                }
                else
                {
                    $str2 = $str2 . ", " . $valor;
                }
            }

            return $str1 . $str2;
        }

        public function ToString()
        {
            return parent::ToString() . " - " . $this->GetLegajo() . " - " . $this->GetSueldo() . " - " . $this->GetTurno();
        }

    }
?>