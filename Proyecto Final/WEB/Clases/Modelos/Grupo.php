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
        public function getId():?int{
            return $this->id;
        }
        public function setId(int $id):void{
            $this->id = $id;
        }

        public function getExtension():string{
            return $this->extension;
        }
        public function setExtension(string $extension):void{
            $this->extension = $extension;
        }

        public function getNombre():string{
            return $this->nombre;
        }
        public function setNombre(string $nombre):void{
            $this->nombre = $nombre;
        }
        public function toAssociativeArray():array{
            $retorno = array();
            $retorno["id"] = $this->id;
            $retorno["extension"] = $this->extension;
            $retorno["nombre"] = $this->nombre;
            return $retorno;
        }
    }
?>