<?php
    namespace PBX;
    require_once 'Modelos/HorarioDeServicio.php';
    require_once 'Modelos/Usuario.php';
    require_once 'UsuarioDatos.php';
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
                $retorno = true;
            }
            return $retorno;
        }
        public static function getHorarioDeServicioById($conexion, int $id):?Modelos\HorarioDeServicio{
            $retorno = null;
            if($pstmSelect = $conexion->prepare("SELECT Usuario,DiaDeLaSemana,HoraInicio,HoraFin FROM tbl_HorariosDeServicios WHERE idHorario = ? LIMIT 1")){
                $pstmSelect->bind_param("i",$id);
                $pstmSelect->execute();
                $pstmSelect->bind_result($idUsuario,$diaDeLaSemana,$horaInicio,$horaFin);
                $sePuede = false;
                if($pstmSelect->fetch()){
                    $sePuede = true;
                }
                $pstmSelect->close();
                if($sePuede){
                    $retorno = new Modelos\HorarioDeServicio($id,UsuarioDatos::getUsuarioById($idUsuario,$conexion), $diaDeLaSemana, new \DateTime($horaInicio), new \DateTime($horaFin));
                }
            }
            return $retorno;
        }
        public static function getHorariosDeServicioByUsuario($conexion, Modelos\Usuario $usuario):array{
            $retorno = array();
            if($pstmSelect = $conexion->prepare("SELECT idHorario FROM tbl_HorariosDeServicios WHERE Usuario = ?")){
                $idUsuario = $usuario->getId();
                $arrayIDs = array();
                $pstmSelect->bind_param("i",$idUsuario);
                $pstmSelect->execute();
                $pstmSelect->bind_result($idHorario);
                while($pstmSelect->fetch()){
                    $arrayIDs[] = $idHorario;
                }
                $pstmSelect->close();
                print_r($arrayIDs);
                for($i = 0; $i < count($arrayIDs); $i++){
                    $retorno[] = HorarioDeServicioDatos::getHorarioDeServicioById($conexion, $arrayIDs[$i]);
                }
            }
            return $retorno;
        }
    }
?>