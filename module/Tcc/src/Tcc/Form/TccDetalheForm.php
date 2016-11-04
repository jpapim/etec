<?php

namespace Tcc\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class TccDetalheForm extends AbstractForm
{


    public function getInputFilter()
    {
        return $this->inputFilter;
    }

    public function __construct($options = [])
    {

        parent::__construct('tccdetalheform');


        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('tccdetalheform', $this, $this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->hidden("id_tcc")->required(false)->label("Tcc");


        #Palavra Chave do TCC
        $objForm->combo("id_palavra_chave", '\PalavraChave\Service\PalavraChaveService', 'id', 'nm_palavra_chave')->required(true)->label("Palavra Chave");

        #Dados dos Concluintes
        $objForm->combo("id_curso", '\Curso\Service\CursoService', 'id', 'nm_curso')->required(true)->label("Curso");
        $objForm->text("nm_concluinte")->required(true)->label("Nome do Aluno");
        $objForm->text("nr_matricula")->required(true)->label("Matrícula");

        $this->formObject = $objForm;
    }
}
