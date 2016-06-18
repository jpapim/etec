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
}