<?php
/**
 * Created by PhpStorm.
 * User: EduFerr
 * Date: 19/09/2016
 * Time: 16:18
 */

namespace Tcc\Controller;
use Concluinte;
use PalavraChaveTcc;
use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Estrutura\Helpers\Pagination;
use Zend\Http\Headers;
use Zend\Http\Response\Stream;


class TccController extends  AbstractCrudController {

    protected  $service;
    protected $form;

    public function  __construct(){
        parent::init();
    }

    public function indexAction()
    {
        return parent::index($this->service,$this->form);
    }

    public function indexPaginationAction()
    {

        $filter = $this->getFilterPage();

        $camposFilter = [
            '0' => [
                'filter' => "tcc.id_tcc  LIKE ?"
            ],
            '1' => [
                'filter' => "area_conhecimento.nm_area_conhecimento  LIKE ?"
            ],
            '2' => [
                'filter' => "tipo_tcc.nm_tipo_tcc  LIKE ?"
            ],
            '3' => [
                'filter' => "professor.nm_professor  LIKE ?"
            ],
            '4' => [
                'filter' => "tcc.tx_titulo_tcc LIKE ?"
            ],
            '5' => [
                'filter' => "tcc.nr_nota_final  LIKE ?"
            ],
            '6' => NULL,
            '7' => NULL,

        ];

        #xd($id_tcc = $this->params('id'));

        $paginator = $this->service->getTccPaginator($filter, $camposFilter);
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

            $local = TXT_CONST_LOCAL_COMPLETO_UPLOAD;
            if (!file_exists($local)) {
                mkdir($local, 0755);
            }

            $files = $request->getFiles();
            $upload = $this->uploadFile($files, $local);

            $local_relativo = TXT_CONST_LOCAL_RELATIVO_UPLOAD;
            foreach ($upload as $file) {
                if (isset($file['tmp_name'])) {
                    $upload['ar_arquivo'] = str_replace($local_relativo,'',str_replace(BASE_PATCH, '', $file['tmp_name']));
                }
            }

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
            $this->addSuccessMessage('Registro alterado com sucesso');
            $id_tcc = $service->salvar();

            //Define o redirecionamento
            if (isset($post['id']) && $post['id']) {
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro-detalhe', 'id' => Cript::enc($post['id'])));
            } else {
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro-detalhe', 'id' => Cript::enc($id_tcc)));
            }

            return $id_tcc;

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

    // Iniciando ações do Cadastro Detalhe

    public function cadastroDetalheAction()
    {
        //recuperar o id do Modulo Tcc
        $id_tcc = Cript::dec($this->params('id') );

        $tcc = new \Tcc\Service\TccService();
        $dadosTcc = $tcc->buscar($id_tcc);
        #xd($dadosTcc);

        $dadosView = [
            'service' => new \Tcc\Service\TccService(),
            'form' => new \Tcc\Form\TccDetalheForm(),
            'controller' => $this->params('controller'),
            'atributos' => array(),
            'id_tcc' => $id_tcc,
            'dadosTcc' => $dadosTcc,
        ];

        return new ViewModel($dadosView);

    }


    // Iniciando ações para Palavra Chave TCC
    public function adicionarPalavraChaveTccAction()
    {
        //Se for a chamada Ajax
        if ($this->getRequest()->isPost()) {

            $id_tcc = \Estrutura\Helpers\Cript::dec($this->params()->fromPost('id'));
            $id_palavra_chave = $this->params()->fromPost('id_palavra_chave');
            $detalhe_palavraChaveTcc = new PalavraChaveTcc\Service\PalavraChaveTccService();

            $id_inserido = $detalhe_palavraChaveTcc->getTable()->salvar(array(
                'id_tcc'=>$id_tcc,
                'id_palavra_chave'=>$id_palavra_chave,
            ), null);
            $valuesJson = new JsonModel( array('id_inserido'=>$id_inserido, 'sucesso'=>true, 'id_palavra_chave'=>$id_palavra_chave) );
            return $valuesJson;
        }
    }

    public function listarPalavraChaveTccAction()
    {
        $filter = $this->getFilterPage();

        $id_tcc = $this->params()->fromPost('id_tcc');
        $camposFilter = [
            '0' => [
                'filter' => "palavra_chave_tcc.nm_palavra_chave LIKE ?"
            ],
            '1' => NULL,
        ];
        #xd($id_tcc = $this->params('id'));

        $paginator = $this->service->getPalavraChaveTccPaginator( $id_tcc, $filter, $camposFilter);

        $paginator->setItemCountPerPage($paginator->getTotalItemCount());

        $countPerPage = $this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());

        $viewModel = new ViewModel([
            'service' => $this->service,
            'form' => new \PalavraChaveTcc\Form\PalavraChaveTccForm(),
            'paginator' => $paginator,
            'filter' => $filter,
            'countPerPage' => $countPerPage,
            'camposFilter' => $camposFilter,
            'controller' => $this->params('controller'),
            'id_tcc'=>$id_tcc,
            'atributos' => array()
        ]);

        return $viewModel->setTerminal(TRUE);
    }

