<?php

namespace AreaConhecimento\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class AreaConhecimentoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('areaconhecimentoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('areaconhecimentoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");  
        $objForm->text("nm_area_conhecimento")->required(false)->label("Area Conhecimento");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}