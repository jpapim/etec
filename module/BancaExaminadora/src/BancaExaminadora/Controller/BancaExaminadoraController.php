<?php

namespace BancaExaminadora\Controller;

use Professor;
use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Estrutura\Helpers\Pagination;
use Zend\View\Model\ViewModel;
use Zend\Form\Element;
use Zend\View\Model\JsonModel;
use Zend\Http\Response\Stream;


class BancaExaminadoraController extends AbstractCrudController
{

    /**
     * @var \BancaExaminadora\Service\BancaExaminadora
     */
    protected $service;
    /**
     * @var \BancaExaminadora\Form\BancaExaminadora
     */
    protected $form;

        public function  __construct()
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
            '0' => [
                'filter' => "banca_examinadora.id_banca_examinadora  LIKE ?"
            ],
            '1' => [
                'filter' => "banca_examinadora.dt_banca  LIKE ?"
            ],
            '2' => NULL,

        ];

        #xd($id_banca_examinadora = $this->params('id'));

        $paginator = $this->service->getBancaExaminadoraPaginator($filter, $camposFilter);
        $paginator->setItemCountPerPage($paginator->getTotalItemCount());
        $countPerPage = $this->getCountPerPage(
            current(Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($this->getCountPerPage(
            current(Pagination::getCountPerPage($paginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());

        $viewModel = new ViewModel([
            'service' => $this->service,
            'form' => $this->form,
            'paginator' => $paginator,
            'filter' => $filter,
            'countPerPage' => $countPerPage,
            'camposFilter' => $camposFilter,
            'controller' => $this->params('controller'),
            'atributos' => array(),
        ]);

        return $viewModel->setTerminal(true);
    }

    public function gravarAction()
    {
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
            # Inicio da Customizaçao dos Valores antes de gravar no banco
            $post['dt_banca'] = Data::converterDataHoraBrazil2BancoMySQL($post['dt_banca']);
            # Fim da Customizaçao dos Valores antes de gravar no banco
            #################################################################

            $form->setData($post);

            if (!$form->isValid()) {
                $this->addValidateMessages($form);
                $this->setPost($post);
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
                return false;
            }
            $service->exchangeArray($form->getData());
            $this->addSuccessMessage('Registro Alterado com sucesso');
            $id_banca_examinadora = $service->salvar();

            //Define o redirecionamento
            if (isset($post['id']) && $post['id']) {
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'index'));
            } else {
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro-detalhe', 'id' => Cript::enc($id_banca_examinadora
				)));
            }

            return $id_banca_examinadora;

        } catch (\Exception $e) {

            $this->setPost($post);
            $this->addErrorMessage($e->getMessage());
            $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
            return false;
        }
    }

    public function excluirAction()
    {
        return parent::excluir($this->service, $this->form);
    }

    public function cadastroAction()
    {
        return parent::cadastro($this->service, $this->form);
    }

    // Iniciando ações do Cadastro Detalhe

    public function cadastroDetalheAction()
    {
        //recuperar o id do Modulo Banca
        $id_banca_examinadora = Cript::dec($this->params('id') );

        $banca = new \BancaExaminadora\Service\BancaExaminadoraService();
        $dadosBancaExaminadora = $banca->buscar($id_banca_examinadora);
        #xd($dadosBancaExaminadora);

        $dadosView = [
            'service' => new \MembrosBanca\Service\MembrosBancaService(),
            'form' => new \MembrosBanca\Form\MembrosBancaForm(),
            'controller' => $this->params('controller'),
            'atributos' => array(),
            'id_banca_examinadora' => $id_banca_examinadora,
            'dadosBancaExaminadora' => $dadosBancaExaminadora,
        ];
        #xd($dadosView);

        return new ViewModel($dadosView);

    }

    public function listarProfessoresAction()
    {
        $filter = $this->getFilterPage();

        $id_banca_examinandora = $this->params()->fromPost('id_banca_examinandora');
        $camposFilter = [
            '0' => [
                'filter' => "Membros_banca.nm_professor LIKE ?"
            ],
            '1' => [
                'filter' => "Membros_banca.cs_orientador  LIKE ?"
            ],
            '2' => NULL,
        ];
        #xd($id_banca_examinadora = $this->params('id'));

        $paginator = $this->service->getProfessorPaginator( $id_banca_examinandora, $filter, $camposFilter);

        $paginator->setItemCountPerPage($paginator->getTotalItemCount());

        $countPerPage = $this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());

        $viewModel = new ViewModel([
            'service' => $this->service,
            'form' => new \MembrosBanca\Form\MembrosBancaForm(),
            'paginator' => $paginator,
            'filter' => $filter,
            'countPerPage' => $countPerPage,
            'camposFilter' => $camposFilter,
            'controller' => $this->params('controller'),
            'id_banca_examinandora'=>$id_banca_examinandora,
            'atributos' => array()
        ]);

        return $viewModel->setTerminal(TRUE);
    }

