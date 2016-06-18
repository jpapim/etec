<?php

namespace Titulacao\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class TitulacaoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('titulacaoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('titulacaoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_titulacao")->required(true)->label("Titulacao");  

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}