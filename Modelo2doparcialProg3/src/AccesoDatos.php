<?php
    class AccesoDatos{

        private static $_objAccesoDatos;
        private $_objetoPDO;

        private function __construct()
        {
            try 
            {
    
                $usuario="root";
                $clave="";

                $this->_objetoPDO = new PDO('mysql:host=localhost;dbname=concesionaria_bd;charset=utf8', $usuario, $clave);
    
            } 
            catch (PDOException $e) 
            {
    
                print "Error!!!<br/>" . $e->getMessage();
    
                die();
            }
        }

        public function RetornarConsulta($sql)
        {
            return $this->_objetoPDO->prepare($sql);
        }

        public static function DameUnObjetoAcceso()
        {
            if (!isset(self::$_objAccesoDatos)) 
            {       
                self::$_objAccesoDatos = new AccesoDatos(); 
            }
    
            return self::$_objAccesoDatos;        
        }

        public function __clone()
        {
            trigger_error('La clonaci&oacute;n de este objeto no est&aacute; permitida!!!', E_USER_ERROR);
        }

        public function RetornarUltimoIdInsertado()
        {
            return $this->_objetoPDO->lastInsertId();
        }
    }
?>