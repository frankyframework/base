<?php
use Base\model\Mailing;
use Base\entity\MailingEntity;
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
        $MyMailing          = new Mailing;
        $MailingEntity      = new MailingEntity($request);

        $MyMailing->setPage($MyRequest->getRequest('page',1));
        $MyMailing->setTampag($MyRequest->getRequest('rows',12));
        $MyMailing->setOrdensql($sortInput." ".$MyRequest->getRequest('sord',"ASC"));

        $result = $MyMailing->getData($MailingEntity->getArrayCopy());
 
        $lista_admin_data = [];
        $dataRows = ["rows" => [], "total" => ceil($MyMailing->getTotal() / $MyRequest->getRequest('rows',12)), "page" => (int)$MyRequest->getRequest('page',1),"records" => $MyMailing->getTotal()];

        if($MyMailing->getTotal() > 0)
        {
                while($registro = $MyMailing->getRows())
                {
                       
                        $registro = array_filter($registro, function($llave) {
                                $clavesPermitidas = ['id','fecha', 'email'];
                                return !is_numeric($llave)  && in_array($llave, $clavesPermitidas);
                        }, ARRAY_FILTER_USE_KEY);
                
                
                        $dataRows['rows'][] = array_merge($registro,array(
                        "id" => $Tokenizer->token("mailing", $registro["id"]),
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