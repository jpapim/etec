<?php

namespace Professor\Controller;

use Estrutura\Controller\AbstractCrudController;
use Estrutura\Helpers\Cript;
use Estrutura\Helpers\Data;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class ProfessorController extends AbstractCrudController {

	/**
	 * @var \Professor\Service\Professor
	 */
	protected $service;

	/**
	 *
	 * @var \Professor\Form\Professor
	 */
	protected $form;

	public function __construct(){
		parent::init();
	}

	public function indexAction() {
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
				'0' => [
						'filter' => "professor.nm_professor LIKE ?",
				],
				'1' => [
						'filter' => "titulacao.nm_titulacao LIKE ?",
				],
				'2' => [
						'filter' => "professor.cs_orientador LIKE ?",
				],
				'3' => [
						'filter' => "professor.cs_ativo LIKE ?",
				],
				'4' => NULL,
		];


		$paginator = $this->service->getProfessoresPaginator($filter, $camposFilter);

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

	public function cadastroAction()
	{
		return parent::cadastro($this->service, $this->form);
	}

	public function excluirAction()
	{
			return parent::excluir($this->service, $this->form);
	}

	public function autocompleteprofessorAction()
	{
			$termo = $_GET['term'];
			$professores = new \Professor\Service\ProfessorService();
			$arrProfessores = $professores->getFiltrarProfessorPorNomeToArray($termo);
			$arrProfessoresFiltrados = array();
			foreach($arrProfessores as $professor){
					if ($professor['cs_orientador'] == 'S') {
						$arrProfessoresFiltrados[] = $professor['nm_professor'] . ' (Orientador(a)) ';
					} else if ($professor['cs_orientador'] == 'N') {
						$arrProfessoresFiltrados[] = $professor['nm_professor'] . ' (Professor(a)) ';
					} else {
						$arrProfessoresFiltrados[] = $professor['nm_professor'];
					}
			}

			$valuesJson = new JsonModel( $arrProfessoresFiltrados );
			return $valuesJson;
	}

	public function alterarviaacademiaAction()
	{
			$id_membro_banca = $this->params('id');
			$membroBanca = new \MembrosBanca\Service\MembrosBancaService();
			$professor = new \Professor\Service\ProfessorService();

			#Recupera os Dados do Banco para Preencher no Formulario
			$arrMembroBanca = $membroBanca->getMembroBancaToArray($id_membro_banca);
			$obProfessor = $professor->buscar($arrMembroBanca['id_professor']);

			$post = $this->getPost();

			if (!empty($post)) {
					$this->form->setData($post);
			}

			$dadosView = [
					'service' => $this->service,
					'form' => $this->form,
					'controller' => $this->params('controller'),
					'atributos' => array(),
					'id_professor' => $obProfessor->getId(),
					'id_titulacao' => $obProfessor->getIdTitulacao(),
					'id_usuario' => $obProfessor->getIdUsuario(),
					'nm_professor' => $obProfessor->getNmProfessor(),
					'dt_cadastro' => $obProfessor->getDtCadastro(),
					'professor_cs_orientador' => $obProfessor->getCsOrientador(),
					'membro_cs_orientador' => $arrMembroBanca['cs_orientador'],
					'cs_ativo' => $obProfessor->getCsAtivo(),
					'id_banca_examinadora' => $arrMembroBanca['id_banca_examinadora'],
					'id_membro_banca' => $id_membro_banca
			];

			return new ViewModel($dadosView);
	}

	public function gravaralteracaoviaacademiaAction() {
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

				$form->setData($post);

				if (!$form->isValid()) {
					$this->addValidateMessages($form);
					$this->setPost($post);
					$this->redirect()->toRoute('navegacao', array('controller' => $controller,
						'action' => 'cadastro'));
					return false;
				}

				$service->exchangeArray($form->getData());
				$this->addSuccessMessage('Registro Alterado com sucesso');
				$this->redirect()->toRoute('navegacao', array('controller' => 'banca_examinadora-bancaexaminadora',
					'action' => 'realizarinscricoes', 'id'=>Cript::enc($post['id_banca_examinadora'])));

				return $service->salvaralterarviaacademia($post);

			} catch (\Exception $e) {

				$this->setPost($post);
				$this->addErrorMessage($e->getMessage());
				$this->redirect()->toRoute('navegacao', array('controller' => $controller,
					'action' => 'cadastro'));
				return false;
			}
	 }
}
