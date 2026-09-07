<?php
namespace Base\model;

class UrlInternacionalModel  extends \Franky\Database\Mysql\objectOperations
{
       public function __construct()
    {
        parent::__construct();
        $this->from()->addTable('url_internacional');
    }

    function getData($url = array(),$franky = array())
    {
        $url = $this->optimizeEntity($url);
        $franky = $this->optimizeEntity($franky);
        $campos = ["url_internacional.id","id_franky","url_internacional.url","url_internacional.status","fecha","lang","nombre","franky.url as urli"];

         $this->where()->addAnd("franky.status",'1','=');

        foreach($url as $k => $v)
        {
            if(!empty($v) || is_numeric($v))
            {
                if(is_array($v))
                {
                    $this->where()->concat('AND (');
                    foreach ($v as $_v)
                    {
                        $this->where()->addOr("url_internacional.".$k,$_v,'=');

                    }
                    $this->where()->concat(')');
                }
                else
                {
                    if(in_array($k,['id','url','fecha','id_franky'])) {
                        $this->where()->addAnd("url_internacional.".$k,$v,'=');
                    } else {
                        $this->where()->addAnd("url_internacional.".$k,"%".$v."%",'like');
                    }
                } 
            }
        }
     
        foreach($franky as $k => $v)
        {
            if(!empty($v) || is_numeric($v))
            {
                if(is_array($v))
                {
                    $this->where()->concat('AND (');
                    foreach ($v as $_v)
                    {
                        $this->where()->addOr("franky.".$k,$_v,'=');

                    }
                    $this->where()->concat(')');
                }
                else
                {
                    if(in_array($k,['id','url'])) {
                        $this->where()->addAnd("franky.".$k,$v,'=');
                    } else {
                        $this->where()->addAnd("franky.".$k,"%".$v."%",'like');
                    }
                } 
            }
        }

        $this->from()->addInner('franky','url_internacional.id_franky','franky.id');

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

    public function save($url)
    {
        $url = $this->optimizeEntity($url);


    	if (isset($url['id']))
    	{
              $this->where()->addAnd('id',$url['id'],'=');
            return $this->editarRegistro($url);
    	}
    	else {

            return $this->guardarRegistro($url);
    	}

    }
}
?>
