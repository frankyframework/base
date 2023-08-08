<?php
namespace Base\entity;

 
class RoleEntity
{
    private $id;
    private $name;
    private $resources;
    private $status;
    private $created_at;
    private $update_at;

    
    public function __construct($data = null)
    {
        if (null != $data) {
            $this->exchangeArray($data);
        }
    }


    public function exchangeArray($data)
    {
        $this->id = (isset($data["id"]) ? $data["id"] : null);
        $this->name = (isset($data["name"]) ? $data["name"] : null);
        $this->resources = (isset($data["resources"]) ? $data["resources"] : null);
        $this->status = (isset($data["status"]) ? $data["status"] : null);
        $this->created_at = (isset($data["created_at"]) ? $data["created_at"] : null);
        $this->update_at = (isset($data["update_at"]) ? $data["update_at"] : null);
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setValidation()
    {
        return array();
    }

    
    
    public function id($id = null){ if($id != null){ $this->id=$id; }else{ return $this->id; } }

    public function name($name = null){ if($name != null){ $this->name=$name; }else{ return $this->name; } }

    public function resources($resources = null){ if($resources != null){ $this->resources=$resources; }else{ return $this->resources; } }

    public function status($status = null){ if($status !== null){ $this->status=$status; }else{ return $this->status; } }

    public function created_at($created_at = null){ if($created_at !== null){ $this->created_at=$created_at; }else{ return $this->created_at; } }

    public function update_at($update_at = null){ if($update_at !== null){ $this->update_at=$update_at; }else{ return $this->update_at; } }
}
?>