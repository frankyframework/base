<?php
namespace Base\Form;

class registroForm extends \Franky\Form\Form
{
    public function __construct($name)
    {

        parent::__construct();

       $this->setAtributos(array(
            'name' => $name,
            'action' => "/registro/submit.users.php",
            'method' => 'post'
        ));

    }

    public function addGeneral(){


      $this->add(array(
               'name' => 'token_xsrf',
               'type'  => 'hidden',

           )
       );


       $this->add(array(
                'name' => 'callback',
                'type'  => 'hidden',

            )
        );

        $this->add(array(
                'name' => 'nombre',
              //  'label' => _('Nombre'),
                'type'  => 'text',
               // 'required'  => true,
                'atributos' => array(
                    'placeholder' => _('Nombre'),
                    'maxlength' => 200
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );


       $this->add(array(
                'name' => 'email',
                //'label' => _('E-mail'),
                'type'  => 'text',
               // 'required'  => true,
                'atributos' => array(
                    'placeholder' => _('E-mail'),
                    'maxlength' => 200,
                    'minlength' => 5,
                    'type_mobile'  => 'email'
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );







       $this->add(array(
                'name' => 'telefono',
               // 'label' => _('Teléfono celular'),
                'type'  => 'text',
               // 'required'  => false,
                'atributos' => array(
                    'placeholder' => ('Teléfono celular'),
                    'maxlength' => 10,
                    'type_mobile'  => 'tel'
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_no_obligatorio'
                 )
            )
        );



       $this->add(array(
                'name' => 'sexo',
                'label' => _('Genero'),
                'type'  => 'radio',

                'required'  => false,
                'options' =>  array("h" => _("Masculino"),
                                    "m"  => _("Femenino"),

                ),

                'atributos' => array("value" => "h"),
                'label_atributos' => array(
                    'class'       => ''
                 )
            )
        );
        $this->add(array(
                'name' => 'fecha_nacimiento',
                'label' => _('Fecha de nacimiento'),
                'type'  => 'date',
                'required'  => false,
                'atributos' => array(
                    'type_mobile' => 'date'

                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_no_obligatorio'
                 )
            )
        );





    }
    public function addGuardar()
    {
          $this->add(array(
               'name' => 'guardar',
               'type'  => 'submit',
               'atributos' => array(
                   'class'       => '_btn _btn-primary',
                   'value' => _("Guardar")
                )

           )
        );
    }
    public function addId()
    {
          $this->add(array(
                'name' => 'id',
                'type'  => 'hidden',

            )
        );
    }
    public function addContrasena1()
    {
        $this->add(array(
                'name' => 'contrasena1',
             //   'label' => _('Confirmar contraseña'),
                'type'  => 'password',
              //  'required'  => true,
                'atributos' => array(
                    'placeholder' => _('Confirmar contraseña'),
                    'maxlength' => 15,
                    'minlength' => 6,
                    'id'       => 'contrasena1'
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );
    }
    public function addContrasena()
    {
          $this->add(array(
                'name' => 'contrasena',
             //   'label' => _('Contraseña'),
                'type'  => 'password',
               // 'required'  => true,
                'atributos' => array(
                    'placeholder' => ('Contraseña'),
                    'maxlength' => 15,
                    'minlength' => 6,
                    'id'       => 'contrasena'
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );
    }

    public function addNivel()
    {
        $this->add(array(
                'name' => 'role',
                'label' => _('Rol'),
                'type'  => 'select',
                'required'  => true,
                'options' => array(),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

    }


    public function addContrasenaAnt()
    {
          $this->add(array(
                'name' => 'contrasena_ant',
            //    'label' => _('Contraseña actual'),
                'type'  => 'password',
            //    'required'  => true,
                'atributos' => array(
                    'placeholder' => ('Contraseña actual'),
                    'maxlength' => 15,
                    'minlength' => 6,
                    'id'       => 'contrasena'
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );
    }
    public function addUsuario()
    {
        $this->add(array(
                'name' => 'usuario',
            //    'label' => ('Usuario'),
                'type'  => 'text',
              //  'required'  => true,
                'atributos' => array(
                    'placeholder' => _('Usuario'),
                    'maxlength' => 15,
                    'minlength' => 3,
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );
    }

    public function addAcepto()
    {
        $this->add(array(
                'name' => 'acepto',
                'type'  => 'checkbox',
                'atributos' => array(
                    'class' => 'required'
                 ),
                'options' =>  array("1" => _("He leído el aviso de privacidad y estoy de acuerdo con los términos y condiciones del servicio")),


            )
        );

    }

}
?>
