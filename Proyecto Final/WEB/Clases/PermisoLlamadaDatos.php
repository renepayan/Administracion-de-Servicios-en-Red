<?php
    namespace PBX;
    require_once 'Modelos/PermisoLlamada.php';
    class PermisoDeLlamadaDatos{
        public static function addPermisoDeLlamada($conexion, Modelos\PermisoLlamada $permisoDeLlamada):bool{
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
            }
            return $retorno;
        }
    }
?>