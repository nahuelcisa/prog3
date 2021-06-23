<?php
    class AccesoDatos
    {
        private static $accesoDatos;
        private $objetoPDO;

        public function __construct()
        {
            try
            {
                $user = 'root';
                $pass = '';
                $this->objetoPDO = new PDO("mysql:host=localhost; dbname=empleados",$user,$pass);
            }
            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }

        public function RetornarConsulta($sql)
        {
            return $this->objetoPDO->prepare($sql);
        }

        public static function ObjetoAccesoDatos()
        {
            if(!isset(self::$accesoDatos))
            {
                return self::$accesoDatos = new AccesoDatos();
            }

            return self::$accesoDatos;
        }

        public function __clone()
        {
            trigger_error('La clonacion de este objeto no esta permitida.',E_USER_ERROR);
        }
    }
?>
