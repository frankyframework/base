<?php
use Catalog\Form\filtrosForm;
use Franky\Core\paginacion;
use Base\model\RoleModel;
use Base\entity\RoleEntity;
use Franky\Haxor\Tokenizer;



$RoleModel = new RoleModel();
$RoleEntity = new RoleEntity();
$Tokenizer = new Tokenizer();

$MyPaginacion = new paginacion();

$MyPaginacion->setPage($MyRequest->getRequest('page',1));
$MyPaginacion->setCampoOrden($MyRequest->getRequest('por',"roles.name"));
$MyPaginacion->setOrden($MyRequest->getRequest('order',"ASC"));
$MyPaginacion->setTampageDefault($MyRequest->getRequest('tampag',25));
$busca_b	= $MyRequest->getRequest('busca_b');


$alias = ['_id' => "roles.id"];
if(isset($alias[$MyRequest->getRequest('por')]))
{

  $orden = $alias[$MyRequest->getRequest('por')];
}
else{
    $orden = $MyPaginacion->getCampoOrden();
}


$RoleModel->setPage($MyPaginacion->getPage());
$RoleModel->setTampag($MyPaginacion->getTampageDefault());
$RoleModel->setOrdensql($MyPaginacion->getCampoOrden()." ".$MyPaginacion->getOrden());


$RoleEntity->status(1);

$result	 		= $RoleModel->getData($RoleEntity->getArrayCopy());
$MyPaginacion->setTotal($RoleModel->getTotal());
$lista_admin_data = array();


if($RoleModel->getTotal() > 0)
{

    $iRow = 0;

    while($registro = $RoleModel->getRows())
    {
        $thisClass  = ((($iRow % 2) == 0) ? "formFieldDk" : "formFieldLt");

        $lista_admin_data[$iRow] = array_merge($registro,array(
                "thisClass"     => $thisClass,
                "id" => $Tokenizer->token('roles',$registro["id"]),
                "_id" => $registro["id"],
                "callback" => $Tokenizer->token('roles',$MyRequest->getURI()),
                "nuevo_estado"  => ($registro["status"] == 1 ?"desactivar" : "activar")
        ));


        $iRow++;
    }
}
//$MyFrankyMonster->setPHPFile(getVista("admin/template/grid.phtml"));
$title_grid = _("Roles");
$class_grid = "roles";
$error_grid = _catalog("No hay roles registrados");
$deleteFunction = "EliminarRol";

$frm_constante_link = FRM_ROLES;

$titulo_columnas_grid = array("_id" => _("ID"),"name" =>  _catalog("Nombre"));
$value_columnas_grid = array("_id", "name");

$css_columnas_grid = array("_id" => "w-xxxx-2", "name" => "w-xxxx-5");


$permisos_grid = "admin_role";
?>
