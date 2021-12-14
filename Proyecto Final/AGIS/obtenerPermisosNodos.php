#!/usr/bin/php -q
<?php
    require_once 'configuracionPrincipal.php';
    require_once "phpagi.php";

    //$USUARIO_DB = "nodo1";
    //$PASSWORD_DB = "nodo1P4ssw0rd";
    //$HOST_DB = "payan.ddns.net";
    //$NOMBRE_DB = "db_pbx";
    //$NODO = 1;

    $usuario = intval($argv[1]);
    $nodoDestino = intval($argv[2]);
    $conexion = new mysqli($HOST_DB, $USUARIO_DB, $PASSWORD_DB, $NOMBRE_DB); //Establezco la conexion con la base de datos
    if($conexion == null){
        die("Error al conectar a la base de datos");
    }
    $agi = new AGI();
    /**
     * En esta seccion se extraen los datos de conexion entre nodos del usuario
     */
    $tienePermisoLlamada = 0;
    if($pstmSelect = $conexion->prepare("SELECT 1 FROM tbl_PermisosLlamadas WHERE Usuario = ? AND NodoOrigen = ? AND NodoDestino = ? LIMIT 1")){
        $pstmSelect->bind_param("iii", $usuario, $NODO, $nodoDestino);
        $pstmSelect->execute();
        $uno = 0;
        $pstmSelect->bind_result($uno);
        if($pstmSelect->fetch()){
            $agi->verbose("Si tiene permisos");
            $tienePermisoLlamada = 1;            
        }
        $pstmSelect->close();
    }
    $agi->set_variable('permisoDeMarcacionANodoDestino', $tienePermisoLlamada);
    $conexion->close();
    exit;
?>