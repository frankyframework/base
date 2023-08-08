<?php
use Base\Form\RolesForm;
use Base\model\RoleModel;
use Base\entity\RoleEntity;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();

$RoleModel  = new RoleModel();
$RoleEntity = new RoleEntity();


$id		= $Tokenizer->decode($MyRequest->getRequest('id'));
$callback	= $MyRequest->getRequest('callback');
$data = $MyFlashMessage->getResponse();

$adminForm = new RolesForm("frmroles");




$title = "Nuevo rol";
if(!empty($id))
{
    $RoleEntity->id($id);
    $RoleModel->getData($RoleEntity->getArrayCopy());

    $data = $RoleModel->getRows();
    $galeria_frm = "";
    $album = $data['id'];
    $RoleEntity->id($id);
    $data['id'] = $Tokenizer->token('catalog_products', $data['id']);;
  
    $title = "Editar rol";
   
    $data["resources"] = json_decode($data["resources"],true);
}
$resources = [];
$modulo = $modulos = getModulos("DESC");
if(!empty($modulos))
{
    foreach($modulos as $modulo)
    {
        $path = PROJECT_DIR."/modulos/".$modulo."/configure/lca.php";
        if(file_exists($path))
        {
            $resources = array_merge($resources,include($path));
        }
    }
}
$optionsResource = [];
foreach ($resources as $name => $resource) {
    $optionsResource = array_merge($optionsResource,$resource);
}
$adminForm->setOptionsInput("set_attribute",$set_attribute);
$adminForm->setOptionsInput("resources[]",$optionsResource);
$adminForm->setData($data);
$adminForm->setAtributoInput("callback","value", urldecode($callback));


$title_form = "$title";