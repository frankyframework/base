<?php
use Franky\Filesystem\File;

$File = new File;


$files = $File->getFiles(PROJECT_DIR.'/public/jquery-ui/themes','dir');
$temas = [];
foreach($files as $file)
{
    $temas[basename($file)] = basename($file);
}

return $temas;