<?php
global $MySession;

return array(
    array('title'=> "Perfil",
            'children' =>  array(
                array(
                 "permiso" =>   ADMINISTRAR_OTROS_USUARIOS,
                 "url" => $MyRequest->url(LISTA_OPERADORES),
                 "etiqueta" => _("Usuarios")
                )
        )
    ),
    array('title'=> "Contenido",
            'children' =>  array(
                 array(
                 "permiso" =>   ADMINISTRAR_CMS_TEMPLATE,
                 "url" => $MyRequest->url(LISTA_CMS_TEMPLATE),
                 "etiqueta" => _("CMS")
               ),
              
                array(
                 "permiso" =>   ADMINISTRAR_MAILING,
                 "url" => $MyRequest->url(MAILING),
                 "etiqueta" => _("Newsletter")
                ),
                array(
                 "permiso" =>   ADMINISTRAR_CONTACTANOS,
                 "url" => $MyRequest->url(CONTACTOS_LIST),
                 "etiqueta" => _("Contacto")
                ),
            )
    ),
    array('title'=> "Configuración",
            'children' =>  array(
                       array(
                 "permiso" =>   ADMINISTRAR_EMAIL_TEMPLATE,
                 "url" => $MyRequest->url(LISTA_EMAIL_TEMPLATE),
                 "etiqueta" => _("E-mails transaccionales")
                ),
               array(
                "permiso" =>   ADMINISTRAR_CORE_CONFIG,
                "url" => $MyRequest->url(ADMIN_CORE_CONFIG),
                "etiqueta" => _("Administrar sistema")
              ),
                 array(
                "permiso" =>   ADMINISTRAR_URLINTERNACIONAL,
                "url" => $MyRequest->url(ADMIN_URL_INTERNACIONAL),
                "etiqueta" => _("Administrar URL Internacional")
               ),
            )
    ),
    
);
?>