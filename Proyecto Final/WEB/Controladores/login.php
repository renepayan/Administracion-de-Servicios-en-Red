<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once '../Clases/Modelos/Usuario.php';
    require_once '../Clases/UsuarioDatos.php';
    require_once 'ajustes.php';
    session_start();
    $conexion = new mysqli(HOST_DB, USUARIO_DB, PASSWORD_DB, NOMBRE_DB);       
    $sal = array();
    if(empty($_SESSION["usuario"])){
        $usuario = $_POST["usuario"];
        $password = $_POST["password"];    
        $usuarioEnSistema = PBX\UsuarioDatos::getUsuarioByUsuarioAndPassword($conexion, $usuario, $password);
        if($usuarioEnSistema == null){
            $sal["Estado"] = "error";
            $sal["Descripcion"] = "Usuario no encontrado o contraseña incorrecta";
        }else{
            $sal["Estado"] = "ok";
            $_SESSION["usuario"] = $usuarioEnSistema->getId();
        }
    }else{
        $sal["Estado"] = "error";
        $sal["Descripcion"] = "El usuario ya esta logueado";
    }
    $conexion->close();
    ob_clean();    
    header("Content-type: application/json");
    echo(json_encode($sal));
?>