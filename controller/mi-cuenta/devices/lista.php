<?php
use Base\model\UserdeviceModel;
use Base\entity\UserdeviceEntity;
use Franky\Haxor\Tokenizer;

if ($MyRequest->isAjax()) {
        $callback	= $MyRequest->getRequest('callback');
        $filters = $MyRequest->getRequest('filters');
        $dataPost = json_decode(stripslashes($filters),true);
        if(isset($dataPost['rules'])) {
            $dataPost = $dataPost['rules'];
        }
        $requestFranky = [];
        $request = [];
        if(!empty($dataPost)) {
            foreach($dataPost as $data) {
                $request[$data['field']] = $MyRequest->Sanitizacion($data['data']);
              }
        }

        $UserdeviceModel = new UserdeviceModel();
        $UserdeviceEntity = new UserdeviceEntity($request);
        $Tokenizer = new Tokenizer();
        $sortInput  = (!empty($MyRequest->getRequest('sidx',"access_last")) ? : "access_last");

        $UserdeviceModel->setPage($MyRequest->getRequest('page',1));
        $UserdeviceModel->setTampag($MyRequest->getRequest('rows',12));
        $UserdeviceModel->setOrdensql($sortInput." ".$MyRequest->getRequest('sord',"ASC"));

        $UserdeviceEntity->id_user($MySession->GetVar('id'));
        $result	 = $UserdeviceModel->getData($UserdeviceEntity->getArrayCopy());
        $dataRows = ["rows" => [], "total" => ceil($UserdeviceModel->getTotal() / $MyRequest->getRequest('rows',12)), "page" => (int)$MyRequest->getRequest('page',1),"records" => $UserdeviceModel->getTotal()];

        if($UserdeviceModel->getTotal() > 0)
        {

                $iRow = 0;

                while($registro = $UserdeviceModel->getRows())
                {
                        $registro = array_filter($registro, function($llave) {
                                return !is_numeric($llave);
                        }, ARRAY_FILTER_USE_KEY);

                        $dataRows['rows'][] = array_merge($registro,array(
                        "id" => $Tokenizer->token("devices", $registro["id"]),
                        "access_last"         => getFechaUI($registro["access_last"]),
                        "status"  => ($registro["status"] == 1 ? "desactivar" : "activar"),
                        "delete"  =>  "desactivar"
                        ));

                        $iRow++;
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
