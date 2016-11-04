<?php

namespace Pesquisar\Controller;

use Estrutura\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;

class PesquisarController extends AbstractCrudController
{

    /**
     * @var \Controller\Service\Controller
     */
    protected $service;

    /**
     * @var \Controller\Form\Controller
     */
    protected $form;

    public function __construct(){
        parent::init();
    }

    public function indexAction()
    {
        return parent::index($this->service, $this->form);
    }

    public function detalhesFiltrosPaginationAction()
    {
        #$this->params()->fromPost('paramname');   // From POST
        #$this->params()->fromQuery('paramname');  // From GET
        #$this->params()->fromRoute('paramname');  // From RouteMatch
        #$this->params()->fromHeader('paramname'); // From header
        #$this->params()->fromFiles('paramname');  // From file being uploaded
        $filter = $this->getFilterPage();
        $request = $this->getRequest();
        $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim', $request->getPost()->toArray());

        $camposFilter = [
        ];

        $paginator = $this->service->getDetalhesFiltrosPaginator($post, $filter, $camposFilter);
        $paginator->setItemCountPerPage($paginator->getTotalItemCount());

        $countPerPage = $this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());

        $viewModel = new ViewModel([
            'service' => $this->service,
            'form' => new \Pesquisar\Form\PesquisarForm(),
            'paginator' => $paginator,
            'filter' => $filter,
            'countPerPage' => $countPerPage,
            'camposFilter' => $camposFilter,
            'controller' => $this->params('controller'),
            'atributos' => array()
        ]);

        return $viewModel->setTerminal(TRUE);
    }

}