<?php
global $MySession;

return array(
    array('title'=> "Perfil",
            'children' =>  array(
                array(
                 "permiso" =>   ADMINISTRAR_MI_USUARIO,
                 "url" => $MyRequest->url(FRM_MIS_DATOS),
                 "etiqueta" => _("Editar mis datos")
                ),
                 array(
                 "permiso" =>   ADMINISTRAR_MI_CONTRASENA,
                 "url" => $MyRequest->url(FRM_MY_PASSWORD),
                 "etiqueta" => _("Cambiar mi contraseña")
                ),
               
         
               array(
                "permiso" =>   ELIMINAR_MI_PERFIL,
                "url" => $MyRequest->url(FRM_ELIMINAR_USER),
                "etiqueta" => _("Eliminar mi cuenta")
               )
        )
               ),
               array('title'=> "Configuración",
               'children' =>  array(
                        
                  array(
                   "permiso" =>   ADMINISTRAR_DEVICES,
                   "url" => $MyRequest->url(ADMIN_DEVICES),
                   "etiqueta" => _("Administrar dispositivos")
                 )
               )
       ),
);
?>