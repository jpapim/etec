<?php

namespace TipoTcc\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class TipoTccForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('tipotccform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('tipotccform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->hidden("id_usuario")->required(false)->label("Id Usuario");
        $objForm->hidden("id_usuario_cadastro")->required(false)->label("Usuario Cadastrador");

        $objForm->text("nm_tipo_tcc")->required(true)->label("Tipo de TCC");
       
        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}