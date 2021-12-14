#!/usr/bin/php -q
<?php
    require_once 'configuracionPrincipal.php';
    require_once "phpagi.php";

    //$USUARIO_DB = "nodo1";
    //$PASSWORD_DB = "nodo1P4ssw0rd";
    //$HOST_DB = "payan.ddns.net";
    //$NOMBRE_DB = "db_pbx";
    //$NODO = 1;
    
    //Aqui inicia el procedimiento para extraer la informacion
    $aliasDestino = trim($argv[1]);  
    $conexion = new mysqli($HOST_DB, $USUARIO_DB, $PASSWORD_DB, $NOMBRE_DB); //Establezco la conexion con la base de datos
    if($conexion == null){
        die("Error al conectar a la base de datos");
    }
    $agi = new AGI();
    /**
     * En esta seccion se extraen los datos generales del usuario
     */
    $encontreElAlias = false;    
    $mismoNodo = 0;
    if($pstmSelect = $conexion->prepare("SELECT tipoAlias, Usuario FROM tbl_Alias WHERE Alias = ? LIMIT 1")){
        $pstmSelect->bind_param("s", $aliasDestino);
        $pstmSelect->execute();
        $pstmSelect->bind_result($tipoAlias, $idUsuario);
        if($pstmSelect->fetch()){
            $encontreElAlias = true;            
        }
        $pstmSelect->close();
        if($encontreElAlias){
            if($pstmSelect = $conexion->prepare("SELECT Extension FROM tbl_Usuarios WHERE idUsuario = ? LIMIT 1")){
                $pstmSelect->bind_param("i", $idUsuario);
                $pstmSelect->execute();
                $pstmSelect->bind_result($extensionDestino);
                if($pstmSelect->fetch()){
                    $agi->set_variable('tipoAlias', $tipoAlias);
                    $agi->set_variable('destinoAlias', $extensionDestino);                    
                }
                $pstmSelect->close();
            }
        }
    }
    if($encontreElAlias){
        $agi->verbose("Encontre el alias");
        $agi->set_variable('encontreElAlias', 1);
    }else{
        $agi->verbose("No encontre el alias");
        $agi->set_variable('encontreElAlias', 0);
    }
    $conexion->close();
    exit;
?>