<?php
    namespace PBX;
    require_once 'Modelos/Alias.php';
    require_once 'Modelos/Usuario.php';
    require_once 'UsuarioDatos.php';
    class AliasDatos{
        public static function addAlias($conexion, Modelos\Alias $alias):bool{
            $retorno = false;
            if($pstmInsert = $conexion->prepare("INSERT INTO tbl_Alias (tipoAlias,Usuario,Alias) VALUES (?,?,?)")){
                $usuario = $alias->getUsuario()->getId();
                $tipoAlias = $alias->getTipoAlias();
                $aliasSTR = $alias->getAlias();
                $pstmInsert->bind_param("iis",$tipoAlias,$usuario,$aliasSTR);
                $pstmInsert->execute();                
                $idHorarioDeServicio = $pstmInsert->insert_id;
                $pstmInsert->close();
                $alias->setId($idHorarioDeServicio);
                $retorno = true;
            }
            return $retorno;
        }
        public static function deleteAlias($conexion, Modelos\Alias $alias):bool{
            $retorno = false;
            if($pstmInsert = $conexion->prepare("DELETE FROM tbl_Alias WHERE idAlias = ? LIMIT 1")){
                $id = $alias->getId();
                $pstmInsert->bind_param("i",$id);
                $pstmInsert->execute();                                
                $pstmInsert->close();                
                $retorno = true;
            }
            return $retorno;
        }
        public static function getAliasById($conexion, int $id):?Modelos\Alias{
            $retorno = null;
            if($pstmSelect = $conexion->prepare("SELECT tipoAlias,Usuario,Alias FROM tbl_Alias WHERE idAlias = ? LIMIT 1")){
                $pstmSelect->bind_param("i",$id);
                $pstmSelect->execute();
                $pstmSelect->bind_result($tipoAlias,$idUsuario,$alias);
                $sePuede = false;
                if($pstmSelect->fetch()){
                    $sePuede = true;
                }
                $pstmSelect->close();
                if($sePuede){
                    $retorno = new Modelos\Alias($id,$tipoAlias, UsuarioDatos::getUsuarioById($conexion, $idUsuario), $alias);
                }
            }
            return $retorno;
        }
        public static function getAliasByUsuario($conexion, Modelos\Usuario $usuario):array{
            $retorno = array();
            if($pstmSelect = $conexion->prepare("SELECT idAlias FROM tbl_Alias WHERE Usuario = ?")){
                $idUsuario = $usuario->getId();
                $arrayIDs = array();
                $pstmSelect->bind_param("i",$idUsuario);
                $pstmSelect->execute();
                $pstmSelect->bind_result($idAlias);
                while($pstmSelect->fetch()){
                    $arrayIDs[] = $idAlias;
                }
                $pstmSelect->close();                
                for($i = 0; $i < count($arrayIDs); $i++){
                    $retorno[] = AliasDatos::getAliasById($conexion, $arrayIDs[$i]);
                }
            }
            return $retorno;
        }
        public static function getAliasByAlias($conexion,string $alias):?Modelos\Alias{
            $retorno = null;
            if($pstmSelect = $conexion->prepare("SELECT idAlias FROM tbl_Alias WHERE Alias = ? LIMIT 1")){                                
                $pstmSelect->bind_param("s",$alias);
                $pstmSelect->execute();
                $pstmSelect->bind_result($idAlias);
                $sePuede = false;
                if($pstmSelect->fetch()){
                    $sePuede = true;                    
                }
                $pstmSelect->close();                
                if($sePuede){
                    $retorno = AliasDatos::getAliasById($conexion, $idAlias);
                }
            }
            return $retorno;
        }
        public static function getAllAlias($conexion):array{
            $retorno = array();
            if($pstmSelect = $conexion->prepare("SELECT idAlias FROM tbl_Alias")){                
                $arrayIDs = array();                
                $pstmSelect->execute();
                $pstmSelect->bind_result($idAlias);
                while($pstmSelect->fetch()){
                    $arrayIDs[] = $idAlias;
                }
                $pstmSelect->close();                
                for($i = 0; $i < count($arrayIDs); $i++){
                    $retorno[] = AliasDatos::getAliasById($conexion, $arrayIDs[$i]);
                }
            }
            return $retorno;
        }
    }
?>