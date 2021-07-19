<?php
use Base\Form\contrasenaForm;
use Base\model\USERS;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();
$MyUser             = new USERS();

$callback	= $MyRequest->getRequest('callback');


$id= $MySession->GetVar('id');

	
if(!empty($id))
{
	
    $result	 		= $MyUser->getData($id);

	$registro = $MyUser->getRows();	
	$id		= $Tokenizer->token('users',$registro["id"]);
	$contrasena_db	= $registro["contrasena"];
	
	
}

$adminForm = new contrasenaForm("userspass");
$adminForm->setAtributo('action','mi-cuenta/users/submit.pass.php');
if(!empty($contrasena_db)):
    $adminForm->addContrasenaAnterior();
endif;   

$adminForm->addSubmit();
$adminForm->setAtributoInput("id","value", $id);
$adminForm->setAtributoInput("callback","value", urldecode($callback));
$title_form = "Cambiar mi contraseña";
?>