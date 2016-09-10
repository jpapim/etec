<?php

namespace Estilos\Form;

use Estrutura\Form\AbstractForm;
use Estrutura\Form\FormObject;
use Zend\InputFilter\InputFilter;

class EstilosForm extends AbstractForm{
    public function __construct($options=[]){
        parent::__construct('estilosform');

        $this->inputFilter = new InputFilter();
        $objForm = new FormObject('estilosform',$this,$this->inputFilter);

        $this->formObject = $objForm;
    }

    public function getInputFilter()
    {
        return $this->inputFilter;
    }
}