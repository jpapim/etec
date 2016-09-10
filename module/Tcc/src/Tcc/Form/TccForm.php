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
        $objForm->combo("id_banca_examinadora",'\BancaExaminadora\Service\BancaExaminadoraService', 'id', 'nm_banca_examinadora')->required(false)->label("Banca Examinadora");
        $objForm->combo("id_area_conhecimento",'\AreaConhecimento\Service\AreaConhecimentoService', 'id', 'nm_area_conhecimento')->required(false)->label("Banca Examinadora");
        $objForm->text("tx_titulo_tcc")->required(true)->label("Título do TCC");



        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }

}