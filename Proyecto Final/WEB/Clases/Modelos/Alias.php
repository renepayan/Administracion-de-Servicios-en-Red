<?php
    namespace PBX\Modelos;
    class Alias{
        private ?int $id;
        private int $tipoAlias;
        private Usuario $usuario;
        private string $alias;
        public function __construct(?int $id, int $tipoAlias, Usuario $usuario, string $alias){
            $this->id = $id;
            $this->usuario = $usuario;
            $this->alias = $alias;    
            $this->tipoAlias = $tipoAlias;        
        }
        public function getId():?int{
            return $this->id;
        }
        public function setId(int $id):void{
            $this->id = $id;
        }

        public function getAlias():string{
            return $this->alias;
        }
        public function setAlias(string $alias):void{
            $this->alias = $alias;
        }

        public function getTipoAlias():int{
            return $this->tipoAlias;
        }
        public function setTipoAlias(int $tipoAlias):void{
            $this->tipoAlias = $tipoAlias;
        }
        public function toAssociativeArray():array{
            $retorno = array();
            $retorno["id"] = $this->id;
            $retorno["tipoAlias"] = $this->tipoAlias;
            $retorno["usuario"] = $this->usuario->toAssociativeArray();
            $retorno["alias"] = $this->alias;
            return $retorno;
        }
    }
?>