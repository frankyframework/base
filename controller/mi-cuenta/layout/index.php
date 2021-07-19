<?php

$MyMenuAdmin = new \Franky\Core\menuSitio();

$modulos = getModulos('DESC');
$mi_modulo = $MyConfigure->getPathSite();
if(!empty($modulos))
{
    foreach($modulos as $modulo)
    {
        if(file_exists(PROJECT_DIR."/modulos/".$mi_modulo."/".$modulo."/menu/cuenta.php"))
        {
          $MyMenuAdmin->setArraySeccion(PROJECT_DIR."/modulos/".$mi_modulo."/".$modulo."/menu/cuenta.php","modulo_".$modulo);
        }
        else {
          if(file_exists(PROJECT_DIR."/modulos/".$modulo."/menu/cuenta.php"))
          {
            $MyMenuAdmin->setArraySeccion(PROJECT_DIR."/modulos/".$modulo."/menu/cuenta.php","modulo_".$modulo);
          }

        }

    }
}
 ?>
