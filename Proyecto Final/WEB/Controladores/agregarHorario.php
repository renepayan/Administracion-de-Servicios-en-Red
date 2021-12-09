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
        $diaDeLaSemana = intval($_POST["diaDeLaSemana"]);
        $horaInicio = new \DateTime($_POST["horaInicio"]);
        $horaFin = new \DateTime($_POST["horaFin"]);
        $idUsuario = $_POST["idUsuario"];

        $usuarioLocal = PBX\UsuarioDatos::getUsuarioById($conexion, $_SESSION["usuario"]); 
        if($usuarioLocal == null || $usuarioLocal->getNivel() == 0){
            $sal["Estado"] = "error";
            $sal["Descripcion"] = "El usuario local no existe o no tiene los permisos";
        }else{
            $usuario = PBX\UsuarioDatos::getUsuarioById($conexion, $idUsuario);
            if($usuario == null){
                $sal["Estado"] = "error";
                $sal["Descripcion"] = "El usuario no existe";
            }else{
                if($diaDeLaSemana < 0 || $diaDeLaSemana > 6){
                    $sal["Estado"] = "error";
                    $sal["Descripcion"] = "El dia de la semana es invalido";
                }else{
                    if($horaInicio > $horaFin){
                        $sal["Estado"] = "error";
                        $sal["Descripcion"] = "La hora de inicio es mayor a la hora inicio";
                    }else{
                        $nuevoHorario = new PBX\Modelos\HorarioDeServicio(null,$usuario,$diaDeLaSemana,$horaInicio,$horaFin);
                        if(!PBX\HorarioDeServicioDatos::addHorarioDeServicio($conexion,$nuevoHorario)){
                            $sal["Estado"] = "error";
                            $sal["Descripcion"] = "Error al insertar el nuevo horario en la base de datos";
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