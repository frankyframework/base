<?php
use Base\Form\loginForm;

$loginForm = new loginForm("autentificacion");
$loginForm->setAtributo('action','admin/login.php');