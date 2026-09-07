<?php
use Base\model\Bloque;
use Base\entity\BloqueEntity;
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

        $MyCMS = new Bloque;
        $BloqueEntity = new BloqueEntity($request);
        $Tokenizer  = new Tokenizer();
        $sortInput  = (!empty($MyRequest->getRequest('sidx',"fecha")) ? : "fecha");
    
        $MyCMS->setPage($MyRequest->getRequest('page',1));
        $MyCMS->setTampag($MyRequest->getRequest('rows',12));
        $MyCMS->setOrdensql($sortInput." ".$MyRequest->getRequest('sord',"ASC"));

        $result	 = $MyCMS->getData($BloqueEntity->getArrayCopy());

        $lista_admin_data = [];
        $dataRows = ["rows" => [], "total" => ceil($MyCMS->getTotal() / $MyRequest->getRequest('rows',12)), "page" => (int)$MyRequest->getRequest('page',1),"records" => $MyCMS->getTotal()];
                
        if($MyCMS->getTotal() > 0)
        {
                while($registro = $MyCMS->getRows())
                {
                        $registro = array_filter($registro, function($llave) {
                                $clavesPermitidas = ['id','fecha', 'titulo','friendly',"status"];
                                return !is_numeric($llave)  && in_array($llave, $clavesPermitidas);
                        }, ARRAY_FILTER_USE_KEY);
                
                
                        $dataRows['rows'][] = array_merge($registro,array(
                        "fecha"        => getFechaUI($registro["fecha"]),
                        "status"  => ($registro["status"] == 1 ? "desactivar" : "activar"),
                        "callback" => $Tokenizer->token("cms", $MyRequest->getURI())
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
