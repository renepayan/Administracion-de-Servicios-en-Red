<?php
    namespace PBX\Modelos;
    require_once 'Usuario.php';
    require_once 'Nodo.php';
    class PermisoLlamada{
        private ?int $id;
        private Usuario $usuario;
        private Nodo $nodoOrigen;
        private Nodo $nodoDestino;
    }
?>