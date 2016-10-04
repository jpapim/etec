<?php

namespace Titulacao\Service;

use \Titulacao\Entity\TitulacaoEntity as Entity;

class TitulacaoService extends Entity {

	public function getTitulacaoToArray($id) {
		$sql = new \Zend\Db\Sql\Sql ( $this->getAdapter () );
		
		$select = $sql->select ( 'titulacao' )
			->where ( ['titulacao.id_titulacao = ?' => $id ] );
		
		return $sql->prepareStatementForSqlObject ( $select )->execute ()->current ();
	}

	public function getTitulacaoPaginator($filter = NULL, $camposFilter = NULL) {

		$sql = new \Zend\Db\Sql\Sql($this->getAdapter());

		$select = $sql->select('titulacao')->columns([
			'id_titulacao',
			'nm_titulacao',
		]);

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

		$select->where($where)->order(['id_titulacao DESC']);

		return new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbSelect($select, $this->getAdapter()));
	}

	public function getFiltrarTitulacaoPorNomeToArray($nm_titulacao) {

		$sql = new \Zend\Db\Sql\Sql($this->getAdapter());

		$select = $sql->select('titulacao')
			->columns(array('nm_titulacao'))
			->where([
				"titulacao.nm_titulacao LIKE ?" => '%' . $nm_titulacao . '%',
			]);

		return $sql->prepareStatementForSqlObject($select)->execute();
	}

	public function getIdTitulacaoPorNomeToArray($nm_titulacao) {

		$arNomeTitulacao = explode('(', $nm_titulacao);
		$nm_titulacao = $arNomeTitulacao[0];

		$sql = new \Zend\Db\Sql\Sql($this->getAdapter());
		$filter = new \Zend\Filter\StringTrim();
		$select = $sql->select('titulacao')
			->columns(array('id_titulacao', 'nm_titulacao'))
			->where([
				'titulacao.nm_titulacao = ?' => $filter->filter($nm_titulacao),
			]);

		return $sql->prepareStatementForSqlObject($select)->execute()->current();
	}
}