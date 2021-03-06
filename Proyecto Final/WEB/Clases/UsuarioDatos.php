<?php
    namespace PBX;
    require_once 'GrupoDatos.php';
    require_once 'NodoDatos.php';
    require_once 'Modelos/Usuario.php';
    require_once 'Modelos/Grupo.php';
    require_once 'Modelos/Nodo.php';
    class UsuarioDatos{
        public static function getUsuarioByNombreDeUsuario($conexion, string $nombreDeUsuario):?Modelos\Usaurio{
            $retorno = null;
            if($pstmSelect = $conexion->prepare("SELECT idUsuario from tbl_Usuarios WHERE Usuario = ? LIMIT 1")){
                $pstmSelect->bind_param("s",$usuario);
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
        public static function getUsuarioById($conexion, int $id):?Modelos\Usuario{
            $retorno = null;
            if($pstmSelect = $conexion->prepare("SELECT idUsuario, Nombre, Usuario, Password, Nivel, Grupo, GrabarLlamadas,LlamarAGrupos,LlamarExtensiones, Extension, Nodo from tbl_Usuarios WHERE idUsuario = ? LIMIT 1")){
                $pstmSelect->bind_param("i",$id);                
                $pstmSelect->execute();
                $pstmSelect->bind_result($idUsuario, $nombre, $usuario, $password, $nivel, $idGrupo, $grabarLlamadas, $llamarAGrupos, $llamarAExtensiones, $extension, $idNodo);
                $sePuede = false;
                if($pstmSelect->fetch()){
                    $sePuede = true;
                }                                
                $pstmSelect->close();
                if($sePuede){
                    $retorno = new Modelos\Usuario($idUsuario, $nombre, $usuario, $password, $nivel, GrupoDatos::getGrupoById($conexion, $idGrupo), $grabarLlamadas, $llamarAGrupos, $llamarAExtensiones, $extension, NodoDatos::getNodoById($conexion, $idNodo));
                }
            }   
            return $retorno;
        }
        public static function getUsuarioByExtension($conexion, string $extension):?Modelos\Usuario{
            $retorno = null;
            if($pstmSelect = $conexion->prepare("SELECT idUsuario from tbl_Usuarios WHERE Extension = ? LIMIT 1")){
                $pstmSelect->bind_param("s",$extension);
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
        public static function getLastExtension($conexion):string{
            $retorno = "100";
            if($pstmSelect = $conexion->prepare("SELECT Extension from tbl_Usuarios ORDER BY Extension DESC LIMIT 1")){                
                $pstmSelect->execute();
                $pstmSelect->bind_result($extension);
                if($pstmSelect->fetch()){
                    $retorno = $extension;
                }                
                $pstmSelect->close();              
            }            
            return $retorno;
        }
        public static function getUsuarioByUsuarioAndPassword($conexion, string $usuario, string $password):?Modelos\Usuario{
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
        public static function addUsuario($conexion, Modelos\Usuario $usuario):bool{
            $retorno = false;
            if($pstmInsert = $conexion->prepare("INSERT INTO tbl_Usuarios (Nombre, Usuario, Password, Nivel, Grupo, GrabarLlamadas, LlamarAGrupos, LlamarExtensiones, Extension, Nodo) VALUES (?,?,?,?,?,?,?,?,?,?)")){
                $nombre = $usuario->getNombre();
                $usuarioSTR = $usuario->getUsuario();
                $password = $usuario->getPassword();
                $nivel = $usuario->getNivel();
                $grupo = $usuario->getGrupo()->getId();
                $grabarLlamadas = (int)$usuario->isGrabarLlamadas();
                $llamarAGrupos = (int)$usuario->isLlamarAGrupos();
                $llamarAExtensiones = (int)$usuario->isLlamarExtensiones();
                $extension = $usuario->getExtension();
                $nodo = $usuario->getNodo()->getId();
                $pstmInsert->bind_param("sssiiiiisi",$nombre, $usuarioSTR, $password, $nivel, $grupo, $grabarLlamadas, $llamarAGrupos, $llamarAExtensiones, $extension, $nodo);
                $pstmInsert->execute();        
                $idUsuario = $pstmInsert->insert_id;
                $pstmInsert->close();
                $usuario->setId($idUsuario);
                $retorno = true;
            }else{
                echo($conexion->error);
            }
            return $retorno;
        }
        public static function getAllUsuarios($conexion):array{
            $retorno = array();
            if($pstmSelect = $conexion->prepare("SELECT idUsuario from tbl_Usuarios")){                
                $ids = array();
                $pstmSelect->execute();
                $pstmSelect->bind_result($idUsuario);
                while($pstmSelect->fetch()){
                    $ids[] = $idUsuario;
                }                
                $pstmSelect->close();
                for($i = 0; $i < count($ids);$i++){
                    $retorno[] = UsuarioDatos::getUsuarioById($conexion, $ids[$i]);
                }
            }            
            return $retorno;
        }
    }
?>