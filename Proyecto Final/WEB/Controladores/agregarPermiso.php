<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once '../Clases/Modelos/Usuario.php';
    require_once '../Clases/Modelos/Nodo.php';
    require_once '../Clases/Modelos/Grupo.php';
    require_once '../Clases/Modelos/PermisoLlamada.php';
    require_once '../Clases/Modelos/HorarioDeServicio.php';
    require_once '../Clases/UsuarioDatos.php';
    require_once '../Clases/PermisoLlamadaDatos.php';
    require_once '../Clases/HorarioDeServicioDatos.php';
    require_once '../Clases/NodoDatos.php';
    require_once '../Clases/GrupoDatos.php';
    require_once 'ajustes.php';
    session_start();
    $conexion = new mysqli(HOST_DB, USUARIO_DB, PASSWORD_DB, NOMBRE_DB);    
    $sal = array();
    if(!empty($_SESSION["usuario"])){       
        $idNodoOrigen = $_POST["idNodoOrigen"];
        $idNodoDestino = $_POST["idNodoDestino"];
        $idUsuario = $_POST["idUsuario"];

        $usuarioLocal = PBX\UsuarioDatos::getUsuarioById($conexion, $_SESSION["usuario"]); 
        if($usuarioLocal == null || $usuarioLocal->getNivel() == 0){
            $sal["Estado"] = "error";
            $sal["Descripcion"] = "El usuario local no existe o no tiene los permisos";
        }else{
            $nodoOrigen = PBX\NodoDatos::getNodoById($conexion, $idNodoOrigen);
            if($nodoOrigen == null){
                $sal["Estado"] = "error";
                $sal["Descripcion"] = "El nodo de origen no existe";
            }else{ 
                $nodoDestino = PBX\NodoDatos::getNodoById($conexion, $idNodoDestino);
                if($nodoDestino == null){
                    $sal["Estado"] = "error";
                    $sal["Descripcion"] = "El nodo de destino no existe";
                }else{
                    $usuario = PBX\UsuarioDatos::getUsuarioById($conexion, $idUsuario);
                    if($usuario == null){
                        $sal["Estado"] = "error";
                        $sal["Descripcion"] = "El usuario no existe";
                    }else{
                        $nuevoPermiso = new PBX\Modelos\PermisoLlamada(null,$usuario,$nodoOrigen,$nodoDestino);
                        if(!PBX\PermisoLlamadaDatos::addPermiso($conexon,$nuevoPermiso)){
                            $sal["Estado"] = "error";
                            $sal["Descripcion"] = "Error al insertar el nuevo permiso en la base de datos";
                        }else{
                            $sal["Estado"] = "ok";
                        }
                    }
                }
            }       
        }
    }else{
        $sal["Estado"] = "error";
        $sal["Descripcion"] = "El usuario no esta logueado";
    }
    $conexion->close();
    ob_clean();    
    //print_r($sal);
    header("Content-type: application/json");
    echo(json_encode($sal,JSON_UNESCAPED_UNICODE));
?>