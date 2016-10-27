<?php

namespace MembrosBanca\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class MembrosBancaForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('inscricoeseventoform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('inscricoeseventoform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo("id_banca_examinadora", '\BancaExaminadora\Service\BancaExaminadoraService', 'id', 'dt_banca')->required(true)->label("Data da Banca");
        $objForm->combo("id_professor",'\Professor\Service\ProfessorService', 'id','nm_Professor')->required(true)->label("Nome do Professor");
        $objForm->text("cs_orientador")->required(true)->label("Professor Orientador");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}
