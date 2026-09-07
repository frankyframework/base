<?php
use Base\Form\bloqueForm;
use Franky\Haxor\Tokenizer;
use Base\model\Bloque;
use Base\entity\BloqueEntity;
$Tokenizer = new Tokenizer;


$id             = $MyRequest->getRequest('id');
$callback       = $MyRequest->getRequest('callback');

$data           = $MyFlashMessage->getResponse();

$path_img_blog = 'temp/'.md5(time());
$MySession->SetVar('path_img_bloque',$path_img_blog);
if(!empty($id))
{
    $MyCMS = new Bloque;
    $BloqueEntity = new BloqueEntity;
    $BloqueEntity->id($id);
    $result = $MyCMS->getData($BloqueEntity->getArrayCopy());
    $data   = $MyCMS->getRows();
    $path_img_blog = $id;

}

$css_template = array(getCss("estilos.css"));
if(is_array($MyFrankyMonster->MyCSSFile()))
{
	if(count($MyFrankyMonster->MyCSSFile()) > 0)
	{
		foreach($MyFrankyMonster->MyCSSFile() as $css)
		{
                    if(!empty($css))
                    {
			$css_template[] = getCss($css);
                    }
		}
	}
}

$cmsForm = new bloqueForm("frmcmstemplate");
$cmsForm->setData($data);
$cmsForm->setAtributoInput("callback","value", urldecode($callback));
$cmsForm->setAtributoInput("template","value", ($data['template']));
$MyMetatag->setCode("<script  src='/public/plugins/tinymce/tinymce.min.js'></script>");
?>
