<?php

namespace BancaExaminadora\Form;


use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;

class BancaExaminadoraForm extends  AbstractForm{

    public function __construct($options=[]){
        parent::__construct('bancaexaminadoraform');


        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('bancaexaminadoraform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");

        $objForm->date('dt_banca')->required(true)->setAttribute('class', 'data')->label("Data da Banca");

        $this->formObject = $objForm;
}

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
} 