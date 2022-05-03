<?php
use Base\Form\filtrosForm;
use Franky\Core\paginacion;
use Base\model\Mailing;
use Franky\Haxor\Tokenizer;


$Tokenizer = new Tokenizer();

$MyPaginacion = new paginacion();
$MyMailing          = new Mailing;

$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"fecha"));
$MyPaginacion->setOrden($MyRequest->getRequest('order',"DESC"));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',25));			
$busca_b	= $MyRequest->getRequest('busca_b');	


$MyMailing->setPage($MyPaginacion->getPage());
$MyMailing->setTampag($MyPaginacion->getTampageDefault());
$MyMailing->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());

$result	 		= $MyMailing->getData($busca_b);
$MyPaginacion->setTotal($MyMailing->getTotal());

$lista_admin_data = array();
if($MyMailing->getTotal() > 0)
{
	$iRow = 0;	

	while($registro = $MyMailing->getRows())
	{
		$thisClass  = ((($iRow % 2) == 0) ? "formFieldDk" : "formFieldLt");
	               
                $lista_admin_data[] = array_merge($registro,array(
                        "id" => $Tokenizer->token("mailing", $registro["id"]),
                "fecha"         => getFechaUI($registro["fecha"]),
                "thisClass"     => $thisClass,
                "nuevo_estado"  =>  "desactivar"
                ));
		 
                $iRow++;
        }
}


$MyFiltrosForm = new filtrosForm('paginar');
$MyFiltrosForm->setMobile($Mobile_detect->isMobile());
$MyFiltrosForm->addBusca();
$MyFiltrosForm->addSubmit();
$deleteFunction ="EliminarEmailNews";
$MyFiltrosForm->setAtributoInput("busca_b", "value",$busca_b);
?>