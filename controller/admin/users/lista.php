<?php
use Base\model\USERS;
use Base\entity\users as EntityUser;
use Franky\Haxor\Tokenizer;


if ($MyRequest->isAjax()) {
    $callback	= $MyRequest->getRequest('callback');
    $filters = $MyRequest->getRequest('filters');
    $dataPost = json_decode(stripslashes($filters),true);
    $dataPost = $dataPost['rules'];
    $request = [];
    foreach($dataPost as $data) {
        $request[$data['field']] = $MyRequest->Sanitizacion($data['data']);
    }
    $MyUser     = new USERS();
    $EntityUser = new EntityUser($request);
    $Tokenizer  = new Tokenizer();
    $sortInput  = (!empty($MyRequest->getRequest('sidx',"nombre")) ? : "nombre");
    $rango = array();

    if(!empty($request['fecha']))
    {
        $rango = [$request['fecha']." 00::00:00",$request['fecha']." 23::59:59"];
       
        $MyUser->setRango($rango);
    }

    $MyUser->setPage($MyRequest->getRequest('page',1));
    $MyUser->setTampag($MyRequest->getRequest('rows',12));
    $MyUser->setOrdensql($sortInput." ".$MyRequest->getRequest('sord',"ASC"));
    $result	 		= $MyUser->getData($EntityUser->getArrayCopy());
    $lista_admin_data = [];
    $_Niveles_usuarios = getRoles();
    $dataRows = ["rows" => [], "total" => ceil($MyUser->getTotal() / $MyRequest->getRequest('rows',12)), "page" => (int)$MyRequest->getRequest('page',1),"records" => $MyUser->getTotal()];
    if($MyUser->getTotal() > 0)
    {
        while($registro = $MyUser->getRows())
        {
            $registro = array_filter($registro, function($llave) {
                $clavesPermitidas = ['id','fecha', 'email','nombre','role','telefono',"callback","status"];
                return !is_numeric($llave)  && in_array($llave, $clavesPermitidas);
            }, ARRAY_FILTER_USE_KEY);

       
            $dataRows['rows'][] = array_merge($registro,array(          
            "id" => $Tokenizer->token("users", $registro["id"]),
            "callback" => $Tokenizer->token("users", $MyRequest->getURI()),
            "role"         => $_Niveles_usuarios[$registro["role"]],
            "status"  => ($registro["status"] == 1 ? "desactivar" : "activar"),
            "fecha"         => getFechaUI($registro["fecha"])
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
