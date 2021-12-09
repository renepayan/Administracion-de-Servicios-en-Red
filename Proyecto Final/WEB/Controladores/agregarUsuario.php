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
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];
    $nombre = utf8_decode($_POST["nombre"]);
    $sal = array();
    if(empty($_SESSION["usuario"])){
        if(PBX\UsuarioDatos::getUsuarioByNombreDeUsuario($conexion, $usuario) != null){
            $sal["Estado"] = "error";
            $sal["Detalle"] = "El nombre de usuario ya esta registrado";
        }else{
            $nodoDelUsuarioARegistrar = PBX\NodoDatos::getNodoAleatorio($conexion);
            $grupoDelUsuarioARegistrar = PBX\GrupoDatos::getGrupoAleatorio($conexion);
            $extension = PBX\UsuarioDatos::getLastExtension($conexion);
            $extension = (intval($extension)+1)."";        
            $usuarioNuevo = new PBX\Modelos\Usuario(
                null,
                $nombre,
                $usuario,
                $password,
                0,
                $grupoDelUsuarioARegistrar,
                false,
                true,
                true,
                $extension,
                $nodoDelUsuarioARegistrar
            );
            if(!PBX\UsuarioDatos::addUsuario($conexion, $usuarioNuevo)){                                    
                $sal["Estado"] = "error";
                $sal["Descripcion"] = "Error al insertar el usuario en la base de datos";                
            }else{
                $permiso = new PBX\Modelos\PermisoLlamada(null, $usuarioNuevo, $nodoDelUsuarioARegistrar, $nodoDelUsuarioARegistrar);
                if(!PBX\PermisoLlamadaDatos::addPermisoLlamada($conexion, $permiso)){
                    $sal["Estado"] = "error";
                    $sal["Descripcion"] = "Error al insertar el permiso de llamada en la base de datos";  
                }else{                    
                    for($i = 0; $i <= 5;$i++){
                        $horario = new PBX\Modelos\HorarioDeServicio(null, $usuarioNuevo, $i, new \DateTime("15:00"), new \DateTime("20:00"));
                        PBX\HorarioDeServicioDatos::addHorarioDeServicio($conexion, $horario);
                    }                    
                    $sal["Estado"] = "ok";                                    
                    $_SESSION["usuario"] = $nuevoUsuario->getId();
                }
            }                        
        }
    }else{
        $idUsuarioEnSesion = $_SESSION["usuario"];
        $usuarioEnSesion = PBX\UsuarioDatos::getUsuarioById($conexion, $idUsuarioEnSesion);
        if($usuarioEnSesion == null){
            session_destroy();
            $sal["Estado"] = "error";
            $sal["Detalle"] = "El usuario no existe en la base de datos";
        }else{
            if($usuarioEnSesion->getNivel() != 1){ //No es un administrador, no puede registrar usuarios
                $sal["Estado"] = "error";
                $sal["Detalle"] = "El usuario no es administrador, no tiene permisos para registrar";
            }else{
                $grupoDelUsuarioARegistrar = PBX\GrupoDatos::getGrupoById($conexion, $_POST["grupo"]);
                if($grupoDelUsuarioARegistrar == null){ //El grupo no existe
                    $sal["Estado"] = "error";
                    $sal["Detalle"] = "El grupo no existe";
                }else{
                    $nodoDelUsuarioARegistrar = PBX\NodoDatos::getNodoById($conexion, $_POST["nodo"]);
                    if($nodoDelUsuarioARegistrar == null){ //El nodo no existe
                        $sal["Estado"] = "error";
                        $sal["Detalle"] = "El nodo no existe";
                    }else{
                        if(PBX\UsuarioDatos::getUsuarioByNombreDeUsuario($conexion, $usuario) != null){
                            $sal["Estado"] = "error";
                            $sal["Detalle"] = "El nombre de usuario ya esta registrado";
                        }else{
                            if(PBX\UsuarioDatos::getUsuarioByExtension($conexion, $_POST["extension"]) != null){
                                $sal["Estado"] = "error";
                                $sal["Detalle"] = "La extension ya esta en uso";
                            }else{
                                $usuarioNuevo = new PBX\Modelos\Usuario(
                                    null,
                                    $nombre,
                                    $usuario,
                                    $password,
                                    $_POST["nivel"],
                                    $grupoDelUsuarioARegistrar,
                                    $_POST["grabarLlamadas"],
                                    $_POST["llamarAGrupos"],
                                    $_POST["llamarExtensiones"],
                                    $_POST["extension"],
                                    $nodoDelUsuarioARegistrar
                                );
                                if(PBX\UsuarioDatos::addUsuario($conexion, $usuarioNuevo)){                                    
                                    $sal["Estado"] = "ok";                                    
                                }else{
                                    $sal["Estado"] = "error";
                                    $sal["Descripcion"] = "Error al insertar en la base de datos";
                                }
                            }
                        }                        
                    }
                }                
            }
        }
    }                
    $conexion->close();
    //ob_clean();    
    header("Content-type: application/json");
    echo(json_encode($sal));
?>