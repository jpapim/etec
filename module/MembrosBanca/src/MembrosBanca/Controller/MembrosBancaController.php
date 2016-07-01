<?php

namespace MembrosBanca\Controller;

use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;

class MembrosBancaController extends AbstractCrudController
{
    /**
     * @var \MembrosBanca\Service\MembrosBanca
     */
    protected $service;

    /**
     * @var \MembrosBanca\Form\MembrosBanca
     */
    protected $form;

    public function __construct(){
        parent::init();
    }

    public function indexAction()
    {
        return parent::index($this->service, $this->form);
    }

    public function cadastroAction()
    {
        return parent::cadastro($this->service, $this->form);
    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }

    public function excluirviaacademiaAction()
    {
        try {
            $request = $this->getRequest();

            if ($request->isPost()) {
                return new JsonModel();
            }

            $id_membro_banca = $this->params('id');
            $this->service->setId($id_membro_banca);

            $dados = $this->service->filtrarObjeto()->current();

            if (!$dados) {
                throw new \Exception('Registro n�o encontrado');
            }

            $membro_banca = new \MembrosBanca\Service\MembrosBancaService();
            $arrMembro = $membro_banca->getMembroBancaToArray($id_membro_banca);
            $id_banca = $arrMembro['id_banca_examinadora'];

            $this->service->excluir();
            $this->addSuccessMessage('Registro excluido com sucesso');
            return $this->redirect()->toRoute('navegacao', ['controller' => 'banca_examinadora-bancaexaminadora', 'action' => 'realizarinscricoes', 'id'=>Cript::enc($id_banca)]);
        } catch (\Exception $e) {

            $this->addErrorMessage($e->getMessage());
            return $this->redirect()->toRoute('navegacao', ['controller' => 'banca_examinadora-bancaexaminadora', 'action' => 'realizarinscricoes', 'id'=>Cript::enc($id_banca)]);
        }
    }


}
