<?php
use Base\model\USERS;
use Base\Form\deleteForm;
use Base\entity\users as UserEntity;

$MyUser = new USERS();
$MyUserEntity       = new UserEntity();

$MyUserEntity->setId($MySession->GetVar('id'));
$result	 = $MyUser->getData($MyUserEntity->getArrayCopy());
$registro = $MyUser->getRows();	
$id		= $registro["id"];
$contrasena_db	= $registro["contrasena"];

$adminForm = new deleteForm("userspass");
if(!empty($contrasena_db)):
    $adminForm->addContrasenaAnterior();
endif;
$title_form = "Eliminar mi cuenta";

?>