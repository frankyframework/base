<?php
global $MySession;

return array(
    array('title'=> "Perfil",
            'children' =>  array(
                array(
                 "permiso" =>   "administrar_mi_usuario",
                 "url" => $MyRequest->url(FRM_MIS_DATOS),
                 "etiqueta" => _("Editar mis datos")
                ),
                 array(
                 "permiso" =>   "administrar_mi_contrasena",
                 "url" => $MyRequest->url(FRM_MY_PASSWORD),
                 "etiqueta" => _("Cambiar mi contraseña")
                ),
               
         
               array(
                "permiso" =>   "eliminar_mi_perfil",
                "url" => $MyRequest->url(FRM_ELIMINAR_USER),
                "etiqueta" => _("Eliminar mi cuenta")
               )
        )
               ),
               array('title'=> "Configuración",
               'children' =>  array(
                        
                  array(
                   "permiso" =>   "administrar_devices",
                   "url" => $MyRequest->url(ADMIN_DEVICES),
                   "etiqueta" => _("Administrar dispositivos")
                 )
               )
       ),
);
?>