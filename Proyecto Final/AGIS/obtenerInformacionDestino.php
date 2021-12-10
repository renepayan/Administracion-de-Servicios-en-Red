#!/usr/bin/php -q
<?php
    require_once "phpagi.php";

    $USUARIO_DB = "nodo1";
    $PASSWORD_DB = "nodo1P4ssw0rd";
    $HOST_DB = "payan.ddns.net";
    $NOMBRE_DB = "db_pbx";
    $NODO = 1;

    
    //Aqui inicia el procedimiento para extraer la informacion
    $extensionDestino = trim($argv[1]);  
    $conexion = new mysqli($HOST_DB, $USUARIO_DB, $PASSWORD_DB, $NOMBRE_DB); //Establezco la conexion con la base de datos
    if($conexion == null){
        die("Error al conectar a la base de datos");
    }
    $agi = new AGI();
    /**
     * En esta seccion se extraen los datos generales del usuario
     */
    $encontreElDestino = false;    
    $mismoNodo = 0;
    if($pstmSelect = $conexion->prepare("SELECT Nodo FROM tbl_Usuarios WHERE Extension = ? LIMIT 1")){
        $pstmSelect->bind_param("s", $extensionDestino);
        $pstmSelect->execute();
        $pstmSelect->bind_result($nodoDestino);
        if($pstmSelect->fetch()){
            $encontreElDestino = true;            
        }
        $pstmSelect->close();
    }
    if($encontreElDestino){
        $agi->verbose("Encontre el destino");
        if($nodoDestino == $NODO){
            $mismoNodo = 1;
        }
        $agi->set_variable('encontreElDestino', 1);
        $agi->set_variable('mismoNodo', $mismoNodo);
        $agi->set_variable('nodoDestino', $nodoDestino);
    }else{
        $agi->verbose("No encontre el usuario");
        $agi->set_variable('encontreElDestino', 0);
    }
    $conexion->close();
    exit;
?>