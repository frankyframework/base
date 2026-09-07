<?php
use Base\model\RoleModel;
use Base\entity\RoleEntity;
use Franky\Haxor\Tokenizer;

if ($MyRequest->isAjax()) {
    $callback	= $MyRequest->getRequest('callback');

    $RoleModel = new RoleModel();
    $RoleEntity = new RoleEntity();
    $Tokenizer = new Tokenizer();

    $alias = ['_id' => "roles.id"];
    if(isset($alias[$MyRequest->getRequest('sidx')]))
    {
        $sortInput = $alias[$MyRequest->getRequest('sidx')];
    }
    else{
        $sortInput  = (!empty($MyRequest->getRequest('sidx',"name")) ? : "name");
    }


    $RoleModel->setPage($MyRequest->getRequest('page',1));
    $RoleModel->setTampag($MyRequest->getRequest('rows',12));
    $RoleModel->setOrdensql($sortInput." ".$MyRequest->getRequest('sord',"ASC"));


    $RoleEntity->status(1);

    $result	 		= $RoleModel->getData($RoleEntity->getArrayCopy());
    
    $dataRows = ["rows" => [], "total" => ceil($RoleModel->getTotal() / $MyRequest->getRequest('rows',12)), "page" => (int)$MyRequest->getRequest('page',1),"records" => $RoleModel->getTotal()];

    if($RoleModel->getTotal() > 0)
    {

        while($registro = $RoleModel->getRows())
        {
            $registro = array_filter($registro, function($llave) {
                $clavesPermitidas = ['id','name', "callback","status"];
                return !is_numeric($llave)  && in_array($llave, $clavesPermitidas);
            }, ARRAY_FILTER_USE_KEY);
            $dataRows['rows'][] = array_merge($registro,array(
                
                    "id" => $Tokenizer->token('roles',$registro["id"]),
                    "_id" => $registro["id"],
                    "callback" => $Tokenizer->token('roles',$MyRequest->getURI()),
                    "status"  => ($registro["status"] == 1 ?"desactivar" : "activar")
            ));
        }
    }
    header('Content-Type: application/json; charset=utf-8');
    echo $callback . '(' . json_encode($dataRows). ');';
    die;
} else {
    $MyMetatag->setJs("/public/plugins/jqGrid/js/jquery.jqGrid.js");
    $MyMetatag->setJs("/public/plugins/jqGrid/js/i18n/grid.locale-$lang_root.js");
    $MyMetatag->setCSS("/public/plugins/jqGrid/css/ui.jqgrid.css");
}
?>
