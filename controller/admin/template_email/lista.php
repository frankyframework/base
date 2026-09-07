<?php
use Base\model\TemplateemailModel;
use Base\entity\TemplateemailEntity;
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

    $TemplateemailModel    = new TemplateemailModel;
    $TemplateemailEntity    = new TemplateemailEntity($request);


    $TemplateemailModel->setPage($MyRequest->getRequest('page',1));
    $TemplateemailModel->setTampag($MyRequest->getRequest('rows',12));
    $TemplateemailModel->setOrdensql($sortInput." ".$MyRequest->getRequest('sord',"ASC"));

    $result	 = $TemplateemailModel->getData($TemplateemailEntity->getArrayCopy());
    $dataRows = ["rows" => [], "total" => ceil($TemplateemailModel->getTotal() / $MyRequest->getRequest('rows',12)), "page" => (int)$MyRequest->getRequest('page',1),"records" => $TemplateemailModel->getTotal()];

    if($TemplateemailModel->getTotal() > 0)
    {

        while($registro = $TemplateemailModel->getRows())
        {
            $registro = array_filter($registro, function($llave) {
                    return !is_numeric($llave);
            }, ARRAY_FILTER_USE_KEY);


            $dataRows['rows'][] = array(
                    "id" => $Tokenizer->token('templates',$registro["id"]),
                    "_id" => $registro["id"],
                    "callback" => $Tokenizer->token('templates',$MyRequest->getURI()),
                    "fecha"        => getFechaUI($registro["fecha"]),
                    "nombre"        => $registro["nombre"],
                    "Asunto"        => $registro["Asunto"],
                    "html"        => prevoewEmailTemplate($registro["html"]),
                    "status"  =>  ($registro["status"] == 1 ? "desactivar" : "activar"),
                );
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
