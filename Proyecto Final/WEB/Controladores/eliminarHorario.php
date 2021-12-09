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
        $idHorario = $_POST["idHorario"];    
        $usuarioLocal = PBX\UsuarioDatos::getUsuarioById($conexion, $_SESSION["usuario"]); 
        if($usuarioLocal == null || $usuarioLocal->getNivel() == 0){
            $sal["Estado"] = "error";
            $sal["Descripcion"] = "El usuario local no existe o no tiene los permisos";
        }else{
            $horario = PBX\HorarioDeServicioDatos::getHorarioDeServicioById($conexion,$idHorario);
            if($horario == null){
                $sal["Estado"] = "error";
                $sal["Descripcion"] = "El horario no existe";
            }else{
                if(!PBX\HorarioDeServicioDatos::deleteHorarioDeServicio($conexion, $horario)){
                    $sal["Estado"] = "error";
                    $sal["Descripcion"] = "Error al eliminar el horario en la base de datos";
                }else{
                    $sal["Estado"] = "ok";
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