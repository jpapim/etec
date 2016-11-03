<?php

namespace Concluinte\Controller;

use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Zend\View\Model\ViewModel;

class ConcluinteController extends AbstractCrudController
{


    protected $service;


    protected $form;

    public function __construct()
    {
        parent::init();
    }

    public function indexAction()
    {
        return new ViewModel([
            'service' => $this->service,
            'form' => $this->form,
            'controller' => $this->params('controller'),
            'atributos' => array()
        ]);
    }

    public function indexPaginationAction()
    {
        $filter = $this->getFilterPage();

        $camposFilter = [
            '0' => NULL,
            '1' => [
                'filter' => "concluinte.nm_concluinte LIKE ?",
            ],
            '2' => [
                'filter' => "concluinte.nr_matricula LIKE ?",
            ],
            '3' => [
                'filter' => "curso.nm_curso LIKE ?",
            ],
            '4' => [
                'filter' => "tcc.tx_titulo_tcc LIKE ?",
            ],
            '5' => NULL,
        ];


        $paginator = $this->service->getConcluintesPaginator($filter, $camposFilter);

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

    public function Backup_gravarAction()
    {
        try {
            $controller = $this->params('controller');
            $request = $this->getRequest();
            $service = $this->service;
            $form = $this->form;

            if (!$request->isPost()) {
                throw new \Exception('Dados Inv�lidos');
            }

            $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim', $request->getPost()->toArray());

            $files = $request->getFiles();
            $upload = $this->uploadFile($files);

            $post = array_merge($post, $upload);

            if (isset($post['id']) && $post['id']) {
                $post['id'] = Cript::dec($post['id']);
            }

            $form->setData($post);

            if (!$form->isValid()) {
                $this->addValidateMessages($form);
                $this->setPost($post);
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
                return false;
            }

            $service->exchangeArray($form->getData());
            $this->addSuccessMessage('Registro Alterado com sucesso');
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
            return $service->salvar();

        } catch (\Exception $e) {

            $this->setPost($post);
            $this->addErrorMessage($e->getMessage());
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
            return false;
        }
    }

    public function gravarAction(){
        $this->addSuccessMessage('Registro gravado com sucesso');
        $this->redirect()->toRoute('navegacao', array('controller' => 'concluinte-concluinte', 'action' => 'index'));
        return parent::gravar($this->service, $this->form);
    }

    public function cadastroAction()
    {
        return parent::cadastro($this->service, $this->form);
    }

    public function excluirAction()
    {
        return parent::excluirAluno($this->service, $this->form);
    }

    /**
     * Método Responsável pelo auto-complete do Concluinte
     * @return \Zend\Db\ResultSet\ResultSet
     */

    public function autocompleteconcluinteAction()
    {
        $nm_concluinte = $_GET['term'];
        $concluintes = new \Concluinte\Service\ConcluinteService();
        $arrConcluintes = $concluintes->getFiltrarConcluintePorNomeToArray($nm_concluinte);
        $arrConcluintesFiltrados = array();
        foreach ($arrConcluintes as $concluinte) {
            $arrConcluintesFiltrados[] = $concluinte['nm_concluinte'];
        }

        $valuesJson = new JsonModel($arrConcluintesFiltrados);
        return $valuesJson;
    }
}
