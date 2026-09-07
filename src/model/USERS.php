<?php
namespace Base\model;

class USERS  extends \Franky\Database\Mysql\objectOperations
{
    protected array $rango;

    public function __construct()
    {
      parent::__construct();
      $this->from()->addTable('users');
    }
  
    public function setRango(array $rango)
    {
        $this->rango = $rango;
    }
    
    
    function getData(array $data = [])
    {
            $data = $this->optimizeEntity($data);
            $campos = array("id","nombre","email","role","fecha","fecha_nacimiento","sexo","telefono","contrasena","verificado","status");

            if(!empty($this->rango))
            {
                  $this->where()->concat('AND (');
                  $this->where()->addAnd('fecha',$this->rango[0],'>=');
                  $this->where()->addAnd('fecha',$this->rango[1],'<=');
                  $this->where()->concat(')');
                  unset($data['fecha']);
            }

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
                  if(in_array($k,['id','contrasena','status','verificado'])) {
                    $this->where()->addAnd($k,$v,'=');
                  } else {
                      $this->where()->addAnd($k,"%".$v."%",'like');
                  }
                } 
              }
            }

            return $this->getColeccion($campos);

        }



    function findEmail(string $email,int $id=null)
    {
        $campos = array("email");
        $this->where()->addAnd('email',$email,'=');
        $this->where()->addAnd('status',1,'=');
        if(!empty($id))
        {
          $this->where()->addAnd('id',$id,'<>');
        }

        return $this->getColeccion($campos);

    }
    function findTelefono(string $telefono, int$id=null)
    {
        $campos = array("telefono");
        $this->where()->addAnd('telefono',$telefono,'=');
        $this->where()->addAnd('status',1,'=');
        if(!empty($id))
        {
          $this->where()->addAnd('id',$id,'<>');
        }

        return $this->getColeccion($campos);

    }
   

    private function optimizeEntity(array $array)
    {
        foreach ($array as $k => $v )
        {
            if (!isset($v)) {
                unset($array[$k]);
            }
        }
        return $array;
    }

    public function save(array $user)
    {

        $user = $this->optimizeEntity($user);


    	if (isset($user['id']))
    	{
          $this->where()->addAnd('id',$user['id'],'=');
            return $this->editarRegistro( $user);
    	}
    	else {

            return $this->guardarRegistro($user);
    	}

    }
}


?>
