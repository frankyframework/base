<?php
use Franky\Core\validaciones;
use Base\model\RoleModel;
use Base\entity\RoleEntity;

use Franky\Haxor\Tokenizer;
use Franky\Core\ObserverManager;

$Tokenizer = new Tokenizer();
$RoleModel               = new RoleModel();
$RoleEntity              = new RoleEntity($MyRequest->getRequest());



$callback = $Tokenizer->decode($MyRequest->getRequest('callback'));
$RoleEntity->id($Tokenizer->decode($MyRequest->getRequest('id')));
$id = $RoleEntity->id();
$resources  = $MyRequest->getRequest('resources');

$error = false;




$validaciones =  new validaciones();


 $valid = $validaciones->validRules($RoleEntity->setValidation());


if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}


if(!$MyAccessList->MeDasChancePasar("admin_role"))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("sin_privilegios"));
    $error = true;
}

if(empty($resources))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("empty_rol"));
    $error = true;
}

if( $RoleModel->existe($RoleEntity->name(),$RoleEntity->id()) == REGISTRO_SUCCESS)
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("rol_duplicado"));
    $error = true;
}


if(!$error)
{
   
    $RoleEntity->resources(json_encode($resources));
    
    if(empty($id))
    {

        $RoleEntity->created_at(date('Y-m-d H:i:s'));
        $RoleEntity->status(1);
    }
    else
    {
        $RoleEntity->update_at(date('Y-m-d H:i:s'));
    }
    $result = $RoleModel->save($RoleEntity->getArrayCopy());
    
   
    if($result == REGISTRO_SUCCESS)
    {

        $ObserverManager = new ObserverManager;

        if(empty($id))
        {
            $id = $RoleModel->getUltimoID();
          
           
            $RoleEntity->id($id);
            
            $ObserverManager->dispatch('save_rol',['data' => $RoleEntity->getArrayCopy()]);
        
            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("guardar_generico_success"));
        }
        else
        {
            $ObserverManager->dispatch('edit_rol',['data' => $RoleEntity->getArrayCopy()]);
        
            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("editar_generico_success"));
        }
        $location = (!empty($callback) ? ($callback) : $MyRequest->url(LISTA_ROLES));


    }
    elseif($result == REGISTRO_ERROR)
    {

        if(empty($id))
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("guardar_generico_error"));
        }
        else
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("editar_generico_error"));
        }
        $location = $MyRequest->getReferer();
    }
    else
    {
        $MyFlashMessage->setMsg("error",$result);
        $location = $MyRequest->getReferer();
    }
}
else
{
    $location = $MyRequest->getReferer();
}


$MyRequest->redirect($location);
?>
