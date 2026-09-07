<?php
use Base\model\Contacto;
use Base\entity\ContactoEntity;
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

    $Tokenizer = new Tokenizer();
    $sortInput  = (!empty($MyRequest->getRequest('sidx',"fecha")) ? : "fecha");
    $MyContacto = new Contacto();
    $ContactoEntity = new ContactoEntity($request);

    $MyContacto->setPage($MyRequest->getRequest('page',1));
    $MyContacto->setTampag($MyRequest->getRequest('rows',12));
    $MyContacto->setOrdensql($sortInput." ".$MyRequest->getRequest('sord',"ASC"));


    $result	 = $MyContacto->getData($ContactoEntity->getArrayCopy());

    $dataRows = ["rows" => [], "total" => ceil($MyContacto->getTotal() / $MyRequest->getRequest('rows',12)), "page" => (int)$MyRequest->getRequest('page',1),"records" => $MyContacto->getTotal()];

    if($MyContacto->getTotal() > 0)
    {
        while($registro = $MyContacto->getRows())
        {
            $registro = array_filter($registro, function($llave) {
                    $clavesPermitidas = ["id","nombre","email","telefono","asunto","comentario","fecha","ip"];
                    return !is_numeric($llave)  && in_array($llave, $clavesPermitidas);
            }, ARRAY_FILTER_USE_KEY);


            $dataRows['rows'][] = array_merge($registro,array(
                        "fecha"         => getFechaUI($registro["fecha"]),
                        "status"  =>  "desactivar"
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
