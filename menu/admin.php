<?php
global $MySession;

return array(
    array('title'=> "Usuarios",
            'children' =>  array(
                array(
                 "permiso" =>   "administrar_otros_usuarios",
                 "url" => $MyRequest->url(LISTA_OPERADORES),
                 "etiqueta" => _("Usuarios")
                ),
             
                        array(
                         "permiso" =>   "admin_role",
                         "url" => $MyRequest->url(LISTA_ROLES),
                         "etiqueta" => _("Roles")
                        )

        )
    ),
        array('title'=> "Contenido",
                'children' =>  array(
                        array(
                        "permiso" =>   "administrar_template_de_cms",
                        "url" => $MyRequest->url(LISTA_CMS_TEMPLATE),
                        "etiqueta" => _("CMS")
                        ),
                ),
        ),
        array('title'=> "Marketing",  
        'children' =>  array(    
                array(
                 "permiso" =>   "administrar_mailing",
                 "url" => $MyRequest->url(MAILING),
                 "etiqueta" => _("Newsletter")
                ),
                array(
                 "permiso" =>   "administrar_contactanos",
                 "url" => $MyRequest->url(CONTACTOS_LIST),
                 "etiqueta" => _("Contacto")
                ),
                array(
                "permiso" =>   "administrar_template_de_mailings",
                "url" => $MyRequest->url(LISTA_EMAIL_TEMPLATE),
                "etiqueta" => _("E-mails transaccionales")
                )
            )
    ),
    array('title'=> "Configuración",
            'children' =>  array(
                       
               array(
                "permiso" =>   "administrar_core_sistem",
                "url" => $MyRequest->url(ADMIN_CORE_CONFIG),
                "etiqueta" => _("Administrar sistema")
              ),
                 array(
                "permiso" =>   "administrar_urlinternacional",
                "url" => $MyRequest->url(ADMIN_URL_INTERNACIONAL),
                "etiqueta" => _("Administrar URL Internacional")
               ),
            )
    ),
    
);
?>