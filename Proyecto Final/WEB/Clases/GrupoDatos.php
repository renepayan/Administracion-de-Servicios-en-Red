<?php
    namespace PBX;
    require_once 'Modelos/Grupo.php';
    class NodoDatos{
        public static function getGrupoById($conexion, int $id):?Nodo{
            $retorno = null;
            if($pstmSelect = $conexion->prepare("SELECT idGrupo, Extension, Nombre FROM tbl_Grupos WHERE idGrupo = ?")){
                $pstmSelect->bind_param("i",$id); 
                $pstmSelect->execute();
                $pstmSelect->bind_result($idGrupo, $extension, $nombre);
                $sePuede = false;
                if($pstmSelect->fetch()){
                    $sePuede = true;
                }                                
                $pstmSelect->close();
                if($sePuede){
                    $retorno = new Grupo($idGrupo, $extension, $nombre);
                }
            }
            return $retorno;
        }
    }
?>