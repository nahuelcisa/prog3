<?php

    require_once ("AccesoDatos.php");
    require_once ("IBM.php");

    class Usuario implements IBM{

        public $id;
        public $nombre;
        public $correo;
        public $clave;
        public $id_perfil;
        public $perfil;


        public function ToJSON()
        {

            $std = new stdClass();

            $std->nombre = $this->nombre;
            $std->correo = $this->correo;
            $std->clave = $this->clave;

            return json_encode($std);
        }

        public function GuardarEnArchivo()
        {
            $rta = new stdClass();
            $rta->bool = false;
            $rta->mensaje = "Hubo un error al guardar en el archivo.";
            
                if(file_exists("archivos/usuarios.json"))
                {
                    $aux1 = fopen("archivos/usuarios.json","r");

                    $aux = fread($aux1, filesize("archivos/usuarios.json"));

                    fclose($aux1);

                    $archivo = fopen("archivos/usuarios.json","w");
                }
                else
                {
                    $archivo = fopen("archivos/usuarios.json","a");
                }


                if(filesize("archivos/usuarios.json") == 0)
                {
                    if(fwrite($archivo, "[". $this->ToJSON() . "]") != 0)
                    {
                        $rta->bool = true;
                        $rta->mensaje = "Se pudo guardar en el archivo.";
                        
                    }

                    fclose($archivo);
                }
                else
                {

                    $lectura = explode("]", $aux);

                        if(fwrite($archivo, $lectura[0] . "," . $this->ToJSON() . "]") != 0)
                        {
                            $rta->bool = true;
                            $rta->mensaje = "Se pudo guardar en el archivo.";
                        }

                        fclose($archivo);

                }
            
            return json_encode($rta);
        }
        
        public static function TraerTodosJSON()
        {

            $archivo = fopen("archivos/usuarios.json", "r");

            $lectura = fread($archivo, filesize("archivos/usuarios.json"));

            $usuarios = json_decode($lectura);

            return $usuarios;
        }

        public function Agregar()
        {
            $retorno = false;

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO usuarios (correo, clave, nombre, id_perfil)"
                                                        . "VALUES(:correo, :clave, :nombre, :id_perfil)");
            
            $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':id_perfil', $this->id_perfil, PDO::PARAM_INT);

            $consulta->execute();

            if($consulta->rowCount() == 1){
                $retorno = true;
            }

            return $retorno;
        }

        public static function TraerTodos()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT usuarios.id, usuarios.nombre, usuarios.correo, usuarios.id_perfil, usuarios.clave ,perfiles.descripcion
            FROM usuarios
            INNER JOIN perfiles
            ON usuarios.id_perfil = perfiles.id");        
            
            $consulta->execute();
            
            return $consulta->fetchAll(PDO::FETCH_OBJ);                                                
            
        }

        public static function TraerUno($params)
        {
            $parametros = json_decode($params);

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT usuarios.nombre, usuarios.correo, usuarios.clave, perfiles.descripcion
            FROM usuarios
            INNER JOIN perfiles
            ON usuarios.id_perfil = perfiles.id 
            WHERE usuarios.correo = '$parametros->correo' && usuarios.clave = '$parametros->clave'");
                                   //:correo                                   :clave      
            //$consulta->bindValue(':correo', $parametros->correo, PDO::PARAM_STR);
            //$consulta->bindValue(':clave', $parametros->clave, PDO::PARAM_STR);   
            
            $consulta->execute();
                                                               
            return $consulta->fetchAll(PDO::FETCH_OBJ); 
        }

        public function Modificar()
        {
            $retorno = false;

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE usuarios SET correo = :correo, clave = :clave, 
                                                            nombre = :nombre, id_perfil = :id_perfil WHERE id = :id");
            
            
            $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':id_perfil', $this->id_perfil, PDO::PARAM_INT);
            $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            
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
            
            $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM usuarios WHERE id = :id");
            
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);

            $consulta->execute();
    
            if($consulta->rowCount() == 1){
                $retorno = true;
            }

            return $retorno;
        }


    }
?>