    public function excluirPalavraChaveTccViaTccAction()
    {
        try {
            $request = $this->getRequest();
            if ($request->isPost()) {
                return new JsonModel();
            }

            $controller = $this->params('controller');
            $id = Cript::dec($this->params('id'));
            $id_tcc = Cript::dec($this->params('aux'));

            $palavrachaveService = new \PalavraChaveTcc\Service\PalavraChaveTccService();
            $palavrachaveService->setId($id);
            $palavrachaveService->setIdTcc($id_tcc);

            $dados = $palavrachaveService->filtrarObjeto()->current();
            if (!$dados) {
                throw new \Exception('Registro nao encontrado');
            }

            $palavrachaveService->excluir();
            $this->addSuccessMessage('Registro excluido com sucesso');
            return $this->redirect()->toRoute('navegacao', ['controller' => $controller, 'action' => 'cadastro-detalhe', 'id' => \Estrutura\Helpers\Cript::enc($id_tcc)]);

        } catch (\Exception $e) {
            if( strstr($e->getMessage(), '1451') ) { #ERRO de SQL (Mysql) para nao excluir registro que possua filhos
                $this->addErrorMessage('Para excluir a academia voce deve excluir todos os atletas da academia. Verifique!');
            }else {
                $this->addErrorMessage($e->getMessage());
            }

            return $this->redirect()->toRoute('navegacao', ['controller' => $controller]);
        }

    }

    // Iniciando ações para Aluno Concluinte
    public function adicionarConcluintesAction()
    {
        //Se for a chamada Ajax
        if ($this->getRequest()->isPost()) {

            $id_tcc = \Estrutura\Helpers\Cript::dec($this->params()->fromPost('id'));
            $nm_concluinte = $this->params()->fromPost('nm_concluinte');
            $nr_matricula = $this->params()->fromPost('nr_matricula');
            $id_curso = $this->params()->fromPost('id_curso');
            $detalhe_concluinte = new Concluinte\Service\ConcluinteService();

            $id_inserido = $detalhe_concluinte->getTable()->salvar(array(
                'id_tcc'=>$id_tcc,
                'nm_concluinte'=>$nm_concluinte,
                'id_curso'=>$id_curso,
                'nr_matricula'=>$nr_matricula,
            ), null);
            $valuesJson = new JsonModel( array('id_inserido'=>$id_inserido, 'sucesso'=>true, 'nm_concluinte'=>$nm_concluinte) );
            return $valuesJson;
        }
    }

