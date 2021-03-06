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
    $usuarioABuscar = (!empty($_GET["usuario"])?$_GET["usuario"]:$_SESSION["usuario"]);
    if(!empty($_SESSION["usuario"])){
        $usuarioLocal = PBX\UsuarioDatos::getUsuarioById($conexion, $_SESSION["usuario"]);        
        if($usuarioLocal == null){
            $sal["Estado"] = "error";
            $sal["Descripcion"] = "El usuario local no existe";
        }else{
            if($usuarioABuscar != $_SESSION["usuario"] && $usuarioLocal->getNivel() == 0){
                $sal["Estado"] = "error";
                $sal["Descripcion"] = "No tiene los permisos necesarios para obtener esa informacion";                  
            }else{
                $usuario = PBX\UsuarioDatos::getUsuarioById($conexion,$usuarioABuscar);
                if($usuario == null){
                    $sal["Estado"] = "error";
                    $sal["Descripcion"] = "El usuario no existe";            
                }else{                    
                    $sal["Usuario"] = $usuario->toAssociativeArray();
                    $sal["Estado"] = "ok";
                    $sal["Permisos"] = array();
                    $permisos = PBX\PermisoLlamadaDatos::getPermisosLlamadaByUsuario($conexion,$usuario);
                    for($i = 0;$i < count($permisos); $i++){
                        $sal["Permisos"][] = $permisos[$i]->toAssociativeArray();
                    }
                    $sal["Horarios"] = array();
                    $horarios = PBX\HorarioDeServicioDatos::getHorariosDeServicioByUsuario($conexion,$usuario);
                    for($i = 0;$i < count($horarios); $i++){
                        $sal["Horarios"][] = $horarios[$i]->toAssociativeArray();
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