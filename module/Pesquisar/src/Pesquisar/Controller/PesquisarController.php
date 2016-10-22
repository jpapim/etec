<?php

/**
 * Created by PhpStorm.
 * User: EduFerr
 * Date: 05/10/2016
 * Time: 17:03
 */

namespace Pesquisar\Controller;

use Estrutura\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;


class PesquisarController extends AbstractCrudController
{

    public function indexAction()
    {

    }

    public function indexPaginationAction()
    {
        $filter = $this->getFilterPage();

        $camposFilter = [
            '0' => [
                'filter' => "pesquisar.id_banca_examinadora LIKE ?",
            ],
            '1' => [
                'filter' => "pesquisar.nm_curso LIKE ?",
            ],
            '2' => [
                'filter' => "pesquisar.nm_area_conhecimento LIKE ?",
            ],
            '3' => [
                'filter' => "pesquisar.nm_tipo_tcc LIKE ?",
            ],
            '4' => [
                'filter' => "pesquisar.nm_professor LIKE ?",
            ],
            '5' =>  NULL,
        ];

        $this->service = new \Pesquisar\Service\PesquisarService();
        $paginator = $this->service->pesquisarTcc($filter, $camposFilter);
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
        $id_prova = $post['id_prova'];

        $camposFilter = [
            '0' => [
                //'filter' => "periodoletivodetalhe.nm_sacramento LIKE ?",
            ],

        ];

        $paginator = $this->service->getDetalhesFiltrosPaginator($id_prova, $filter, $camposFilter);
        $paginator->setItemCountPerPage($paginator->getTotalItemCount());

        $countPerPage = $this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());

        $viewModel = new ViewModel([
            'service' => $this->service,
            'form' => new \Prova\Form\QuestaoAleatoriaForm(),
            'paginator' => $paginator,
            'filter' => $filter,
            'countPerPage' => $countPerPage,
            'camposFilter' => $camposFilter,
            'controller' => $this->params('controller'),
            'id_prova' => $id_prova,
            'atributos' => array()
        ]);

        return $viewModel->setTerminal(TRUE);
    }

}