<?php
/**
 * Created by PhpStorm.
 * User: IGOR
 * Date: 08/06/2016
 * Time: 13:55
 */


namespace Tcc\Form;


use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;

class TccForm extends  AbstractForm{

    public function __construct($options=[]){
        parent::__construct('detalhetccform');


        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('detalhetccform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->hidden("id_tcc")->required(false)->label("Id do Tcc");
//        $objForm->combo("id_curso", '\Curso\Service\CursoService', 'id', 'nm_curso')->required(true)->label("Curso");
        $objForm->combo("id_tcc", '\Tcc\Service\TccService', 'id', 'tx_titulo_tcc')->required(true)->label("Título do Tcc");
        $objForm->text("nm_concluinte")->required(true)->label("Nome do Aluno");
        $objForm->text("nr_matricula")->required(true)->label("Matricula");

        $this->formObject = $objForm;
}

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}