//    public function adicionarbancaexaminadoradetalheAction()
//    {
//        //Se for a chamada Ajax
//        if ($this->getRequest()->isPost()) {
//            $id_banca_examinadora = $this->params()->fromPost('id');
//            $dt_encontro = $this->params()->fromPost('dt_encontro');
//
//            $dt_encontro = Data::converterDataHoraBrazil2BancoMySQL($dt_encontro);
//            $detalhe_periodo_letivo = new \DetalhePeriodoLetivo\Service\DetalhePeriodoLetivoService();
//
//            $id_inserido = $detalhe_periodo_letivo->getTable()->salvar(array('id_periodo_letivo' => $id_periodo_letivo, 'dt_encontro' => $dt_encontro), null);
//            $valuesJson = new JsonModel(array('id_inserido' => $id_inserido, 'sucesso' => true, 'dt_encontro' => $dt_encontro));
//
//            return $valuesJson;
//        }
//    }
//
//    public function detalhePaginationAction()
//    {
//        #$this->params()->fromPost('paramname');   // From POST
//        #$this->params()->fromQuery('paramname');  // From GET
//        #$this->params()->fromRoute('paramname');  // From RouteMatch
//        #$this->params()->fromHeader('paramname'); // From header
//        #$this->params()->fromFiles('paramname');  // From file being uploaded
//
//        $filter = $this->getFilterPage();
//
//        $id_periodo_letivo = $this->params()->fromPost('id_periodo_letivo');
//        $id_periodo_letivo = isset($id_periodo_letivo) && $id_periodo_letivo ? $id_periodo_letivo : $this->params()->fromRoute('id');
//
//        $camposFilter = [
//            '0' => [
//                //'filter' => "periodoletivodetalhe.nm_sacramento LIKE ?",
//            ],
//
//        ];
//
//        $paginator = $this->service->getPeriodoLetivoDetalhePaginator($id_periodo_letivo, $filter, $camposFilter);
//
//        $paginator->setItemCountPerPage($paginator->getTotalItemCount());
//
//        $countPerPage = $this->getCountPerPage(
//            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
//        );
//
//        $paginator->setItemCountPerPage($this->getCountPerPage(
//            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
//        ))->setCurrentPageNumber($this->getCurrentPage());
//
//        $viewModel = new ViewModel([
//            'service' => $this->service,
//            'form' => new \DetalhePeriodoLetivo\Form\DetalhePeriodoLetivoForm(),
//            'paginator' => $paginator,
//            'filter' => $filter,
//            'countPerPage' => $countPerPage,
//            'camposFilter' => $camposFilter,
//            'controller' => $this->params('controller'),
//            'id_periodo_letivo' => $id_periodo_letivo,
//            'atributos' => array()
//        ]);
//
//        return $viewModel->setTerminal(TRUE);
//    }

} 