<?php

namespace PalavraChaveTcc\Controller;

use Estrutura\Controller\AbstractCrudController;

class PalavraChaveTccController extends AbstractCrudController
{
    /**
     * @var \PalavraChaveTcc\Service\PalavraChaveTcc
     */
    protected $service;

    /**
     * @var \PalavraChaveTcc\Form\PalavraChaveTcc
     */
    protected $form;

    public function __construct(){
        parent::init();
    }

    public function indexAction()
    {
        return parent::index($this->service, $this->form);
    }

    public function gravarAction(){
        $this->addSuccessMessage('Registro gravado com sucesso!');
        $this->redirect()->toRoute('navegacao', array('controller' => 'palavra_chave_tcc-palavrachavetcc') );
        return parent::gravar($this->service, $this->form);
    }

    public function cadastroAction()
    {
        return parent::cadastro($this->service, $this->form);
    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }
}
