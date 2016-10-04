<?php

namespace PalavraChaveTcc\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class PalavraChaveTccForm extends AbstractForm
{
    public function __construct($options = [])
    {
        parent::__construct('palavrachavetccform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('palavrachavetccform', $this, $this->inputFilter);

        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo("id_tcc", '\Tcc\Service\TccService', 'id', 'tx_titulo_tcc')->required(false)->label("TCC");
        $objForm->combo("id_palavra_chave", '\PalavraChave\Service\PalavraChaveService', 'id', 'nm_palavra_chave')->required(false)->label("Palavra Chave");

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}