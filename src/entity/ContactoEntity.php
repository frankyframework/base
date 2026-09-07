<?php
namespace Base\entity;

 
class ContactoEntity
{
    private int|null $id;
    private string|null $nombre;
    private string|null $email;
    private string|null $telefono;
    private string|null $asunto;
    private string|null $fecha;
    private string|null $compentario;
    private string|null $ip;
   
    public function __construct($data = null)
    {
        if (null != $data) {
            $this->exchangeArray($data);
        }
    }


    public function exchangeArray(array $data)
    {
        $this->id       = (isset($data["id"]) && !empty($data["id"]) ? $data["id"] : null);
        $this->email   = (isset($data["email"]) ? $data["email"] : null);
        $this->fecha    = (isset($data["fecha"]) ? $data["fecha"] : null);
        $this->nombre   = (isset($data["nombre"]) ? $data["nombre"] : null);
        $this->telefono    = (isset($data["telefono"]) ? $data["telefono"] : null);
        $this->asunto   = (isset($data["asunto"]) ? $data["asunto"] : null);
        $this->compentario    = (isset($data["compentario"]) ? $data["compentario"] : null);
        $this->ip    = (isset($data["ip"]) ? $data["ip"] : null);
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setValidation()
    {
        return array();
    }

    public function id($id = null){ if($id !== null){ $this->id=$id; }else{ return $this->id; } }

    public function email($email = null){ if($email != null){ $this->email=$email; }else{ return $this->email; } }

    public function fecha($fecha = null){ if($fecha !== null){ $this->fecha=$fecha; }else{ return $this->fecha; } }

    public function nombre($nombre = null){ if($nombre !== null){ $this->nombre=$nombre; }else{ return $this->nombre; } }
    
    public function telefono($telefono = null){ if($telefono !== null){ $this->telefono=$telefono; }else{ return $this->telefono; } }
    
    public function asunto($asunto = null){ if($asunto !== null){ $this->asunto=$asunto; }else{ return $this->asunto; } }
    
    public function compentario($compentario = null){ if($compentario !== null){ $this->compentario=$compentario; }else{ return $this->compentario; } }
    
    public function ip($ip = null){ if($ip !== null){ $this->ip=$ip; }else{ return $this->ip; } }
}
?>