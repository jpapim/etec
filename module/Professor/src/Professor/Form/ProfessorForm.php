<?php

namespace Professor\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class ProfessorForm extends AbstractForm {
	public function __construct($options=[]){
		parent::__construct('professorform');

		$this->inputFilter = new InputFilter();
		$objForm = new FormObject('professorform',$this,$this->inputFilter);

		$objForm->hidden("id")->required(false)->label("Id");
		$objForm->hidden("id_usuario")->required(false)->label("Id Usuario");
		$objForm->text("nm_professor")->required(true)->label("Nome do Professor");
		$objForm->combo("id_titulacao", '\Titulacao\Service\TitulacaoService', 'id', 'nm_titulacao')->required(true)->label("Titulação");
		$objForm->select("cs_ativo", array('A'=>'Ativo', 'I'=>'Inativo'))->required(false)->label("Situação");
//		$objForm->checkbox("cs_orientador", array('N'=>'Não', 'S'=>'Sim'), true)->required(false)->label("Este professor é orientador?");

		$arrOpcoes[] = array('value' => 'S', 'label' => 'Sim');
		$arrOpcoes[] = array('value' => 'N', 'label' => 'Nao');
		$objForm->radio("cs_orientador", $arrOpcoes)->required(true)->label("Este professor é orientador?");



		$this->formObject = $objForm;
	}
}