    public function listarConcluintesAction()
    {
        $filter = $this->getFilterPage();

        $id_tcc = $this->params()->fromPost('id_tcc');
        $camposFilter = [
            '0' => [
                'filter' => "concluinte.nm_concluinte  LIKE ?"
            ],
            '1' => [
                'filter' => "concluinte.nr_matricula LIKE ?"
            ],
            '2' => [
                'filter' => "concluinte.nm_curso  LIKE ?"
            ],
            '3' => NULL,
        ];
        #xd($id_tcc = $this->params('id'));

        $paginator = $this->service->getConcluintePaginator( $id_tcc, $filter, $camposFilter);

        $paginator->setItemCountPerPage($paginator->getTotalItemCount());

        $countPerPage = $this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        );

        $paginator->setItemCountPerPage($this->getCountPerPage(
            current(\Estrutura\Helpers\Pagination::getCountPerPage($paginator->getTotalItemCount()))
        ))->setCurrentPageNumber($this->getCurrentPage());

        $viewModel = new ViewModel([
            'service' => $this->service,
            'form' => new \Concluinte\Form\ConcluinteForm(),
            'paginator' => $paginator,
            'filter' => $filter,
            'countPerPage' => $countPerPage,
            'camposFilter' => $camposFilter,
            'controller' => $this->params('controller'),
            'id_tcc'=>$id_tcc,
            'atributos' => array()
        ]);

        return $viewModel->setTerminal(TRUE);
    }

    public function excluirConcluinteViaTccAction()
    {
        try {
            $request = $this->getRequest();
            if ($request->isPost()) {
                return new JsonModel();
            }

            $controller = $this->params('controller');
            $id = Cript::dec($this->params('id'));
            $id_tcc = Cript::dec($this->params('aux'));

            $concluinteService = new \Concluinte\Service\ConcluinteService();
            $concluinteService->setId($id);
            $concluinteService->setIdTcc($id_tcc);

            $dados = $concluinteService->filtrarObjeto()->current();
            if (!$dados) {
                throw new \Exception('Registro nao encontrado');
            }

            $concluinteService->excluir();
            $this->addSuccessMessage('Registro excluido com sucesso');
            return $this->redirect()->toRoute('navegacao', ['controller' => $controller, 'action' => 'cadastro-detalhe', 'id' => \Estrutura\Helpers\Cript::enc($id_tcc)]);

        } catch (\Exception $e) {
            if( strstr($e->getMessage(), '1451') ) { #ERRO de SQL (Mysql) para nao excluir registro que possua filhos
                $this->addErrorMessage('Para excluir a academia voce deve excluir todos os atletas da academia. Verifique!');
            }else {
                $this->addErrorMessage($e->getMessage());
            }

            return $this->redirect()->toRoute('navegacao', ['controller' => $controller]);
        }

    }

    /**
     * @return Stream
     */
    public function downloadArquivoAction()
    {
        define('DIR_DOWNLOAD', '.'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'arquivos'.DIRECTORY_SEPARATOR);
        $obTcc = new \Tcc\Service\TccService();
        $resultado = $obTcc->buscar(Cript::dec($this->params()->fromRoute('id')));
        $file = DIR_DOWNLOAD.$resultado->getArArquivo();
        $file = filter_var($file, FILTER_SANITIZE_STRING);

        $response = new \Zend\Http\Response\Stream();
        $response->setStream(fopen($file, 'r'));
        $response->setStatusCode(200);
        $response->setStreamName(basename($file));
        $headers = new \Zend\Http\Headers();

        $headers->addHeaders(array(
            'Content-Disposition' => 'attachment; filename="' . basename($file) . '"',
            'Content-Type' => 'application/pdf',
            'Content-Type' => 'application/msword',
            'Content-Type' => 'application/octet-stream',
            'Content-Type' => 'image/jpg',
            'Expires' => '@0', // @0, because zf2 parses date as string to \DateTime() object
            'Content-Length' => filesize($file),
            'Cache-Control' => 'must-revalidate',
            'Pragma' => 'public'
        ));
        $response->setHeaders($headers);
        return $response;

    }


} 