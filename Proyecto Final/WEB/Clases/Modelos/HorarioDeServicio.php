<?php
    namespace PBX\Modelos;
    require_once 'Usuario.php';
    class HorarioDeServicio{
        private ?int $id;
        private Usuario $usuario;
        private int $diaDeLaSemana;
        private \DateTime $horaInicio;
        private \DateTime $horaFin;
    }
?>