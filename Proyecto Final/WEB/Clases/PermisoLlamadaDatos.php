<?php
    namespace PBX;
    require_once 'Modelos/PermisoLlamada.php';
    class PermisoDeLlamadaDatos{
        public static function addPermisoDeLlamada($conexion, Modelos\PermisoLlamada $permisoDeLlamada):bool{
            $retorno = false;
            if($pstmInsert = $conexion->prepare("INSERT INTO tbl_PermisosLlamadas (Usuario, NodoOrigen, NodoDestino) VALUES (?,?,?)")){
                $pstmInsert->bind_param("iii",$permisoDeLlamada->getUsuario()->getId(),$permisoDeLlamada->getNodoOrigen()->getId(),$permisoDeLlamada->getNodoDestino()->getId());
                $pstmInsert->execute();                
                $idPermisoLlamada = $pstmInsert->insert_id;
                $pstmInsert->close();
                $permisoDeLlamada->setId($idPermisoLlamada);
            }
            return $retorno;
        }
    }
?>