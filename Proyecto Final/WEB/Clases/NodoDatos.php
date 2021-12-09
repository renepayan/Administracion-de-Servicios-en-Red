<?php
    namespace PBX;
    require_once 'Modelos/Nodo.php';
    class NodoDatos{
        public static function getNodoById($conexion, int $id):?Nodo{
            $retorno = null;
            if($pstmSelect = $conexion->prepare("SELECT idNodo, Numero, IP, Dominio, Nombre FROM tbl_Nodos WHERE idNodo = ?")){
                $pstmSelect->bind_param("i",$id); 
                $pstmSelect->execute();
                $pstmSelect->bind_result($idNodo, $numero, $ip, $dominio, $nombre);
                $sePuede = false;
                if($pstmSelect->fetch()){
                    $sePuede = true;
                }                                
                $pstmSelect->close();
                if($sePuede){
                    $retorno = new Nodo($idNodo, $numero, $ip, $dominio, $nombre);
                }
            }
            return $retorno;
        }
    }
?>