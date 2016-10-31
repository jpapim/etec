<?php

namespace BancaExaminadora\Controller;

use Professor;
use MembrosBanca;
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
        $id_banca_examinadora = Cript::dec($this->params('id'));

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

        $id_banca_examinadora = $this->params()->fromPost('id_banca_examinadora');

        $camposFilter = [
            '0' => [
                'filter' => "membros_banca.nm_professor LIKE ?"
            ],
            '1' => [
                'filter' => "membros_banca.cs_orientador  LIKE ?"
            ],
            '2' => NULL,
        ];
        #xd($id_banca_examinadora = $this->params('id'));

        $paginator = $this->service->getProfessorPaginator($id_banca_examinadora, $filter, $camposFilter);

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
            'id_banca_examinadora' => $id_banca_examinadora,
            'atributos' => array()
        ]);

        return $viewModel->setTerminal(TRUE);
    }

    public function adicionarProfessoresAction()
    {
        //Se for a chamada Ajax
        if ($this->getRequest()->isPost()) {

            $id_banca_examinadora = \Estrutura\Helpers\Cript::dec($this->params()->fromPost('id'));
            $id_professor = $this->params()->fromPost('id_professor');
            $cs_orientador = $this->params()->fromPost('cs_orientador');
            $detalhe_banca = new MembrosBanca\Service\MembrosBancaService();


            $id_inserido = $detalhe_banca->getTable()->salvar(array(
                'id_banca_examinadora' => $id_banca_examinadora,
                'id_professor' => $id_professor,
                'cs_orientador' => $cs_orientador,
            ), null);
            $valuesJson = new JsonModel(array('id_inserido' => $id_inserido, 'sucesso' => true, 'id_professor' => $id_professor));
            return $valuesJson;
        }
    }

    public function excluirMembrobancaViaBancaAction()
    {
        try {
            $request = $this->getRequest();
            if ($request->isPost()) {
                return new JsonModel();
            }

            $controller = $this->params('controller');
            $id = Cript::dec($this->params('id'));
            $id_banca_examinadora = Cript::dec($this->params('aux'));

            $MembrosBancaService = new \MembrosBanca\Service\MembrosBancaService();
            $MembrosBancaService->setId($id);
            $MembrosBancaService->setIdBanca_examinadora($id_banca_examinadora);

            $dados = $MembrosBancaService->filtrarObjeto()->current();
            if (!$dados) {
                throw new \Exception('Registro nao encontrado');
            }

            $MembrosBancaService->excluir();
            $this->addSuccessMessage('Registro excluido com sucesso');
            return $this->redirect()->toRoute('navegacao', ['controller' => $controller, 'action' => 'cadastro-detalhe', 'id' => \Estrutura\Helpers\Cript::enc($id_banca_examinadora)]);

        } catch (\Exception $e) {
            if( strstr($e->getMessage(), '1451') ) { #ERRO de SQL (Mysql) para nao excluir registro que possua filhos
                $this->addErrorMessage('Para excluir. Verifique!');
            }else {
                $this->addErrorMessage($e->getMessage());
            }

            return $this->redirect()->toRoute('navegacao', ['controller' => $controller]);
        }

    }
} 