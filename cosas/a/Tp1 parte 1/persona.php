<?php

    abstract class Persona{

        protected $_apellido;
        protected $_dni;
        protected $_nombre;
        protected $_sexo;


        public function __construct($nombre, $apellido, $dni, $sexo)
        {
            $this->_nombre = $nombre;
            $this->_apellido = $apellido;
            $this->_dni = $dni;
            $this->_sexo = $sexo;
        }

        public function GetApellido()
        {
            return $this->_apellido;
        }

        public function GetNombre()
        {
            return $this->_nombre;
        }

        public function GetDni()
        {
            return $this->_dni;
        }

        public function GetSexo()
        {
            return $this->_sexo;
        }


        public abstract function Hablar($idioma);


        public function ToString()
        {
            return $this->GetNombre() . " - " . $this->GetApellido() . " - " . $this->GetSexo() . " - " . $this->GetDni();        
        }
    }

?>