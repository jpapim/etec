<?php

namespace Concluinte\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class ConcluinteForm extends AbstractForm {
	public function __construct($options=[]){
		parent::__construct('concluinteform');

		$this->inputFilter = new InputFilter();
		$objForm = new FormObject('concluinteform',$this,$this->inputFilter);

		$objForm->hidden("id")->required(false)->label("Id");
		$objForm->combo("id_curso", '\Curso\Service\CursoService', 'id', 'nm_curso')->required(true)->label("Curso");
		$objForm->combo("id_tcc", '\Tcc\Service\TccService', 'id', 'tx_titulo_tcc')->required(true)->label("Título do Tcc");
		$objForm->text("nm_concluinte")->required(true)->label("Nome do Aluno");
		$objForm->text("nr_matricula")->required(true)->label("Matricula");


		$this->formObject = $objForm;
	}
}
