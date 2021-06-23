<?php

    require_once ("ICRUD.php");
    require_once ("AccesoDatos.php");
    require_once ("Usuario.php");

    class Empleado extends Usuario implements ICRUD
    {
        public $foto;
        public $sueldo;

        public static function TraerTodos()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT empleados.id,empleados.correo,empleados.clave,empleados.nombre,empleados.sueldo
            ,empleados.foto,empleados.id_perfil,perfiles.descripcion
            FROM empleados
            INNER JOIN perfiles
            ON empleados.id_perfil = perfiles.id");        
            
            $consulta->execute();
            
            return $consulta->fetchAll(PDO::FETCH_OBJ);                                                
        }

        public function Agregar()
        {
            $retorno = false;

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO empleados (id,correo, clave, nombre, id_perfil,foto,sueldo)"
                                                        . "VALUES(:id,:correo, :clave, :nombre, :id_perfil,:foto,:sueldo)");

            $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':id_perfil', $this->id_perfil, PDO::PARAM_INT);
            $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
            $consulta->bindValue(':sueldo',strval($this->sueldo), PDO::PARAM_STR);

            $consulta->execute();

            if($consulta->rowCount() == 1){
                $retorno = true;
            }

            return $retorno;
        }

        public function Modificar()
        {
            $retorno = false;

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE empleados SET correo = :correo, clave = :clave, 
                                                            nombre = :nombre, id_perfil = :id_perfil, foto = :foto, sueldo = :sueldo 
                                                            WHERE id = :id");
            
            
            $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':id_perfil', $this->id_perfil, PDO::PARAM_INT);
            $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
            $consulta->bindValue(':sueldo',strval($this->sueldo), PDO::PARAM_STR);
            
            $consulta->execute();
    
            if($consulta->rowCount() == 1){
                $retorno = true;
            }

            return $retorno;
        }

        public static function Eliminar($id)
        {
            $retorno = false;

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM empleados WHERE id = :id");
            
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);

            $consulta->execute();
    
            if($consulta->rowCount() == 1){
                $retorno = true;
            }

            return $retorno;
        }
    }
?>