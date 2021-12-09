<?php
    namespace PBX;
    require_once 'GrupoDatos.php';
    require_once 'NodoDatos.php';
    require_once 'Modelos/Usuario.php';
    require_once 'Modelos/Grupo.php';
    require_once 'Modelos/Nodo.php';
    class UsuarioDatos{
        public static function getUsuarioByNombreDeUsuario($conexion, string $nombreDeUsuario):?Usaurio{
            $retorno = null;
            
            return $retorno;
        }
        public static function getUsuarioById($conexion, int $id):?Usuario{
            $retorno = null;
            if($pstmSelect = $conexion->prepare("SELECT SELECT idUsuario, Nombre, Usuario, Password, Nivel, Grupo, GrabarLlamadas,LlamarAGrupos,LlamarExtensiones, Extension, Nodo from tbl_Usuarios WHERE idUsuario = ? LIMIT 1")){
                $pstmSelect->bind_param("i",$id);                
                $pstmSelect->execute();
                $pstmSelect->bind_result($idUsuario, $nombre, $usuario, $password, $nivel, $idGrupo, $grabarLlamadas, $llamarAGrupos, $llamarAExtensiones, $extension, $idNodo);
                $sePuede = false;
                if($pstmSelect->fetch()){
                    $sePuede = true;
                }                                
                $pstmSelect->close();
                if($sePuede){
                    $retorno = new Usuario($idUsuario, $nombre, $usuario, $password, $nivel, GrupoDatos::getGrupoById($conexion, $idGrupo), $grabarLlamadas, $llamarAGrupos, $llamarAExtensiones, $extension, NodoDatos::getNodoById($conexion, $idNodo));
                }
                if($id>0){
                    $retorno = UsuarioDatos::getUsuarioById($conexion, $id);
                }
            }   
            return $retorno;
        }
        public static function getUsuarioByExtension($conexion, string $extension):?Usuario{
        }
        public static function getLastExtension($conexion):?Usuario{
        }
        public static function getUsuarioByUsuarioAndPassword($conexion, string $usuario, string $password):?Usuario{
            $retorno = null;
            if($pstmSelect = $conexion->prepare("SELECT idUsuario from tbl_Usuarios WHERE Usuario = ? AND Password = ? LIMIT 1")){
                $pstmSelect->bind_param("ss",$usuario, $password);
                $id = -1;
                $pstmSelect->execute();
                $pstmSelect->bind_result($idUsuario);
                if($pstmSelect->fetch()){
                    $id = $idUsuario;
                }                
                $pstmSelect->close();
                if($id>0){
                    $retorno = UsuarioDatos::getUsuarioById($conexion, $id);
                }
            }            
            return $retorno;
        }
    }
?>