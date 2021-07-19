<?php
use Base\Form\registroForm;
use Base\model\USERS;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();
$MyUser             = new USERS();

$callback	= $MyRequest->getRequest('callback');
$data = $MyFlashMessage->getResponse();


$id= $MySession->GetVar('id');


$adminForm = new registroForm("users");
$adminForm->setMobile($Mobile_detect->isMobile());
$adminForm->setAtributo("action","/mi-cuenta/users/submit.users.php");

$MyUser->getData($id);
$data = $MyUser->getRows();
$data['id'] = $Tokenizer->token('users', $data['id']);
$adminForm->addId();


$adminForm->addGeneral();
$adminForm->addGuardar();
$adminForm->setData($data);
$adminForm->setAtributoInput("callback","value", urldecode($callback));
$adminForm->setAtributoInput('token_xsrf', 'value',$Tokenizer->token('users_xsrf', time()));


$title_form = _("Editar mi informacíon de cuenta");
