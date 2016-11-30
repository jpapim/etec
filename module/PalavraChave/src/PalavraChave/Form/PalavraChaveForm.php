<?php

namespace PalavraChave\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class PalavraChaveForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('palavrachaveform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('palavrachaveform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->hidden("id_usuario")->required(false)->label("Id Usuario");
        $objForm->hidden("id_usuario_cadastro")->required(false)->label("Usuario Cadastrador");

        $objForm->text("nm_palavra_chave")->required(true)->label("Nome da Palavra Chave");
       
        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}