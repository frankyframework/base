<?php
namespace Base\model;


class Bloque  extends \Franky\Database\Mysql\objectOperations
{


          public function __construct()
          {
            parent::__construct();
            $this->from()->addTable('bloques_cms');
          }

        function getData($data = [])
        {
            $data = $this->optimizeEntity($data);
            $campos = array("id","titulo","friendly","template","fecha","status");


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
                    if(in_array($k,['id','friendly','fecha'])) {
                        $this->where()->addAnd($k,$v,'=');
                    } else {
                        $this->where()->addAnd($k,"%".$v."%",'like');
                    }
                } 
              }
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


        function save($titulo,$friendly,$template)
        {
            $nvoregistro = array(
                "titulo" => $titulo,
                "friendly" => $friendly,
                "template" => $template,
                "fecha" => date('Y-m-d')." ".date('H:i:s'),
                "status" => "1"
            );



            return $this->guardarRegistro( $nvoregistro);
        }

        function edit($id,$titulo,$friendly,$template)
        {
            $nvoregistro = array(
                "titulo" => "$titulo",
                "friendly" => "$friendly",
                "template" => "$template",
                "update_at" => date('Y-m-d H:i:s')
            );


              $this->where()->addAnd('id',$id,'=');
            return $this->editarRegistro( $nvoregistro);
        }


        function delete($id,$status)
        {
            $nvoregistro = array(
                "status" => "$status"
            );


              $this->where()->addAnd('id',$id,'=');

            return $this->editarRegistro( $nvoregistro);
        }


    function existeTemplate($nombre,$id='')
    {
            $campos = array("id");
            $this->where()->addAnd('titulo',$nombre,'=');

            if(!empty($id))
            {
              $this->where()->addAnd('id',$id,'<>');
            }

            return $this->getColeccion($campos);
    }

}


?>
