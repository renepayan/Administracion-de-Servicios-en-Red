<?php
    namespace PBX\Modelos;
    require_once 'Nodo.php';
    require_once 'Usuario.php';
    class Llamada{
        private ?int $id;
        private Usuario $usuario;
        private Nodo $nodoOrigen;
        private Nodo $nodoDestino;
        private string $telefono;
        private \DateTime $fechaInicio;
        private \DateTime $fechaFin;
        private boolean $grabada;
        private string $idAsterisk;
    }
?>