<?php

function changeDir($path = null)
{
    global $MyConfigure;
    if(empty($path)) {
        $path = PROJECT_DIR."/public/upload/".$MyConfigure->getPathSite()."/";
    } else {
        $path = PROJECT_DIR."/public/upload/".$MyConfigure->getPathSite().$path;
    }
    $File = new \Franky\Filesystem\File;
    $contenido = array();

    foreach($files = $File->getFiles(realpath($path),'dir') as $file)
    {
        $contenido[] = array($file,'directory');
    }
    foreach($files = $File->getFiles(realpath($path)) as $file)
    {

        $partes_ruta = pathinfo($file);
        $validExtencions = explode(",",getCoreConfig("base/server/validmediaextension"));
        if(in_array($partes_ruta['extension'], $validExtencions)) {
            $contenido[] = array($file,'file');
        }
        
    }
    $path = str_replace( PROJECT_DIR."/public/upload/".$MyConfigure->getPathSite(), "", realpath($path));
    return array("connect" => true,"ls_remoto" => $contenido,"pwd_remoto" => $path);
}


function renameFile($path,$new_path)
{
    global $MyConfigure;
    $path = PROJECT_DIR."/public/upload/".$MyConfigure->getPathSite()."/".$path;
    $new_path = PROJECT_DIR."/public/upload/".$MyConfigure->getPathSite()."/".$new_path;
        if(file_exists($path))
        {
            return rename ( $path, $new_path);
        }

        return true;
}


function eliminarCarpeta($path)
{
    global $MyConfigure;
    $path = PROJECT_DIR."/public/upload/".$MyConfigure->getPathSite()."/".$path;
    if(file_exists($path))
    {
         return rmdir ($path);
    }

    return true;
}

function eliminarArchivo($path)
{
    global $MyConfigure;
    $path = PROJECT_DIR."/public/upload/".$MyConfigure->getPathSite()."/".$path;
    if(!is_dir($path))
    {
       return unlink($path);
    }

    return true;
}


function nuevaCarpeta($path)
{
    global $MyConfigure;
    $path = PROJECT_DIR."/public/upload/".$MyConfigure->getPathSite()."/".$path;
    if(!file_exists($path))
    {
        return mkdir($path,'0777');
    }

    return true;
}

function descargarArchivo($path)
{
    global $MyConfigure;
    $path = PROJECT_DIR."/public/upload/".$MyConfigure->getPathSite()."/".$path;
    global $MyRequest;
    return ["dowload" => $MyRequest->link(str_replace(PROJECT_DIR, "", $path),false,false)];
}

function getAllFiles($path)
{
    $File = new \Franky\Filesystem\File;
    $files = $File->getAllFiles($path);
  return $files;
}

$MyAjax->register("changeDir");
$MyAjax->register("renameFile");
$MyAjax->register("nuevaCarpeta");
$MyAjax->register("eliminarCarpeta");
$MyAjax->register("eliminarArchivo");
$MyAjax->register("descargarArchivo");
$MyAjax->register("getAllFiles");
?>
