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
        $objForm->hidden("id_usuario")->required(false)->label("Id Usuario");
        $objForm->hidden("id_usuario_cadastro")->required(false)->label("Usuario Cadastrador");

        $objForm->text("nm_area_conhecimento")->required(true)->label("Nome da Área de Conhecimento");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}