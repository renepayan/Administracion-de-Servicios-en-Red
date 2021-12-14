#!/usr/bin/php -q
<?php
    $USUARIO_DB = "nodo1";
    $PASSWORD_DB = "nodo1P4ssw0rd";
    $HOST_DB = "payan.ddns.net";
    $NOMBRE_DB = "db_pbx";
    $NODO = 1;
    $FICHERO = "/etc/asterisk/sip_generado.conf";    

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
        exec("echo \"\" > ".$FICHERO);    
        while($pstmSelect->fetch()){                
            file_put_contents($FICHERO, "[".$extension."]\n", FILE_APPEND | LOCK_EX);
            file_put_contents($FICHERO, "username=".utf8_encode($usuario)."\n", FILE_APPEND | LOCK_EX);            
            file_put_contents($FICHERO, "secret=".$password."\n", FILE_APPEND | LOCK_EX);
            file_put_contents($FICHERO, "accountcode=".$extension."\n", FILE_APPEND | LOCK_EX);
            file_put_contents($FICHERO, "callerid=\"".$nombre."\"\n", FILE_APPEND | LOCK_EX);
            file_put_contents($FICHERO, "mailbox=".$extension."\n", FILE_APPEND | LOCK_EX);
            file_put_contents($FICHERO, "host=dynamic\n", FILE_APPEND | LOCK_EX);
            file_put_contents($FICHERO, "canreinvite=no\n", FILE_APPEND | LOCK_EX);
            file_put_contents($FICHERO, "context=ContextoPrincipal\n", FILE_APPEND | LOCK_EX);
            file_put_contents($FICHERO, "qualify=yes\n", FILE_APPEND | LOCK_EX);
            file_put_contents($FICHERO, "port=5061\n", FILE_APPEND | LOCK_EX);
            file_put_contents($FICHERO, "nat=yes\n", FILE_APPEND | LOCK_EX);
            file_put_contents($FICHERO, "type=friend\n", FILE_APPEND | LOCK_EX);
            file_put_contents($FICHERO, "disallow=all\n", FILE_APPEND | LOCK_EX);
            file_put_contents($FICHERO, "allow=ulaw,alaw\n", FILE_APPEND | LOCK_EX);            
            file_put_contents($FICHERO, "transport=tls,udp\n", FILE_APPEND | LOCK_EX);
            file_put_contents($FICHERO, "encryption=no\n", FILE_APPEND | LOCK_EX);
            file_put_contents($FICHERO, "\n", FILE_APPEND | LOCK_EX);        
        }
        $pstmSelect->close();
        exec(" asterisk -rx \"sip reload\"");
        exec(" asterisk -rx \"dialplan reload\"");
        exec(" asterisk -rx \"reload\"");
    }    
    $conexion->close();
    exit;
?>









