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

class TccDetalheForm extends  AbstractForm{

    public function __construct($options=[]){
        parent::__construct('detalhetccform');


        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('detalhetccform',$this,$this->inputFilter);
        $objForm->hidden("id")->required(false)->label("Id");
        $objForm->hidden("id_periodo_letivo")->required(false)->label("Id");

        $objForm->date("dt_encontro")->required(true)->setAttribute('class', 'data')->label("Data do Encontro");

        $this->formObject = $objForm;
}

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
} 