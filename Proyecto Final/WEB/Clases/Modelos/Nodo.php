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
        public function getId():?int{
            return $this->id;
        }
        public function toAssociativeArray():array{
            $retorno = array();
            $retorno["id"] = $this->id;
            $retorno["numero"] = $this->numero;
            $retorno["ip"] = $this->ip;
            $retorno["dominio"] = $this->dominio;
            $retorno["nombre"] = $this->nombre;
            return $retorno;
        }
    }
?>