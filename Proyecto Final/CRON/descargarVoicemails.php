#!/usr/bin/php -q
<?php
    $USUARIO_DB = "nodo1";
    $PASSWORD_DB = "nodo1P4ssw0rd";
    $HOST_DB = "payan.ddns.net";
    $NOMBRE_DB = "db_pbx";
    $NODO = 1;    
    $FICHERO_CORREOS = "/etc/asterisk/voicemail_generados.conf";

    $conexion = new mysqli($HOST_DB, $USUARIO_DB, $PASSWORD_DB, $NOMBRE_DB); //Establezco la conexion con la base de datos
    if($conexion == null){
        die("Error al conectar a la base de datos");
    }    
    /**
     * En esta seccion se extraen los datos de conexion entre nodos del usuario
     */
    
    if($pstmSelect = $conexion->prepare("SELECT Extension, Nombre, Usuario, Password FROM tbl_Usuarios WHERE Nodo = ?")){
        $pstmSelect->bind_param("i", $NODO);
        $pstmSelect->execute();  
        $pstmSelect->bind_result($extension,$nombre,$usuario,$password);
        exec("echo \"\" > ".$FICHERO_CORREOS);
        file_put_contents($FICHERO_CORREOS, "[default]\n", FILE_APPEND | LOCK_EX);
        while($pstmSelect->fetch()){                            
            file_put_contents($FICHERO_CORREOS, $extension." => 1234\n", FILE_APPEND | LOCK_EX);            
        }
        $pstmSelect->close();
        exec(" asterisk -rx \"sip reload\"");
        exec(" asterisk -rx \"dialplan reload\"");
        exec(" asterisk -rx \"reload\"");
    }    
    $conexion->close();
    exit;
?>









