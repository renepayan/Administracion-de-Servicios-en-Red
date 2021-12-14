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
    $canal = $argv[1];       
    $canal = explode("-",explode("/",$canal)[1])[0];           
    $nodoOrigen = $canal[strlen($canal)-2];
    $extension = $argv[2];
    $agi = new AGI();
    $agi->verbose($canal);
    $agi->set_variable('nombreOrigen', $extensionOrigen);

    exit;
?>