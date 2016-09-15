<?php

namespace Tcc\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class TccForm extends AbstractForm
{

    public function __construct($options = [])
    {
        parent::__construct('tccform');

        $this->inputFilter = new InputFilter();

        $objForm = new FormObject('tccform', $this, $this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo("id_banca",'\BancaExaminadora\Service\BancaExaminadoraService', 'id', 'dt_banca')->required(true)->label("Data da Banca");
        $objForm->combo("id_area_conhecimento", '\AreaConhecimento\Service\AreaConhecimentoService', 'id', 'nm_area_conhecimento')->required(true)->label("Área de Conhecimento");
        $objForm->combo("id_professor",'\Professor\Service\ProfessorService', 'id', 'nm_Professor')->required(true)->label("Nome do Professor");
        $objForm->text("tx_titulo_tcc")->required(true)->label("Título do TCC");
        $objForm->textarea("tx_resumo")->required(true)->label("Resumo");
        $objForm->text("nr_nota_final")->required(true)->label("Nota");



        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }

}