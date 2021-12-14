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
    $extensionOrigen = $argv[1];       
    $extensionOrigen = explode("-",explode("/",$extensionOrigen)[1])[0];            
    $agi = new AGI();
    $agi->verbose($argv[1]);
    $agi->set_variable('extensionOrigen', $extensionOrigen);
    exit;
?>