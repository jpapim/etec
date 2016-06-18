<?php

namespace Professor\Service;

use \Professor\Entity\ProfessorEntity as Entity;

class ProfessorService extends Entity {

	public function getEventoToArray($id) {

			$sql = new \Zend\Db\Sql\Sql($this->getAdapter());

			$select = $sql->select('professor')
					->where([
							'professor.id_professor = ?' => $id,
					]);

			return $sql->prepareStatementForSqlObject($select)->execute()->current();
	}

	public function gravar($post) {
		$this->preSave();
		$dados = $this->hydrate();
		$where = null;

		if($this->getId()) {
			if(!$field = $this->fieldName('id')) {
				$field = $this->fieldName('Id');
			}
			$where = [$field => $this->getId()];
		}

		# Setando manualmente os dados do formulario
		$dados['id_titulacao'] = $post['id_titulacao'];
		$dados['id_usuario'] = $post['id_usuario'];

		$result = $this->getTable()->salvar($dados, $where);
		if (is_string($result)) {
			$this->setId($result);
		}
		$this->posSave();
		return $result;
	}

	/**
	 * Filtra a busca dos professores
	 *
	 * @param unknown $filter
	 * @param unknown $camposFilter
	 * @return \Zend\Paginator\Paginator
	 */
	public function getProfessoresPaginator($filter = NULL, $camposFilter = NULL) {

		$sql = new \Zend\Db\Sql\Sql($this->getAdapter());

		$select = $sql->select('professor')->columns([
				'id_professor',
				'nm_professor',
				'cs_orientador',
				'cs_ativo',
		])
		->join('titulacao', 'titulacao.id_titulacao = professor.id_titulacao', [
				'nm_titulacao'
		]);

		$where = [
		];

		if (!empty($filter)) {

			foreach ($filter as $key => $value) {

				if ($value) {

					if (isset($camposFilter[$key]['mascara'])) {

						eval("\$value = " . $camposFilter[$key]['mascara'] . ";");

					}

					/*
					* Tratamento para buscas no campo Orientador
					*/
					if ($key == 2) {
						if (strcasecmp($value, "sim") == 0) {
							$value = 'S';
						} else if (strcasecmp($value, "não") == 0 ||
								strcasecmp($value, "nao") == 0 ||
								strcasecmp($value, "nÃo") == 0) {
							$value = 'N';
						}
					}

					/*
					* Tratamento para buscas no campo Situação
					*/
					if ($key == 3) {
						if (strcasecmp($value, "ativo") == 0) {
							$value = 'A';
						} else if (strcasecmp($value, "inativo") == 0) {
							$value = 'I';
						}
					}

					$where[$camposFilter[$key]['filter']] = '%' . $value . '%';

				}
			}
		}

		$select->where($where)->order(['nm_professor ASC']);

		return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
	}
}
