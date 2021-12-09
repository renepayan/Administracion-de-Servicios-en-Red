<?php
    namespace PBX;
    require_once 'Modelos/Grupo.php';
    class GrupoDatos{
        public static function getGrupoById($conexion, int $id):?Modelos\Grupo{
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
                    $retorno = new Modelos\Grupo($idGrupo, $extension, $nombre);
                }
            }
            return $retorno;
        }
        public static function getGrupoAleatorio($conexion):?Modelos\Grupo{
            $retorno = null;
            if($pstmSelect = $conexion->prepare("SELECT idGrupo FROM tbl_Grupos ORDER BY RAND() LIMIT 1")){
                $pstmSelect->execute();
                $pstmSelect->bind_result($idGrupo);
                $sePuede = false;
                if($pstmSelect->fetch()){
                    $sePuede = true;
                }                                
                $pstmSelect->close();
                if($sePuede){
                    $retorno = GrupoDatos::getGrupoById($conexion, $idGrupo);
                }
            }
            return $retorno;
        }
    }
?>