<?php
use Base\Form\registroForm;
use Base\model\USERS;
use Base\entity\users as UserEntity;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();
$MyUser             = new USERS();
$MyUserEntity       = new UserEntity();

$id		= $Tokenizer->decode($MyRequest->getRequest('id'));
$callback	= $MyRequest->getRequest('callback');
$data = $MyFlashMessage->getResponse();

if(!$MyAccessList->MeDasChancePasar("administrar_otros_usuarios"))
{

	$id= $MySession->GetVar('id');
}

$adminForm = new registroForm("users");
$adminForm->setMobile($Mobile_detect->isMobile());
$adminForm->setAtributo("action","/admin/users/submit.users.php");

$title = "Alta";

if(!empty($id))
{
    $title = "Edición";

    $MyUserEntity->setId($id);
    $result	 		= $MyUser->getData($MyUserEntity->getArrayCopy());

	$data = $MyUser->getRows();
        $data['id'] = $Tokenizer->token('users', $data['id']);
        $adminForm->addId();

}
$adminForm->addGeneral();
if($MyAccessList->MeDasChancePasar("administrar_otros_usuarios")):

    $adminForm->addNivel();
    $adminForm->setOptionsInput("role",getRoles());
endif;
$adminForm->addGuardar();
$adminForm->setData($data);
$adminForm->setAtributoInput("callback","value", urldecode($callback));
$adminForm->setAtributoInput('token_xsrf', 'value',$Tokenizer->token('users_xsrf', time()));


$title_form = "$title de usuario";
