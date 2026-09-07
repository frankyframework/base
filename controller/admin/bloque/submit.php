<?php
use Base\entity\redireccionesEntity;
use Franky\Core\validaciones;
use Base\model\Bloque;
use Franky\Haxor\Tokenizer;


$MyCMS = new Bloque;
$Tokenizer  = new Tokenizer();
$id             = $MyRequest->getRequest('id');
$callback	= $Tokenizer->decode($MyRequest->getRequest('callback'));
$titulo         = $MyRequest->getRequest('titulo');
$template       = $MyRequest->getRequest('template',"",true);
$nametemplate    = $MyRequest->getRequest('friendly', getFriendly($titulo));


$error = false;

$rules = array(
            "Titulo" => array("valor" => $titulo,"required","length" => array("max" => "200")),
            "Template" => array("valor" => $template,"required"),
            "URL" => array("valor" => $nametemplate,"required")
            );


$validaciones =  new validaciones();
$valid = $validaciones->validRules($rules);
if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}

if($MyCMS->existeTemplate($titulo,$id) == REGISTRO_SUCCESS)
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("nombre_template_duplicado"));
    $error = true;
}

if(!$MyAccessList->MeDasChancePasar("administrar_template_de_bloque"))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("sin_privilegios"));
    $error = true;
}

if($error == false)
{
    if(empty($id))
    {

        $result = $MyCMS->save($titulo,$nametemplate,$template);
        if($result == REGISTRO_SUCCESS)
        {
            $dir_blog = $MyConfigure->getServerUploadDir()."/bloques/".$MySession->GetVar('path_img_bloque')."/";      
            rename($dir_blog,str_replace($MySession->GetVar('path_img_bloque'),$MyCMS->getUltimoID(),$dir_blog));

            $template = str_replace($MySession->GetVar('path_img_bloque'),$MyCMS->getUltimoID(),$template);
            $MyCMS->edit($MyCMS->getUltimoID(),$titulo,$nametemplate,$template);


            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("guardar_generico_success"));
            $location =  (!empty($callback) ? ($callback) : $MyRequest->url(LISTA_CMS_BLOQUE));
        }
        else
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("guardar_generico_error"));
            $location = $MyRequest->getReferer();
        }
    }
    else
    {
        $MyCMS->getData(['id' => $id]);
        $registro = $MyCMS->getRows();
        $_titulo		= $registro["titulo"];
        $friendly              = $registro["friendly"];



        $result = $MyCMS->edit($id,$titulo,$nametemplate,$template);

        if($result == REGISTRO_SUCCESS)
        {


            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("editar_generico_success"));
            $location = (!empty($callback) ? ($callback) : $MyRequest->url(LISTA_CMS_BLOQUE));
	    }
        else
        {
           $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("editar_generico_error"));
           $location = $MyRequest->getReferer();
        }
    }

}
else
{
    $location = $MyRequest->getReferer();
}

$MyRequest->redirect($location);
?>
