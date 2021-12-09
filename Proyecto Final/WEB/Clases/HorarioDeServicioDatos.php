<?php
    namespace PBX;
    require_once 'Modelos\HorarioDeServicio.php';
    class HorarioDeServicioDatos{
        public static function addHorarioDeServicio($conexion, Modelos\HorarioDeServicio $horarioDeServicio):bool{
            $retorno = false;
            if($pstmInsert = $conexion->prepare("INSERT INTO tbl_HorariosDeServicios (Usuario,DiaDeLaSemana,HoraInicio,HoraFin) VALUES (?,?,TIME(?),TIME(?))")){
                $pstmInsert->bind_param("iiss",$horarioDeServicio->getUsuario()->getId(),$horarioDeServicio->getDiaDeLaSemana(),$horarioDeServicio->getHoraInicio()->format("H:i:s"),$horarioDeServicio->getHoraFin()->format("H:i:s"));
                $pstmInsert->execute();                
                $idHorarioDeServicio = $pstmInsert->insert_id;
                $pstmInsert->close();
                $horarioDeServicio->setId($idHorarioDeServicio);
            }
            return $retorno;
        }
    }
?>