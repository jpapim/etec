<?php

namespace MembrosBanca\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class MembrosBancaForm extends AbstractForm
{
	public function getInputFilter()
    {
        return $this->inputFilter;
    }
	
    public function __construct($options = [])
    {
        parent::__construct('bancaexaminadoraform');

         $this->inputFilter = new InputFilter();
        $objForm = new FormObject('bancaexaminadoraform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->combo("id_banca_examinadora", '\BancaExaminadora\Service\BancaExaminadoraService', 'id', 'dt_banca')->required(true)->label("Data da Banca");
        $objForm->text("id_professor")->required(false)->label("Nome do Professor");

        $arrOpcoes[] = array('value' => '', 'label' => 'Selecione...');
        $arrOpcoes[] = array('value' => 'S', 'label' => 'Orientador');
        $arrOpcoes[] = array('value' => 'N', 'label' => 'Professor');
        $objForm->select("cs_orientador", $arrOpcoes)->required(false)->label("Função na Banca");
    }

    
}