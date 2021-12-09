<?php
    namespace PBX;
    require_once 'Modelos/HorarioDeServicio.php';
    class HorarioDeServicioDatos{
        public static function addHorarioDeServicio($conexion, Modelos\HorarioDeServicio $horarioDeServicio):bool{
            $retorno = false;
            if($pstmInsert = $conexion->prepare("INSERT INTO tbl_HorariosDeServicios (Usuario,DiaDeLaSemana,HoraInicio,HoraFin) VALUES (?,?,TIME(?),TIME(?))")){
                $usuario = $horarioDeServicio->getUsuario()->getId();
                $diaDeLaSemana = $horarioDeServicio->getDiaDeLaSemana();
                $horaInicio = $horarioDeServicio->getHoraInicio()->format("H:i:s");
                $horaFin = $horarioDeServicio->getHoraFin()->format("H:i:s");
                $pstmInsert->bind_param("iiss",$usuario,$diaDeLaSemana,$horaInicio,$horaFin);
                $pstmInsert->execute();                
                $idHorarioDeServicio = $pstmInsert->insert_id;
                $pstmInsert->close();
                $horarioDeServicio->setId($idHorarioDeServicio);
            }
            return $retorno;
        }
    }
?>