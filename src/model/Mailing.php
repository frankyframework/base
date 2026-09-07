<?php
namespace Base\model;

class Mailing  extends \Franky\Database\Mysql\objectOperations
{


        public function __construct()
        {
          parent::__construct();
          $this->from()->addTable('mailing');
        }


        function getData($data = [])
        {
            $data = $this->optimizeEntity($data);
            $campos = array("id","email","fecha");

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



}


?>
