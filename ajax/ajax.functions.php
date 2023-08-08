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
	//echo $path;
  $File = new \Franky\Filesystem\File;
        $files = $File->getFiles(PROJECT_DIR.$path,$file);

        if(count($files) > 0)
        {
            foreach($files as $file)
            {
                $respuesta["file"][] =  $file;
            }
        }
        else
        {
            $respuesta[] = array("message" => "error");
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
?>
