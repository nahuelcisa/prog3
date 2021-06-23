<?php
    include_once("Usuario.php");
    include_once("ICrud.php");

    class Empleado extends Usuario implements ICrud
    {
        public $foto;
        public $sueldo;

        public static function TraerTodos()
        {
            $objetoAccesoDatos = AccesoDatos::ObjetoAccesoDatos();

            $query = $objetoAccesoDatos->RetornarConsulta("SELECT empleados.id, empleados.correo, empleados.clave, empleados.nombre, empleados.foto, empleados.sueldo, perfiles.descripcion FROM empleados INNER JOIN perfiles ON empleados.id_perfil = perfiles.id");

            try
            {
                $query->execute();
                return $query->fetchAll(PDO::FETCH_OBJ);
            }
            catch(PDOException $e)
            {
                echo "ERROR: {$e->getMessage()}";
            }

            return $query->fetchAll(PDO::FETCH_OBJ);
        }

        public function Agregar()
        {
          $accesoDatos = AccesoDatos::ObjetoAccesoDatos();

            $sql = "INSERT INTO empleados (id, correo, nombre, clave, id_perfil, foto, sueldo) VALUES (:id, :correo, :nombre, :clave, :id_perfil, :foto, :sueldo)";

            $query = $accesoDatos->RetornarConsulta($sql);

            $query->bindValue(':id', $this->id, PDO::PARAM_INT);
            $query->bindValue(':correo', $this->correo, PDO::PARAM_STR);
            $query->bindValue(':foto', $this->foto, PDO::PARAM_STR);
            $query->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $query->bindValue(':clave', $this->clave, PDO::PARAM_STR);
            $query->bindValue(':sueldo', strval($this->sueldo), PDO::PARAM_STR);
            $query->bindValue(':id_perfil', $this->id_perfil, PDO::PARAM_INT);

            try
            {
                $query->execute();
                if($query->rowCount() > 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch(PDOException $e)
            {
                echo "Error: {$e->getMessage()}";
                return false;
            }
        }      
        
        public function Modificar()
        {
            $accesoDatos = AccesoDatos::ObjetoAccesoDatos();

            $query = $accesoDatos->RetornarConsulta("UPDATE empleados SET correo = :correo, nombre = :nombre, id_perfil = :id_perfil, sueldo = :sueldo, foto = :foto WHERE id = :id");

            $query->bindValue(":correo", $this->correo, PDO::PARAM_STR);
            $query->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
            $query->bindValue(":correo", $this->correo, PDO::PARAM_STR);
            $query->bindValue(":foto", $this->foto, PDO::PARAM_STR);
            $query->bindValue(":sueldo", strval($this->sueldo), PDO::PARAM_STR);
            $query->bindValue(":id_perfil", $this->id_perfil, PDO::PARAM_INT);
            $query->bindValue(":id", $this->id, PDO::PARAM_INT);

            try
            {
                $query->execute();
                if($query->rowCount() > 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch(PDOException $e)
            {
                echo "ERROR: {$e->getMessage()}";
                return false;
            }
        }

        public static function Eliminar($id)
        {
            $accesoDatos = AccesoDatos::ObjetoAccesoDatos();

            $query = $accesoDatos->RetornarConsulta("DELETE FROM empleados WHERE id = :id");

            $query->bindValue(":id", $id, PDO::PARAM_INT);
            
            try
            {
                $query->execute();
                if($query->rowCount() > 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch(PDOException $e)
            {
                echo "ERROR: {$e->getMessage()}";
                return false;
            }
        }
    }
?>