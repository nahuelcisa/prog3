<?php

    class Usuario{
        private $email;
        private $clave;

        public function __construct($email,$clave){
            $this->email = $email;
            $this->clave = $clave;
        }

        public function ToString(){
            return $this->email . "-" . $this->clave;
        }
        public function GuardarEnArchivo(){

            $rta = "hubo un error al guardar.";

            $path = "./archivos/usuarios.txt";

            $archivo = fopen($path,"a");

            if(fwrite($archivo,$this->ToString() . "\n")){
                $rta = "se guardo con exito.";
            }

            return $rta;
        }

        public static function TraerTodos(){
            $path = "./archivos/usuarios.txt";

            $archivo = fopen($path,"a+");

            $usuarios = 0;

            if($archivo != false){
                $lectura = fread($archivo, filesize($path));
                $usuarios = explode("\n",$lectura);
            }

            return $usuarios;
        }

        public static function VerificarExistencia($usuario){

            $usuarios = Usuario::TraerTodos();

            if(in_array($usuario->ToString(),$usuarios)){
                return true;
            }

            return false;
        }
    }

?>