<?php
$MyCMS = new \Base\model\CMS;
$CmsEntity = new \Base\entity\CmsEntity();
$CmsEntity->friendly($MyRequest->getURI());
$CmsEntity->status(1);

if($MyCMS->getData($CmsEntity->getArrayCopy()) == REGISTRO_SUCCESS)
{

				$registro           = $MyCMS->getRows();
				$id_cms             = $registro["id"];
        $titulo_cms         = $registro["titulo"];
        $mostrar_titulo         = $registro["mostrar_titulo"];
        $template_cms       = contentWebP($registro["template"]);
        $MyMetatag->setTitulo($registro["meta_titulo"]);
        $MyMetatag->setDescripcion($registro["meta_descripcion"]);
        $MyMetatag->setkeywords("");
}
else
{
    $MyRequest->redirect();
}
