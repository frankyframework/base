<?php
namespace Base\entity;

 
class CmsEntity
{
    private int|null $id;
    private string|null $titulo;
    private string|null $friendly;
    private string|null $template;
    private string|null $fecha;
    private int|null $status;
    private string|null $meta_titulo;
    private string|null $meta_descripcion;
    private int|null $mostrar_titulo;

    public function __construct($data = null)
    {
        if (null != $data) {
            $this->exchangeArray($data);
        }
    }


    public function exchangeArray(array $data)
    {
        $this->id       = (isset($data["id"]) && !empty($data["id"]) ? $data["id"] : null);
        $this->titulo   = (isset($data["titulo"]) ? $data["titulo"] : null);
        $this->friendly = (isset($data["friendly"]) ? $data["friendly"] : null);
        $this->template = (isset($data["template"]) ? $data["template"] : null);
        $this->status   = (isset($data["status"]) ? $data["status"] : null);
        $this->fecha    = (isset($data["fecha"]) ? $data["fecha"] : null);
        $this->meta_titulo  = (isset($data["meta_titulo"]) ? $data["meta_titulo"] : null);
        $this->meta_descripcion = (isset($data["meta_descripcion"]) ? $data["meta_descripcion"] : null);
        $this->mostrar_titulo = (isset($data["mostrar_titulo"]) ? $data["mostrar_titulo"] : null);

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

    public function titulo($titulo = null){ if($titulo != null){ $this->titulo=$titulo; }else{ return $this->titulo; } }

    public function friendly($friendly = null){ if($friendly != null){ $this->friendly=$friendly; }else{ return $this->friendly; } }

    public function template($template = null){ if($template != null){ $this->template=$template; }else{ return $this->template; } }

    public function status($status = null){ if($status !== null){ $this->status=$status; }else{ return $this->status; } }

    public function fecha($fecha = null){ if($fecha !== null){ $this->fecha=$fecha; }else{ return $this->fecha; } }

    public function meta_titulo($meta_titulo = null){ if($meta_titulo !== null){ $this->meta_titulo=$meta_titulo; }else{ return $this->meta_titulo; } }

    public function meta_descripcion($meta_descripcion = null){ if($meta_descripcion !== null){ $this->meta_descripcion=$meta_descripcion; }else{ return $this->meta_descripcion; } }

    public function mostrar_titulo($mostrar_titulo = null){ if($mostrar_titulo !== null){ $this->mostrar_titulo=$mostrar_titulo; }else{ return $this->mostrar_titulo; } }
}
?>