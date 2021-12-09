<?php
    namespace PBX\Modelos;
    class Nodo{
        private ?int $id;
        private int $numero;
        private string $ip;
        private string $dominio;
        private string $nombre;
        public function __construct(?int $id, int $numero, string $ip, string $dominio, string $nombre){
            $this->id = $id;
            $this->numero = $numero;
            $this->ip = $ip;
            $this->dominio = $dominio;
            $this->nombre = $nombre;
        }
    }
?>