<?php
    class Usuario{
        
        public $id;
        public $correo;
        public $clave;
        public $nombre;
        public $perfil;
        public $descripcion;


        public function MostrarDatos()
        {
            return $this->id." - ".$this->correo." - ".$this->clave." - ".$this->nombre." - ". $this->descripcion;
        }

        public static function TraerTodosLosUsuarios()
        {    
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios
            JOIN `perfiles` ON usuarios.perfil = perfiles.id");        
            
            $consulta->execute();
            
            $consulta->setFetchMode(PDO::FETCH_INTO, new Usuario);                                                

            return $consulta; 
        }

        public static function Login($correo,$clave)
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT *
            FROM `usuarios`
            JOIN `perfiles` ON usuarios.perfil = perfiles.id
            WHERE usuarios.correo = '$correo' && usuarios.clave = '$clave'");        
            
            $consulta->execute();
            
            $consulta->setFetchMode(PDO::FETCH_INTO, new Usuario);                                                

            return $consulta;    
        }

        public static function InsertarElUsuario($correo, $clave, $nombre, $perfil)
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO usuarios (correo, clave, nombre, perfil)"
                                                        . "VALUES(:correo, :clave, :nombre, :perfil)");
            
            $consulta->bindValue(':correo', $correo, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $clave, PDO::PARAM_STR);
            $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $consulta->bindValue(':perfil', $perfil, PDO::PARAM_INT);

            $consulta->execute();

        }

        public static function ModificarUsuario($id, $correo, $clave, $nombre, $perfil)
        {
    
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE usuarios SET correo = :correo, clave = :clave, 
                                                            nombre = :nombre, perfil = :perfil WHERE id = :id");
            
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->bindValue(':correo', $correo, PDO::PARAM_STR);
            $consulta->bindValue(':clave', $clave, PDO::PARAM_STR);
            $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $consulta->bindValue(':perfil', $perfil, PDO::PARAM_INT);
    
            return $consulta->execute();
    
        }

        public static function EliminarUsuario($id)
        {

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM usuarios WHERE id = :id");
            
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);

            return $consulta->execute();

        }
        
    }




?>