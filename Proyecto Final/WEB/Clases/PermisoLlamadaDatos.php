<?php
    namespace PBX;
    require_once 'Modelos/PermisoLlamada.php';
    require_once 'Modelos/Usuario.php';
    require_once 'UsuarioDatos.php';
    class PermisoLlamadaDatos{
        public static function addPermisoLlamada($conexion, Modelos\PermisoLlamada $permisoDeLlamada):bool{
            $retorno = false;
            if($pstmInsert = $conexion->prepare("INSERT INTO tbl_PermisosLlamadas (Usuario, NodoOrigen, NodoDestino) VALUES (?,?,?)")){
                $usuario = $permisoDeLlamada->getUsuario()->getId();
                $nodoOrigen = $permisoDeLlamada->getNodoOrigen()->getId();
                $nodoDestino = $permisoDeLlamada->getNodoDestino()->getId();
                $pstmInsert->bind_param("iii",$usuario,$nodoOrigen,$nodoDestino);
                $pstmInsert->execute();                
                $idPermisoLlamada = $pstmInsert->insert_id;
                $pstmInsert->close();
                $permisoDeLlamada->setId($idPermisoLlamada);
                $retorno = true;
            }else{
                echo($conexion->error);
            }
            return $retorno;
        }
        public static function getPermisoLlamadaById($conexion, int $id):?Modelos\PermisoLlamada{
            if($pstmSelect = $conexion->prepare("SELECT Usuario,NodoOrigen,NodoDestino FROM tbl_PermisosLlamadas WHERE idPermiso = ? LIMIT 1")){
                $pstmSelect->bind_param("i",$id);
                $pstmSelect->execute();
                $pstmSelect->bind_result($idUsuario,$idNodoOrigen,$idNodoDestino);
                $sePuede = false;
                if($pstmSelect->fetch()){
                    $sePuede = true;
                }
                $pstmSelect->close();
                if($sePuede){
                    $retorno = new Modelos\PermisoLlamada($id, UsuarioDatos::getUsuarioById($conexion, $idUsuario), NodoDatos::getNodoById($conexion, $idNodoOrigen), NodoDatos::getNodoById($conexion, $idNodoDestino));
                }
            }
            return $retorno;
        }
        public static function getPermisosLlamadaByUsuario($conexion, Modelos\Usuario $usuario):array{
            $retorno = array();
            if($pstmSelect = $conexion->prepare("SELECT idPermiso FROM tbl_PermisosLlamadas WHERE Usuario = ?")){
                $idUsuario = $usuario->getId();
                $arrayIDs = array();
                $pstmSelect->bind_param("i",$idUsuario);
                $pstmSelect->execute();
                $pstmSelect->bind_result($idHorario);
                while($pstmSelect->fetch()){
                    $arrayIDs[] = $idHorario;
                }
                $pstmSelect->close();
                for($i = 0; $i < count($arrayIDs); $i++){
                    $retorno[] = PermisoLlamadaDatos::getPermisoLlamadaById($conexion, $arrayIDs[$i]);
                }
            }
            return $retorno;
        }
    }
?>