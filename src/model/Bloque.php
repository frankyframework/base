<?php
namespace Base\model;


class Bloque  extends \Franky\Database\Mysql\objectOperations
{


          public function __construct()
          {
            parent::__construct();
            $this->from()->addTable('bloques_cms');
          }

        function getData($id='',$busca="",$status="",$url="")
        {
            $campos = array("id","titulo","friendly","template","fecha","status");


            if(!empty($id))
            {
                if(is_numeric($id))
                {
                    $this->where()->addAnd('id',$id,'=');

                }
                else
                {
                    $this->where()->addAnd('friendly',$id,'=');
                }
            }
            if($status != "")
            {
                $this->where()->addAnd('status',$status,'=');
            }
            if($busca != "")
            {
              $this->where()->concat('AND (');
              $this->where()->addOr('titulo','%'.$busca.'%','like');
              $this->where()->addOr('template','%'.$busca.'%','like');
              $this->where()->concat(')');
            }


            return $this->getColeccion($campos);

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
