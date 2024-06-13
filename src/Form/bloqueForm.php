<?php
namespace Base\Form;

class bloqueForm extends \Franky\Form\Form
{
    public function __construct($name)
    {

        parent::__construct();

       $this->setAtributos(array(
            'name' => $name,
            'action' => "/admin/bloque/submit.php",
            'method' => 'post'
        ));

         $this->add(array(
                'name' => 'id',
                'type'  => 'hidden',

            )
        );
       $this->add(array(
                'name' => 'callback',
                'type'  => 'hidden',

            )
        );


        $this->add(array(
                'name' => 'titulo',
                'label' => _('Titulo:'),
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'class'       => 'required',
                    'maxlength' => 200
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

       

           $this->add(array(
                'name' => 'template',
                'label' => ('Template'),
                'type'  => 'textarea',
                'required'  => true,
                'atributos' => array(
                    'class' => 'required',
                    'rows'  => 5
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

        $this->add(array(
                'name' => 'friendly',
                'label' => _('ID Path'),
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'class'       => 'required',
                    'maxlength' => 255
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );


        $this->add(array(
            'name' => 'guardar_editar',
            'type'  => 'submit',
            'atributos' => array(
                'class'       => '_btn _btn-primary',
                'value' => _("Guardar y continuar editando")
             )

        )
    );
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

}
?>
