<?php
namespace Base\model;

class UserdeviceModel  extends \Franky\Database\Mysql\objectOperations
{

    public function __construct()
    {
      parent::__construct();
      $this->from()->addTable('user_device');
    }

    function getData($data = array())
    {
        $data = $this->optimizeEntity($data);
        $campos = ["id","id_user","type","os","user_agent","ip","device_id","create_at","access_last","status"];

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

    public function save($merca_estados)
    {
        $merca_estados = $this->optimizeEntity($merca_estados);


    	if (isset($merca_estados['id']))
    	{
            $this->where()->addAnd('id',$merca_estados['id'],'=');

            return $this->editarRegistro($merca_estados);
    	}
    	else {

            return $this->guardarRegistro( $merca_estados);
    	}

    }

    public function delete($data)
    {

      $data = $this->optimizeEntity($data);
      foreach($data as $k => $v)
      {
          $this->where()->addAnd("user_device.".$k,$v,'=');
      }

      return $this->eliminarRegistro($data);
    }
}
?>
