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
        private bool $grabada;
        private string $idAsterisk;
    }
    public function __construct(?int $id, Usuario $usuario, Nodo $nodoOrigen, Nodo $nodoDestino, string $telefono, \DateTime $fechaInicio, \DateTime $fechaFin, bool $grabada, string $idAsterisk){
        $this->id = $id;
        $this->usuario = $usuario;
        $this->nodoOrigen = $nodoOrigen;
        $this->nodoDestino = $nodoDestino;
        $this->telefono = $telefono;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->grabada = $grabada;
        $this->idAsterisk = $idAsterisk;
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
    public function getNodoDestino():Nodo{
        return $this->nodoDestino;
    }
    public function setNodoDestino(Nodo $nodoDestino):void{
        $this->nodoDestino = $nodoDestino;
    }
    public function getFechaInicio():\DateTime{
        return $this->fechaInicio;
    }
    public function setFechaInicio(\DateTime $fechaInicio):void{
        $this->fechaInicio = $fechaInicio;
    }

    public function getFechaFin():\DateTime{
        return $this->fechaFin;
    }
    public function setFechaFin(\DateTime $fechaFin):void{
        $this->fechaFin = $fechaFin;
    }
    public function toAssociativeArray():array{
        $retorno = array();
        $retorno["id"] = $this->id;
        $retorno["usuario"] = $this->usuario->toAssociativeArray();
        $retorno["nodoOrigen"] = $this->nodoOrigen->toAssociativeArray();
        $retorno["nodoDestino"] = $this->nodoDestino->toAssociativeArray();
        $retorno["telefono"] = $this->telefono;
        $retorno["fechaInicio"] = $this->fechaInicio->format("Y/m/d H:i:s");
        $retorno["fechaFin"] = $this->fechaFin->format("Y/m/d H:i:s");
        $retorno["grabada"] = $this->grabada;
        $retorno["idAsterisk"] = $this->idAsterisk;
        $retorno["id"] = $this->id;
        return $retorno;
    }
}

?>