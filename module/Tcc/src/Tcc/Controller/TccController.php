<?php
/**
 * Created by PhpStorm.
 * User: EduFerr
 * Date: 19/09/2016
 * Time: 16:18
 */

namespace Tcc\Controller;

use Estrutura\Controller\AbstractCrudController;
use Zend\View\Model\ViewModel;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Pagination;

class TccController extends AbstractCrudController{

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
            '0' => [
                'filter' => "tcc.id_tcc  LIKE ?"
            ],
            '1' => [
                'filter' => "tcc.dt_banca  LIKE ?"
            ],
            '2' => [
                'filter' => "tcc.nm_area_conhecimento  LIKE ?"
            ],
            '3' => [
                'filter' => "tcc.nm_area_conhecimento  LIKE ?"
            ],
            '4' => [
                'filter' => "tcc.tx_titulo_tcc LIKE ?"
            ],
            '5' => NULL,

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

    public function gravarAction() {
        try {
            $controller = $this->params('controller');
            $request = $this->getRequest();
            $service = $this->service;
            $form = $this->form;

            if (!$request->isPost()) {
                throw new \Exception('Dados InvÃ¡lidos');
            }

            $post = \Estrutura\Helpers\Utilities::arrayMapArray('trim', $request->getPost()->toArray());

            $files = $request->getFiles();
            $upload = $this->uploadFile($files);

            $post = array_merge($post, $upload);

            if (isset($post['id']) && $post['id']) {
                $post['id'] = Cript::dec($post['id']);
            }
            $post['id_tcc'] = ($post['id_tcc']);


            $form->setData($post);

            if (!$form->isValid()) {
                $this->addValidateMessages($form);
                $this->setPost($post);
                $this->redirect()->toRoute('navegacao', array('controller' => $controller, 'action' => 'cadastro'));
                return false;
            }

            $service->exchangeArray($form->getData());
            $this->addSuccessMessage('Registro Alterado com sucesso');

            $id_tcc = $service->salvar();

            //Define o redirecionamento
            if (isset($post['id']) && $post['id']) {
                $this->redirect()->toRoute('navegacao',array('controller'=>$controller,'action'=>'index'));
            } else {
                $this->redirect()->toRoute('navegacao',array('controller'=>$controller,
                    'action'=>'detalheconcluinte','id'=>Cript::enc($id_tcc)));
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
        #x(Cript::dec($this->params('id')));
        return parent::cadastro($this->service, $this->form);
    }

    public function detalheconcluinteAction()
    {
        //Se for a chamada Ajax
        if ($this->getRequest()->isPost()) {

            // recebendo o nome do professor e o id da banca
            $request = $this->getRequest();
            $nm_professor = $this->params()->fromPost('nm_professor');
            $id_banca = $this->params()->fromPost('id_banca_examinadora');

            // buscando o id do professor atravÃ©s de seu nome
            $professor = new \Professor\Service\ProfessorService();
            $arrProfessor = $professor->getIdProfessorPorNomeToArray(trim($this->params()->fromPost('nm_professor')));

            // verifica a existÃªncia do professor na base de dados.
            $membrosService = new \MembrosBanca\Service\MembrosBancaService();
            $values = [];
            if (!$arrProfessor) {
                $values['sucesso'] = false;
                $values['nm_professor'] = null;
            } else {
                // verifica se o professor jÃ¡ estÃ¡ cadastrado na banca examinadora.
                // Caso nÃ£o esteja serÃ¡ efetuado o cadastro.
                if ($membrosService->checarSeProfessorEstaInscritoNaBanca($arrProfessor['id_professor'],$id_banca)) {
                    $values['sucesso'] = false;
                    $values['nm_professor'] = $arrProfessor['nm_professor'];
                } else {
                    $id_inserido = $membrosService->getTable()->salvar(
                        array('id_banca_examinadora'=>$id_banca,
                            'id_professor'=>$arrProfessor['id_professor'],
                            'cs_orientador'=>$arrProfessor['cs_orientador']), null);
                    $values['sucesso'] = true;
                    $values['nm_professor'] = $arrProfessor['nm_professor'];
                }
            }

            // realiza a contagem dos professores inscritos
            $inscricoes = $membrosService->fetchAllMembrosBanca(array('id_banca_examinadora' => $id_banca));
            $values['qtd_inscritos'] = count($inscricoes);

            $valuesJson = new JsonModel($values);
            return $valuesJson;

        } else { //Se for requisiÃ§Ã£o normal

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

}