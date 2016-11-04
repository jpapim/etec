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
                'filter' => "banca_examinadora.dt_banca  LIKE ?"
            ],
            '1' => NULL,

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

        $membrosBancoService = new \MembrosBanca\Service\MembrosBancaService();
        $arrResultado = $membrosBancoService->fetchAllById(['id_banca_examinadora'=>$id_banca_examinadora]);

        $dadosView = [
            'service' => new \MembrosBanca\Service\MembrosBancaService(),
            'form' => new \MembrosBanca\Form\MembrosBancaForm(),
            'controller' => $this->params('controller'),
            'atributos' => array(),
            'id_banca_examinadora' => $id_banca_examinadora,
            'dadosBancaExaminadora' => $dadosBancaExaminadora,
            'quantidade_professores' => count($arrResultado),
        ];
        #xd($dadosView);

        return new ViewModel($dadosView);

    }

    public function adicionarProfessoresAction()
    {
        //Se for a chamada Ajax
        if ($this->getRequest()->isPost()) {

            $id_banca_examinadora = $this->params()->fromPost('id_banca_examinadora');
            $nm_professor = $this->params()->fromPost('id_professor'); #Aqui tem o Nome do Professor e Não o ID
            $cs_orientador = $this->params()->fromPost('cs_orientador');

            #Recuperar o ID do Professor
            $professorService = new \Professor\Service\ProfessorService();
            $obProfessor = $professorService->getIdProfessorPorNomeToArray($nm_professor);

            // verifica se o professor é membro da Banca.
            $detalhe_banca = new MembrosBanca\Service\MembrosBancaService();
            $values = [];
            if (!$obProfessor) {
                $values['sucesso'] = false;
                $values['nm_professor'] = null;
                #xd($obProfessor);
            } else {
                // verifica se o professor já está cadastrado na banca examinadora.
                // Caso não esteja será efetuado o cadastro.
                if ($detalhe_banca->checarSeProfessorEstaInscritoNaBanca($obProfessor['id_professor'],$id_banca_examinadora)) {
                    $values['sucesso'] = false;
                    $values['nm_professor'] = $obProfessor['nm_professor'];
                } else {
                    $id_inserido = $detalhe_banca->getTable()->salvar(
                        array('id_banca_examinadora' => $id_banca_examinadora,
                            'id_professor' => $obProfessor['id_professor'],
                            'cs_orientador' => $cs_orientador,
                        ), null);
                    $values['sucesso'] = true;
                    $values['nm_professor'] = $obProfessor['nm_professor'];
                }
            }

            // contar quantos professores tem inscritos na banca
            $inscricoes = $detalhe_banca->fetchAllMembrosBanca(array('id_banca_examinadora' => $id_banca_examinadora));
            $values['qtd_inscritos'] = count($inscricoes);

            $valuesJson = new JsonModel($values);
            #xd($valuesJson);
            return $valuesJson;

        } else { //Se for requisição normal

            $id = Cript::dec($this->params('id'));
            $post = $this->getPost();

            if (!empty($post)) {
                $this->form->setData($post);
            }

            $banca = new \BancaExaminadora\Service\BancaExaminadoraService();
            $dadosBanca = $banca->getBancaExaminadoraToArray($id);

            $inscricoes = new \MembrosBanca\Service\MembrosBancaService();
            $dadosInscricoes = $inscricoes->fetchAllMembrosBanca(array(
                'id_banca_examinadora' => $dadosBanca['id_banca_examinadora']));

            $dadosView = [
                'service' => $this->service,
                'form' => $this->form,
                'controller' => $this->params('controller'),
                'atributos' => array(),
                'dados_banca' => $dadosBanca,
                'lista_inscritos' => $dadosInscricoes
            ];

            return new ViewModel($dadosView);
        }
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