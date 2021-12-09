<?php
    require_once 'Clases/Modelos/Usuario.php';
    require_once 'Clases/UsuarioDatos.php';
    require_once 'ajustes.php';
    session_start();
    $conexion = new mysqli(HOST_DB, USUARIO_DB, PASSWORD_DB, NOMBRE_DB);
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];
    $nombre = $_POST["nombre"];
    $sal = array();
    if(empty($_SESSION["usuario"])){
        if(UsuarioDatos::getUsuarioByNombreDeUsuario($conexion, $usuario) != null){
            $sal["Estado"] = "error";
            $sal["Detalle"] = "El nombre de usuario ya esta registrado";
        }else{
            $nodoDelUsuarioARegistrar = NodoDatos::getNodoAleatorio($conexion);
            $grupoDelUsuarioARegistrar = GrupoDatos::getGrupoAleatorio($conexion);
            $extension = UsuarioDatos::getLastExtension($conexion);
            $extension = (intval($extension)+1)."";        
            $usuarioNuevo = new Usuario(
                null,
                $nombre,
                $usuario,
                0,
                $grupoDelUsuarioARegistrar,
                false,
                true,
                true,
                $extension,
                $nodoDelUsuarioARegistrar
            );
            if(UsuarioDatos::agregarUsuario($conexion, $usuarioNuevo)){                                    
                $sal["Estado"] = "ok";                                    
                $_SESSION["usuario"] = $nuevoUsuario->getId();
            }else{
                $sal["Estado"] = "error";
                $sal["Descripcion"] = "Error al insertar en la base de datos";
            }                        
        }
    }else{
        $idUsuarioEnSesion = $_SESSION["usuario"];
        $usuarioEnSesion = UsuarioDatos::getUsuarioById($conexion, $idUsuarioEnSesion);
        if($usuarioEnSesion == null){
            session_destroy();
            $sal["Estado"] = "error";
            $sal["Detalle"] = "El usuario no existe en la base de datos";
        }else{
            if($usuarioEnSesion->getNivel() != 1){ //No es un administrador, no puede registrar usuarios
                $sal["Estado"] = "error";
                $sal["Detalle"] = "El usuario no es administrador, no tiene permisos para registrar";
            }else{
                $grupoDelUsuarioARegistrar = GrupoDatos::getGrupoById($conexion, $_POST["grupo"]);
                if($grupoDelUsuarioARegistrar == null){ //El grupo no existe
                    $sal["Estado"] = "error";
                    $sal["Detalle"] = "El grupo no existe";
                }else{
                    $nodoDelUsuarioARegistrar = NodoDatos::getNodoById($conexion, $_POST["nodo"]);
                    if($nodoDelUsuarioARegistrar == null){ //El nodo no existe
                        $sal["Estado"] = "error";
                        $sal["Detalle"] = "El nodo no existe";
                    }else{
                        if(UsuarioDatos::getUsuarioByNombreDeUsuario($conexion, $usuario) != null){
                            $sal["Estado"] = "error";
                            $sal["Detalle"] = "El nombre de usuario ya esta registrado";
                        }else{
                            if(UsuarioDatos::getUsuarioByExtension($conexion, $_POST["extension"]) != null){
                                $sal["Estado"] = "error";
                                $sal["Detalle"] = "La extension ya esta en uso";
                            }else{
                                $usuarioNuevo = new Usuario(
                                    null,
                                    $nombre,
                                    $usuario,
                                    $_POST["nivel"],
                                    $grupoDelUsuarioARegistrar,
                                    $_POST["grabarLlamadas"],
                                    $_POST["llamarAGrupos"],
                                    $_POST["llamarExtensiones"],
                                    $_POST["extension"],
                                    $nodoDelUsuarioARegistrar
                                );
                                if(UsuarioDatos::agregarUsuario($conexion, $usuarioNuevo)){                                    
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
    ob_clean();    
    header("Content-type: application/json");
    echo(json_encode($sal));
?>