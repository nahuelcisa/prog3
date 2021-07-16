<?php

use Slim\Psr7\Response;
use Slim\Psr7\Request;

require_once __DIR__ . '/ISlimeable.php';
require_once("AccesoDatos.php");

class Usuario implements ISlimeable
{
    public $id;
    public $nombre;
    public $correo;
    public $apellido;
    public $clave;
    public $id_perfil;
    public $descripcion;

    public function MostrarDatos()
    {
        return $this->id . " - " . $this->correo . " - " . $this->clave . " - " . $this->nombre . " - " . $this->descripcion;
    }

    public static function mostrarUsuarios()
    {
        try {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            $query = $accesoDatos->RetornarConsulta("SELECT usuarios.id, usuarios.correo, usuarios.clave, usuarios.nombre, usuarios.apellido, usuarios.id_perfil, perfiles.descripcion, perfiles.estado FROM usuarios INNER JOIN perfiles ON perfiles.id = usuarios.id_perfil");
            $query->execute();
            $query->setFetchMode(PDO::FETCH_OBJ);
        } catch (Exception $e) {
        }
        return $query->fetchAll();
    }

    public static function mostrarUsuario($id)
    {
        try {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            $query = $accesoDatos->RetornarConsulta("SELECT usuarios.id, usuarios.correo, usuarios.clave, usuarios.nombre, usuarios.apellido, usuarios.id_perfil, perfiles.descripcion, perfiles.estado FROM usuarios INNER JOIN perfiles ON perfiles.id = usuarios.id_perfil where usuarios.id = :id");
            $query->bindValue(':id', $id);
            $query->execute();
            $query->setFetchMode(PDO::FETCH_INTO, new usuario);
        } catch (Exception $e) {
        }
        return $query->fetch();
    }

    public static function verificarUsuario($correo, $clave)
    {
        try {
            $accesoDatos = AccesoDatos::DameUnObjetoAcceso();
            $query = $accesoDatos->RetornarConsulta("SELECT * FROM usuarios where clave = :clave AND correo = :correo");
            $query->bindValue(':clave', $clave);
            $query->bindValue(':correo', $correo);
            $query->execute();
        } catch (Exception $e) {
        }
        return $query->fetchObject();
    }

    public static function agregarUsuario($correo, $clave, $nombre, $apellido, $perfil, $foto)
    {
        $retValue = false;
        if (Usuario::validarFoto($foto)) {
            $filename = $foto->getClientFilename();
            $extension = explode(".", $filename);
            $destino = "./../fotos/" . $nombre . "." . date("Gis") . '.' . array_reverse($extension)[0];
            try {
                $conex = AccesoDatos::DameUnObjetoAcceso();
                $query = $conex->RetornarConsulta("INSERT INTO usuarios (correo,clave,nombre,apellido,foto,id_perfil) VALUES (:correo, :clave, :nombre, :apellido,:foto , :perfil)");
                $query->bindValue(':correo', $correo, PDO::PARAM_STR);
                $query->bindValue(':clave', $clave, PDO::PARAM_STR);
                $query->bindValue(':nombre', $nombre, PDO::PARAM_STR);
                $query->bindValue(':apellido', $apellido, PDO::PARAM_STR);
                $query->bindValue(':foto', $destino, PDO::PARAM_STR);
                $query->bindValue(':perfil', $perfil, PDO::PARAM_INT);
                $query->execute();
                if ($query->rowCount() > 0) {
                    $foto->moveTo(__DIR__ . $destino);
                    $retValue = true;
                }
            } catch (Exception $e) {
            }
        }

        return $retValue;
    }

    public static function modificarUsuario($id, $correo, $clave, $nombre, $apellido, $perfil)
    {
        $retValue = false;
        try {
            $conex = AccesoDatos::DameUnObjetoAcceso();
            $query = $conex->RetornarConsulta("UPDATE usuarios SET correo = :correo, clave = :clave, nombre = :nombre, apellido = :apellido ,id_perfil = :perfil WHERE id = :id");
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->bindValue(':correo', $correo, PDO::PARAM_STR);
            $query->bindValue(':clave', $clave, PDO::PARAM_STR);
            $query->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $query->bindValue(':apellido', $apellido, PDO::PARAM_STR);
            $query->bindValue(':perfil', $perfil, PDO::PARAM_INT);
            $query->execute();
            if ($query->rowCount() > 0) {
                $retValue = true;
            }
        } catch (Exception $e) {
        }

        return $retValue;
    }

    public static function eliminarUsuario($id)
    {
        $retValue = false;
        try {
            $conex = AccesoDatos::DameUnObjetoAcceso();
            $query = $conex->RetornarConsulta("DELETE FROM usuarios WHERE id = :id");
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();
            if ($query->rowCount() > 0) {
                $retValue = true;
            }
        } catch (Exception $e) {
        }

        return $retValue;
    }

    public static function guardarFoto($nombre, $foto)
    {
        $filename = $foto->getClientFilename();
        $extension = explode(".", $filename);
        $destino = "./../fotos/" . $nombre . "." . date("Gis") . '.' . array_reverse($extension)[0];
        $foto->moveTo($destino);
    }

    public static function validarFoto($foto)
    {
        $retValue = false;
        if ($foto->getError() === UPLOAD_ERR_OK) {
            if ($foto != FALSE) {
                $filename = $foto->getClientFilename();
                $extension = explode(".", $filename);
                $extension = array_reverse($extension)[0];
                if ($extension == "jpg" ||  $extension == "bmp" ||  $extension == "gif" ||  $extension == "png" ||  $extension == "jpeg") {
                    $retValue = true;
                }
            }
        }
        return $retValue;
    }

    function TraerTodos(Request $request, Response $response, array $args): Response
    {
        $newResponse = $response->withStatus(200, "Salio piola");
        $newResponse->getBody()->write(json_encode(Usuario::mostrarUsuarios()));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }
    function TraerUno(Request $request, Response $response, array $args): Response
    {
        $newResponse = $response->withStatus(200, "Salio piola");
        $newResponse->getBody()->write(json_encode(Usuario::mostrarUsuario($args['id'])));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }
    function AgregarUno(Request $request, Response $response, array $args): Response
    {
        $archivos = $request->getUploadedFiles();
        $params = $request->getParsedBody();
        $newResponse = $response->withStatus(200, "Salio piola");
        $newResponse->getBody()->write(json_encode(Usuario::agregarUsuario($params['correo'], $params['clave'], $params['nombre'], $params['apellido'], $params['perfil'], $archivos['foto'])));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }
    function ModificarUno(Request $request, Response $response, array $args): Response
    {
        $params = json_decode($args['cadenaJson']);
        $newResponse = $response->withStatus(200, "Salio piola");
        $newResponse->getBody()->write(json_encode(Usuario::modificarUsuario($params->id, $params->correo, $params->clave, $params->nombre, $params->apellido, $params->perfil)));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }
    function BorrarUno(Request $request, Response $response, array $args): Response
    {
        $newResponse = $response->withStatus(200, "Salio piola");
        $newResponse->getBody()->write(json_encode(Usuario::eliminarUsuario($args['id'])));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }

    function verificarUno(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParsedBody();
        $newResponse = $response->withStatus(200, "Salio piola");
        $newResponse->getBody()->write(json_encode(Usuario::verificarUsuario($params['correo'], $params['clave'])));
        return $newResponse->withHeader('Content-Type', 'application/json');
    }
}
