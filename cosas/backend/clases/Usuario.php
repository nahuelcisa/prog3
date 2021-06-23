<?php
    include_once("./clases/accesoDatos.php");
    include_once("./clases/IBM.php");
    
    class Usuario implements IBM
    {
        public $id;
        public $nombre;
        public $correo;
        public $clave;
        public $id_perfil;
        public $perfil;
        public $descripcion;

        public function ToJSON()
        {
            $obj = new stdClass();
            $obj->nombre = $this->nombre;
            $obj->correo = $this->correo;
            $obj->clave = $this->clave;
            
            return json_encode($obj);
        }

        public function GuardarEnArchivo()
        {
            $path = "./archivos/usuarios.json";

            $archivo = fopen($path, "r+");
            $size = filesize($path);
            $retornoJSON = new stdClass();

            if($size > 0)
            {  
                $obj = new stdClass();
                $obj->correo = $this->correo;
                $obj->clave = $this->clave;
                $obj->nombre = $this->nombre;


                $array = $this->TraerTodosJSON();
                array_push($array, $obj);

                if(fwrite($archivo, json_encode($array)) != 0)
                {
                    $retornoJSON->exito = true;
                    $retornoJSON->mensaje= "usuario guardado correctamente";
                    fclose($archivo);
                    return json_encode($retornoJSON);
                }
                else
                {
                    $retornoJSON->exito = false;
                    $retornoJSON->mensaje= "Error al guardar el archivo";
                    fclose($archivo);
                    return json_encode($retornoJSON);
                }
            }
            else
            {
                if(fwrite($archivo, '[' . $this->ToJSON() . ']') != 0)
                {
                    $retornoJSON->exito = true;
                    $retornoJSON->mensaje= "usuario guardado correctamente";
                    fclose($archivo);
                    return json_encode($retornoJSON);
                }
                else
                {
                    $retornoJSON->exito = false;
                    $retornoJSON->mensaje= "Error al guardar el archivo";
                    fclose($archivo);
                    return json_encode($retornoJSON);
                }
            }
        }

        public static function TraerTodosJSON()
        {
            $path = "./archivos/usuarios.json";

            $archivo = fopen($path, "r");

            $json = fread($archivo,filesize($path));

            fclose($archivo);
            
            return json_decode($json);
        }

        public function Agregar()
        {
            $accesoDatos = AccesoDatos::ObjetoAccesoDatos();

            $sql = "INSERT INTO usuarios (correo, nombre, clave, perfil) VALUES (:correo, :nombre, :clave, :id_perfil)";

            $query = $accesoDatos->RetornarConsulta($sql);

            $query->bindValue(':correo', $this->correo, PDO::PARAM_STR);
            $query->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $query->bindValue(':clave', $this->clave, PDO::PARAM_STR);
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


        public static function TraerTodos()
        {
            $objetoAccesoDatos = AccesoDatos::ObjetoAccesoDatos();

            $query = $objetoAccesoDatos->RetornarConsulta("SELECT usuarios.id, usuarios.nombre, usuarios.correo, usuarios.perfil, perfiles.descripcion FROM usuarios INNER JOIN perfiles ON usuarios.perfil = perfiles.id");

            try
            {
                $query->execute();
                return $query->fetchAll(PDO::FETCH_OBJ);
            }
            catch(PDOException $e)
            {
                echo "ERROR: {$e->getMessage()}";
            }
        }

        public static function TraerUno($correo, $clave)
        {
            $accesoDatos = AccesoDatos::ObjetoAccesoDatos();

            $query = $accesoDatos->RetornarConsulta("SELECT correo, clave FROM usuarios WHERE (correo = :correo AND clave = :clave)");
            
            $query->bindValue(':correo',$correo,PDO::PARAM_STR);
            $query->bindValue(':clave',$clave,PDO::PARAM_STR);
            
            try
            {
                $query->execute();
                $user = $query->fetchAll(PDO::FETCH_ASSOC);
                return $user;
            }
            catch(PDOException $e)
            {
                echo "ERROR: {$e->getMessage()}";
            }
        }

        public function Modificar()
        {
            $accesoDatos = AccesoDatos::ObjetoAccesoDatos();

            $query = $accesoDatos->RetornarConsulta("UPDATE usuarios SET correo = :correo, nombre = :nombre, perfil = :perfil WHERE id = :id");

            $query->bindValue(":correo", $this->correo, PDO::PARAM_STR);
            $query->bindValue(":nombre", $this->nombre, PDO::PARAM_STR);
            $query->bindValue(":perfil", $this->perfil, PDO::PARAM_INT);
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

            $query = $accesoDatos->RetornarConsulta("DELETE FROM usuarios WHERE id = :id");

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