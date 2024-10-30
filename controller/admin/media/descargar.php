<?php
use Franky\Filesystem\File;
$file = $MyRequest->getRequest('file');

$BASE = PROJECT_DIR;
if(empty($file))
{
    $MyRequest->redirect();
}
if(!$MyAccessList->MeDasChancePasar("administrar_media_gallery"))
{
    $MyRequest->redirect();
}
if(!file_exists($BASE.$file))
{
    $MyRequest->redirect();
}

if(is_dir($BASE.$file))
{

    $zip = new ZipArchive();

    $zip->open(basename($file).".zip", ZipArchive::CREATE);

    $File = new File;

    $files = $File->getAllFiles($BASE.$file);
    
    $validExtencions = explode(",",getCoreConfig("base/server/validmediaextension"));

    foreach($files['file'] as $_file)
    {
        $partes_ruta = pathinfo($_file);
        
        if(in_array($partes_ruta['extension'], $validExtencions)) {
            $zip->addFile($_file,str_replace($BASE."/public/upload/".$MyConfigure->getPathSite(),"", $_file));
        }
    }

    $zip->close();

    header("Content-type: application/octet-stream");
    header("Content-disposition: attachment; filename=".basename($file).".zip");
    readfile(basename($file).'.zip');
    unlink(basename($file).'.zip');
}
else
{
    header("Content-disposition: attachment; filename=".basename($file));
    header("Content-type: application/octet-stream");
    readfile($BASE.$file);
}
?>
