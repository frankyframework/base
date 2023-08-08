<?php
namespace Base\model;

class RoleModel  extends \Franky\Database\Mysql\objectOperations
{

    public function __construct()
    {
      parent::__construct();
      $this->from()->addTable('roles');
    }

    function getData($avatares = array())
    {

        $avatares = $this->optimizeEntity($avatares);

        $campos = ["id","name","resources","status","created_at", "update_at"];

        foreach($avatares as $k => $v)
        {
            if(!empty($v))
            {
              $this->where()->addAnd($k,$v,'=');
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

    public function save($avatares)
    {
        $avatares = $this->optimizeEntity($avatares);

      	if (isset($avatares['id']))
      	{
              $this->where()->addAnd('id',$avatares['id'],'=');
              return $this->editarRegistro($avatares);
      	}
      	else {

              return $this->guardarRegistro($avatares);
      	}

    }


    function existe($name,$id='')
    {
            $campos = array("id");

             $this->where()->addAnd('name',$name,'=');
            if(!empty($id))
            {
              $this->where()->addAnd('id',$id,'<>');
            }

            return $this->getColeccion($campos);
    }

    public function delete($avatares)
    {
        $avatares = $this->optimizeEntity($avatares);


      	if (isset($avatares['id']))
      	{
              $this->where()->addAnd('id',$avatares['id'],'=');
              return $this->eliminarRegistro();
      	}


    }
}
?>
