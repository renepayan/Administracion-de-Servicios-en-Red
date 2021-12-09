#!/usr/bin/php -q
<?php
    require_once "phpagi.php";

    $USUARIO_DB = "nodo1";
    $PASSWORD_DB = "nodo1P4ssw0rd";
    $HOST_DB = "payan.ddns.net";
    $NOMBRE_DB = "db_pbx";
    $NODO = 1;

    
    //Aqui inicia el procedimiento para extraer la informacion
    $extensionOrigen = $argv[1];       
    $extensionOrigen = explode("-",explode("/",$extensionOrigen)[1])[0];        
    $conexion = new mysqli($HOST_DB, $USUARIO_DB, $PASSWORD_DB, $NOMBRE_DB); //Establezco la conexion con la base de datos
    if($conexion == null){
        die("Error al conectar a la base de datos");
    }
    $agi = new AGI();
    /**
     * En esta seccion se extraen los datos generales del usuario
     */
    $encontreElUsuario = false;
    if($pstmSelect = $conexion->prepare("SELECT idUsuario, Nombre, Usuario, Nivel, Grupo, GrabarLlamadas,LlamarAGrupos,LlamarExtensiones FROM tbl_Usuarios WHERE Extension = ? LIMIT 1")){
        $pstmSelect->bind_param("s", $extensionOrigen);
        $pstmSelect->execute();
        $pstmSelect->bind_result($idUsuario, $nombre, $usuario, $nivel, $grupo, $grabarLlamada, $llamarAGrupos, $llamarExtensiones);
        if($pstmSelect->fetch()){
            $encontreElUsuario = true;            
        }
        $pstmSelect->close();
    }
    if($encontreElUsuario){
        $agi->verbose("Encontre el usuario");
        /**
         * En esta seccion extraigo sus permisos de horario para hablar (Valido que sea una hora valida)
         */
        $tienePermisoLlamarHorario = 0;
        if($nivel == 1){ //Es Admin, en automatico tiene permisos
            $agi->verbose("El usuario es administrador");
            $tienePermisoLlamarHorario = 1;
        }else{
            $agi->verbose("El usuario no es administrador");
            //Aqui reviso si tiene un horario de servicio regular
            if($pstmSelect = $conexion->prepare("SELECT 1 FROM tbl_HorariosDeServicios WHERE Usuario = ? AND WEEKDAY(CURDATE()) = DiaDeLaSemana AND CURTIME() BETWEEN HoraInicio AND HoraFin LIMIT 1")){
                $pstmSelect->bind_param("i", $idUsuario);
                $pstmSelect->bind_result($resultadoLocal);
                $pstmSelect->execute(); 
                if($pstmSelect->fetch()){
                    $agi->verbose("Hay un horario de servicio que coincide");
                    $tienePermisoLlamarHorario = 1;
                }                
                $pstmSelect->close();
            }else{
                echo($conexion->error);
            }
        }    
        $agi->set_variable('encontreElUsuario', 1);
        $agi->set_variable('nombre', utf8_encode($nombre));
        $agi->set_variable('idUsuario', $idUsuario);
        $agi->set_variable('nivel', $nivel);
        $agi->set_variable('grabarLlamada', $grabarLlamada);
        $agi->set_variable('llamarAGrupos', $llamarAGrupos);
        $agi->set_variable('llamarExtensiones', $llamarExtensiones);        
        $agi->set_variable('tienePermisoHorario', $tienePermisoLlamarHorario);
    }else{
        $agi->verbose("No encontre el usuario");
        $agi->set_variable('encontreElUsuario', 0);
    }
    $conexion->close();
    exit;
?>