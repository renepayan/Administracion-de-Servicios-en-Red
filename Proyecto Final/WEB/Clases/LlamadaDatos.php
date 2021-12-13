<?php
    namespace PBX;
    require_once 'UsuarioDatos.php';
    require_once 'NodoDatos.php';
    require_once 'Modelos/Usuario.php';
    require_once 'Modelos/Nodo.php';
    class LlamadaDatos{
        public static function getLlamadaById($conexion, int $id):?Modelos\Llamada{
            $retorno = null;
            if($pstmSelect = $conexion->prepare("SELECT idLlamada, NodoOrigen, NodoDestino, Grabada, Telefono, Usuario, idAsterisk, FechaInicio, FechaFin from tbl_Llamadas WHERE idLlamada = ? LIMIT 1")){
                $pstmSelect->bind_param("i",$id);                
                $pstmSelect->execute();
                $pstmSelect->bind_result($idLlamada, $nodoOrigen, $nodoDestino, $grabada, $telefono, $usuario, $idAsterisk, $fechaInicio, $fechaFin);
                $sePuede = false;
                if($pstmSelect->fetch()){
                    $sePuede = true;
                }                                
                $pstmSelect->close();
                if($sePuede){
                    $retorno = new Modelos\Llamada($idLlamada, UsuarioDatos::getUsuarioById($conexion, $usuario), NodoDatos::getNodoById($conexion, $nodoOrigen),  NodoDatos::getNodoById($conexion, $nodoDestino), $telefono, new \DateTime($fechaInicio), new \DateTime($fechaFin), $grabada, $idAsterisk);
                }
            }   
            return $retorno;
        }        
        public static function getAllLlamadas($conexion):array{
            $retorno = array();
            if($pstmSelect = $conexion->prepare("SELECT idLlamada from tbl_Llamadas")){                
                $ids = array();
                $pstmSelect->execute();
                $pstmSelect->bind_result($idLlamada);
                while($pstmSelect->fetch()){
                    $ids[] = $idLlamada;
                }                
                $pstmSelect->close();
                for($i = 0; $i < count($ids);$i++){
                    $retorno[] = LlamadaDatos::getLlamadaById($conexion, $ids[$i]);
                }
            }            
            return $retorno;
        }
        public static function getLlamadasByUsuario($conexion, Modelos\Usuario $usuario):array{
            $retorno = array();
            if($pstmSelect = $conexion->prepare("SELECT idLlamada from tbl_Llamadas WHERE Usuario = ?")){                
                $ids = array();
                $idUsuario = $usuario->getId();
                $pstmSelect->bind_param("i",$idUsuario);
                $pstmSelect->execute();                
                $pstmSelect->bind_result($idLlamada);
                while($pstmSelect->fetch()){
                    $ids[] = $idLlamada;
                }                
                $pstmSelect->close();
                for($i = 0; $i < count($ids);$i++){
                    $retorno[] = LlamadaDatos::getLlamadaById($conexion, $ids[$i]);
                }
            }            
            return $retorno;
        }
    }
?>