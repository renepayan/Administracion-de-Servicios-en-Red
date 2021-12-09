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
        public function getId():?int{
            return $this->id;
        }
        public function setId(int $id):void{
            $this->id = $id;
        }

        public function getNivel():int{
            return $this->nivel;
        }
        public function setNivel(int $nivel):void{
            $this->nivel = $nivel;
        }

        public function getNombre():string{
            return $this->nombre;
        }
        public function setNombre(string $nombre):void{
            $this->nombre = $nombre;
        }
        
        public function getUsuario():string{
            return $this->usuario;
        }
        public function setUsuario(string $usuario):void{
            $this->usuario = $usuario;
        }
        
        public function getPassword():string{
            return $this->password;
        }
        public function setPassword(string $password):void{
            $this->password = $password;
        }

        public function getExtension():string{
            return $this->extension;
        }
        public function setExtension(string $extension):void{
            $this->extension = $extension;
        }

        public function isGrabarLlamadas():bool{
            return $this->grabarLlamadas;
        }
        public function setGrabarLlamadas(bool $grabarLlamadas):void{
            $this->grabarLlamadas = $grabarLlamadas;
        }

        public function isLlamarAGrupos():bool{
            return $this->llamarAGrupos;
        }
        public function setLlamarAGrupos(bool $llamarAGrupos):void{
            $this->llamarAGrupos = $llamarAGrupos;
        }

        public function isLlamarExtensiones():bool{
            return $this->llamarExtensiones;
        }
        public function setLlamarExtensiones(bool $llamarExtensiones):void{
            $this->llamarExtensiones = $llamarExtensiones;
        }

        public function getNodo():Nodo{
            return $this->nodo;
        }
        public function setNodo(Nodo $nodo):void{
            $this->nodo = $nodo;
        }

        public function getGrupo():Grupo{
            return $this->grupo;
        }
        public function setGrupo(Grupo $grupo):void{
            $this->grupo = $grupo;
        }
        public function toAssociativeArray():array{
            $retorno = array();
            $retorno["id"] = $this->id;
            $retorno["nombre"] = $this->nombre;
            $retorno["password"] = $this->password;
            $retorno["usuario"] = $this->usuario;
            $retorno["nivel"] = $this->nivel;
            $retorno["grupo"] = $this->grupo->toAssociativeArray();
            $retorno["nodo"] = $this->nodo->toAssociativeArray();
            $retorno["grabarLlamadas"] = $this->grabarLlamadas;
            $retorno["llamarAGrupos"] = $this->llamarAGrupos;
            $retorno["llamarExtensiones"] = $this->llamarExtensiones;
            $retorno["extension"] = $this->extensiones;
            return $retorno;
        }
    }
?>