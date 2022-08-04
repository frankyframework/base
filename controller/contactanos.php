<?php
use Base\Form\contactanosForm;
use Franky\Haxor\Tokenizer;

$Tokenizer = new Tokenizer();
$contactanosForm = new contactanosForm("frmContacto");
$contactanosForm->setMobile($Mobile_detect->isMobile());
$contactanosForm->setData($MyFlashMessage->getResponse());
$contactanosForm->setAtributoInput('token_xsrf', 'value',$Tokenizer->token('cantactanos_xsrf', time()));

if(getCoreConfig('base/contactanos/captcha') == 1):
    $MyMetatag->setCode('<script src="https://www.google.com/recaptcha/api.js" async defer></script>'); 
endif; 
?>
