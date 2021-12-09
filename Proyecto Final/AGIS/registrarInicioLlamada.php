#!/usr/bin/php -q
<?php
    require_once "phpagi.php";

    $USUARIO_DB = "nodo1";
    $PASSWORD_DB = "nodo1P4ssw0rd";
    $HOST_DB = "payan.ddns.net";
    $NOMBRE_DB = "db_pbx";
    $NODO = 1;

    $usuario = intval($argv[1]);
    $tieneGrabacion = intval($argv[2]);    
    $nodoDestino = intval($argv[3]);    
    $telefonoMarcado = $argv[4];
    $idUnico = $argv[5];

    $conexion = new mysqli($HOST_DB, $USUARIO_DB, $PASSWORD_DB, $NOMBRE_DB); //Establezco la conexion con la base de datos
    if($conexion == null){
        die("Error al conectar a la base de datos");
    }
    $agi = new AGI();
    /**
     * En esta seccion se extraen los datos de conexion entre nodos del usuario
     */
    $idLlamada = 0;
    if($pstmInsert = $conexion->prepare("INSERT INTO tbl_Llamadas (Usuario, NodoOrigen, NodoDestino, Telefono, FechaInicio, FechaFin, Grabada, IdAsterisk) VALUES (?,?,?,?,NOW(),NOW(),?,?)")){
        $pstmInsert->bind_param("iiisbs", $usuario, $NODO, $nodoDestino, $telefonoMarcado, ($tieneGrabacion ==  1? true:false), $idUnico);
        $pstmInsert->execute();        
        $idLlamada = $pstmInsert->insert_id;
        $pstmInsert->close();
    }
    $agi->set_variable('idLlamada', $idLlamada);
    $conexion->close();
    exit;
?>