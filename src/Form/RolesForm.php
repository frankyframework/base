<?php
namespace Base\Form;

class RolesForm extends \Franky\Form\Form
{
    public function __construct($name)
    {

        parent::__construct();

       $this->setAtributos(array(
            'name' => $name,
            'action' =>  "/admin/roles/submit.php",
            'method' => 'post',
            'enctype' => "multipart/form-data"
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
                'name' => 'name',
                'label' => _('Nombre'),
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
            'name' => 'resources[]',
            'type'  => 'checkbox',
            'required'  => true,
           'required'  => true,
            'atributos' => array(
                'class'       => 'required',

             ),
            'options' => array(

            ),
            'label_atributos' => array(
                'class'       => 'desc_form_obligatorio',
             )
        )
     );

         $this->add(array(
                'name' => 'guardar',
                'type'  => 'submit',
                'atributos' => array(
                    'class'       => 'btn btn-primary btn-big float_right',
                    'value' => _("Guardar")
                 )

            )
        );

    }

}
?>
