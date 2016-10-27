<?php

namespace Concluinte\Service;

use \Concluinte\Entity\ConcluinteEntity as Entity;

class ConcluinteService extends Entity {

	public function getConcluinteToArray($id) {

			$sql = new \Zend\Db\Sql\Sql($this->getAdapter());

			$select = $sql->select('concluinte')
					->where([
							'concluite.id_concluinte = ?' => $id,
					]);

			return $sql->prepareStatementForSqlObject($select)->execute()->current();
	}

	public function getConcluintesPaginator($filter = NULL, $camposFilter = NULL) {

		$sql = new \Zend\Db\Sql\Sql($this->getAdapter());

		$select = $sql->select('concluinte')->columns([
				'id_concluinte',
				'nm_concluinte',
				'nr_matricula',
		])
		->join('curso', 'curso.id_curso = concluinte.id_curso', ['nm_curso'])
		->join('tcc', 'tcc.id_tcc = concluinte.id_tcc', ['tx_titulo_tcc']);

		$where = [
		];

		if (!empty($filter)) {
			foreach ($filter as $key => $value) {
				if ($value) {
					if (isset($camposFilter[$key]['mascara'])) {
						eval("\$value = " . $camposFilter[$key]['mascara'] . ";");
					}
					$where[$camposFilter[$key]['filter']] = '%' . $value . '%';
				}
			}
		}

		$select->where($where)->order(['id_concluinte DESC']);

		return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
	}

	public function getFiltrarConcluintePorNomeToArray($nm_concluinte) {

			$sql = new \Zend\Db\Sql\Sql($this->getAdapter());

			$select = $sql->select('concluinte')
							->columns(array('nm_concluinte', 'nr_matricula')) #Colunas a retornar. Basta Omitir que ele traz todas as colunas
							->where([
					"concluinte.nm_concluinte LIKE ?" => '%' . $nm_concluinte . '%',
			]);

			return $sql->prepareStatementForSqlObject($select)->execute();
	}

	public function getIdConcluintePorNomeToArray($nm_concluinte) {

			$arNomeConcluinte = explode('(', $nm_concluinte);
			$nm_concluinte = $arNomeConcluinte[0];

			$sql = new \Zend\Db\Sql\Sql($this->getAdapter());
			$filter = new \Zend\Filter\StringTrim();
			$select = $sql->select('concluinte')
							->columns(array('id_concluinte', 'nm_concluinte', 'nr_matricula'))
							->where([
					'concluinte.nm_concluinte = ?' => $filter->filter($nm_concluinte),
			]);

			return $sql->prepareStatementForSqlObject($select)->execute()->current();
	}


}
