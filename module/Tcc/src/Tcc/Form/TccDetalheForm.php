<?php

namespace Tcc\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class ConcluinteForm extends AbstractForm {

    public function __construct($options=[]){
        parent::__construct('tccdetalheform');


        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('formacaodetalheform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->hidden("id_tcc")->required(false)->label("Id Tcc");

        $objForm->combo("id_curso", '\Curso\Service\CursoService', 'id', 'nm_curso')->required(true)->label("Curso");
        $objForm->text("nm_concluinte")->required(true)->label("Nome do Aluno");
        $objForm->text("nr_matricula")->required(true)->label("Matricula");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }

//    
//    public function __construct($options=[]){
//        parent::__construct('concluinteform');
//
//        $this->inputFilter = new InputFilter();
//        $objForm = new FormObject('concluinteform',$this,$this->inputFilter);
//
//        $objForm->hidden("id")->required(false)->label("Id");
//        $objForm->hidden("id_tcc")->required(false)->label("Id");
//        $objForm->combo("id_curso", '\Curso\Service\CursoService', 'id', 'nm_curso')->required(true)->label("Curso");
//        $objForm->text("nm_concluinte")->required(true)->label("Nome do Aluno");
//        $objForm->text("nr_matricula")->required(true)->label("Matricula");
//
//
//        $this->formObject = $objForm;
//    }
}
