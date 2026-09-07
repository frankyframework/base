<?php
use Base\model\UrlInternacionalModel;
use Base\entity\UrlInternacionalEntity;
use Base\entity\OrganosEntity;
use Franky\Haxor\Tokenizer;

if ($MyRequest->isAjax()) {
  $callback	= $MyRequest->getRequest('callback');
  $filters = $MyRequest->getRequest('filters');
  $dataPost = json_decode(stripslashes($filters),true);
  $dataPost = $dataPost['rules'];
  $requestFranky = [];
  $request = [];
  foreach($dataPost as $data) {
    if(in_array($data['field'],["urli",'nombre'])) {
      if($data['field'] == "urli") {
        $requestFranky["url"] = $MyRequest->Sanitizacion($data['data']);
      } else {
        $requestFranky[$data['field']] = $MyRequest->Sanitizacion($data['data']);
      }
      
    } else {
      $request[$data['field']] = $MyRequest->Sanitizacion($data['data']);
    }
  }


  $Tokenizer = new Tokenizer();
  $sortInput  = (!empty($MyRequest->getRequest('sidx',"fecha")) ? : "fecha");
 

  if(empty($request['lang'])){
    $request['lang'] = $_SESSION['lang'];
  }
 
  $idioma_base = getCoreConfig('base/theme/baselang');
  $request['lang'] = (empty( $request['lang']) ? $idioma_base:  $request['lang']);

  $OrganosEntity = new OrganosEntity($requestFranky);
  $UrlInternacionalEntity = new UrlInternacionalEntity($request);
  $UrlInternacionalModel = new UrlInternacionalModel();

  $UrlInternacionalModel->setPage($MyRequest->getRequest('page',1));
  $UrlInternacionalModel->setTampag($MyRequest->getRequest('rows',12));
  $UrlInternacionalModel->setOrdensql($sortInput." ".$MyRequest->getRequest('sord',"ASC"));

  $result	= $UrlInternacionalModel->getData($UrlInternacionalEntity->getArrayCopy(),$OrganosEntity->getArrayCopy());
  $dataRows = ["rows" => [], "total" => ceil($UrlInternacionalModel->getTotal() / $MyRequest->getRequest('rows',12)), "page" => (int)$MyRequest->getRequest('page',1),"records" => $UrlInternacionalModel->getTotal()];

  if($UrlInternacionalModel->getTotal() > 0)
  {
    while($registro = $UrlInternacionalModel->getRows())
    {
      $registro = array_filter($registro, function($llave) {
              return !is_numeric($llave);
      }, ARRAY_FILTER_USE_KEY);


      $dataRows['rows'][] = array_merge($registro,array(
								"id" => $Tokenizer->token('url_internacional',$registro["id"]),
								"callback" => $Tokenizer->token('url_internacional',$MyRequest->getURI()),
                "status"  => ($registro["status"] == 1 ? "desactivar" : "activar")
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
