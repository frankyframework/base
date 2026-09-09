<?php
namespace Base\model;

class redireccionesModel  extends \Franky\Database\Mysql\objectOperations
{


          public function __construct()
          {
            parent::__construct();
            $this->from()->addTable('redirecciones');
          }

        function getData($data = [])
        {
          $data = $this->optimizeEntity($data);
            $campos = array("id","url","redireccion","status","fecha");

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
                        if(in_array($k,['id','url','status'])) {
                            $this->where()->addAnd($k,$v,'=');
                        } else {
                            $this->where()->addAnd($k,"%".$v."%",'like');
                        }
                    } 
                }
            }


            return $this->getColeccion($campos);

        }


        function existe($url,$id='',$urln='')
        {
                $campos = array("id");
                $this->where()->addAnd('url',$url,'=');

                if(!empty($id))
                {
                  $this->where()->addAnd('id',$id,'<>');
                }
                if(!empty($urln))
                {
                  $this->where()->addAnd('redireccion',$urln,'=');
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

        public function save($redireccion)
        {

            $redireccion = $this->optimizeEntity($redireccion);


            if (isset($redireccion['id']))
            {
                $this->where()->addAnd('id',$redireccion['id'],'=');
                return $this->editarRegistro( $redireccion);
            }
            else {

                return $this->guardarRegistro($redireccion);
            }

        }
}
?>