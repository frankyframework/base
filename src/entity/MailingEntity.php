<?php
namespace Base\entity;

 
class MailingEntity
{
    private int|null $id;
    private string|null $email;
    private string|null $fecha;
   
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
}
?>