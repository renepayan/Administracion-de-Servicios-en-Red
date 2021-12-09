<?php
    namespace PBX\Modelos;
    require_once 'Grupo.php';
    class Usuario{
        private ?int $id;
        private string $nombre;
        private string $usuario;     
        private string $password;   
        private int $nivel;
        private Grupo $grupo;
        private bool $grabarLlamadas;
        private bool $llamarAGrupos;
        private bool $llamarExtensiones;
        private string $extension;
        private Nodo $nodo;
        public function __construct(?int $id, string $nombre, string $usuario, string $password, int $nivel, Grupo $grupo, bool $grabarLlamadas, bool $llamarAGrupos, bool $llamarExtensiones, string $extension, Nodo $nodo){
            $this->id = $id;
            $this->nombre = $nombre;
            $this->usuario = $usuario;
            $this->password = $password;
            $this->nivel = $nivel;
            $this->grupo = $grupo;
            $this->grabarLlamadas = $grabarLlamadas;
            $this->llamarAGrupos = $llamarAGrupos;
            $this->llamarExtensiones = $llamarExtensiones;
            $this->extension = $extension;
            $this->nodo = $nodo;
        }

    }
?>