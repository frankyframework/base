<?php
/******************************* AJAX ADMIN *********************************/

function EliminarUser($id,$status)
{

        $MyUser             = new \Base\model\USERS();
        $MyUserEntity    = new \Base\entity\users();
        $Tokenizer = new \Franky\Haxor\Tokenizer;
        global $MyAccessList;
        global $MyMessageAlert;
        global $MyFlashMessage;
        $respuesta = null;
        if($MyAccessList->MeDasChancePasar("administrar_otros_usuarios"))
        {
            $MyUserEntity->setId(addslashes($Tokenizer->decode($id)));
            $MyUserEntity->setStatus(addslashes($status));
            if($MyUser->save($MyUserEntity->getArrayCopy()) == REGISTRO_SUCCESS)
            {

            }
            else
            {
		            $respuesta[] = array("message" => $MyMessageAlert->Message("delete_suscriptor_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }

	return $respuesta;
}


function EliminarTemplate($id,$status)
{
        $TemplateemailModel    = new\Base\model\TemplateemailModel;
        $TemplateemailEntity    = new\Base\entity\TemplateemailEntity;
          $Tokenizer = new \Franky\Haxor\Tokenizer;
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta = null;
        $TemplateemailEntity->status(addslashes($status));
        $TemplateemailEntity->id(addslashes($Tokenizer->decode($id)));
        if($MyAccessList->MeDasChancePasar("administrar_template_de_mailings"))
        {
            if($TemplateemailModel->save($TemplateemailEntity->getArrayCopy()) == REGISTRO_SUCCESS)
            {


            }
            else
            {
		  $respuesta[] = array("message" => $MyMessageAlert->Message(($status == 1 ? "activar" : "eliminar")."_generico_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }

	return $respuesta;
}
function EliminarCMSTemplate($id,$status)
{

	$MyCMS = new \Base\model\CMS;
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta = null;
        if($MyAccessList->MeDasChancePasar("administrar_template_de_cms"))
        {
            if($MyCMS->delete(addslashes($id),addslashes($status)) == REGISTRO_SUCCESS)
            {


            }
            else
            {
		  $respuesta[] = array("message" => $MyMessageAlert->Message(($status == 1 ? "activar" : "eliminar")."_generico_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }

	return $respuesta;
}

function EliminarDispositivo($password,$id,$status)
{
        global $MySession;
        $UserdeviceModel = new \Base\model\UserdeviceModel;
        $UserdeviceEntity = new \Base\entity\UserdeviceEntity;
        $MyUser         = new \Base\model\USERS();
        $Tokenizer = new \Franky\Haxor\Tokenizer;
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta = null;
        if(password_verify($password,$MySession->GetVar('contrasena')))
        {
          if($MyAccessList->MeDasChancePasar("administrar_devices"))
          {

            $UserdeviceEntity->id(addslashes($Tokenizer->decode($id)));
              if($UserdeviceModel->delete($UserdeviceEntity->getArrayCopy()) == REGISTRO_SUCCESS)
              {


              }
              else
              {
                    $respuesta[] = array("message" => $MyMessageAlert->Message(($status == 1 ? "activar" : "eliminar")."_generico_error"));
              }
          }
          else
          {
               $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
          }

        }
        else {

          $respuesta[] = array("message" => $MyMessageAlert->Message("error_pass_actual"));

        }

	return $respuesta;
}


function BloquearDispositivo($password,$id,$status)
{
      global $MySession;
	     $UserdeviceModel = new \Base\model\UserdeviceModel;
         $UserdeviceEntity = new \Base\entity\UserdeviceEntity;
       $MyUser         = new \Base\model\USERS();
       $Tokenizer = new \Franky\Haxor\Tokenizer;
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta = null;

        if(password_verify($password,$MySession->GetVar('contrasena')))
        {
          if($MyAccessList->MeDasChancePasar("administrar_devices"))
          {

            $UserdeviceEntity->id(addslashes($Tokenizer->decode($id)));
            $UserdeviceEntity->status(addslashes($status));
              if($UserdeviceModel->save($UserdeviceEntity->getArrayCopy()) == REGISTRO_SUCCESS)
              {


              }
              else
              {
                    $respuesta[] = array("message" => $MyMessageAlert->Message(($status == 1 ? "activar" : "eliminar")."_generico_error"));
              }
          }
          else
          {
               $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
          }

        }
        else {

          $respuesta[] = array("message" => $MyMessageAlert->Message("error_pass_actual"));

        }

	return $respuesta;
}



function EliminarComentario($id,$status)
{

	$ContactoModel = new Base\model\Contacto;
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta = null;
        if($MyAccessList->MeDasChancePasar("administrar_contactanos"))
        {
            if($ContactoModel->delete(addslashes($id)) == REGISTRO_SUCCESS)
            {


            }
            else
            {
		  $respuesta[] = array("message" => $MyMessageAlert->Message(($status == 1 ? "activar" : "eliminar")."_generico_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }

	return $respuesta;
}


function _getFiles($path,$file='file')
{
    global $MyAccessList;
    global $MyMessageAlert;
    
    $respuesta = [];
    
    if(!$MyAccessList->MeDasChancePasar("administrar_media_gallery"))
    {
        $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        return $respuesta;  
    }
    
    $path = trim($path);
    $file = trim($file);
    
    if (preg_match('/\.\.(\/|\\\\)/', $path) || 
        preg_match('/\.\.(\/|\\\\)/', $file) ||
        strpos($path, '~') !== false ||
        strpos($file, '~') !== false) {
        $respuesta[] = array("message" => "Path no permitido");
        return $respuesta;
    }
    
    $path = trim($path, '/\\');
    
    $allowedPaths = [
        'uploads',
        'public/uploads',
        'modulos',
        'public/jquery',
        'public/css',
        'public/js',
        'public/images'
    ];
    
    $isAllowed = false;
    foreach ($allowedPaths as $allowed) {
        if (strpos($path, $allowed) === 0) {
            $isAllowed = true;
            break;
        }
    }
    
    if (!$isAllowed) {
        $isSubdirAllowed = false;
        foreach ($allowedPaths as $allowed) {
            if (strpos($allowed, $path) === 0) {
                $isSubdirAllowed = true;
                break;
            }
        }
        
        if (!$isSubdirAllowed) {
            $respuesta[] = array("message" => "Acceso denegado a este directorio");
            return $respuesta;
        }
    }
    
    if (!preg_match('/^[a-zA-Z0-9_\-\*\.]*$/', $file)) {
        $respuesta[] = array("message" => "Patrón de búsqueda inválido");
        return $respuesta;
    }
    
    $fullPath = PROJECT_DIR . '/' . $path;
    
    if (!is_dir($fullPath)) {
        $respuesta[] = array("message" => "El directorio no existe");
        return $respuesta;
    }
    
    if (!is_readable($fullPath)) {
        $respuesta[] = array("message" => "No se puede leer el directorio");
        return $respuesta;
    }
    
    $File = new \Franky\Filesystem\File();
    
    try {
        $files = $File->getFiles($fullPath, $file);
        
        if(count($files) > 0)
        {
            $safeFiles = [];
            foreach($files as $filePath)
            {
                $fileName = basename($filePath);
                
                if (preg_match('/^[a-zA-Z0-9_\-\., ]+$/', $fileName)) {
                    $fileFullPath = $fullPath . '/' . $fileName;
                    if (file_exists($fileFullPath)) {
                        $fileInfo = [
                            'name' => $fileName,
                            'path' => $path . '/' . $fileName,
                            'size' => filesize($fileFullPath) ?: 0,
                            'modified' => date('Y-m-d H:i:s', filemtime($fileFullPath))
                        ];
                        
                        $dangerousExtensions = ['php', 'phtml', 'inc', 'htaccess', 'env', 'sql', 'sh', 'bash'];
                        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                        
                        if (!in_array($extension, $dangerousExtensions)) {
                            $safeFiles[] = $fileInfo;
                        }
                    }
                }
            }
            
            if (count($safeFiles) > 0) {
                $respuesta["files"] = $safeFiles;
                $respuesta["count"] = count($safeFiles);
                $respuesta["path"] = $path;
            } else {
                $respuesta[] = array("message" => "No se encontraron archivos seguros");
            }
        }
        else
        {
            $respuesta[] = array("message" => "No se encontraron archivos");
        }
    } catch (Exception $e) {
        error_log("Error en _getFiles: " . $e->getMessage());
        $respuesta[] = array("message" => "Error al procesar la solicitud");
    }

	return $respuesta;
}



function registrarEmail($email)
{
    global $MyMessageAlert;
    $Select = new \Franky\Database\Mysql\Select();
    $Insert = new \Franky\Database\Mysql\Insert();
    $From = new \Franky\Database\Mysql\From();
    $Where = new \Franky\Database\Mysql\Where();
    $validaciones = new \Franky\Core\validaciones();
    $ObserverManager = new \Franky\Core\ObserverManager();


    $respuesta["result"] = "ndefaulterror";
    $respuesta["message"] =  $MyMessageAlert->Message("news_defaulterror");

    $error = false;
    $From->addTable("mailing");
    $Where->addAnd('email',$email,'=');

    if(empty($email))
    {
        $respuesta["result"] = "empty";
        $respuesta["message"] =  $MyMessageAlert->Message("news_empty");
    }
    else
    {
        if($validaciones->ValidaMail($email))
        {

            if($Select->execute($From->get(), array("id"), $Where->get(), "", "id ASC")== CONSULTAS_SUCCESS)
            {
                $respuesta["result"] = "duplicate";
                $respuesta["message"] =  $MyMessageAlert->Message("news_duplicate");
            }
            else
            {
                if($Insert->execute($From->get(), array("email"=> $email,"fecha" => date('Y-m-d')." ".date("H:i:s"))) == CONSULTAS_SUCCESS)
                {
                    $respuesta["result"] = "success";
                    $respuesta["message"] =  $MyMessageAlert->Message("news_success");
                    $ObserverManager->dispatch('register_news',[$email]);
                }
                else
                {
                    $respuesta["result"] = "error";
                    $respuesta["message"] =  $MyMessageAlert->Message("news_error");
                }
            }
        }
        else
        {
            $respuesta["result"] = "bad";
            $respuesta["message"] =  $MyMessageAlert->Message("news_bad");

        }
    }
    return $respuesta;
}

function EliminarEmailNews($id,$status = 0)
{
    global $MyMessageAlert;
    global $MyAccessList;
    $Delete = new \Franky\Database\Mysql\Delete();
    
    $From = new \Franky\Database\Mysql\From();
    $Where = new \Franky\Database\Mysql\Where();
   

    $Tokenizer = new \Franky\Haxor\Tokenizer;
    $respuesta = null;

    $error = false;
    $From->addTable("mailing");
    $Where->addAnd('id',$Tokenizer->decode($id),'=');

    if(empty($id))
    {
        $respuesta["message"] =  $MyMessageAlert->Message("news_empty_id");
    }
    else
    {
        if($MyAccessList->MeDasChancePasar("administrar_mailing"))
        {

            if($Delete->execute($From->get(), $Where->get())== CONSULTAS_SUCCESS)
            {
               
            }
            else
            {
                    $respuesta["message"] =  $MyMessageAlert->Message("news_error");
            }
        }
        else
        {
            $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));

        }
    }
    return $respuesta;
}


function setExplorador()
{
    $_SESSION["explorador"] = true;
    return $respuesta;

}

function EliminarUrlIternacional($id,$status)
{
        global $MyAccessList;
        global $MyMessageAlert;

        $UrlInternacionalModel              = new \Base\model\UrlInternacionalModel();
        $UrlInternacionalEntity              = new \Base\entity\UrlInternacionalEntity();

        $Tokenizer = new \Franky\Haxor\Tokenizer;
        $respuesta = null;
        if($MyAccessList->MeDasChancePasar("administrar_urlinternacional"))
        {
            $UrlInternacionalEntity->id(addslashes($Tokenizer->decode($id)));
            $UrlInternacionalEntity->status(addslashes($status));
            if($UrlInternacionalModel->save($UrlInternacionalEntity->getArrayCopy()) == REGISTRO_SUCCESS)
            {

            }
            else
            {
		 $respuesta[] = array("message" => $MyMessageAlert->Message("eliminar_generico_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }

	return $respuesta;
}


function EliminarRol($id,$status)
{

        $RoleModel             = new \Base\model\RoleModel();
        $RoleEntity    = new \Base\entity\RoleEntity();
        $Tokenizer = new \Franky\Haxor\Tokenizer;
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta = null;
        if($MyAccessList->MeDasChancePasar("admin_role"))
        {
            $RoleEntity->id(addslashes($Tokenizer->decode($id)));
            $RoleEntity->status(addslashes($status));
            if($RoleModel->save($RoleEntity->getArrayCopy()) == REGISTRO_SUCCESS)
            {

            }
            else
            {
		            $respuesta[] = array("message" => $MyMessageAlert->Message("eliminar_generico_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }

	return $respuesta;
}

function EliminarBloque($id,$status)
{

	    $MyCMS = new \Base\model\Bloque;
        global $MyAccessList;
        global $MyMessageAlert;
        $respuesta = null;
        if($MyAccessList->MeDasChancePasar("administrar_template_de_bloque"))
        {
            if($MyCMS->delete(addslashes($id),addslashes($status)) == REGISTRO_SUCCESS)
            {


            }
            else
            {
		  $respuesta[] = array("message" => $MyMessageAlert->Message(($status == 1 ? "activar" : "eliminar")."_generico_error"));
            }
        }
        else
        {
             $respuesta[] = array("message" => $MyMessageAlert->Message("sin_privilegios"));
        }

	return $respuesta;
}


/******************************** EJECUTA *************************/

$MyAjax->register("EliminarUser");
$MyAjax->register("EliminarTemplate");
$MyAjax->register("EliminarCMSTemplate");
$MyAjax->register("EliminarComentario");
$MyAjax->register("_getFiles");
$MyAjax->register("registrarEmail");
$MyAjax->register("setExplorador");
$MyAjax->register("EliminarUrlIternacional");
$MyAjax->register("BloquearDispositivo");
$MyAjax->register("EliminarDispositivo");
$MyAjax->register("EliminarEmailNews");
$MyAjax->register("EliminarRol");
$MyAjax->register("EliminarBloque");
?>