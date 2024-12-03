<?php
class Biblioteca{

    private $id;
    private $libro;
    private $descripcion;
    private $categoria;
    private $disponibilidad;
    private $nombreCliente;
    private $fecha;

    function __construct($idParam,$libroParam,$descripcionParam,$categoriaParam,$disponibilidadParam,$clienteParam,$fechaParam)
    {
        $this->id = $idParam;
        $this->libro = $libroParam;
        $this->descripcion = $descripcionParam;
        $this->categoria = $categoriaParam;
        $this->disponibilidad = $disponibilidadParam;
        $this->nombreCliente = $clienteParam;
        $this->fecha = $fechaParam;
    }

    
function GetId(){
        return $this->id;
    }

function GetLibro(){
    return $this->libro;
}

function SetLibro($newLibro){
    $this->libro = $newLibro;

}

function GetDescripcion(){
    return $this->descripcion;
}

function SetDescripcion($newDescrip){
    $this->descripcion = $newDescrip;
}

function GetCategoria(){
    return $this->categoria;
}

function SetCategoria($newCategoria){
    $this->categoria = $newCategoria;
}

function GetDispo(){
    return $this->disponibilidad;
}

function SetDispo($newDispo){
    $this->disponibilidad = $newDispo;
}

function GetNombreCliente(){
    return $this->nombreCliente;
}

function SetNombreCliente($ClienteParam){
    $this->nombreCliente = $ClienteParam;
}

function GetFecha(){
    return $this->fecha;
}

function SetFecha($fechaParam){
    $this->fecha = $fechaParam;
}

}

?>