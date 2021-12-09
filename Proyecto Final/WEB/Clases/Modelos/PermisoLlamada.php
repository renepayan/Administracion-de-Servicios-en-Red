<?php
    namespace PBX\Modelos;
    require_once 'Usuario.php';
    require_once 'Nodo.php';
    class PermisoLlamada{
        private ?int $id;
        private Usuario $usuario;
        private Nodo $nodoOrigen;
        private Nodo $nodoDestino;
        public function __construct(?int $id, Usuario $usuario, Nodo $nodoOrigen, Nodo $nodoDestino){
            $this->id = $id;
            $this->usuario = $usuario;
            $this->nodoOrigen = $nodoOrigen;
            $this->nodoDestino = $nodoDestino;
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

        public function getNodoOrigen():Nodo{
            return $this->nodoOrigen;
        }
        public function setNodoOrigen(Nodo $nodoOrigen):void{
            $this->nodoOrigen = $nodoOrigen;
        }

        public function getNodoDestino():Nodo{
            return $this->nodoDestino;
        }
        public function setNodoDestino(Nodo $nodoDestino):void{
            $this->nodoDestino = $nodoDestino;
        }
    }
?>