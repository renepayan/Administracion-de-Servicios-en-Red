#!/usr/bin/php -q
<?php
    require_once "phpagi.php";

    $USUARIO_DB = "nodo1";
    $PASSWORD_DB = "nodo1P4ssw0rd";
    $HOST_DB = "payan.ddns.net";
    $NOMBRE_DB = "db_pbx";
    $NODO = 1;
    $llamada = $argv[1];

    $conexion = new mysqli($HOST_DB, $USUARIO_DB, $PASSWORD_DB, $NOMBRE_DB); //Establezco la conexion con la base de datos
    if($conexion == null){
        die("Error al conectar a la base de datos");
    }
    $agi = new AGI();
    /**
     * En esta seccion se extraen los datos de conexion entre nodos del usuario
     */
    $tienePermisoLlamada = 0;
    if($pstmUpdate = $conexion->prepare("UPDATE tbl_Llamadas SET FechaFin = NOW() WHERE idAsterisk = ?")){
        $pstmUpdate->bind_param("d", $llamada);
        $pstmUpdate->execute();        
        $pstmUpdate->close();
    }
    $conexion->close();
    exit;
?>