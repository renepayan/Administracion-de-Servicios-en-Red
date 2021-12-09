<?php
    namespace PBX\Modelos;
    class Grupo{
        private ?int $id;
        private string $extension;
        private string $nombre;
        public function __construct(?int $id, string $extension, string $nombre){
            $this->id = $id;
            $this->extension = $extension;
            $this->nombre = $nombre;            
        }
    }
?>