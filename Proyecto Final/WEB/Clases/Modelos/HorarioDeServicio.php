<?php
    namespace PBX\Modelos;
    require_once 'Usuario.php';
    class HorarioDeServicio{
        private ?int $id;
        private Usuario $usuario;
        private int $diaDeLaSemana;
        private \DateTime $horaInicio;
        private \DateTime $horaFin;
        public function __construct(?int $id, Usuario $usuario, int $diaDeLaSemana, \DateTime $horaInicio, \DateTime $horaFin){
            $this->id = $id;
            $this->usuario = $usuario;
            $this->diaDeLaSemana = $diaDeLaSemana;
            $this->horaInicio = $horaInicio;
            $this->horaFin = $horaFin;
        }
        public function getId():?int{
            return $this->id;
        }
        public function setId(int $id):void{
            $this->id = $id;
        }

        public function getUsuario():Usuario{
            return $this->usuario;
        }
        public function setUsuario(Usuario $usuario):void{
            $this->usuario = $usuario; 
        }

        public function getDiaDeLaSemana():int{
            return $this->diaDeLaSemana;
        }
        public function setDiaDeLaSemana(int $diaDeLaSemana):void{
            $this->diaDeLaSemana = $diaDeLaSemana;
        }

        public function getHoraInicio():\DateTime{
            return $this->horaInicio;
        }
        public function setHoraInicio(\DateTime $horaInicio):void{
            $this->horaInicio = $horaInicio;
        }

        public function getHoraFin():\DateTime{
            return $this->horaFin;
        }
        public function setHoraFin(\DateTime $horaFin):void{
            $this->horaFin = $horaFin;
        }
    }
?>