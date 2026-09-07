<?php
namespace Base\model;

class TemplateemailModel  extends \Franky\Database\Mysql\objectOperations
{

    public function __construct()
    {
      parent::__construct();
      $this->from()->addTable('templates_email');
    }

    function getData($data = array())
    {
        $data = $this->optimizeEntity($data);
        $campos = ["id","nombre","status","fecha","Asunto","destinatario","cc","bcc","name_from",
        "email_from","reply","editable","html"];

        foreach($data as $k => $v)
        {
          if(!empty($v) || is_numeric($v))
          {
            if(is_array($v))
            {
                $this->where()->concat('AND (');
                foreach ($v as $_v)
                {
                  $this->where()->addOr($k,$_v,'=');

                }
                $this->where()->concat(')');
            }
            else
            {
                if(in_array($k,['id','fecha'])) {
                    $this->where()->addAnd($k,$v,'=');
                } else {
                    $this->where()->addAnd($k,"%".$v."%",'like');
                }
            } 
          }
        }

        return $this->getColeccion($campos);

    }

    private function optimizeEntity($array)
    {
        foreach ($array as $k => $v )
        {
            if (!isset($v)) {
                unset($array[$k]);
            }
        }
        return $array;
    }

    function existe($nombre,$id='')
    {
            $campos = array("id");

             $this->where()->addAnd('nombre',$nombre,'=');
            if(!empty($id))
            {
              $this->where()->addAnd('id',$id,'<>');
            }

            return $this->getColeccion($campos);
    }

    public function save($templates_email)
    {
        $templates_email = $this->optimizeEntity($templates_email);


    	if (isset($templates_email['id']))
    	{
            $this->where()->addAnd('id',$templates_email['id'],'=');

            return $this->editarRegistro($templates_email);
    	}
    	else {

            return $this->guardarRegistro( $templates_email);
    	}

    }
}
?>
