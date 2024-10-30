<?php
$respuesta = array("error" => false);  
$path = $MyRequest->getRequest('path');

$path = PROJECT_DIR."/public/upload/".$MyConfigure->getPathSite().$path;


$files = array();
foreach ($_FILES['files'] as $k => $l) {
    foreach ($l as $i => $v) {
        if (!array_key_exists($i, $files))
            $files[$i] = array();
        $files[$i][$k] = $v;
    }
}      
     
if(!$MyAccessList->MeDasChancePasar("administrar_media_gallery"))
{

    $respuesta = array("error" => true,"msg" => $MyMessageAlert->Message("sin_privilegios"));  
}
        
     

$validExtencions = explode(",",getCoreConfig("base/server/validmediaextension"));


foreach ($files as $file) 
{    
    $handle = new \Franky\Filesystem\Upload($file);
    if ($handle->uploaded)
    {  
        if (in_array(strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)),$validExtencions ))// (!$handle->file_is_image)
        {

            $handle->file_max_size = 1024*1024*100; //1k(1024) x 512
        

            $handle->Process($path);

            if ($handle->processed)
            {

            
            $respuesta["file"][] = array("name" => $file['name'], "error" => false, "msg" => "");
            }
            else
            {
            $respuesta["file"][] = array("name" => $file['name'], "error" => true, "msg" => "Error al subir el archivo");
            }
        }
    }
    else
    {
        $respuesta["file"][] = array("name" => $file['name'], "error" => true, "msg" => "Error al subir el archivo");
    }
}
if($MyRequest->isAjax())
{
    header('Content-Type: application/json');
    echo json_encode($respuesta);
}
else
{
    $MyRequest->redirect();
}
?>