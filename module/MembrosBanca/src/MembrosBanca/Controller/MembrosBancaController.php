<?php

namespace MembrosBanca\Controller;

use Estrutura\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;


class MembrosBancaController extends AbstractCrudController
{
    protected $service;

    protected $form;

    public function __construct()
    {
        parent::init();
    }

    public function indexAction()
    {
        return parent::index($this->service, $this->form);
    }

    public function indexPaginationAction()
    {
        $filter = $this->getFilterPage();

        $camposFilter = [
            '0' => NULL,
            '1' => [
                'filter' => "banca_examinadora.dt_banca LIKE ?",
            ],
            '2' => [
                'filter' => "professor.nm_professor LIKE ?",
            ],
            '3' => NULL,
        ];


        $paginator = $this->service->getMembrosBancaPaginator($filter, $camposFilter);

        $paginator->setItemCountPerPage($paginator->getTotalItemCount());

        $countPerPage = $this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());

        $viewModel = new ViewModel([
            'service' => $this->service,
            'form' => $this->form,
            'paginator' => $paginator,
            'filter' => $filter,
            'countPerPage' => $countPerPage,
            'camposFilter' => $camposFilter,
            'controller' => $this->params('controller'),
            'atributos' => array()
        ]);

        return $viewModel->setTerminal(TRUE);
    }

    public function gravarAction()
    {
        $this->addSuccessMessage('Registro gravado com sucesso!');
        $this->redirect()->toRoute('navegacao', array('controller' => 'membros_banca-membrosbanca'));
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

    public function excluirembroBancaViaBancaAction()
    {
        try {
            $request = $this->getRequest();

            if ($request->isPost()) {
                return new JsonModel();
            }

            $controller = $this->params('controller');

            $id = Cript::dec($this->params('id'));
            $id_banca_examinadora = Cript::enc($this->params('aux'));

            $this->service->setId($id);

            $dados = $this->service->filtrarObjeto()->current();
            if (!$dados) {
                throw new \Exception('Registro nao encontrado');
            }

            $this->service->excluir();
            $this->addSuccessMessage('Registro excluido com sucesso');
            return $this->redirect()->toRoute('navegacao', array('controller' => 'banca_examinadora-bancaexaminadora', 'action' => 'cadastro-detalhe', 'id' => $id_banca_examinadora));
        } catch (\Exception $e) {
            if (strstr($e->getMessage(), '1451')) { #ERRO de SQL (Mysql) para nao excluir registro que possua filhos
                $this->addErrorMessage('Para excluir Verifique!');
            } else {
                $this->addErrorMessage($e->getMessage());
            }

            return $this->redirect()->toRoute('navegacao', ['controller' => $controller]);
        }

        return parent::excluir($this->service, $this->form);
    }
}
