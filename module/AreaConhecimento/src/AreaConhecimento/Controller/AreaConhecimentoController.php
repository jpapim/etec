<?php

namespace AreaConhecimento\Controller;

use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class AreaConhecimentoController extends AbstractCrudController
{

    protected $service;

    protected $form;

    public function __construct(){
        parent::init();
    }

    public function indexAction()
    {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
    
        return new ViewModel([
            'service' => $this->service,
            'form' => $this->form,
            'controller' => $this->params('controller'),
            'atributos' => array()
        ]);
    }
    
    public function indexPaginationAction()
    {
        //http://igorrocha.com.br/tutorial-zf2-parte-9-paginacao-busca-e-listagem/4/
        
        $filter = $this->getFilterPage();

        $camposFilter = [
            '0' => [
                'filter' => "area_conhecimento.nm_area_conhecimento LIKE ?",
            ],
            '1' => NULL,
        ];
        
        
        $paginator = $this->service->getAreaConhecimentosPaginator($filter, $camposFilter);

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
    
    
    
    

    public function gravarAction() {
        try {
            $controller = $this->params('controller');
            $request = $this->getRequest();
            $service = $this->service;
            $form = $this->form;

            if (!$request->isPost()) {
                throw new \Exception('Dados Inválidos');
            }

            $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim', $request->getPost()->toArray());

            $files = $request->getFiles();
            $upload = $this->uploadFile($files);

            $post = array_merge($post, $upload);

            if (isset($post['id']) && $post['id']) {
                $post['id'] = Cript::dec($post['id']);
            }


            #################################################################
           

            $form->setData($post);

            if (!$form->isValid()) {
                $this->addValidateMessages($form);
                $this->setPost($post);
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
                return false;
            }

            $service->exchangeArray($form->getData());
            $this->addSuccessMessage('Registro executado com sucesso');
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
            return $service->salvar();

        } catch (\Exception $e) {

            $this->setPost($post);
            $this->addErrorMessage($e->getMessage());
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
            return false;
        }
    }

    public function cadastroAction()
    {
        return parent::cadastro($this->service, $this->form);
    }


    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }

    public function autocompleteareaconhecimentoAction()
    {
        $termo = $_GET['term'];
        $areaconhecimentos = new \AreaConhecimento\Service\AreaConhecimentoService();
        $arrAreaConhecimentos = $areaconhecimentos->getFiltrarAreaConhecimentoPorNomeToArray($termo);
        $arrAreaConhecimentosFiltradas = array();
        foreach($arrAreaConhecimentos as $areaconhecimento){
            $arrAreaConhecimentosFiltradas[] = $areaconhecimento['nm_area_conhecimento'];
        }

        $valuesJson = new JsonModel( $arrAreaConhecimentosFiltradas );
        return $valuesJson;
    }

    public function xxxAction()
    {

    }



}
