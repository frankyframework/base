<?php
$MyRedireccion      = new \Base\model\redireccionesModel();
$redireccionesEntity      = new \Base\entity\redireccionesEntity();

$redireccionesEntity->setUrl(parse_url($MyRequest->getURI(),PHP_URL_PATH));
$redireccionesEntity->setStatus(1);
$result	 	= $MyRedireccion->getData($redireccionesEntity->getArrayCopy());
$total		= $MyRedireccion->getTotal();
if($result == REGISTRO_SUCCESS)
{
    $registro = $MyRedireccion->getRows();
    $redireccion = parse_url($registro["redireccion"]);

    $redireccion = $redireccion["path"];

    $MyRequest->redirect($redireccion,"301");
}
