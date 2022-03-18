<?php

$campos = [
    
];

$TemplateemailModel    = new \Base\model\TemplateemailModel;
$TemplateemailEntity    = new \Base\entity\TemplateemailEntity;
$TemplateemailEntity->id(getCoreConfig('base/smtp/email-test'));
$TemplateemailModel->getData($TemplateemailEntity->getArrayCopy());

$data = $TemplateemailModel->getRows();
sendEmail($campos,$data);