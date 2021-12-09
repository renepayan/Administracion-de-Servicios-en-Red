<?php
    require_once 'Clases/Modelos/Usuario.php';
    require_once 'Clases/UsuarioDatos.php';
    require_once 'ajustes.php';
    session_start();
    $conexion = new mysqli(HOST_DB, USUARIO_DB, PASSWORD_DB, NOMBRE_DB);       
    $sal = array();
    if(empty($_SESSION["usuario"])){
        $usuario = $_POST["usuario"];
        $password = $_POST["password"];    
        $usuarioEnSistema = UsuarioDatos::getUsuarioByUsuarioAndPassword($conexion, $usuario, $password);
        if($usuarioEnSistema == null){
            $sal["Estado"] = "error";
        }else{
            $sal["Estado"] = "ok";
            $_SESSION["Usuario"] = $usuarioEnSistema->getId();
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