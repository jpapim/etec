<?php

namespace Curso\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class CursoForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('cursoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('cursoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->hidden("id_usuario")->required(false)->label("Id Usuario");
        $objForm->hidden("id_usuario_cadastro")->required(false)->label("Usuario Cadastrador");

        $objForm->text("nm_curso")->required(true)->label("Nome do Curso");
       
        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}