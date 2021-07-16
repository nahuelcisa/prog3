<?php
class AccesoDatos
{
    private static $objetoAccesoDatos;
    private $objetoPDO;
 
    private function __construct()
    {
        try {
 
            /* $usuario='id16773233_mazzu';
            $clave='XOSzP3yLv5s]vCMV';

            $this->objetoPDO = new PDO('mysql:host=localhost;dbname=id16773233_usuarios_bd;charset=utf8', $usuario, $clave);  */
 
            $usuario='root';
            $clave='';

            $this->objetoPDO = new PDO('mysql:host=localhost;dbname=cdcol;charset=utf8', $usuario, $clave);

        } catch (PDOException $e) {
 
            print "Error!!!<br/>" . $e->getMessage();
 
            die();
        }
    }
 
    public function RetornarConsulta($sql)
    {
        return $this->objetoPDO->prepare($sql);
    }
 
    public function LastInsertId()
    {
        return $this->objetoPDO->lastInsertId();
    }

    public static function DameUnObjetoAcceso()//singleton
    {
        if (!isset(self::$objetoAccesoDatos)) {       
            self::$objetoAccesoDatos = new AccesoDatos(); 
        }
        return self::$objetoAccesoDatos;
    }
 
    // Evita que el objeto se pueda clonar
    public function __clone()
    {
        trigger_error('La clonaci&oacute;n de este objeto no est&aacute; permitida!!!', E_USER_ERROR);
    }
}
